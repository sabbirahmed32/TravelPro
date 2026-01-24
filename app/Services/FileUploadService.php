<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class FileUploadService
{
    /**
     * Upload and store multiple files for a given entity
     */
    public function uploadFiles(array $files, string $entityType, int $entityId): array
    {
        $uploadedDocuments = [];
        
        foreach ($files as $file) {
            if ($this->validateFile($file)) {
                $path = $this->storeFile($file, $entityType);
                
                $document = Document::create([
                    'documentable_id' => $entityId,
                    'documentable_type' => $entityType,
                    'filename' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
                
                $uploadedDocuments[] = $document;
            }
        }
        
        return $uploadedDocuments;
    }

    /**
     * Upload a single file
     */
    public function uploadFile(UploadedFile $file, string $directory = 'uploads'): string
    {
        if (!$this->validateFile($file)) {
            throw new \InvalidArgumentException('Invalid file format or size');
        }
        
        return $this->storeFile($file, $directory);
    }

    /**
     * Validate file format and size
     */
    private function validateFile(UploadedFile $file): bool
    {
        $allowedMimes = [
            'application/pdf',
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];
        
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        return in_array($file->getClientMimeType(), $allowedMimes) && 
               $file->getSize() <= $maxSize;
    }

    /**
     * Store file in appropriate directory
     */
    private function storeFile(UploadedFile $file, string $directory): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Delete a file from storage
     */
    public function deleteFile(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Get file URL
     */
    public function getFileUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Generate file preview HTML
     */
    public function generatePreviewHtml(Document $document): string
    {
        $url = $this->getFileUrl($document->file_path);
        $filename = $document->filename;
        $fileType = $document->file_type;
        
        if ($fileType === 'application/pdf') {
            return "
                <div class='border rounded-lg p-4 hover:shadow-md transition-shadow'>
                    <div class='flex items-center space-x-3'>
                        <i class='fas fa-file-pdf text-red-500 text-2xl'></i>
                        <div class='flex-1'>
                            <p class='text-sm font-medium text-gray-900 truncate'>$filename</p>
                            <p class='text-xs text-gray-500'>PDF - {$this->formatFileSize($document->file_size)}</p>
                        </div>
                        <a href='$url' target='_blank' class='text-blue-600 hover:text-blue-800'>
                            <i class='fas fa-external-link-alt'></i>
                        </a>
                    </div>
                </div>
            ";
        } elseif (str_starts_with($fileType, 'image/')) {
            return "
                <div class='border rounded-lg p-2 hover:shadow-md transition-shadow'>
                    <img src='$url' alt='$filename' class='w-full h-32 object-cover rounded mb-2'>
                    <div class='flex items-center justify-between'>
                        <p class='text-xs text-gray-900 truncate'>$filename</p>
                        <a href='$url' target='_blank' class='text-blue-600 hover:text-blue-800'>
                            <i class='fas fa-external-link-alt'></i>
                        </a>
                    </div>
                </div>
            ";
        }
        
        return "
            <div class='border rounded-lg p-4 hover:shadow-md transition-shadow'>
                <div class='flex items-center space-x-3'>
                    <i class='fas fa-file text-gray-500 text-2xl'></i>
                    <div class='flex-1'>
                        <p class='text-sm font-medium text-gray-900 truncate'>$filename</p>
                        <p class='text-xs text-gray-500'>{$this->formatFileSize($document->file_size)}</p>
                    </div>
                    <a href='$url' target='_blank' class='text-blue-600 hover:text-blue-800'>
                        <i class='fas fa-external-link-alt'></i>
                    </a>
                </div>
            </div>
        ";
    }

    /**
     * Format file size in human readable format
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes === 0) return '0 Bytes';
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Get file type icon
     */
    public function getFileIcon(string $mimeType): string
    {
        return match ($mimeType) {
            'application/pdf' => 'fas fa-file-pdf text-red-500',
            'image/jpeg', 'image/jpg' => 'fas fa-file-image text-blue-500',
            'image/png' => 'fas fa-file-image text-green-500',
            default => 'fas fa-file text-gray-500'
        };
    }
}