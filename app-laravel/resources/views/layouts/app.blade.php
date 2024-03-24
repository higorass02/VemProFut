<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Salon App</title>
</head>
<body>

<nav>
    <!-- Your navigation bar code here -->
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="{{route('employees.index')}}">Employees</a></li>
        <li><a href="{{route('customers.index')}}">Customers</a></li>
    </ul>
</nav>

<div class="container">
    @yield('content')
</div>

<footer>
    <!-- Your footer content here -->
    <p>&copy; <?php echo date("Y"); ?> Your Salon App. All rights reserved.</p>
</footer>

</body>
</html>
