@extends('driver.layouts.main')

@section('title', 'Giới thiệu - Dịch vụ tài xế thuê lái')

@section('meta')
<meta name="description" content="Tìm hiểu về công ty dịch vụ tài xế thuê lái, sứ mệnh, tầm nhìn và cam kết chất lượng của chúng tôi.">
<meta name="keywords" content="giới thiệu công ty, sứ mệnh tầm nhìn, đội ngũ tài xế, cam kết chất lượng">
@endsection

@push('styles')
<style>
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: var(--gradient-dark);
    overflow: hidden;
    padding-top: 80px; /* Add padding for fixed header */
}

.hero-video-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        rgba(99, 102, 241, 0.8) 0%, 
        rgba(139, 92, 246, 0.6) 50%, 
        rgba(236, 72, 153, 0.4) 100%);
}

.hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
    background-size: 400px 400px, 300px 300px, 200px 200px;
    animation: float-particles 20s ease-in-out infinite;
}

@keyframes float-particles {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: var(--white);
    max-width: 800px;
    margin: 0 auto;
    padding: 0 1rem;
    width: 100%;
}

.hero-badge {
    margin-bottom: 2rem;
}

.badge-glow {
    display: inline-block;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.hero-title {
    font-size: clamp(2.5rem, 8vw, 4rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 1.5rem;
}

.title-line {
    display: block;
}

.title-highlight {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-description {
    font-size: 1.25rem;
    margin-bottom: 3rem;
    opacity: 0.9;
    line-height: 1.7;
}

.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
}

.scroll-arrow {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    animation: bounce 2s infinite;
    cursor: pointer;
    transition: all 0.3s ease;
}

.scroll-arrow:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-50%) scale(1.1);
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

.about-content {
    padding: 80px 0;
    margin-top: 20px; /* Add margin for better spacing */
}

.section-title {
    text-align: center;
    margin-bottom: 60px;
}

.section-title h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.section-title p {
    font-size: 1.1rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
}

.about-story {
    margin-bottom: 80px;
}

.story-content {
    padding: 40px 0;
}

.story-content h3 {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
}

.story-content p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 1.5rem;
}

.story-image {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.story-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mission-vision {
    background: #f8f9fa;
    padding: 80px 0;
    margin: 80px 0;
}

.mission-card,
.vision-card {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    height: 100%;
    transition: transform 0.3s ease;
}

.mission-card:hover,
.vision-card:hover {
    transform: translateY(-5px);
}

.mission-card .icon,
.vision-card .icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    color: white;
    font-size: 2rem;
}

.mission-card h4,
.vision-card h4 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.mission-card p,
.vision-card p {
    color: #6c757d;
    line-height: 1.6;
}

