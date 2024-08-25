<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'figtree'
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .verification_notice {
            width: auto;
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 1.5rem 2rem;
            margin-top: 2rem;
        }

        button {
            padding: .6rem 1rem;
            background-color: #252525;
            outline: none;
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        input {
            padding: .6rem 1rem;
            background-color: #e0e0e0;
            outline: none;
            border: none;
            color: #252525;
            font-weight: 600;
            border-radius: 5px;
        }
    </style>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="container">
        <div class="verification_notice">
            <h3>Send Password Reset Link</h3>
            <form action="">
                <input type="email" name="email" placeholder="Email">
                <button type="submit">Send Link</button>
            </form>
        </div>
    </div>
</body>

</html>
