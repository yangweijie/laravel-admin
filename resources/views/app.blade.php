<!-- resources/views/app.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <!-- Don't forget to use your package name -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>