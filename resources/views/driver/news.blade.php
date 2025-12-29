@extends('driver.layouts.main')

@section('title', 'Tin tức - Dịch vụ tài xế thuê lái')

@section('meta')
<meta name="description" content="Tin tức mới nhất về dịch vụ tài xế thuê lái, mẹo lái xe an toàn, và các thông tin hữu ích khác.">
<meta name="keywords" content="tin tức tài xế, mẹo lái xe, dịch vụ thuê lái, an toàn giao thông">
@endsection

@push('styles')
<style>
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --accent-color: #ec4899;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --dark-color: #1f2937;
    --light-color: #f8fafc;
    --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    --font-family-heading: "Poppins", sans-serif;
}

/* Base Typography */
.news-grid {
    font-family: var(--font-family);
    font-size: 1rem;
    line-height: 1.7;
    color: #334155;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.hero-section {
    position: relative;
    min-height: 80vh;
    display: flex;
    align-items: center;
    background: var(--gradient-primary);
    overflow: hidden;
    padding-top: 80px;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(99, 102, 241, 0.9) 0%, 
        rgba(139, 92, 246, 0.8) 50%, 
        rgba(236, 72, 153, 0.7) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
}

.hero-title {
    font-family: var(--font-family-heading);
    font-size: clamp(2rem, 8vw, 3.5rem);
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
}

.hero-description {
    font-family: var(--font-family);
    font-size: clamp(1rem, 2vw, 1.25rem);
    line-height: 1.6;
    opacity: 0.95;
    font-weight: 400;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: var(--font-size-mobile-3xl);
    }
    
    .hero-description {
        font-size: var(--font-size-mobile-base);
    }
    
    .news-image {
        padding-bottom: 60%;
    }
    
    .news-card {
        margin-bottom: 1.5rem;
    }
}

.news-grid {
    padding: 50px 0;
    background: #f8fafc;
}

.news-filters {
    margin-bottom: 40px;
    text-align: center;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    align-items: center;
}

.filter-btn {
    font-family: var(--font-family);
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 10px 20px;
    border-radius: 30px;
    transition: all 0.3s ease;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.95rem;
    line-height: 1.5;
    text-decoration: none;
    display: inline-block;
    white-space: nowrap;
}

.filter-btn:hover, .filter-btn.active {
    background: var(--gradient-primary);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.news-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.news-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.news-image {
    width: 100%;
    height: 0;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    overflow: hidden;
    position: relative;
    background: #f1f5f9;
    border-radius: 20px 20px 0 0;
}

.news-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.4s ease;
    display: block;
}

.news-card:hover .news-image img {
    transform: scale(1.08);
}

.news-category {
    font-family: var(--font-family);
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--gradient-primary);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    line-height: 1.4;
    text-decoration: none;
}

.news-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.news-date {
    font-family: var(--font-family);
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.5;
    margin-bottom: 12px;
}

.news-title {
    font-family: var(--font-family-heading);
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 12px;
    flex-grow: 1;
}