.values-section {
    margin-bottom: 80px;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.value-item {
    text-align: center;
    padding: 30px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.value-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.value-item .icon {
    width: 70px;
    height: 70px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 1.8rem;
}

.value-item h5 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.value-item p {
    color: #6c757d;
    line-height: 1.6;
}

.team-section {
    background: #f8f9fa;
    padding: 80px 0;
    margin: 80px 0;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.team-member {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.team-member:hover {
    transform: translateY(-5px);
}

.team-photo {
    height: 250px;
    overflow: hidden;
}

.team-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-member:hover .team-photo img {
    transform: scale(1.1);
}

.team-info {
    padding: 25px;
    text-align: center;
}

.team-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.team-position {
    color: #007bff;
    font-weight: 500;
    margin-bottom: 1rem;
}

.team-description {
    color: #6c757d;
    line-height: 1.6;
    font-size: 0.95rem;
}

.office-section {
    margin-bottom: 80px;
}

.office-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.office-item {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.office-item:hover {
    transform: translateY(-5px);
}

.office-image {
    height: 200px;
    overflow: hidden;
}

.office-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.office-item:hover .office-image img {
    transform: scale(1.1);
}

.office-info {
    padding: 25px;
    background: white;
}

.office-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.office-description {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 0;
}

.quality-commitment {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.quality-commitment h3 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 2rem;
}

.quality-commitment p {
    font-size: 1.1rem;
    opacity: 0.9;
    max-width: 800px;
    margin: 0 auto 3rem;
    line-height: 1.6;
}

.commitment-items {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.commitment-item {
    text-align: center;
}

.commitment-item .icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 2rem;
}

.commitment-item h5 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.commitment-item p {
    opacity: 0.8;
    line-height: 1.6;
}

.stats-section {
    padding: 80px 0;
    background: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    text-align: center;
}

.stat-item {
    padding: 20px;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 1rem;
    display: block;
}

.stat-label {
    font-size: 1.1rem;
    color: #6c757d;
    font-weight: 500;
}

@media (max-width: 768px) {
    .hero-section {
        padding-top: 100px; /* Adjust padding for mobile */
        min-height: 80vh;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
    
    .section-title h2 {
        font-size: 2rem;
    }
    
    .story-content h3 {
        font-size: 1.5rem;
    }
    
    .values-grid,
    .team-grid,
    .office-grid {
        grid-template-columns: 1fr;
    }
    
    .commitment-items {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-video-bg">
        <video autoplay muted loop>
            <source src="{{ asset('videos/hero-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-particles"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="badge-glow">Dịch vụ tài xế thuê lái</span>
        </div>
        <h1 class="hero-title">
            <span class="title-line">Về</span>
            <span class="title-highlight">Chúng Tôi</span>
        </h1>
        <p class="hero-description">
            Chúng tôi là đơn vị tiên phong trong lĩnh vực dịch vụ tài xế thuê lái tại Việt Nam, cam kết mang đến sự an toàn, tiện lợi và chuyên nghiệp cho mọi khách hàng.
        </p>
        <a href="#about-story" class="scroll-indicator">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </a>
    </div>
</section>

<!-- About Story Section -->
<section class="about-content" id="about-story">
    <div class="container">
        <div class="section-title">
            <h2>Câu Chuyện Của Chúng Tôi</h2>
            <p>Hành trình xây dựng thương hiệu dịch vụ tài xế thuê lái hàng đầu Việt Nam</p>
        </div>

        <div class="about-story">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="story-content">
                        <h3>Khởi Nguồn</h3>
                        <p>Được thành lập vào năm 2020, chúng tôi bắt đầu với một tầm nhìn rõ ràng: tạo ra một dịch vụ tài xế thuê lái an toàn, đáng tin cậy và tiện lợi cho người dân Việt Nam.</p>
                        <p>Xuất phát từ nhu cầu thực tế của xã hội, khi nhiều người cần tài xế có kinh nghiệm để đảm bảo an toàn cho bản thân và gia đình, chúng tôi đã xây dựng một hệ thống dịch vụ hoàn chỉnh.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="story-image">
                        <img src="{{ asset('images/projects/project-1.jpg') }}" alt="Khởi nguồn công ty">
                    </div>
                </div>
            </div>
        </div>

        <div class="about-story">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="story-content">
                        <h3>Phát Triển</h3>
                        <p>Từ một nhóm nhỏ với vài tài xế, chúng tôi đã phát triển thành một đội ngũ hơn 100 tài xế chuyên nghiệp, phục vụ khắp các tỉnh thành lớn của Việt Nam.</p>
                        <p>Chúng tôi không ngừng cải tiến chất lượng dịch vụ, áp dụng công nghệ hiện đại để mang đến trải nghiệm tốt nhất cho khách hàng.</p>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="story-image">
                        <img src="{{ asset('images/projects/project-2.jpg') }}" alt="Phát triển công ty">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission-vision">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="mission-card">
                    <div class="icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4>Sứ Mệnh</h4>
                    <p>Mang đến dịch vụ tài xế thuê lái an toàn, chất lượng và tiện lợi, góp phần nâng cao chất lượng cuộc sống và đảm bảo an toàn giao thông cho cộng đồng.</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="vision-card">
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4>Tầm Nhìn</h4>
                    <p>Trở thành đơn vị tiên phong và uy tín nhất trong lĩnh vực dịch vụ tài xế thuê lái tại Việt Nam, mở rộng dịch vụ ra toàn quốc và khu vực Đông Nam Á.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="about-content">
    <div class="container">
        <div class="section-title">
            <h2>Giá Trị Cốt Lõi</h2>
            <p>Những nguyên tắc và giá trị định hướng mọi hoạt động của chúng tôi</p>
        </div>

        <div class="values-section">
            <div class="values-grid">
                <div class="value-item">
                    <div class="icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>An Toàn</h5>
                    <p>Đặt sự an toàn của khách hàng lên hàng đầu, đảm bảo mọi chuyến đi đều được thực hiện một cách an toàn tuyệt đối.</p>
                </div>
                <div class="value-item">
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5>Uy Tín</h5>
                    <p>Xây dựng niềm tin với khách hàng thông qua chất lượng dịch vụ nhất quán và cam kết thực hiện đúng những gì đã hứa.</p>
                </div>
                <div class="value-item">
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5>Chất Lượng</h5>
                    <p>Không ngừng nâng cao chất lượng dịch vụ, từ việc tuyển chọn tài xế đến quy trình phục vụ khách hàng.</p>
                </div>
                <div class="value-item">
                    <div class="icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5>Tận Tâm</h5>
                    <p>Phục vụ khách hàng với tất cả sự tận tâm, lắng nghe và đáp ứng mọi nhu cầu một cách chu đáo nhất.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="section-title">
            <h2>Đội Ngũ Của Chúng Tôi</h2>
            <p>Những con người tài năng và tâm huyết đang ngày đêm phục vụ khách hàng</p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <div class="team-photo">
                    <img src="{{ asset('images/users/avatar-1.jpg') }}" alt="Giám đốc điều hành">
                </div>
                <div class="team-info">
                    <h5 class="team-name">Nguyễn Văn An</h5>
                    <div class="team-position">Giám Đốc Điều Hành</div>
                    <p class="team-description">Với hơn 15 năm kinh nghiệm trong lĩnh vực vận tải và dịch vụ khách hàng, anh An đã dẫn dắt công ty phát triển từ một startup nhỏ thành doanh nghiệp uy tín.</p>
                </div>
            </div>
            <div class="team-member">
                <div class="team-photo">
                    <img src="{{ asset('images/users/avatar-2.jpg') }}" alt="Trưởng phòng vận hành">
                </div>
                <div class="team-info">
                    <h5 class="team-name">Trần Thị Bình</h5>
                    <div class="team-position">Trưởng Phòng Vận Hành</div>
                    <p class="team-description">Chị Bình chịu trách nhiệm quản lý đội ngũ tài xế, đảm bảo chất lượng dịch vụ và sự hài lòng của khách hàng.</p>
                </div>
            </div>
            <div class="team-member">
                <div class="team-photo">
                    <img src="{{ asset('images/users/avatar-3.jpg') }}" alt="Trưởng phòng kỹ thuật">
                </div>
                <div class="team-info">
                    <h5 class="team-name">Lê Văn Cường</h5>
                    <div class="team-position">Trưởng Phòng Kỹ Thuật</div>
                    <p class="team-description">Anh Cường đảm nhiệm việc phát triển và vận hành hệ thống công nghệ, đảm bảo website và ứng dụng hoạt động ổn định.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Office Section -->
<section class="about-content">
    <div class="container">
        <div class="section-title">
            <h2>Văn Phòng & Cơ Sở</h2>
            <p>Hệ thống văn phòng và cơ sở vật chất hiện đại phục vụ khách hàng</p>
        </div>

        <div class="office-section">
            <div class="office-grid">
                <div class="office-item">
                    <div class="office-image">
                        <img src="{{ asset('images/layouts/layout-1.png') }}" alt="Trụ sở chính">
                    </div>
                    <div class="office-info">
                        <h5 class="office-title">Trụ Sở Chính</h5>
                        <p class="office-description">Tòa nhà A, 123 Đường ABC, Quận 1, TP.HCM. Đây là trung tâm điều hành chính của công ty, nơi tiếp đón khách hàng và xử lý các yêu cầu dịch vụ.</p>
                    </div>
                </div>
                <div class="office-item">
                    <div class="office-image">
                        <img src="{{ asset('images/layouts/layout-2.png') }}" alt="Chi nhánh Hà Nội">
                    </div>
                    <div class="office-info">
                        <h5 class="office-title">Chi Nhánh Hà Nội</h5>
                        <p class="office-description">Tầng 5, Tòa nhà B, 456 Đường XYZ, Quận Ba Đình, Hà Nội. Chi nhánh phục vụ khách hàng khu vực miền Bắc.</p>
                    </div>
                </div>
                <div class="office-item">
                    <div class="office-image">
                        <img src="{{ asset('images/layouts/layout-3.png') }}" alt="Trung tâm đào tạo">
                    </div>
                    <div class="office-info">
                        <h5 class="office-title">Trung Tâm Đào Tạo</h5>
                        <p class="office-description">789 Đường DEF, Quận 7, TP.HCM. Nơi đào tạo và nâng cao kỹ năng cho đội ngũ tài xế chuyên nghiệp.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">100+</span>
                <div class="stat-label">Tài Xế Chuyên Nghiệp</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">10,000+</span>
                <div class="stat-label">Chuyến Đi Thành Công</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">5,000+</span>
                <div class="stat-label">Khách Hàng Hài Lòng</div>
            </div>
            <div class="stat-item">
                <span class="stat-number">3</span>
                <div class="stat-label">Tỉnh Thành Phục Vụ</div>
            </div>
        </div>
    </div>
</section>

<!-- Quality Commitment Section -->
<section class="quality-commitment">
    <div class="container">
        <h3>Cam Kết Chất Lượng</h3>
        <p>Chúng tôi cam kết mang đến dịch vụ tốt nhất với những tiêu chuẩn chất lượng cao nhất</p>

        <div class="commitment-items">
            <div class="commitment-item">
                <div class="icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h5>Chứng Chỉ Hành Nghề</h5>
                <p>Tất cả tài xế đều có chứng chỉ hành nghề và được đào tạo bài bản về an toàn giao thông.</p>
            </div>
            <div class="commitment-item">
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h5>Phục Vụ 24/7</h5>
                <p>Dịch vụ hoạt động 24/7, sẵn sàng phục vụ khách hàng mọi lúc, mọi nơi.</p>
            </div>
            <div class="commitment-item">
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5>Bảo Hiểm Đầy Đủ</h5>
                <p>Mọi chuyến đi đều được bảo hiểm đầy đủ, đảm bảo an toàn cho khách hàng và tài xế.</p>
            </div>
            <div class="commitment-item">
                <div class="icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h5>Hỗ Trợ Khách Hàng</h5>
                <p>Đội ngũ hỗ trợ khách hàng chuyên nghiệp, sẵn sàng giải đáp mọi thắc mắc.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats on scroll
    const stats = document.querySelectorAll('.stat-number');
    const statsSection = document.querySelector('.stats-section');
    
    const animateStats = () => {
        stats.forEach(stat => {
            const target = parseInt(stat.textContent.replace(/\D/g, ''));
            const increment = target / 100;
            let current = 0;
            
            const updateStat = () => {
                if (current < target) {
                    current += increment;
                    stat.textContent = Math.ceil(current) + stat.textContent.replace(/\d/g, '');
                    requestAnimationFrame(updateStat);
                } else {
                    stat.textContent = target + stat.textContent.replace(/\d/g, '');
                }
            };
            
            updateStat();
        });
    };
    
    // Intersection Observer for stats animation
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateStats();
                statsObserver.unobserve(entry.target);
            }
        });
    });
    
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush
