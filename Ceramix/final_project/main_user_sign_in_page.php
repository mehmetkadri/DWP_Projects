<?php
    error_reporting(0);
    session_start();

    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "ceramix";

    $isLogin = false;
    $message = "";

    try{
        $connect = new PDO("mysql:host=$server;dbname=$db",$username,$password);
        $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if($_POST['buttonSignIn']){
            $user = $_POST['customerUsername'];
            $pass = md5($_POST['customerPassword']);
            $sql = "SELECT customerUsername, customerName, customerPassword FROM customer WHERE customerUsername='$user' and customerPassword='$pass'";
            $result = $connect->query($sql);
            $row = $result->fetch();
            echo $row['customerUsername'];
            if($row['customerUsername'] != ""){
                $isLogin = true;
                $_SESSION['user'] = $_POST['customerUsername'];
                header("Location:user_main_page.php");
            }else{
                $message = "Invalid Credentials";
            }
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
    <title>User Sign In</title>
    <link rel="stylesheet" href="ceramix.css">
</head>
<body>
<div class="header">
    <div style="width: 200px">
        <h1 onclick="window.history.go(0)" style="color: #564141; cursor: pointer">Ceramix</h1>
    </div>
    <p style="color: #564141">Handmade Pottery Since 2022</p>

</div>

<div class="topNav">
    <a href="main_page.php">Main Page</a>

    <a href="main_admin_sign_in_page.php" style="float:right">Admin Sign In</a>
    <a href="main_user_sign_in_page.php" style="float:right">Sign In</a>
    <a href="main_user_sign_up_page.php" style="float:right">Sign Up</a>
</div>
<div class="newTable" style="width:20%;">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
        <div style="width:75%;margin-left: auto;margin-right: auto; text-align: center;">
            <b>Sign In</b><br><br>
            <table style="width:100%; margin-left: auto; margin-right: auto">
                <tr>
                    <td><input type="text" name="customerUsername" placeholder="Username"></td>
                </tr>

                <tr>
                    <td><input type="password" name="customerPassword" placeholder="Password"></td>
                </tr>

                <tr>
                    <td>
                        <br>
                    </td>
                </tr>

                <tr>
                    <td><input type="submit" name="buttonSignIn" value="Sign In" style="color: #c59b66;background-color: #564141;width: 90%; height: 40px;font-weight: bold; border-radius: 5px"></td>
                </tr>

                <tr><td style="color:#ff0000;"><?php echo $message?></td></tr>
            </table>
        </div>
    </form>
</div>

</body>
</html>
