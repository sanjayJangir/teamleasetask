<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') ?? 'Laravel' }}</title>


</head>

<body>
    <h1>API Results</h1>
    <h2>Weather Data:</h2>
    <pre>{{ print_r($weather, true) }}</pre>
    <h2>Current Price:</h2>
    <pre>{{ print_r($currentprice, true) }}</pre>
</body>

</html>
