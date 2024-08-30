<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Poppins, sans-serif;
            line-height: 1.6;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: inline-block;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #4CAF50; /* Green */
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You!</h1>
        <p>Your request has been successfully processed.</p>
        <p>Regards,<br>{{ config('constants.site_title') }}</p>
    </div>
</body>
</html>
