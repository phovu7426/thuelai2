// Driver Service Website JavaScript

// FAQ Functionality
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Close other open items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Initialize all components
    initScrollAnimations();
    initSmoothScrolling();
    initFormValidation();
    initServiceBooking();
    initMobileMenu();
    initFloatingSocial();
    initFAQ();
});

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, observerOptions);

    // Observe all fade-in elements
    document.querySelectorAll(".fade-in").forEach((el) => {
        observer.observe(el);
    });
}

// Smooth Scrolling
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
}

// Form Validation
function initFormValidation() {
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showAlert("Vui lòng kiểm tra lại thông tin!", "danger");
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll("[required]");

    requiredFields.forEach((field) => {
        if (!field.value.trim()) {
            field.classList.add("is-invalid");
            isValid = false;
        } else {
            field.classList.remove("is-invalid");
        }
    });

    // Validate phone number
    const phoneField = form.querySelector('input[type="tel"]');
    if (phoneField && phoneField.value) {
        const phoneRegex = /^[0-9+\-\s()]{10,}$/;
        if (!phoneRegex.test(phoneField.value)) {
            phoneField.classList.add("is-invalid");
            isValid = false;
        }
    }

    // Validate email
    const emailField = form.querySelector('input[type="email"]');
    if (emailField && emailField.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            emailField.classList.add("is-invalid");
            isValid = false;
        }
    }

    return isValid;
}

// Service Booking
function initServiceBooking() {
    const bookButtons = document.querySelectorAll(".book-service-btn");
    bookButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const serviceId = this.getAttribute("data-service-id");
            const serviceName = this.getAttribute("data-service-name");

            // Scroll to booking form
            const bookingForm = document.getElementById("booking-form");
            if (bookingForm) {
                bookingForm.scrollIntoView({ behavior: "smooth" });

                // Auto-select service
                const serviceSelect =
                    document.getElementById("driver_service_id");
                if (serviceSelect) {
                    serviceSelect.value = serviceId;
                    // Trigger change event
                    serviceSelect.dispatchEvent(new Event("change"));
                }
            }
        });
    });
}

// Mobile Menu
function initMobileMenu() {
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
        // Close mobile menu when clicking on a link
        const navLinks = navbarCollapse.querySelectorAll(".nav-link");
        navLinks.forEach((link) => {
            link.addEventListener("click", () => {
                if (window.innerWidth < 992) {
                    navbarCollapse.classList.remove("show");
                }
            });
        });
    }
}


// Alert System
function showAlert(message, type = "info", duration = 5000) {
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Position the alert
    alertDiv.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 500px;
    `;

    document.body.appendChild(alertDiv);

    // Auto-remove after duration
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, duration);
}

// Loading Spinner
function showLoading(element) {
    const spinner = document.createElement("span");
    spinner.className = "loading-spinner me-2";
    element.appendChild(spinner);
    element.disabled = true;
}

function hideLoading(element) {
    const spinner = element.querySelector(".loading-spinner");
    if (spinner) {
        spinner.remove();
    }
    element.disabled = false;
}

// Price Calculator
function calculatePrice(serviceType, hours, basePrice) {
    let totalPrice = 0;

    switch (serviceType) {
        case "hourly":
            totalPrice = basePrice * hours;
            break;
        case "trip":
            totalPrice = basePrice;
            break;
        case "custom":
            totalPrice = basePrice * 4; // Default 4 hours
            break;
        default:
            totalPrice = 0;
    }

    return totalPrice;
}

// Service Type Change Handler
function handleServiceTypeChange() {
    const serviceTypeSelect = document.getElementById("service_type");
    const hoursInput = document.getElementById("hours");

    if (serviceTypeSelect && hoursInput) {
        serviceTypeSelect.addEventListener("change", function () {
            if (this.value === "hourly") {
                hoursInput.style.display = "block";
                hoursInput.required = true;
            } else {
                hoursInput.style.display = "none";
                hoursInput.required = false;
            }
        });
    }
}

// Initialize service type handler
document.addEventListener("DOMContentLoaded", function () {
    handleServiceTypeChange();
});

// Lazy Loading for Images
function initLazyLoading() {
    const images = document.querySelectorAll("img[data-src]");

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove("lazy");
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach((img) => imageObserver.observe(img));
}

// Initialize lazy loading
document.addEventListener("DOMContentLoaded", function () {
    initLazyLoading();
});

// Counter Animation
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);

    function updateCounter() {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start);
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target;
        }
    }

    updateCounter();
}

// Initialize counter animations when elements come into view
function initCounterAnimations() {
    const counters = document.querySelectorAll("[data-counter]");

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.dataset.counter);
                animateCounter(counter, target);
                counterObserver.unobserve(counter);
            }
        });
    });

    counters.forEach((counter) => counterObserver.observe(counter));
}

// Initialize counter animations
document.addEventListener("DOMContentLoaded", function () {
    initCounterAnimations();
});

// Utility Functions
function formatCurrency(amount) {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(amount);
}

function formatPhoneNumber(phone) {
    return phone.replace(/(\d{4})(\d{3})(\d{3})/, "$1 $2 $3");
}

// Floating Social Icons
function initFloatingSocial() {
    // Get individual social buttons
    const zaloBtn = document.getElementById("zaloBtn");
    const facebookBtn = document.getElementById("facebookBtn");
    const phoneBtn = document.getElementById("phoneBtn");

    // Zalo integration
    if (zaloBtn) {
        zaloBtn.addEventListener("click", () => {
            // Thay bằng số điện thoại thực tế của bạn (định dạng: 84xxxxxxxxx)
            const phoneNumber = "84398982112"; // VD: 84987654321 cho số 0987654321
            const message = encodeURIComponent(
                "Xin chào! Tôi muốn tư vấn dịch vụ lái xe thuê từ website laixeho.net.vn"
            );

            // Kiểm tra nếu đang trên mobile
            const isMobile =
                /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent
                );

            if (isMobile) {
                // Thử mở Zalo app trước
                const zaloAppUrl = `zalo://chat?phone=${phoneNumber}&message=${message}`;
                window.location.href = zaloAppUrl;

                // Fallback sau 2 giây nếu app không mở được
                setTimeout(() => {
                    // Mở trang Zalo OA hoặc profile
                    const zaloWebUrl = `https://zalo.me/${phoneNumber}`;
                    window.open(zaloWebUrl, "_blank");
                }, 2000);
            } else {
                // Trên desktop, hiển thị popup hướng dẫn
                showZaloInstructions(phoneNumber);
            }
        });
    }

    // Facebook Messenger integration
    if (facebookBtn) {
        facebookBtn.addEventListener("click", () => {
            const facebookPageId = "your-facebook-page-id"; // Thay bằng Page ID thực tế
            const message = encodeURIComponent(
                "Xin chào! Tôi muốn tư vấn dịch vụ lái xe thuê."
            );

            // Mở Facebook Messenger
            window.open(
                `https://m.me/${facebookPageId}?text=${message}`,
                "_blank"
            );
        });
    }

    // Phone call
    if (phoneBtn) {
        phoneBtn.addEventListener("click", () => {
            const phoneNumber = window.contactData?.phone || "0987654321";
            window.open(`tel:${phoneNumber}`, "_self");
        });
    }
}

