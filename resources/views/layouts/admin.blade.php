<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- ✅ Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ✅ Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lEjyW0Cej9z8EV2cQzG3YT4fsvC7D4r5d9+eV6wG9PmeMI1Yg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="d-flex">
        {{-- ✅ Sidebar --}}
        @include('layouts.aside')

        {{-- ✅ Main Content --}}
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

    {{-- ✅ Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
