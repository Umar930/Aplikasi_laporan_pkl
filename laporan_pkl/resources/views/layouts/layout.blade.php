<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 240px;
            background-color: #38393a;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: rgb(6, 102, 247);
            border-radius: 4px;
        }
        .main-content {
            margin-left: 240px;
        }
        .header-nav {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column p-3" >
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi bi-journal-text fs-1 me-3 text-primary"></i>
            <span class="fs-4 fw-bold">Aplikasi Laporan PKL</span>
        </a>
        <hr class="text-secondary">
        <ul class="nav nav-pills flex-column mb-auto gap-1">
            
            @auth('web')
            <li>
                <span class="fs-5 fw-bold text-secondary">Dashboard Admin</span>
                <a href="{{ route('observasi') }}" class="nav-link {{ request()->is('observasi') ? 'active' : '' }}">
                    <i class="bi bi-box-seam me-2"></i> Observasi
                </a>
            </li>
            @endauth

            @auth('murid')
            <li>
                <span class="fs-5 fw-bold text-secondary">Dashboard Murid</span>
                <a href="{{ route('harian') }}" class="nav-link {{ request()->is('laporan-harian') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-fill me-2"></i> Laporan Harian
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bulanan') }}" class="nav-link {{ request()->is('laporan-bulanan') ? 'active' : '' }}">
                    <i class="bi bi-journals me-2"></i> Laporan Bulanan
                </a>
            </li>
            <li>
                <a href="{{ route('kompetensi') }}" class="nav-link {{ request()->is('jurnal-kompetensi') ? 'active' : '' }}">
                    <i class="bi bi-journal me-2"></i> Jurnal Kompetensi
                </a>
            </li>
            <li>
                <a href="{{ route('profil') }}" class="nav-link {{ request()->is('profil') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill me-2"></i> Profil
                </a>
            </li>
            @endauth

            @auth('guru')
            <li>
                <span class="fs-5 fw-bold text-secondary">Dashboard Guru</span>
                <a href="{{ route('kompetensi') }}" class="nav-link {{ request()->is('jurnal-kompetensi') ? 'active' : '' }}">
                    <i class="bi bi-journal me-2"></i> Jurnal Kompetensi
                </a>
            </li>
            <li>
                <a href="{{ route('nilai') }}" class="nav-link {{ request()->is('laporan-nilai') ? 'active' : '' }}">
                    <i class="bi bi-calculator me-2"></i> Laporan Nilai
                </a>
            </li>
            @endauth

            @auth('dudi')
            <li>
                <span class="fs-5 fw-bold text-secondary">Dashboard Dudi</span>
                <a href="{{ route('nilai') }}" class="nav-link {{ request()->is('laporan-nilai') ? 'active' : '' }}">
                    <i class="bi bi-calculator me-2"></i> Laporan Nilai
                </a>
            </li>
            <li>
                <a href="{{ route('kompetensi') }}" class="nav-link {{ request()->is('jurnal-kompetensi') ? 'active' : '' }}">
                    <i class="bi bi-journal me-2"></i> Jurnal Kompetensi
                </a>
            </li>
            @endauth
        </ul>
    </div>

    <div class="main-content">
        <header class="header-nav d-flex align-items-center justify-content-between px-4 sticky-top">
            <h5 class="mb-0 fw-bold text-secondary">@yield('title')</h5>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 me-2 text-secondary"></i>
                    <span class="fw-bold">
                        @if (Auth::guard('murid')->check())
                            {{ Auth::guard('murid')->user()->nama_murid }}
                        @elseif (Auth::guard('guru')->check())
                            {{ Auth::guard('guru')->user()->nama }}
                        @elseif (Auth::guard('dudi')->check())
                            {{ Auth::guard('dudi')->user()->nama_dudi }}
                        @elseif (Auth::guard('web')->check())
                            {{ Auth::guard('web')->user()->name }}
                        @endif
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="dropdownUser">
                    <li>
                        <a class="dropdown-menu-item dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
        </header>

        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>