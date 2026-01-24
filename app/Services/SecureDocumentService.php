<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\Document;
use Carbon\Carbon;

class SecureDocumentService
{
    protected $disk;
    protected $encryptionKey;

    public function __construct()
    {
        $this->disk = config('filesystems.secure_documents', 'secure_docs');
        $this->encryptionKey = config('app.encryption_key');
    }

    /**
     * Store document securely
     */
    public function storeDocument($file, array $metadata = []): Document
    {
        // Generate secure filename
        $filename = $this->generateSecureFilename($file);
        $path = $this->generateSecurePath();
        
        // Encrypt file before storage
        $encryptedContent = $this->encryptFile($file);
        
        // Store encrypted file
        Storage::disk($this->disk)->put($path . '/' . $filename, $encryptedContent);
        
        // Create document record
        $document = Document::create([
            'documentable_id' => $metadata['documentable_id'] ?? null,
            'documentable_type' => $metadata['documentable_type'] ?? null,
            'filename' => $file->getClientOriginalName(),
            'file_path' => $path . '/' . $filename,
            'encrypted_path' => $path . '/' . $filename,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'encryption_key' => $this->generateEncryptionKey(),
            'checksum' => hash('sha256', file_get_contents($file->getPathname())),
            'access_level' => $metadata['access_level'] ?? 'private',
            'expires_at' => $metadata['expires_at'] ?? null,
            'download_count' => 0,
            'max_downloads' => $metadata['max_downloads'] ?? null,
            'status' => 'active',
        ]);

        return $document;
    }

    /**
     * Retrieve and decrypt document
     */
    public function retrieveDocument(Document $document, string $accessKey = null): ?string
    {
        // Check if document is expired
        if ($this->isDocumentExpired($document)) {
            throw new \Exception('Document has expired');
        }

        // Check download limits
        if ($this->exceedsDownloadLimit($document)) {
            throw new \Exception('Download limit exceeded');
        }

        // Verify access
        if (!$this->hasAccess($document, $accessKey)) {
            throw new \Exception('Access denied');
        }

        // Retrieve encrypted content
        $encryptedContent = Storage::disk($this->disk)->get($document->encrypted_path);
        
        if (!$encryptedContent) {
            throw new \Exception('Document not found');
        }

        // Decrypt content
        $decryptedContent = $this->decryptFile($encryptedContent, $document->encryption_key);
        
        // Increment download count
        $document->increment('download_count');
        
        return $decryptedContent;
    }

    /**
     * Create secure download link
     */
    public function createSecureLink(Document $document, Carbon $expiresAt = null): string
    {
        $expiresAt = $expiresAt ?? now()->addHours(24);
        $token = $this->generateDownloadToken($document, $expiresAt);
        
        // Store token metadata
        cache()->put("download_token_{$token}", [
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'expires_at' => $expiresAt,
            'ip' => request()->ip(),
        ], $expiresAt);
        
        return route('secure.download', ['token' => $token]);
    }

    /**
     * Validate and process secure download
     */
    public function processSecureDownload(string $token): ?array
    {
        $tokenData = cache()->get("download_token_{$token}");
        
        if (!$tokenData) {
            throw new \Exception('Invalid or expired download token');
        }

        if (now()->isAfter($tokenData['expires_at'])) {
            cache()->forget("download_token_{$token}");
            throw new \Exception('Download token expired');
        }

        if ($tokenData['ip'] !== request()->ip()) {
            cache()->forget("download_token_{$token}");
            throw new \Exception('IP address mismatch');
        }

        $document = Document::find($tokenData['document_id']);
        if (!$document) {
            throw new \Exception('Document not found');
        }

        // Clear token
        cache()->forget("download_token_{$token}");
        
        return [
            'document' => $document,
            'filename' => $document->filename,
            'content' => $this->retrieveDocument($document),
        ];
    }

