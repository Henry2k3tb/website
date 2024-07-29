<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang ADMIN</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background: linear-gradient(145deg, #e6e6e6, #ffffff);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-family: 'Roboto', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #343a40;
        }

        .btn-custom {
            margin: 10px;
            padding: 10px 20px;
            font-size: 1.2rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #17a2b8;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Chào mừng bạn đến với trang ADMIN</h1>
        <a href="../../admin/authen/register.php" class="btn btn-primary btn-custom">Đăng kí</a>
        <a href="../../admin/authen/login.php" class="btn btn-secondary btn-custom">Đăng nhập</a>
    </div>

</body>

</html>