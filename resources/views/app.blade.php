<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/svg+xml"
          href="https://cdn.streamlabs.com/static/imgs/streamlabs-logos/favicon/favicon.svg">
    <title>Advanced Stream Stats</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>

<body>
    <div id="app"></div>
</body>

<script src="https://js.braintreegateway.com/web/dropin/1.33.4/js/dropin.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</html>
