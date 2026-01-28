@extends('layouts.dashboard')

@section('title', 'Manage Blogs')

@section('header', 'Blog Management')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Blog Posts</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all blog posts and articles</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus -ml-1 mr-2"></i>
                    New Post
                </a>
                <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-sync -ml-1 mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" action="{{ route('admin.blogs') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Search by title, content...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                            <select id="author" name="author" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Authors</option>
                                @foreach($authors ?? [] as $author)
                                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-search mr-2"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Blog Posts Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($blogs->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($blogs as $blog)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $blog->title }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                     {{ $blog->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                        ($blog->status === 'archived' ? 'bg-gray-100 text-gray-800' : 
                                                        'bg-yellow-100 text-yellow-800') }}">
                                                     {{ ucfirst($blog->status) }}
                                                </span>
                                                @if($blog->is_featured)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        <i class="fas fa-star mr-1"></i>Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                <i class="fas fa-user mr-1"></i> {{ $blog->author?->name ?? 'Unknown' }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-eye mr-1"></i> {{ $blog->views ?? 0 }} views
                                                @if($blog->published_at)
                                                    <span class="mx-2">•</span>
                                                    <i class="fas fa-calendar mr-1"></i> Published: {{ $blog->published_at->format('M d, Y') }}
                                                @endif
                                            </p>
                                            @if($blog->excerpt)
                                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit(strip_tags($blog->excerpt), 150) }}</p>
                                            @endif
                                            @if($blog->tags && count($blog->tags) > 0)
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach($blog->tags as $tag)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                            #{{ $tag }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>
                                                Created: {{ $blog->created_at->format('M d, Y H:i') }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-edit mr-1"></i>
                                                Updated: {{ $blog->updated_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.blogs.show', $blog) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View
                                            </a>
                                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                Edit
                                            </a>
                                            @if($blog->status === 'draft')
                                                <form method="POST" action="{{ route('admin.blogs.publish', $blog) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                        Publish
                                                    </button>
                                                </form>
                                            @elseif($blog->status === 'published')
                                                <form method="POST" action="{{ route('admin.blogs.archive', $blog) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">
                                                        Archive
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-newspaper text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No blog posts found</h3>
                    <p class="text-gray-500">No blog posts match your current filters.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus -ml-1 mr-2"></i>
                            Create First Post
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
            <div class="mt-6">
                {{ $blogs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection