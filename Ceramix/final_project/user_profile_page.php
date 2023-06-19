<?php
error_reporting(0);
session_start();

if(!isset($_SESSION['user'])){
    header("Location:userLogin.php");
}

$server = "localhost";
$userName = "root";
$passwordForDB = "";
$db = "ceramix";

$name ="";
$surname = "";
$password = "";
$email = "";
$newPassword = false;

$nameErr=$surnameErr=$emailErr=$passwordErr= "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['name'])){
        $name = $_SESSION['currentName'];
    }else{
        $name = cleanProcess($_POST['name']);
        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$name)){
            $nameErr = "Only characters and space";
        }else{
            $nameErr ="";
        }
    }
    if(empty($_POST['surname'])){
        $surname = $_SESSION['currentSurname'];
    }else{
        $surname = cleanProcess($_POST['surname']);
        if(!preg_match("/^[a-zA-Z üğÜĞİşŞçÇöÖ]*$/",$surname)){
            $surnameErr = "Only characters and space";
        }else{
            $surnameErr = "";
        }
    }
    if(empty($_POST['email'])){
        $email = $_SESSION['currentEmail'];
    }else{
        $email = cleanProcess($_POST['email']);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email";
        }else{
            $emailErr ="";
        }
    }
    if(empty($_POST['newPassword'])){
        $password = $_SESSION['currentPassword'];
        $newPassword = false;
    }else{
        $password = cleanProcess($_POST['newPassword']);
        $newPassword = true;
        $passwordErr = "";
    }
    if(empty($_POST['password'])){
        $passwordErr = "Pasword Needed";
    }
}

try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$passwordForDB);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($_POST['btnUpdate'] && $nameErr=="" && $surnameErr=="" && $emailErr=="" && $passwordErr==""){
        $user = $_SESSION["user"];
        $pass = $newPassword ? md5($password) : $password;
        $sqlPassword = "SELECT customerPassword FROM customer WHERE customerUsername ='$user'";
        $result = $connect->query($sqlPassword);
        $rowPassword = $result->fetch();
        if($rowPassword['customerPassword'] != md5($_POST['password'])){
            $passwordErr = "Wrong Password!";
        }else{
            $sqlUpdate = "UPDATE customer SET customerName='$name',customerSurname='$surname', customerPassword='$pass',customerEmail ='$email' WHERE customerUsername ='$user' ";
            $statement = $connect->prepare($sqlUpdate);
            $statement->execute();
        }
    }
    $currentUser = $_SESSION["user"];
    $sqlSelect = "SELECT customerName,customerSurname,customerPassword,customerEmail FROM customer WHERE customerUsername='$currentUser'";
    $result = $connect->query($sqlSelect);
    $row = $result->fetch();

    if($row['customerName'] != ""){
        $_SESSION['currentName'] = $name =$row['customerName'];
        $_SESSION['currentSurname'] = $surname = $row['customerSurname'];
        $_SESSION['currentPassword'] = $password = $row['customerPassword'];
        $_SESSION['currentEmail'] = $email = $row['customerEmail'];
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    <a href="user_main_page.php">Main Page</a>
    <a href="user_basket.php">Basket</a>
    <a href="user_profile_page.php">Profile</a>

    <a href="user_sign_out.php" style="float:right">Sign Out</a>
</div>

<div class="newTable" style="width: 25%">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
        <div style="width:100%;margin-left: auto;margin-right: auto;">
            <b>User Profile</b><br><br>
            <table style="width:100%;">
                <tr>
                    <td style="text-align: start">Name: </td>
                    <td><input type="text" name="name" placeholder="<?php echo $name ?>"> </td>
                    <td><span class="error"><?php echo $nameErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">Surname: </td>
                    <td><input type="text" name="surname" placeholder="<?php echo $surname ?>"> </td>
                    <td><span class="error"><?php echo $surnameErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">E-mail: </td>
                    <td><input type="email" name="email" placeholder="<?php echo $email ?>"> </td>
                    <td><span class="error"><?php echo $emailErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">Password: </td>
                    <td><input type="password" name="password" placeholder="Password"> </td>
                    <td><span class="error"><?php echo $passwordErr ?></span> </td>
                </tr>

                <tr>
                    <td style="text-align: start">New Password: </td>
                    <td><input type="password" name="newPassword" placeholder="New Password"> </td>
                </tr>

                <tr>
                    <td>
                        <br>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="btnUpdate" value="Update Profile" style="color: #c59b66;background-color: #564141;width: 100%; height: 40px;font-weight: bold; border-radius: 5px"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

</body>
</html>
