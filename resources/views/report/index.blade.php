<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="' . BASEURL . '/img/icon/favicon.ico">
    <title>{{ $title }}</title>
    <style>
        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            font-family: Arial;
        }

        .table {
            font-family: times-new-roman;
            font-size: 14px;
            width: 100%;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #1f6238e3;
            color: white;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            font-size: 14px;
            background-color: #f5f5f5;
            padding: 10px;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
