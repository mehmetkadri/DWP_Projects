<?php
error_reporting(0);
if($_GET['Login'] == "no"){
    $message = "Invalid Credentials";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
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

<div class="newTable" style="width:15%;">
    <form method="post" action="admin_display_products_page.php">
        <div style="width:100%;margin-left: auto;margin-right: auto; text-align: center;">
            <b>Admin Sign In</b><br><br>
            <table style="width:100%; margin-left: auto; margin-right: auto">
                <tr>
                    <td><input type="text" name="username" placeholder="Username"></td>
                </tr>

                <tr>
                    <td><input type="password" name="password" placeholder="Password"></td>
                </tr>

                <tr>
                    <td>
                        <br>
                    </td>
                </tr>

                <tr>
                    <td><input type="submit" name="buttonAdminSignIn" value="Sign In" style="color: #c59b66;background-color: #564141;width: 85%; height: 40px;font-weight: bold; border-radius: 5px"></td>
                </tr>

                <tr><td style="color:#ff0000;"><?php echo $message?></td></tr>
            </table>
        </div>
    </form>
</div>

</body>
</html>