.news-title a {
    color: var(--dark-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.news-title a:hover {
    color: var(--primary-color);
}

.news-excerpt {
    font-family: var(--font-family);
    color: #64748b;
    margin-bottom: 16px;
    font-size: 0.9375rem;
    line-height: 1.7;
    font-weight: 400;
}

.news-meta {
    font-family: var(--font-family);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
    margin-top: auto;
}

.news-views {
    font-size: 0.875rem;
    color: #94a3b8;
    font-weight: 500;
    line-height: 1.5;
}

.read-more {
    font-family: var(--font-family);
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    line-height: 1.5;
    transition: all 0.3s ease;
}

.read-more:hover {
    color: var(--secondary-color);
}

.news-sidebar {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    position: sticky;
    top: 100px;
}

.sidebar-title {
    font-family: var(--font-family-heading);
    font-size: 1.375rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 20px;
    color: var(--dark-color);
}

.popular-news-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.popular-news-image {
    width: 70px;
    height: 70px;
    min-width: 70px;
    border-radius: 15px;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.popular-news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.3s ease;
    display: block;
}

.popular-news-item:hover .popular-news-image img {
    transform: scale(1.1);
}

.popular-news-content h5 {
    font-family: var(--font-family-heading);
    font-size: 0.9375rem;
    font-weight: 600;
    line-height: 1.5;
    margin-bottom: 6px;
}

.popular-news-content h5 a {
    color: var(--dark-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.popular-news-content h5 a:hover {
    color: var(--primary-color);
}

.categories-list {
    list-style: none;
    padding: 0;
}

.categories-list a {
    font-family: var(--font-family);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background: #f8fafc;
    border-radius: 12px;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9375rem;
    line-height: 1.5;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.categories-list a:hover {
    background: var(--gradient-primary);
    color: white;
}

.categories-list .count {
    font-family: var(--font-family);
    background: #e2e8f0;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.8125rem;
    font-weight: 600;
    line-height: 1.4;
    transition: all 0.3s ease;
}

.categories-list a:hover .count {
    background: rgba(255,255,255,0.2);
    color: white;
}

.quick-contact {
    font-family: var(--font-family);
    background: var(--gradient-primary);
    padding: 25px;
    border-radius: 15px;
    color: white;
    text-align: center;
    margin-top: 30px;
}

.quick-contact .sidebar-title {
    color: white;
}

.quick-contact .btn {
    font-family: var(--font-family);
    font-weight: 600;
    font-size: 0.9375rem;
    line-height: 1.5;
}

.empty-state {
    font-family: var(--font-family);
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-md);
}

.empty-state h4 {
    font-family: var(--font-family-heading);
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 12px;
    color: var(--dark-color);
}

.empty-state p {
    font-size: 1rem;
    line-height: 1.6;
    color: #64748b;
    font-weight: 400;
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Tin tức & Blog</h1>
            <p class="hero-description">Cập nhật những tin tức mới nhất, mẹo lái xe an toàn và thông tin hữu ích.</p>
        </div>
    </div>
</section>

<!-- News Grid Section -->
<section class="news-grid" id="news-grid">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Filters -->
                <div class="news-filters">
                    <a href="{{ route('driver.news') }}" class="filter-btn {{ request()->get('category') ? '' : 'active' }}">Tất cả</a>
                    @foreach($categories as $category)
                        <a href="{{ route('driver.news', ['category' => $category->slug]) }}" class="filter-btn {{ request()->get('category') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>

                <!-- News Grid -->
                <div class="row">
                    @forelse($posts as $post)
                        <div class="col-md-4 mb-4">
                            <article class="news-card">
                                <div class="news-image">
                                    <img src="{{ $post->image ?? asset('images/default-post.jpg') }}" alt="{{ $post->title }}">
                                    @if($post->category)
                                    <a href="{{ route('driver.news.category', $post->category->slug) }}" class="news-category">
                                        {{ $post->category->name }}
                                    </a>
                                    @endif
                                </div>
                                <div class="news-content">
                                    <div class="news-date">
                                        <i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('d/m/Y') }}
                                    </div>
                                    <h3 class="news-title">
                                        <a href="{{ route('driver.news.detail', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    <p class="news-excerpt">{{ Str::limit($post->excerpt ?? $post->content, 120) }}</p>
                                    <div class="news-meta">
                                        <a href="{{ route('driver.news.detail', $post->slug) }}" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                                        <span class="news-views"><i class="fas fa-eye"></i> {{ $post->views ?? 0 }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <h4>Không tìm thấy bài viết</h4>
                                <p>Chưa có bài viết nào trong danh mục này.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="pagination-wrapper mt-4 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="news-sidebar">
                    <!-- Popular News -->
                    <div class="popular-news mb-5">
                        <h4 class="sidebar-title">Bài viết phổ biến</h4>
                        @forelse($popularPosts as $popularPost)
                        <div class="popular-news-item">
                            <div class="popular-news-image">
                                <img src="{{ $popularPost->image ?? asset('images/default-post.jpg') }}" alt="{{ $popularPost->title }}">
                            </div>
                            <div class="popular-news-content">
                                <h5><a href="{{ route('driver.news.detail', $popularPost->slug) }}">{{ Str::limit($popularPost->title, 50) }}</a></h5>
                                <div class="news-date">{{ $popularPost->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        @empty
                        <p style="font-family: var(--font-family); font-size: 0.9375rem; color: #64748b; line-height: 1.6;">Không có bài viết phổ biến.</p>
                        @endforelse
                    </div>

                    <!-- Categories -->
                    <div class="news-categories mb-5">
                        <h4 class="sidebar-title">Danh mục</h4>
                        <ul class="categories-list">
                             <li><a href="{{ route('driver.news') }}">Tất cả <span class="count">{{ $totalPosts }}</span></a></li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('driver.news', ['category' => $category->slug]) }}">{{ $category->name }} <span class="count">{{ $category->posts_count }}</span></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Quick Contact -->
                    @if($contactInfo)
                    <div class="quick-contact">
                        <h4 class="sidebar-title">Liên hệ nhanh</h4>
                        @if($contactInfo && $contactInfo->phone)
                        <a href="tel:{{ $contactInfo->phone }}" class="btn btn-light btn-lg w-100 mb-2"><i class="fas fa-phone"></i> {{ $contactInfo->phone }}</a>
                        @endif
                        <a href="{{ route('driver.contact') }}" class="btn btn-outline-light w-100"><i class="fas fa-envelope"></i> Gửi tin nhắn</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection