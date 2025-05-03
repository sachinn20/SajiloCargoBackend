<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Yield custom styles -->
    @yield('styles')

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #212529;
        }
        .content {
            flex-grow: 1;
            overflow-y: auto;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .sidebar.show {
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 1050;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Sidebar Toggle -->
    <button class="btn btn-dark d-md-none m-2 position-fixed z-3" id="sidebarToggle" style="top: 10px; left: 10px;">
        <i class="fas fa-bars"></i>
    </button>

    <div class="wrapper">
        <!-- Sidebar (make sure this ID is applied in aside file) -->
        @include('layouts.aside') {{-- should contain <div class="sidebar" id="sidebar"> --}}
        
        <!-- Main Content -->
        <div class="content p-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar toggle & tooltip initializer -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar?.classList.toggle('show');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
