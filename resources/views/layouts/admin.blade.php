<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>@yield('title', 'Dashboard') — ভোরের খবর Admin</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css' rel='stylesheet'>
  <link href='{{ asset("css/admin.css") }}' rel='stylesheet'>
  @stack('styles')
</head>
<body class='bk-admin-body'>

  {{-- ═══ SIDEBAR ═══ --}}
  <aside class='bk-admin-sidebar' id='sidebar'>
    <div class='bk-admin-brand'>
      <i class='bi bi-newspaper me-2'></i>ভোরের খবর
    </div>

    <nav class='bk-admin-nav'>
      <a href='{{ route("admin.dashboard") }}'
         class='{{ request()->routeIs("admin.dashboard") ? "active" : "" }}'>
        <i class='bi bi-grid-1x2'></i> Dashboard
      </a>

      <div class='bk-nav-group'>সংবাদ</div>
      <a href='{{ route("admin.news.index") }}'
         class='{{ request()->routeIs("admin.news.*") ? "active" : "" }}'>
        <i class='bi bi-newspaper'></i> সংবাদ তালিকা
      </a>
      <a href='{{ route("admin.news.create") }}'>
        <i class='bi bi-plus-circle'></i> নতুন সংবাদ
      </a>
      <a href='{{ route("admin.categories.index") }}'
         class='{{ request()->routeIs("admin.categories.*") ? "active" : "" }}'>
        <i class='bi bi-folder2'></i> বিভাগ
      </a>

      <div class='bk-nav-group'>বিজ্ঞাপন ও পাতা</div>
      <a href='{{ route("admin.advertisements.index") }}'
         class='{{ request()->routeIs("admin.advertisements.*") ? "active" : "" }}'>
        <i class='bi bi-megaphone'></i> বিজ্ঞাপন
      </a>
      <a href='{{ route("admin.privacy.edit") }}'
         class='{{ request()->routeIs("admin.privacy.*") ? "active" : "" }}'>
        <i class='bi bi-shield-check'></i> Privacy Policy
      </a>
      <a href='{{ route("admin.terms.edit") }}'
         class='{{ request()->routeIs("admin.terms.*") ? "active" : "" }}'>
        <i class='bi bi-file-text'></i> Terms & Conditions
      </a>

      {{-- Show Admins & Roles section only if user has at least one of these permissions --}}
@canany(['admin.create', 'role.create'])
    <div class="bk-nav-section">ব্যবস্থাপনা</div>

    {{-- Admin Management link --}}
    @can('admin.create')
    <a href="{{ route('admin.admins.index') }}"
       class="bk-nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i>অ্যাডমিন ব্যবস্থাপনা
    </a>
    @endcan

    {{-- Roles & Permissions link --}}
    @can('role.create')
    <a href="{{ route('admin.roles.index') }}"
       class="bk-nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
        <i class="bi bi-shield-check me-2"></i>রোল ও অনুমতি
    </a>
    @endcan

@endcanany

    </nav>
  </aside>

  {{-- ═══ MAIN AREA ═══ --}}
  <div class='bk-admin-main'>

    {{-- Topbar --}}
    <header class='bk-admin-topbar'>
      <button class='btn btn-sm btn-light me-3' id='sidebarToggle'>
        <i class='bi bi-list fs-5'></i>
      </button>
      <span class='fw-600'>@yield('title', 'Dashboard')</span>
      <div class='ms-auto d-flex align-items-center gap-3'>
        <a href='{{ route("home") }}' target='_blank' class='btn btn-sm btn-outline-secondary'>
          <i class='bi bi-globe2 me-1'></i>সাইট দেখুন
        </a>
        <div class='dropdown'>
          <button class='btn btn-sm btn-light dropdown-toggle' data-bs-toggle='dropdown'>
            <i class='bi bi-person-circle me-1'></i>{{ Auth::user()->name }}
          </button>
          <ul class='dropdown-menu dropdown-menu-end'>
            <li><h6 class='dropdown-header'>{{ Auth::user()->email }}</h6></li>
            <li><hr class='dropdown-divider'></li>
            <li>
              <form action='{{ route("admin.logout") }}' method='POST'>
                @csrf
                <button class='dropdown-item text-danger'>
                  <i class='bi bi-box-arrow-right me-2'></i>লগআউট
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    {{-- Content --}}
    <main class='bk-admin-content'>
      @if(session('success'))
      <div class='alert alert-success alert-dismissible fade show'>
        <i class='bi bi-check-circle me-2'></i>{{ session('success') }}
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>
      @endif
      @if(session('error'))
      <div class='alert alert-danger alert-dismissible fade show'>
        <i class='bi bi-exclamation-circle me-2'></i>{{ session('error') }}
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>
      @endif
      @yield('content')
    </main>

  </div>{{-- end admin-main --}}

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
<script src='{{ asset("js/admin.js") }}'></script>
@stack('scripts')
</body>
</html>