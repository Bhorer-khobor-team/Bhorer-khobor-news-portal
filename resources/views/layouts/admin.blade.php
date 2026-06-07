<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | ভোরের খবর Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="bk-admin-body">

{{-- Sidebar --}}
<nav class="bk-sidebar" id="sidebar">
    <div class="bk-sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
            <span class="bk-sidebar-logo">ভোরের খবর</span>
            <small class="d-block text-muted" style="font-size:10px">Admin Panel</small>
        </a>
    </div>
    <ul class="bk-sidebar-nav list-unstyled mt-3">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="bk-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> <span>ড্যাশবোর্ড</span>
            </a>
        </li>
        <li class="bk-nav-section">সংবাদ</li>
        <li>
            <a href="{{ route('admin.news.index') }}" class="bk-nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> <span>সব সংবাদ</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.news.create') }}" class="bk-nav-link {{ request()->routeIs('admin.news.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> <span>নতুন সংবাদ</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categories.index') }}" class="bk-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> <span>বিভাগ</span>
            </a>
        </li>
        <li class="bk-nav-section">মিডিয়া</li>
        <li>
            <a href="{{ route('admin.advertisements.index') }}" class="bk-nav-link {{ request()->routeIs('admin.advertisements.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> <span>বিজ্ঞাপন</span>
            </a>
        </li>
        <li class="bk-nav-section">পেজ</li>
        <li>
            <a href="{{ route('admin.privacy.edit') }}" class="bk-nav-link {{ request()->routeIs('admin.privacy.*') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i> <span>গোপনীয়তা নীতি</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.terms.edit') }}" class="bk-nav-link {{ request()->routeIs('admin.terms.*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> <span>শর্তাবলী</span>
            </a>
        </li>
        @canany(['admin.create', 'role.create'])
        <li class="bk-nav-section">অ্যাডমিন</li>
        @can('admin.create')
        <li>
            <a href="{{ route('admin.admins.index') }}" class="bk-nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> <span>অ্যাডমিন ব্যবস্থাপনা</span>
            </a>
        </li>
        @endcan
        @can('role.create')
        <li>
            <a href="{{ route('admin.roles.index') }}" class="bk-nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> <span>রোল ও অনুমতি</span>
            </a>
        </li>
        @endcan
        @endcanany
    </ul>
</nav>

{{-- Main Wrapper --}}
<div class="bk-main-wrapper" id="mainWrapper">
    {{-- Topbar --}}
    <header class="bk-topbar-admin d-flex align-items-center justify-content-between px-4">
        <div class="d-flex align-items-center gap-3">
            <button class="bk-sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h5 class="mb-0 fw-semibold text-dark">@yield('title', 'Dashboard')</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('public.home') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-globe me-1"></i>সাইট দেখুন
            </a>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <div class="bk-admin-avatar">
                        {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ auth('admin')->user()->email ?? '' }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="bi bi-box-arrow-right me-2"></i>লগআউট
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    {{-- Content --}}
    <main class="bk-admin-content p-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
