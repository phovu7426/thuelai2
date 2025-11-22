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
    font-size: clamp(3rem, 8vw, 4.5rem);
    font-weight: 900;
    margin-bottom: 1.5rem;
}

.hero-description {
    font-size: 1.25rem;
    opacity: 0.95;
}

.news-grid {
    padding: 50px 0;
    background: #f8fafc;
}

.news-filters {
    margin-bottom: 40px;
    text-align: center;
}

.filter-btn {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 10px 20px;
    margin: 5px;
    border-radius: 30px;
    transition: all 0.3s ease;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
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
    height: 220px;
    overflow: hidden;
    position: relative;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-category {
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--gradient-primary);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
}

.news-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.news-date {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.news-title {
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: 15px;
    flex-grow: 1;
}

.news-title a {
    color: var(--dark-color);
    text-decoration: none;
}

.news-excerpt {
    color: #64748b;
    margin-bottom: 20px;
    font-size: 0.95rem;
    line-height: 1.6;
}

.news-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
    margin-top: auto;
}

.read-more {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 700;
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
    font-size: 1.4rem;
    font-weight: 800;
    margin-bottom: 25px;
}

.popular-news-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.popular-news-image {
    width: 70px;
    height: 70px;
    border-radius: 15px;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.popular-news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popular-news-content h5 a {
    color: var(--dark-color);
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
}

.categories-list {
    list-style: none;
    padding: 0;
}

.categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #f8fafc;
    border-radius: 12px;
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.categories-list a:hover {
    background: var(--gradient-primary);
    color: white;
}

.categories-list .count {
    background: #e2e8f0;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.categories-list a:hover .count {
    background: rgba(255,255,255,0.2);
    color: white;
}

.quick-contact {
    background: var(--gradient-primary);
    padding: 25px;
    border-radius: 15px;
    color: white;
    text-align: center;
    margin-top: 30px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-md);
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
                        <p>Không có bài viết phổ biến.</p>
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