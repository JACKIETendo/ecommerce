<?php
    include 'connection.php';
    session_start();
    $admin_id = $_SESSION['admin_name'];

    if (!isset($admin_id)) {
        header('location:login.php');
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location:login.php');
    }
    //adding products to the database
    if (isset($_POST['add_product'])){
        $product_name = mysqli_real_escape_string($conn, $_POST['name']); 
        $product_price = mysqli_real_escape_string($conn, $_POST['price']);
        $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);

        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $image_type = $_FILES['image']['type'] ?? '';
        if (!in_array($image_type, $allowed_types)){
            //$message[] = '';
        }else{ 
            $image = $_FILES['image']['name']?? 'image';
            $image_size = $_FILES['image']['size']?? 0;
            $image_tmp_name = $_FILES['image']['tmp_name']?? 'image';
            $image_folder = 'images/' .$image;
        }
        

        $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$product_name'") or die ('query failed');
        if(mysqli_num_rows($select_product_name)>0) {
            $message[] = 'Product name already exist';
        }else{
            $insert_product = mysqli_query($conn, "INSERT IGNORE INTO `products`(`name`, `price`, `product_detail`, `image`) VALUES ('$product_name', '$product_price', '$product_detail', '$image_folder')") or die('query failed');
            if ($insert_product) {
                if ($image_size > 2000000) {
                    $message[] = 'image size is too large';
                }else{
                    move_uploaded_file($image_tmp_name, $image_folder);  
                    $message[] = 'Product added successfully';
                }
            }
        }
    }

?>
<style type="text/css">
    <?php
        include 'style.css';
    ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"> 
    <title>admin pannel</title>
</head>
<body>
    <?php include 'admin_header.php';?>
    <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '
                        <div class="message">
                            <span>'.$message.'</span>
                            <h4 class="close-btn" onclick="this.parentElement.remove()">close</h4>
                        </div>
                    ';
                }
            } 
        ?>
        <div class="line2"></div>
        <section class="add-products form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input-field">
                    <label for="">Product name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-field">
                    <label for="">Product price</label>
                    <input type="text" name="price" required>
                </div>
                <div class="input-field">
                    <label for="">Product detail</label>
                    <textarea name="detail" id="" required></textarea>
                </div>
                <div class="input-field">
                    <label for="">Product image</label>
                    <input type="file" name="name" accept="image/jpg, image/jpeg, image.png, image/webp" required>
                </div>
                <input type="submit" name="add_product" value="add product" class="btn">
            </form>
        </section>
        <div class="line3"></div>
        <div class="line4"></div>
        <section class="show_products">
            <div class="box-container">
                <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    if (mysqli_num_rows($select_products)>0){
                        while($fetch_products = mysqli_fetch_assoc($select_products)) {

                ?>
                <div class="box">
                    <img src="images/<?php echo $fetch_products['image']; ?>">
                    <p>Price : $<?php echo $fetch_products['price']; ?></p>
                    <h4><?php echo $fetch_products['name']; ?></h4>
                    <details><?php echo $fetch_products['product_detail']; ?></details>
                    <a href="admin_product.php?edit =<?php echo $fetch_products['id']; ?>" class="edit">Edit</a>
                    <a href="admin_product.php?delete =<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('Want to delete this product');">Delete</a>
                </div>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>No products added yet</p>
                            </div>
                        ';
                    }
                ?>


                
            </div>
        </section>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>