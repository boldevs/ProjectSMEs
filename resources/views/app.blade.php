<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application</title>
    <!-- Specify the favicon -->
    <link rel="icon" href="https://cdn.icon-icons.com/icons2/2555/PNG/512/sales_sale_supermarket_stock_market_icon_153043.png" type="image/x-icon">

    <!-- If you have a different size for the favicon, you can also include additional tags for different sizes -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://cdn.icon-icons.com/icons2/2555/PNG/512/sales_sale_supermarket_stock_market_icon_153043.png">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body>
    <div id="app">
        <App></App>
    </div>

</body>

</html>
