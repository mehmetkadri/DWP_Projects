<?php
session_start();
error_reporting(0);
$server = "localhost";
$username = "root";
$password = "";
$db = "ceramix";

if(!isset($_SESSION['admin'])){
    header("Location:main_admin_sign_in_page.php?Login=no");
}

try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['buttonAddProduct'])){
        $title = $_POST['title'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $pictureURL = $_POST['pictureURL'];

        $sql = "INSERT INTO products(productTitle, productCategory, productQuantity,productPrice,productDescription,productPhotoURL) VALUES('$title','$category','$quantity','$price','$description','$pictureURL')";
        $result = $connect->exec($sql);
    }
}
catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}
$connect = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Entry</title>
    <link rel="stylesheet" href="ceramix.css">
</head>
<body>
<div class="header">
    <div style="width: 200px">
        <h1 onclick="window.history.go(0)" style="color: #564141; cursor: pointer">Ceramix</h1>
    </div>

</div>

<div class="topNav">
    <a href="admin_display_products_page.php">Products</a>
    <a href="admin_add_product_page.php">Add Products</a>
    <a href="admin_add_admin_page.php">Add Admin</a>

    <a href="admin_sign_out.php" style="float:right">Sign Out</a>
</div>
<div class="newTable">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div style="width:90%;margin-left: auto;margin-right: auto;">
            <b>Add Ceramic</b><br><br>
            <table style="width:100%;">
                <tr>
                    <td><label for="title">Title: </label></td>
                    <td><input type="text" id="title" name="title"></td>
                </tr>
                <tr>
                    <td><label for="category">Category: </label></td>
                    <td><input type="text" id="category" name="category"></td>
                </tr>
                <tr>
                    <td><label for="quantity">Quantity: </label></td>
                    <td><input type="text" id="quantity" name="quantity"></td>
                </tr>
                <tr>
                    <td><label for="price">Price: </label></td>
                    <td><input type="text" id="price" name="price"></td>
                </tr>
                <tr>
                    <td><label for="description">Description: </label></td>
                    <td><input type="text" id="description" name="description"></td>
                </tr>
                <tr>
                    <td><label for="pictureURL">Picture URL: </label></td>
                    <td><input type="text" id="pictureURL" name="pictureURL"></td>
                </tr>

                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="buttonAddProduct" value="Add" style="color: #c59b66;background-color: #564141;width: 90%; height: 40px;font-weight: bold; border-radius: 5px">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

</body>
</html>