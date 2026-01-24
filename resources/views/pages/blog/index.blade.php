@extends('layouts.app')

@section('title', 'Blog - TravelPro')

@section('meta-description', 'Travel tips, guides, and insights from our expert consultants. Stay updated with the latest travel trends and advice.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Travel Blog</h1>
                <p class="lead">Tips, guides, and insights from our travel experts</p>
            </div>
        </div>
    </div>
</section>

<!-- Blog Categories -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog-categories">
                    <button class="category-btn active" onclick="filterBlogPosts('all')">All Posts</button>
                    <button class="category-btn" onclick="filterBlogPosts('travel-tips')">Travel Tips</button>
                    <button class="category-btn" onclick="filterBlogPosts('visa-guide')">Visa Guide</button>
                    <button class="category-btn" onclick="filterBlogPosts('destination')">Destinations</button>
                    <button class="category-btn" onclick="filterBlogPosts('student-life')">Student Life</button>
                    <button class="category-btn" onclick="filterBlogPosts('holiday-packages')">Holiday Packages</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="row g-4" id="blogPostsContainer">
                    <!-- Featured Post -->
                    <div class="col-12">
                        <div class="card blog-card featured-post" data-category="travel-tips">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                         class="img-fluid rounded-start h-100" alt="Featured Post" style="object-fit: cover;">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <div class="blog-meta mb-2">
                                            <span class="badge bg-primary">Featured</span>
                                            <span class="badge bg-secondary ms-2">Travel Tips</span>
                                            <small class="text-muted ms-2">3 days ago</small>
                                        </div>
                                        <h3 class="card-title">Ultimate Travel Guide: 50 Essential Tips for 2024</h3>
                                        <p class="card-text">Discover the most comprehensive travel tips that will transform your journey from ordinary to extraordinary. From packing hacks to cultural etiquette...</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="author-info">
                                                <img src="https://picsum.photos/seed/author1/30/30.jpg" alt="Author" class="rounded-circle me-2">
                                                <small>Sarah Johnson</small>
                                            </div>
                                            <div class="blog-stats">
                                                <small class="text-muted me-3">
                                                    <i class="bi bi-eye me-1"></i>1.2k views
                                                </small>
                                                <small class="text-muted">
                                                    <i class="bi bi-chat me-1"></i>23 comments
                                                </small>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="#" class="btn btn-primary" onclick="showBlogPost(1)">
                                                Read More <i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Regular Posts -->
                    <div class="col-md-6">
                        <div class="card blog-card" data-category="visa-guide">
                            <img src="https://images.unsplash.com/photo-1526494097098-586132821b0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                 class="card-img-top" alt="Blog Post">
                            <div class="card-body">
                                <div class="blog-meta mb-2">
                                    <span class="badge bg-success">Visa Guide</span>
                                    <small class="text-muted ms-2">5 days ago</small>
                                </div>
                                <h5 class="card-title">Student Visa Application: Complete Step-by-Step Guide</h5>
                                <p class="card-text">Everything you need to know about applying for a student visa, from document preparation to interview tips...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="author-info">
                                        <img src="https://picsum.photos/seed/author2/30/30.jpg" alt="Author" class="rounded-circle me-2">
                                        <small>Michael Chen</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>856 views
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="showBlogPost(2)">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card blog-card" data-category="destination">
                            <img src="https://images.unsplash.com/photo-1549188917-4e0a9c889244?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                 class="card-img-top" alt="Blog Post">
                            <div class="card-body">
                                <div class="blog-meta mb-2">
                                    <span class="badge bg-info">Destinations</span>
                                    <small class="text-muted ms-2">1 week ago</small>
                                </div>
                                <h5 class="card-title">Hidden Gems of Southeast Asia: Beyond the Tourist Trail</h5>
                                <p class="card-text">Explore the lesser-known destinations in Southeast Asia that offer authentic experiences away from crowds...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="author-info">
                                        <img src="https://picsum.photos/seed/author3/30/30.jpg" alt="Author" class="rounded-circle me-2">
                                        <small>Emily Rodriguez</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>623 views
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="showBlogPost(3)">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card blog-card" data-category="student-life">
                            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                 class="card-img-top" alt="Blog Post">
                            <div class="card-body">
                                <div class="blog-meta mb-2">
                                    <span class="badge bg-warning text-dark">Student Life</span>
                                    <small class="text-muted ms-2">2 weeks ago</small>
                                </div>
                                <h5 class="card-title">Surviving Your First Year Abroad: A Student's Guide</h5>
                                <p class="card-text">Essential tips for international students to adapt and thrive in their new academic environment...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="author-info">
                                        <img src="https://picsum.photos/seed/author4/30/30.jpg" alt="Author" class="rounded-circle me-2">
                                        <small>David Williams</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>445 views
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="showBlogPost(4)">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card blog-card" data-category="holiday-packages">
                            <img src="https://images.unsplash.com/photo-1537953774741-3d5a5fbd9f2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                 class="card-img-top" alt="Blog Post">
                            <div class="card-body">
                                <div class="blog-meta mb-2">
                                    <span class="badge bg-danger">Holiday Packages</span>
                                    <small class="text-muted ms-2">2 weeks ago</small>
                                </div>
                                <h5 class="card-title">Family Vacation Planning Made Easy: Tips & Tricks</h5>
                                <p class="card-text">How to plan the perfect family vacation that keeps everyone happy and within budget...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="author-info">
                                        <img src="https://picsum.photos/seed/author5/30/30.jpg" alt="Author" class="rounded-circle me-2">
                                        <small>Lisa Anderson</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>789 views
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="showBlogPost(5)">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Load More Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-outline-primary" onclick="loadMoreBlogPosts()">
                        <i class="bi bi-arrow-down-circle me-2"></i>Load More Posts
                    </button>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Search Widget -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Search Blog</h5>
                        <form id="blogSearchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search posts..." id="blogSearchInput">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Popular Posts -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Popular Posts</h5>
                        <div class="popular-posts">
                            <div class="popular-post-item d-flex mb-3">
                                <img src="https://images.unsplash.com/photo-1512455039149-3cbb91b0b6f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                     class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;" alt="Popular Post">
                                <div>
                                    <h6 class="mb-1">Top 10 Travel Destinations for 2024</h6>
                                    <small class="text-muted">2.3k views</small>
                                </div>
                            </div>
                            <div class="popular-post-item d-flex mb-3">
                                <img src="https://images.unsplash.com/photo-1526494097098-586132821b0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                     class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;" alt="Popular Post">
                                <div>
                                    <h6 class="mb-1">Visa Interview Success Tips</h6>
                                    <small class="text-muted">1.8k views</small>
                                </div>
                            </div>
                            <div class="popular-post-item d-flex">
                                <img src="https://images.unsplash.com/photo-1549188917-4e0a9c889244?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                                     class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;" alt="Popular Post">
                                <div>
                                    <h6 class="mb-1">Budget Travel: How to Save Money</h6>
                                    <small class="text-muted">1.5k views</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Categories Widget -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Categories</h5>
                        <div class="category-list">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="#" class="text-decoration-none" onclick="filterBlogPosts('travel-tips')">Travel Tips</a>
                                <span class="badge bg-secondary">12</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="#" class="text-decoration-none" onclick="filterBlogPosts('visa-guide')">Visa Guide</a>
                                <span class="badge bg-secondary">8</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="#" class="text-decoration-none" onclick="filterBlogPosts('destination')">Destinations</a>
                                <span class="badge bg-secondary">15</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="#" class="text-decoration-none" onclick="filterBlogPosts('student-life')">Student Life</a>
                                <span class="badge bg-secondary">6</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="text-decoration-none" onclick="filterBlogPosts('holiday-packages')">Holiday Packages</a>
                                <span class="badge bg-secondary">9</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tags Widget -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Popular Tags</h5>
                        <div class="tag-cloud">
                            <span class="badge bg-light text-dark me-2 mb-2">#travel</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#visa</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#student</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#tips</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#guide</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#destination</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#budget</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#adventure</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#culture</span>
                            <span class="badge bg-light text-dark me-2 mb-2">#packing</span>
                        </div>
                    </div>
                </div>
                
                <!-- Newsletter Widget -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Subscribe to Newsletter</h5>
                        <p class="text-muted small mb-3">Get the latest travel tips and guides delivered to your inbox</p>
                        <form id="newsletterForm">
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Your email address" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Post Modal -->
<div class="modal fade" id="blogPostModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blogModalTitle">Blog Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="blogModalBody">
                <!-- Blog post content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.blog-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 30px;
}

.category-btn {
    padding: 10px 20px;
    border: 2px solid #dee2e6;
    background: white;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.category-btn:hover,
.category-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.blog-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.blog-card .card-img-top {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .card-img-top {
    transform: scale(1.05);
}

.featured-post {
    border: 2px solid var(--primary-color);
}

.author-info img {
    width: 30px;
    height: 30px;
    object-fit: cover;
}

.popular-post-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.popular-post-item:hover {
    opacity: 0.8;
}

.tag-cloud .badge {
    cursor: pointer;
    transition: all 0.3s ease;
}

.tag-cloud .badge:hover {
    background: var(--primary-color) !important;
    color: white !important;
}

.category-list a {
    transition: color 0.3s ease;
}

.category-list a:hover {
    color: var(--primary-color) !important;
}

@media (max-width: 768px) {
    .blog-categories {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
    }
    
    .category-btn {
        white-space: nowrap;
        flex-shrink: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Sample blog posts data
const blogPosts = {
    1: {
        title: "Ultimate Travel Guide: 50 Essential Tips for 2024",
        author: "Sarah Johnson",
        date: "3 days ago",
        category: "Travel Tips",
        image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80",
        content: `
            <h2>Introduction</h2>
            <p>Traveling in 2024 comes with its own set of challenges and opportunities. Whether you're a seasoned traveler or planning your first trip, these 50 essential tips will help you navigate the world with confidence and ease.</p>
            
            <h2>Planning & Preparation</h2>
            <ol>
                <li><strong>Research your destination thoroughly</strong> - Understand local customs, laws, and weather conditions.</li>
                <li><strong>Book flights 6-8 weeks in advance</strong> - Get the best deals and seat selection.</li>
                <li><strong>Check passport validity</strong> - Ensure it's valid for at least 6 months beyond your travel dates.</li>
                <li><strong>Get travel insurance</strong> - Protect yourself against unexpected events.</li>
                <li><strong>Create a detailed itinerary</strong> - But leave room for spontaneity.</li>
            </ol>
            
            <h2>Packing Smart</h2>
            <ol start="6">
                <li><strong>Make a packing list</strong> - Organize by category to avoid forgetting essentials.</li>
                <li><strong>Use packing cubes</strong> - Maximize space and stay organized.</li>
                <li><strong>Pack versatile clothing</strong> - Items that can be mixed and matched.</li>
                <li><strong>Bring a portable charger</strong> - Keep your devices powered on the go.</li>
                <li><strong>Don't overpack</strong> - Leave room for souvenirs.</li>
            </ol>
            
            <h2>Money & Budget</h2>
            <ol start="11">
                <li><strong>Set a realistic budget</strong> - Include all expenses from flights to souvenirs.</li>
                <li><strong>Notify your bank</strong> - Avoid card blocks while traveling.</li>
                <li><strong>Carry multiple payment methods</strong> - Cards, cash, and mobile payments.</li>
                <li><strong>Use local currency</strong> - Get better exchange rates.</li>
                <li><strong>Track expenses</strong> - Use apps to monitor your spending.</li>
            </ol>
            
            <h2>Safety & Security</h2>
            <ol start="16">
                <li><strong>Make digital copies of documents</strong> - Store them securely in the cloud.</li>
                <li><strong>Share your itinerary</strong> - Keep someone informed about your plans.</li>
                <li><strong>Research local scams</strong> - Be aware of common tourist traps.</li>
                <li><strong>Keep emergency contacts handy</strong> - Local authorities and embassy information.</li>
                <li><strong>Trust your instincts</strong> - If something feels wrong, it probably is.</li>
            </ol>
            
            <h2>Health & Wellness</h2>
            <ol start="21">
                <li><strong>Get necessary vaccinations</strong> - Check health requirements for your destination.</li>
                <li><strong>Pack a basic first-aid kit</strong> - Include medications and supplies.</li>
                <li><strong>Stay hydrated</strong> - Drink plenty of water, especially in hot climates.</li>
                <li><strong>Get travel health insurance</strong> - Cover medical emergencies abroad.</li>
                <li><strong>Adjust to jet lag</strong> - Reset your sleep schedule gradually.</li>
            </ol>
            
            <h2>Technology & Connectivity</h2>
            <ol start="26">
                <li><strong>Get an international SIM card</strong> - Or use eSIM for flexibility.</li>
                <li><strong>Download offline maps</strong> - Navigate without internet connection.</li>
                <li><strong>Use VPN services</strong> - Protect your data on public Wi-Fi.</li>
                <li><strong>Bring universal adapters</strong> - Charge devices anywhere in the world.</li>
                <li><strong>Backup your photos</strong> - Use cloud storage or external drives.</li>
            </ol>
            
            <h2>Cultural Etiquette</h2>
            <ol start="31">
                <li><strong>Learn basic phrases</strong> - Hello, thank you, and excuse me go a long way.</li>
                <li><strong>Dress appropriately</strong> - Respect local dress codes and customs.</li>
                <li><strong>Understand tipping culture</strong> - Research local expectations.</li>
                <li><strong>Be punctual</strong> - Respect local time concepts.</li>
                <li><strong>Ask before photographing</strong> - Respect people's privacy.</li>
            </ol>
            
            <h2>Transportation</h2>
            <ol start="36">
                <li><strong>Book airport transfers in advance</strong> - Avoid last-minute stress.</li>
                <li><strong>Use public transportation apps</strong> - Navigate like a local.</li>
                <li><strong>Consider rail passes</strong> - Cost-effective for extensive travel.</li>
                <li><strong>Learn local traffic rules</strong> - If planning to drive.</li>
                <li><strong>Keep taxi apps handy</strong> - Reliable transportation options.</li>
            </ol>
            
            <h2>Accommodation</h2>
            <ol start="41">
                <li><strong>Read recent reviews</strong> - Get current information about properties.</li>
                <li><strong>Check location carefully</strong> - Proximity to attractions and transport.</li>
                <li><strong>Understand cancellation policies</strong> - Protect yourself against changes.</li>
                <li><strong>Bring earplugs</strong> - Deal with noisy environments.</li>
                <li><strong>Secure your valuables</strong> - Use room safes when available.</li>
            </ol>
            
            <h2>Making the Most of Your Trip</h2>
            <ol start="46">
                <li><strong>Wake up early</strong> - Experience popular attractions with fewer crowds.</li>
                <li><strong>Talk to locals</strong> - Get insider tips and recommendations.</li>
                <li><strong>Try local cuisine</strong> - Step out of your comfort zone.</li>
                <li><strong>Take guided tours</strong> - Learn about history and culture.</li>
                <li><strong>Document your journey</strong> - But don't forget to live in the moment.</li>
            </ol>
            
            <h2>Conclusion</h2>
            <p>Travel is an incredible opportunity to learn, grow, and create lasting memories. By following these essential tips, you'll be well-prepared for whatever adventures await. Remember to stay flexible, embrace new experiences, and most importantly, enjoy every moment of your journey!</p>
        `
    },
    2: {
        title: "Student Visa Application: Complete Step-by-Step Guide",
        author: "Michael Chen",
        date: "5 days ago",
        category: "Visa Guide",
        image: "https://images.unsplash.com/photo-1526494097098-586132821b0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80",
        content: `
            <h2>Introduction to Student Visas</h2>
            <p>Applying for a student visa can be a complex process, but with proper guidance and preparation, you can navigate it successfully. This comprehensive guide will walk you through every step of the student visa application process.</p>
            
            <h2>Step 1: Research and Preparation</h2>
            <h3>Understand Visa Requirements</h3>
            <p>Before starting your application, research the specific student visa requirements for your chosen country. Each country has different requirements, processing times, and documentation needs.</p>
            
            <h3>Check Eligibility Criteria</h3>
            <ul>
                <li>Academic requirements (GPA, test scores)</li>
                <li>English language proficiency</li>
                <li>Financial capacity</li>
                <li>Health and character requirements</li>
            </ul>
            
            <h2>Step 2: Document Preparation</h2>
            <h3>Essential Documents</h3>
            <ul>
                <li><strong>Valid Passport</strong> - Must be valid for the duration of your study</li>
                <li><strong>Acceptance Letter</strong> - From your chosen educational institution</li>
                <li><strong>Academic Transcripts</strong> - Certified copies of previous education</li>
                <li><strong>English Test Scores</strong> - IELTS, TOEFL, or equivalent</li>
                <li><strong>Financial Documents</strong> - Bank statements, scholarship letters</li>
                <li><strong>Health Insurance</strong> - Proof of coverage</li>
                <li><strong>Passport Photos</strong> - Recent photographs meeting specifications</li>
            </ul>
            
            <h2>Step 3: Online Application</h2>
            <h3>Create Your Account</h3>
            <p>Most countries now use online visa application systems. Create an account on the official immigration website of your destination country.</p>
            
            <h3>Fill Out the Application Form</h3>
            <ul>
                <li>Provide accurate personal information</li>
                <li>Complete all required fields</li>
                <li>Upload supporting documents</li>
                <li>Pay the application fee</li>
            </ul>
            
            <h2>Step 4: Biometrics and Medical Examination</h2>
            <h3>Schedule Biometrics Appointment</h3>
            <p>Most countries require biometric data (fingerprints and photograph). Schedule an appointment at the designated visa application center.</p>
            
            <h3>Complete Medical Examination</h3>
            <p>Visit an approved panel physician for a medical examination if required by your destination country.</p>
            
            <h2>Step 5: Interview Preparation</h2>
            <h3>Common Interview Questions</h3>
            <ul>
                <li>Why did you choose this country/university?</li>
                <li>What is your study plan?</li>
                <li>How will you finance your studies?</li>
                <li>What are your career goals after graduation?</li>
                <li>Do you have family or friends in the country?</li>
            </ul>
            
            <h3>Tips for Success</h3>
            <ul>
                <li>Practice your answers</li>
                <li>Dress professionally</li>
                <li>Bring all required documents</li>
                <li>Be confident and honest</li>
                <li>Arrive early</li>
            </ul>
            
            <h2>Step 6: Post-Application</h2>
            <h3>Track Your Application</h3>
            <p>Use the online tracking system to monitor your application status. Processing times vary by country and season.</p>
            
            <h3>Prepare for Arrival</h3>
            <ul>
                <li>Book your flight</li>
                <li>Arrange accommodation</li>
                <li>Pack essential items</li>
                <li>Exchange currency</li>
                <li>Download important apps</li>
            </ul>
            
            <h2>Common Mistakes to Avoid</h2>
            <ul>
                <li>Submitting incomplete applications</li>
                <li>Providing false information</li>
                <li>Missing deadlines</li>
                <li>Not preparing for interviews</li>
                <li>Insufficient financial proof</li>
            </ul>
            
            <h2>Conclusion</h2>
            <p>The student visa application process requires careful planning and attention to detail. Start early, follow all instructions carefully, and seek professional help if needed. Good luck with your application!</p>
        `
    }
};

function filterBlogPosts(category) {
    // Update active button
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filter posts
    const posts = document.querySelectorAll('.blog-card');
    posts.forEach(post => {
        if (category === 'all' || post.dataset.category === category) {
            post.style.display = 'block';
        } else {
            post.style.display = 'none';
        }
    });
}

function showBlogPost(postId) {
    const post = blogPosts[postId];
    if (!post) return;
    
    document.getElementById('blogModalTitle').textContent = post.title;
    document.getElementById('blogModalBody').innerHTML = `
        <div class="blog-post-content">
            <img src="${post.image}" class="img-fluid rounded mb-4" alt="${post.title}">
            <div class="blog-meta mb-3">
                <span class="badge bg-primary">${post.category}</span>
                <small class="text-muted ms-2">${post.date}</small>
                <span class="ms-3">By ${post.author}</span>
            </div>
            <div class="blog-content">
                ${post.content}
            </div>
            <div class="mt-4">
                <h5>Share this post:</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-facebook"></i>
                    </button>
                    <button class="btn btn-outline-info btn-sm">
                        <i class="bi bi-twitter"></i>
                    </button>
                    <button class="btn btn-outline-success btn-sm">
                        <i class="bi bi-whatsapp"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-link-45deg"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('blogPostModal'));
    modal.show();
}

function loadMoreBlogPosts() {
    // In real app, this would load more posts from the server
    showToast('All posts loaded', 'info');
    event.target.style.display = 'none';
}

// Blog search
document.getElementById('blogSearchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const searchTerm = document.getElementById('blogSearchInput').value.toLowerCase();
    
    if (searchTerm) {
        // Filter posts based on search term
        const posts = document.querySelectorAll('.blog-card');
        let found = false;
        
        posts.forEach(post => {
            const title = post.querySelector('.card-title').textContent.toLowerCase();
            const content = post.querySelector('.card-text').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                post.style.display = 'block';
                found = true;
            } else {
                post.style.display = 'none';
            }
        });
        
        if (!found) {
            showToast('No posts found matching your search', 'info');
        }
    } else {
        // Show all posts
        document.querySelectorAll('.blog-card').forEach(post => {
            post.style.display = 'block';
        });
    }
});

// Newsletter subscription
document.getElementById('newsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    showToast('Successfully subscribed to newsletter!', 'success');
    this.reset();
});
</script>
@endpush