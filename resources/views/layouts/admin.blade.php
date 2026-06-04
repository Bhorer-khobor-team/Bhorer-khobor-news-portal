<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <!-- SIDEBAR -->
    <div style="width:200px; float:left;">
        <h3>Admin</h3>
        <ul>
            <li>Dashboard</li>
            <li>News</li>
            <li>Categories</li>
            <li>Users</li>
        </ul>
    </div>

    <!-- CONTENT -->
    <div style="margin-left:210px;">
        @yield('content')
    </div>

</body>
</html>