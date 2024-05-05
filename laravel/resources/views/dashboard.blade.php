
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .footer {
            background-color: #6c757d;
            color: #fff;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        .sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background-color: #343a40;
            padding-top: 80px;
            overflow-y: auto;
            color: #fff;
        }
        .sidebar h2 {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
        .sidebar ul {
            padding: 0;
            list-style: none;
            text-align: center;
        }
        .sidebar ul li {
            padding: 15px 0;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .sidebar ul li a:hover {
            background-color: #495057;
            padding-left: 20px;
            border-left: 5px solid #007bff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .content h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Admin</h1>
</div>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#users">Users</a></li>
        <li><a href="#posts">Posts</a></li>
        <li><a href="#log-out">Log-Out</a></li>
    </ul>
</div>

<div class="content">
    <h2>Dashboard - Welcome, Admin!</h2>
</div>

<div class="footer">
    <p>&copy; Silverio Gwapo Kaayu. All rights reserved.</p>
</div>

</body>
</html>