// Show Zalo instructions for desktop users
function showZaloInstructions(phoneNumber) {
    // Tạo modal hướng dẫn
    const modal = document.createElement("div");
    modal.className = "zalo-instruction-modal";
    modal.innerHTML = `
        <div class="zalo-instruction-content">
            <div class="zalo-instruction-header">
                <h4><i class="fas fa-phone text-primary"></i> Liên hệ qua Zalo</h4>
                <button class="zalo-close-btn" onclick="this.closest('.zalo-instruction-modal').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="zalo-instruction-body">
                <p><strong>Cách 1: Quét mã QR</strong></p>
                <div class="qr-code-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://zalo.me/${phoneNumber}"
                         alt="QR Code Zalo" class="qr-code">
                    <p class="text-muted">Mở Zalo trên điện thoại và quét mã QR</p>
                </div>

                <p><strong>Cách 2: Tìm kiếm số điện thoại</strong></p>
                <div class="phone-search">
                    <div class="phone-number-display">
                        <i class="fas fa-phone text-success"></i>
                        <span class="phone-number">${phoneNumber.replace(
                            "84",
                            "0"
                        )}</span>
                        <button class="copy-phone-btn" onclick="copyToClipboard('${phoneNumber.replace(
                            "84",
                            "0"
                        )}')">
                            <i class="fas fa-copy"></i> Sao chép
                        </button>
                    </div>
                    <p class="text-muted">Mở Zalo và tìm kiếm số điện thoại trên</p>
                </div>

                <p><strong>Cách 3: Gọi điện trực tiếp</strong></p>
                <div class="direct-call">
                    <a href="tel:${phoneNumber.replace(
                        "84",
                        "0"
                    )}" class="btn btn-success">
                        <i class="fas fa-phone-alt"></i> Gọi ngay
                    </a>
                </div>
            </div>
        </div>
    `;

    // Thêm CSS cho modal
    const style = document.createElement("style");
    style.textContent = `
        .zalo-instruction-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 20px;
        }
        .zalo-instruction-content {
            background: white;
            border-radius: 15px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .zalo-instruction-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .zalo-instruction-header h4 {
            margin: 0;
            color: #333;
        }
        .zalo-close-btn {
            background: none;
            border: none;
            font-size: 18px;
            color: #999;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .zalo-close-btn:hover {
            background: #f5f5f5;
            color: #333;
        }
        .zalo-instruction-body {
            padding: 20px;
        }
        .qr-code-container {
            text-align: center;
            margin: 15px 0;
        }
        .qr-code {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: white;
        }
        .phone-number-display {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .phone-number {
            font-weight: bold;
            color: #0068ff;
            flex: 1;
        }
        .copy-phone-btn {
            background: #0068ff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        .copy-phone-btn:hover {
            background: #0052cc;
        }
        .direct-call {
            text-align: center;
            margin-top: 15px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
        .text-muted {
            color: #6c757d;
            font-size: 14px;
        }
        .text-primary {
            color: #0068ff;
        }
        .text-success {
            color: #28a745;
        }
    `;

    document.head.appendChild(style);
    document.body.appendChild(modal);

    // Đóng modal khi click outside
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.remove();
            style.remove();
        }
    });
}

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard
        .writeText(text)
        .then(() => {
            showAlert("Đã sao chép số điện thoại!", "success", 2000);
        })
        .catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("copy");
            document.body.removeChild(textArea);
            showAlert("Đã sao chép số điện thoại!", "success", 2000);
        });
}

// Export functions for global use
window.DriverService = {
    showAlert,
    showLoading,
    hideLoading,
    calculatePrice,
    formatCurrency,
    formatPhoneNumber,
};
