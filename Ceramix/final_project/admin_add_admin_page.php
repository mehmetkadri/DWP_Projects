<?php
session_start();
error_reporting(0);
$server = "localhost";
$usernameForDB = "root";
$passwordForDB = "";
$db = "ceramix";
if(!isset($_SESSION['admin'])){
    header("Location:main_admin_sign_in_page.php?Login=no");
}

$username = "";
$password = "";
$userNameErr=$passwordErr = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['username'])){
        $userNameErr = "Enter Username";
    }else{
        $username = cleanProcess($_POST['username']);
        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$username)){
            $userNameErr = "Invalid character detected.";
        }else{
            $userNameErr ="";
        }
    }
    $passwordErr = empty($_POST['password']) ? "Enter Password" : "";
}
try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$usernameForDB,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['buttonAddAdmin']) && $userNameErr == "" && $passwordErr == ""){
        $password = md5($_POST['password']);

        $sqlTest = "SELECT adminUsername FROM admin WHERE adminUsername='$username'";
        $result = $connect->query($sqlTest);
        $row = $result->fetch();
        if($row['adminUsername'] != ""){
            $userNameErr = "Username already exists!";
        }else{
            $sql = "INSERT INTO admin VALUES('$username','$password')";
            $result = $connect->exec($sql);
            $_POST['username'] = "";
            $_POST['password'] = "";
            header("Location:admin_add_product_page.php");
        }

    }
}
catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}

function cleanProcess($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$connect = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Assignment</title>
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

<div class="newTable" style="width: 25%">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <div style="width:90%;margin-left: auto;margin-right: auto;">
            <b>Add Admin</b><br><br><br>
            <table style="width:100%;">
                <tr>
                    <td><label for="username">Username: </label></td>
                    <td><input type="text" id="username" name="username"></td>
                    <td><span class="error">*<?php echo $userNameErr ?></span> </td>
                </tr>
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" id="password" name="password"></td>
                    <td><span class="error">*<?php echo $passwordErr ?></span> </td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="buttonAddAdmin" value="Add" style="color: #c59b66;background-color: #564141;width: 90%; height: 40px;font-weight: bold; border-radius: 5px">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

</body>
</html>