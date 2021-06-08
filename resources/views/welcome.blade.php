<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dato</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-screen">
    <div id="app" class="h-screen">

        <example-component></example-component>
    </div>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
