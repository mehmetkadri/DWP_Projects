<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign Up</title>
    <link rel="stylesheet" href="ceramix.css">
</head>
<body>

<?php
error_reporting(0);
session_start();
$serverName = "localhost";
$userNameForDB = "root";
$passwordForDB = "";
$db = "ceramix";

$name = "";
$surname = "";
$email = "";
$username = "";
$password = "";

$nameErr=$surnameErr=$emailErr=$usernameErr=$passwordErr= "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['name'])){
        $nameErr = "Name is required";
    }else{
        $name = cleanProcess($_POST['name']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$name)){
            $nameErr = "Only characters and space";
        }else{
            $nameErr ="";
        }
    }
    if(empty($_POST['surname'])){
        $surnameErr = "Surname is required";
    }else{
        $surname = cleanProcess($_POST['surname']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$surname)){
            $surnameErr = "Only characters and space";
        }else{
            $surnameErr = "";
        }
    }
    if(empty($_POST['email'])){
        $emailErr = "Email is required";
    }else{
        $email = cleanProcess($_POST['email']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
        }else{
            $emailErr ="";
        }
    }
    if(empty($_POST['username'])){
        $usernameErr = "User Name is required";
    }else{
        $username = cleanProcess($_POST['username']);
        if(!preg_match("/^[a-zA-Z üğÜĞİışŞçÇöÖ]*$/",$username)){
            $usernameErr = "Only characters and space";
        }else{
            $usernameErr = "";
        }
    }
    if(empty($_POST['password'])){
        $passwordErr = "Password is required";
    }else{
        $password = cleanProcess($_POST['password']);
        $passwordErr = "";
    }
}
try{
    $connect = new PDO("mysql:host=$serverName;dbname=$db",$userNameForDB,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($name !="" && $nameErr=="" && $surnameErr=="" && $emailErr=="" && $usernameErr=="" && $passwordErr==""){

        $isUniq = doesUserExist($connect, $username);

        if($isUniq){
            $passwordMD5 = md5($password);
            $sqlRegister = "INSERT INTO customer (customerName,customerSurname,customerEmail,customerUsername,customerPassword) VALUES
                    ('$name','$surname','$email','$username','$passwordMD5')";
            $connect->exec($sqlRegister);

            header("Location:main_page.php");
            $_POST['name'] = "";
            $_POST['surname'] = "";
            $_POST['email'] = "";
            $_POST['username'] = "";
            $_POST['password'] = "";
            $name ="";
            $surname ="";
            $email ="";
            $username ="";
            $password ="";
            $usernameErr = "";
        }
        else{
            $usernameErr = "Username already taken!";
        }
    }
}catch(PDOException $ex){echo $ex;}

function cleanProcess($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function doesUserExist($connection, $user){
    $sqlUsername = "SELECT customerUsername FROM customer WHERE customerUsername='$user'";
    $resultOfUserName = $connection->query($sqlUsername);
    $row = $resultOfUserName->fetch();
    return $row[0] == "";
}
$connect = null;

?>

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

<div class="newTable">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
        <div style="width:90%;margin-left: auto;margin-right: auto;">
            <b>Sign Up</b><br><br>
            <table style="width:100%;">
                <tr>
                    <td style="text-align: start">Name: </td>
                    <td><input type="text" name="name" value="<?php echo $name ?>"> </td>
                    <td><span class="error">*<?php echo $nameErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">Surname: </td>
                    <td><input type="text" name="surname" value="<?php echo $surname ?>"> </td>
                    <td><span class="error">*<?php echo $surnameErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">E-mail: </td>
                    <td><input type="email" name="email" value="<?php echo $email ?>"> </td>
                    <td><span class="error">*<?php echo $emailErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">Username: </td>
                    <td><input type="text" name="username" value="<?php echo $username ?>"> </td>
                    <td><span class="error">*<?php echo $usernameErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">Password: </td>
                    <td><input type="password" name="password" value="<?php echo $password ?>"> </td>
                    <td><span class="error">*<?php echo $passwordErr ?></span> </td>
                </tr>

                <tr>
                    <td>
                        <br>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"><input type="submit" name="btnSubmit" value="Sign Up" style="color: #c59b66;background-color: #564141;width: 100%; height: 40px;font-weight: bold; border-radius: 5px"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

</body>
</html>