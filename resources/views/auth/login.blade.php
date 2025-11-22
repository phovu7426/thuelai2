<!doctype html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập - Dịch vụ lái xe</title>
    
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    
    <style>
        /* CSS Variables */
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-secondary: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-dark: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
            
            --transition-fast: 0.15s ease-in-out;
            --transition-normal: 0.3s ease-in-out;
            --transition-slow: 0.5s ease-in-out;
            
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-family-heading: 'Poppins', sans-serif;
        }

        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            line-height: 1.6;
            color: var(--gray-700);
            background: var(--gradient-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        /* Background Animation */
        .auth-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            background: 
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(236, 72, 153, 0.2) 0%, transparent 50%);
            background-size: 400px 400px, 300px 300px, 200px 200px;
            animation: float-particles 20s ease-in-out infinite;
        }

        @keyframes float-particles {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Login Container */
        .auth-container {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-2xl);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Logo Section */
        .auth-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .brand-logo i {
            font-size: 2.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-subtitle {
            color: var(--gray-600);
            font-size: 0.875rem;
            text-align: center;
        }

        /* Form Styles */
        .auth-title {
            font-family: var(--font-family-heading);
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-group label i {
            color: var(--primary-color);
            width: 16px;
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            transition: var(--transition-normal);
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        /* Checkbox */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .form-check-input {
            width: 1rem;
            height: 1rem;
            accent-color: var(--primary-color);
        }

        .form-check-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            cursor: pointer;
        }

        /* Buttons */
        .btn-primary {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--gradient-primary);
            color: var(--white);
            border: none;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition-normal);
            box-shadow: var(--shadow-lg);
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .btn-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--white);
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition-normal);
            margin-bottom: 1.5rem;
        }

        .btn-google:hover {
            background: var(--gray-50);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-google i {
            color: #ea4335;
        }

        /* Links */
        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition-normal);
            margin: 0 0.5rem;
        }

        .auth-links a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-container {
                margin: 1rem;
                padding: 2rem;
            }
            
            .auth-title {
                font-size: 1.5rem;
            }
            
            .brand-logo {
                font-size: 1.5rem;
            }
            
            .brand-logo i {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-bg"></div>
    <div class="auth-container">
        <div class="auth-logo">
            <div class="brand-logo">
                <i class="fas fa-car"></i>
                <span>DriveService</span>
            </div>
            <p class="auth-subtitle">Dịch vụ lái xe chuyên nghiệp</p>
        </div>
        
        <h1 class="auth-title">Đăng nhập</h1>
        
        <form id="login_form">
            @csrf
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i>
                    Email
                </label>
                <input type="email" name="email" id="email" class="form-control" required
                    placeholder="Nhập email của bạn">
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    Mật khẩu
                </label>
                <input type="password" name="password" id="password" class="form-control" required
                    placeholder="Nhập mật khẩu">
            </div>
            
            <div class="form-check">
                <input type="checkbox" id="show-password" class="form-check-input">
                <label for="show-password" class="form-check-label">Hiển thị mật khẩu</label>
            </div>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Đăng nhập
            </button>
            
            <button type="button" onclick="window.location.href='{{ route('google.login') }}'" class="btn-google">
                <i class="fab fa-google"></i>
                Đăng nhập với Google
            </button>
            
            <div class="auth-links">
                <a href="{{ route('forgot.password.index') }}">Quên mật khẩu?</a>
                <span>|</span>
                <a href="{{ route('register.index') }}">Đăng ký</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Configure toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            $('#login_form').on('submit', function(event) {
                event.preventDefault();
                
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
                submitBtn.prop('disabled', true);
                
                $.ajax({
                    url: '{{ route('login.post') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success === true) {
                            toastr.success(response.message || 'Đăng nhập thành công!');
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            toastr.error(response.message || 'Đăng nhập thất bại!');
                        }
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || 'Đăng nhập thất bại!';
                        toastr.error(message);
                    },
                    complete: function() {
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            $('#show-password').on('change', function() {
                const passwordField = $('#password');
                if ($(this).is(':checked')) {
                    passwordField.attr('type', 'text');
                } else {
                    passwordField.attr('type', 'password');
                }
            });

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
            
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
        });
    </script>
</body>

</html>
