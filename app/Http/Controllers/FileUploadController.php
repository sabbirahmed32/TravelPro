<?php

namespace App\Http\Controllers;

use App\Services\FileUploadService;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class FileUploadController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService)
    {
        $this->middleware('auth');
    }

    /**
     * Upload files via AJAX
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            'entity_type' => 'required|string',
            'entity_id' => 'required|integer',
        ]);

        try {
            $files = $request->file('files');
            $entityType = $request->input('entity_type');
            $entityId = $request->input('entity_id');

            $uploadedDocuments = $this->fileUploadService->uploadFiles($files, $entityType, $entityId);

            $documentData = [];
            foreach ($uploadedDocuments as $document) {
                $documentData[] = [
                    'id' => $document->id,
                    'filename' => $document->filename,
                    'url' => $this->fileUploadService->getFileUrl($document->file_path),
                    'preview_html' => $this->fileUploadService->generatePreviewHtml($document),
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Files uploaded successfully',
                'documents' => $documentData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading files: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a file
     */
    public function delete(Document $document): JsonResponse
    {
        $this->authorize('delete', $document);

        try {
            $this->fileUploadService->deleteFile($document->file_path);
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a file
     */
    public function download(Document $document): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('view', $document);

        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $document->filename);
    }

    /**
     * Generate file preview
     */
    public function preview(Document $document): JsonResponse
    {
        $this->authorize('view', $document);

        $previewHtml = $this->fileUploadService->generatePreviewHtml($document);

        return response()->json([
            'success' => true,
            'preview_html' => $previewHtml
        ]);
    }

    /**
     * Upload user avatar
     */
    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $user = $request->user();
            
            // Delete old avatar if exists
            if ($user->avatar) {
                $this->fileUploadService->deleteFile($user->avatar);
            }

            $path = $this->fileUploadService->uploadFile($request->file('avatar'), 'avatars');
            $user->update(['avatar' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Avatar uploaded successfully',
                'avatar_url' => $this->fileUploadService->getFileUrl($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file information
     */
    public function fileInfo(Document $document): JsonResponse
    {
        $this->authorize('view', $document);

        return response()->json([
            'success' => true,
            'document' => [
                'id' => $document->id,
                'filename' => $document->filename,
                'file_type' => $document->file_type,
                'file_size' => $document->file_size,
                'formatted_size' => $this->formatFileSize($document->file_size),
                'url' => $this->fileUploadService->getFileUrl($document->file_path),
                'icon' => $this->fileUploadService->getFileIcon($document->file_type),
                'created_at' => $document->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Format file size for display
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes === 0) return '0 Bytes';
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
}