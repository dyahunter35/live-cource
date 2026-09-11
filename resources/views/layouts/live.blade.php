<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        @include('partials.head')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap');

            * {
                font-family: 'Tajawal', sans-serif;
                box-sizing: border-box;
            }

            body {
                margin: 0;
                padding: 0;
                background: #f0f4f8;
                direction: rtl;
            }

            /* ===== LAYOUT ===== */
            .live-layout {
                display: flex;
                min-height: 100vh;
                background: #f0f4f8;
            }

            /* ===== SIDEBAR ===== */
            .live-sidebar {
                width: 220px;
                min-height: 100vh;
                background: #fff;
                border-left: 1px solid #e8ecf0;
                display: flex;
                flex-direction: column;
                position: fixed;
                right: 0;
                top: 0;
                bottom: 0;
                z-index: 100;
                box-shadow: -2px 0 8px rgba(0,0,0,0.04);
            }

            .sidebar-logo {
                padding: 18px 20px;
                border-bottom: 1px solid #f0f4f8;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .sidebar-logo-icon {
                width: 42px;
                height: 42px;
                background: linear-gradient(135deg, #1a3a6c, #2d5fb7);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .sidebar-logo-icon svg {
                width: 24px;
                height: 24px;
                fill: white;
            }

            .sidebar-logo-text {
                display: flex;
                flex-direction: column;
                line-height: 1.2;
            }

            .sidebar-logo-title {
                font-size: 11px;
                font-weight: 800;
                color: #1a3a6c;
                letter-spacing: -0.3px;
            }

            .sidebar-logo-sub {
                font-size: 9px;
                color: #7a8fa6;
                font-weight: 500;
            }

            .sidebar-nav {
                flex: 1;
                padding: 12px 10px;
                overflow-y: auto;
            }

            .sidebar-nav-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 12px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 500;
                color: #5a6a7e;
                text-decoration: none;
                margin-bottom: 2px;
                transition: all 0.15s ease;
                cursor: pointer;
                border: none;
                background: none;
                width: 100%;
                text-align: right;
            }

            .sidebar-nav-item:hover {
                background: #f0f4f8;
                color: #1a3a6c;
            }

            .sidebar-nav-item.active {
                background: #eef2ff;
                color: #2d5fb7;
                font-weight: 700;
            }

            .sidebar-nav-item svg {
                width: 18px;
                height: 18px;
                flex-shrink: 0;
                opacity: 0.7;
            }

            .sidebar-nav-item.active svg {
                opacity: 1;
                color: #2d5fb7;
            }

            .sidebar-divider {
                height: 1px;
                background: #f0f4f8;
                margin: 8px 10px;
            }

            .sidebar-whatsapp {
                padding: 14px 16px;
                border-top: 1px solid #f0f4f8;
            }

            .sidebar-whatsapp-btn {
                display: flex;
                align-items: center;
                gap: 10px;
                background: linear-gradient(135deg, #25d366, #20ba59);
                color: white;
                padding: 10px 16px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 700;
                text-decoration: none;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            }

            .sidebar-whatsapp-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(37, 211, 102, 0.4);
            }

            /* ===== MAIN AREA ===== */
            .live-main {
                margin-right: 220px;
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            /* ===== HEADER ===== */
            .live-header {
                background: #fff;
                border-bottom: 1px solid #e8ecf0;
                padding: 0 28px;
                height: 64px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 50;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }

            .header-search {
                display: flex;
                align-items: center;
                gap: 8px;
                background: #f5f7fa;
                border: 1px solid #e8ecf0;
                border-radius: 10px;
                padding: 8px 14px;
                min-width: 240px;
                cursor: text;
            }

            .header-search svg {
                width: 16px;
                height: 16px;
                color: #9aacbb;
            }

            .header-search input {
                border: none;
                background: none;
                outline: none;
                font-size: 13px;
                color: #5a6a7e;
                font-family: 'Tajawal', sans-serif;
                width: 100%;
            }

            .header-search input::placeholder {
                color: #b0bcca;
            }

            .header-right {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .header-notification {
                position: relative;
                cursor: pointer;
            }

            .header-notification svg {
                width: 22px;
                height: 22px;
                color: #5a6a7e;
            }

            .notification-badge {
                position: absolute;
                top: -4px;
                left: -4px;
                width: 16px;
                height: 16px;
                background: #e74c3c;
                border-radius: 50%;
                font-size: 9px;
                font-weight: 800;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px solid white;
            }

            .header-user {
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                padding: 6px 10px;
                border-radius: 10px;
                transition: background 0.15s ease;
            }

            .header-user:hover {
                background: #f5f7fa;
            }

            .user-info {
                text-align: right;
            }

            .user-name {
                font-size: 13px;
                font-weight: 700;
                color: #1a3a6c;
                line-height: 1.2;
            }

            .user-role {
                font-size: 11px;
                color: #9aacbb;
                font-weight: 500;
            }

            .user-avatar {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e8ecf5, #c8d4e8);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                font-weight: 700;
                color: #2d5fb7;
                border: 2px solid #e8ecf0;
                overflow: hidden;
            }

            .user-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* ===== CONTENT ===== */
            .live-content {
                flex: 1;
                padding: 28px;
                background: #f0f4f8;
            }

            @media (max-width: 1024px) {
                .live-sidebar {
                    transform: translateX(100%);
                    transition: transform 0.3s ease;
                }
                .live-main {
                    margin-right: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="live-layout">
            {{-- Sidebar --}}
            <aside class="live-sidebar">
                {{-- Logo --}}
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div class="sidebar-logo-text">
                        <span class="sidebar-logo-title">منصة منيسوتا للتدريب</span>
                        <span class="sidebar-logo-sub">Minnesota Training & Development Platform</span>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="sidebar-nav">
                    <a href="#" class="sidebar-nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        الرئيسية
                    </a>

                    <a href="{{ route('live-courses') }}" class="sidebar-nav-item active">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        الدورات المباشرة
                    </a>

                    <a href="#" class="sidebar-nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                        </svg>
                        دوراتي المسجلة
                    </a>

                    <a href="#" class="sidebar-nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                        الشهادات
                    </a>

                    <div class="sidebar-divider"></div>

                    <a href="#" class="sidebar-nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        ملفي الشخصي
                    </a>

                    <a href="#" class="sidebar-nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        المساعدة
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-nav-item" style="color:#e74c3c;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            تسجيل الخروج
                        </button>
                    </form>
                </nav>

                {{-- WhatsApp Button --}}
                <div class="sidebar-whatsapp">
                    <a href="https://wa.me/" target="_blank" class="sidebar-whatsapp-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20" height="20">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                        </svg>
                        <span>تواصل معنا<br><span style="font-size:10px;font-weight:400;opacity:0.85;">عبر واتساب</span></span>
                    </a>
                </div>
            </aside>

            {{-- Main Area --}}
            <div class="live-main">
                {{-- Header --}}
                <header class="live-header">
                    {{-- Search --}}
                    <div class="header-search">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" placeholder="ابحث في دوراتك...">
                    </div>

                    {{-- Right side --}}
                    <div class="header-right">
                        {{-- Notification --}}
                        <div class="header-notification">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                            </svg>
                            <span class="notification-badge">3</span>
                        </div>

                        {{-- User --}}
                        <div class="header-user">
                            <div class="user-info">
                                <div class="user-name">أحمد محمد</div>
                                <div class="user-role">طالب</div>
                            </div>
                            <div class="user-avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="live-content">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @fluxScripts
    </body>
</html>