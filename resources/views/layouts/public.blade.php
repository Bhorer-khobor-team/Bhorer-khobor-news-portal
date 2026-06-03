<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bhorer Khobor</title>

    <link rel="stylesheet" href="{{ asset('css/bhorer-khobor.css') }}">
</head>
<body>

    <!-- HEADER -->
    <header>
        <h2>Bhorer Khobor News</h2>
        <nav>
            <a href="/">Home</a>
        </nav>
    </header>

    <!-- CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2026 Bhorer Khobor</p>
    </footer>

</body>
</html>