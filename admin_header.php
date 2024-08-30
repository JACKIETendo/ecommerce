<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> 
    <title>Document</title>
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="admin_pannel.php" class="logo"><img style=" width: 110px;  height: 110px; margin-left: 100px; border-radius: 60px;" src="img/beau logo.jpg" alt=""></a>
            <nav class="navbar">
                <a href="admin_pannel.php">Home</a>
                <a href="admin_product.php">Products</a>
                <a href="admin_order.php">Orders</a>
                <a href="admin_user.php">Users</a>
                <a href="admin_message.php">Messages </a>
            </nav>
            <div class="icons">
            <i class="bi bi-person" id="user-btn"></i>
            <i class="bi bi-list" id="menu-btn"></i>
            </div>
            <div class="user-box">
                <p>username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
                <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p> 
                <form method="post">
                    <button type="submit" class="logout-btn">Log out</button>
                </form>
            </div>
        </div>
    </header>
    <div class="banner">
        <div class="detail">
            <h1>Admin Dashboard</h1>
            <p style="font-size: 1.3rem; color: black; font-weight: bold;">Elevate your beauty, Elevate your confidence.</p>
        </div>
    </div>
    <div class="line"></div>
</body>
</html>