    /**
     * Delete document securely
     */
    public function deleteDocument(Document $document): bool
    {
        try {
            // Delete encrypted file
            Storage::disk($this->disk)->delete($document->encrypted_path);
            
            // Delete backup copies if exist
            $this->deleteBackups($document);
            
            // Delete database record
            $document->delete();
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Create backup of important documents
     */
    public function createBackup(Document $document): bool
    {
        if (!$this->shouldBackup($document)) {
            return false;
        }

        $backupPath = 'backups/' . date('Y/m/d');
        $sourcePath = $document->encrypted_path;
        $backupFilename = $this->generateBackupFilename($document);
        
        try {
            Storage::disk($this->disk)->copy($sourcePath, $backupPath . '/' . $backupFilename);
            
            // Log backup creation
            \Log::info("Document backup created", [
                'document_id' => $document->id,
                'backup_path' => $backupPath . '/' . $backupFilename,
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error("Document backup failed", [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
            ]);
            
            return false;
        }
    }

    /**
     * Encrypt file content
     */
    protected function encryptFile($file): string
    {
        $content = file_get_contents($file->getPathname());
        return Crypt::encrypt($content);
    }

    /**
     * Decrypt file content
     */
    protected function decryptFile(string $encryptedContent, string $encryptionKey): string
    {
        return Crypt::decrypt($encryptedContent);
    }

    /**
     * Generate secure filename
     */
    protected function generateSecureFilename($file): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $random = Str::random(16);
        
        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Generate secure path
     */
    protected function generateSecurePath(): string
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $hash = Str::random(8);
        
        return "documents/{$year}/{$month}/{$day}/{$hash}";
    }

    /**
     * Generate encryption key
     */
    protected function generateEncryptionKey(): string
    {
        return Str::random(32);
    }

    /**
     * Generate download token
     */
    protected function generateDownloadToken(Document $document, Carbon $expiresAt): string
    {
        $payload = [
            'document_id' => $document->id,
            'expires_at' => $expiresAt->timestamp,
            'random' => Str::random(16),
        ];
        
        return hash_hmac('sha256', json_encode($payload), $this->encryptionKey);
    }

    /**
     * Generate backup filename
     */
    protected function generateBackupFilename(Document $document): string
    {
        $timestamp = now()->format('Y_m_d_H_i_s');
        $originalName = pathinfo($document->filename, PATHINFO_FILENAME);
        $extension = pathinfo($document->filename, PATHINFO_EXTENSION);
        
        return "{$originalName}_backup_{$timestamp}.{$extension}";
    }

    /**
     * Check if document is expired
     */
    protected function isDocumentExpired(Document $document): bool
    {
        return $document->expires_at && now()->isAfter($document->expires_at);
    }

    /**
     * Check if download limit exceeded
     */
    protected function exceedsDownloadLimit(Document $document): bool
    {
        return $document->max_downloads && 
               $document->download_count >= $document->max_downloads;
    }

    /**
     * Check if user has access
     */
    protected function hasAccess(Document $document, string $accessKey = null): bool
    {
        // Admin has access to all
        if (auth()->check() && auth()->user()->isAdmin()) {
            return true;
        }

        // Owner has access
        if (auth()->check() && $document->user_id === auth()->id()) {
            return true;
        }

        // Check public access
        if ($document->access_level === 'public') {
            return true;
        }

        // Check access key for protected documents
        if ($document->access_level === 'protected' && $accessKey) {
            return hash_equals($document->access_key, $accessKey);
        }

        return false;
    }

    /**
     * Check if document should be backed up
     */
    protected function shouldBackup(Document $document): bool
    {
        return config('security.documents.backup_enabled', true) &&
               in_array($document->documentable_type, [
                   \App\Models\VisaApplication::class,
                   \App\Models\StudentApplication::class,
               ]);
    }

    /**
     * Delete backup copies
     */
    protected function deleteBackups(Document $document): void
    {
        $backupPattern = "backups/*/*{$document->filename}*";
        $backups = Storage::disk($this->disk)->glob($backupPattern);
        
        foreach ($backups as $backup) {
            Storage::disk($this->disk)->delete($backup);
        }
    }

    /**
     * Clean up expired documents
     */
    public function cleanupExpiredDocuments(): int
    {
        $expiredDocuments = Document::where('expires_at', '<', now())->get();
        $deletedCount = 0;

        foreach ($expiredDocuments as $document) {
            if ($this->deleteDocument($document)) {
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * Get document statistics
     */
    public function getDocumentStatistics(): array
    {
        return [
            'total_documents' => Document::count(),
            'active_documents' => Document::where('status', 'active')->count(),
            'expired_documents' => Document::where('expires_at', '<', now())->count(),
            'total_size' => Document::sum('file_size'),
            'by_type' => Document::selectRaw('documentable_type, count(*) as count')
                ->groupBy('documentable_type')
                ->get()
                ->pluck('count', 'documentable_type')
                ->toArray(),
        ];
    }
}