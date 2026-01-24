<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function blogs(Request $request)
    {
        $blogs = Blog::with('author')
            ->when($request->search, fn($q, $search) => 
                $q->where('title', 'like', "%{$search}%")
                 ->orWhere('content', 'like', "%{$search}%"))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->featured, fn($q) => $q->where('is_featured', true))
            ->latest()
            ->paginate(15);

        return response()->json($blogs);
    }

    public function publishedBlogs(Request $request)
    {
        $blogs = Blog::published()
            ->with('author')
            ->when($request->search, fn($q, $search) => 
                $q->where('title', 'like', "%{$search}%")
                 ->orWhere('content', 'like', "%{$search}%"))
            ->when($request->featured, fn($q) => $q->featured())
            ->latest('published_at')
            ->paginate(12);

        return response()->json($blogs);
    }

    public function showBlog(Blog $blog)
    {
        if ($blog->status !== 'published') {
            $this->authorizeAdmin(request()->user());
        }

        $blog->increment('views');

        return response()->json($blog->load('author'));
    }

    public function storeBlog(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_at' => 'nullable|date',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . time();
        $data['author_id'] = $request->user()->id;

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $path;
        }

        if ($data['status'] === 'published' && !$data['published_at']) {
            $data['published_at'] = now();
        }

        $blog = Blog::create($data);

        return response()->json([
            'message' => 'Blog post created successfully',
            'blog' => $blog->load('author')
        ], 201);
    }

    public function updateBlog(Request $request, Blog $blog)
    {
        $this->authorizeAdmin($request->user());

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'excerpt' => 'sometimes|required|string|max:500',
            'content' => 'sometimes|required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'sometimes|required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_at' => 'nullable|date',
        ]);

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . time();
        }

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $path = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $path;
        }

        if (isset($data['status']) && $data['status'] === 'published' && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return response()->json([
            'message' => 'Blog post updated successfully',
            'blog' => $blog->load('author')
        ]);
    }

    public function destroyBlog(Blog $blog)
    {
        $this->authorizeAdmin(request()->user());

        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog post deleted successfully']);
    }

    public function faqs(Request $request)
    {
        $faqs = FAQ::active()
            ->when($request->category, fn($q, $category) => $q->where('category', $category))
            ->when($request->search, fn($q, $search) => 
                $q->where('question', 'like', "%{$search}%")
                 ->orWhere('answer', 'like', "%{$search}%"))
            ->ordered()
            ->get();

        return response()->json($faqs);
    }

    public function adminFaqs(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $faqs = FAQ::when($request->category, fn($q, $category) => $q->where('category', $category))
            ->when($request->search, fn($q, $search) => 
                $q->where('question', 'like', "%{$search}%")
                 ->orWhere('answer', 'like', "%{$search}%"))
            ->ordered()
            ->paginate(20);

        return response()->json($faqs);
    }

    public function storeFaq(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:2000',
            'category' => 'required|in:visa,admission,travel,consultation,general',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $data['is_active'] ?? true;

        $faq = FAQ::create($data);

        return response()->json([
            'message' => 'FAQ created successfully',
            'faq' => $faq
        ], 201);
    }

    public function updateFaq(Request $request, FAQ $faq)
    {
        $this->authorizeAdmin($request->user());

        $data = $request->validate([
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string|max:2000',
            'category' => 'sometimes|required|in:visa,admission,travel,consultation,general',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $faq->update($data);

        return response()->json([
            'message' => 'FAQ updated successfully',
            'faq' => $faq
        ]);
    }

    public function destroyFaq(FAQ $faq)
    {
        $this->authorizeAdmin(request()->user());

        $faq->delete();

        return response()->json(['message' => 'FAQ deleted successfully']);
    }

    public function toggleFaqStatus(Request $request, FAQ $faq)
    {
        $this->authorizeAdmin($request->user());

        $faq->update(['is_active' => !$faq->is_active]);

        return response()->json([
            'message' => 'FAQ status updated successfully',
            'faq' => $faq
        ]);
    }

    private function authorizeAdmin($user)
    {
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }
}