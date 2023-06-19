<?php
error_reporting(0);
session_start();
$server = "localhost";
$username = "root";
$password = "";
$db = "ceramix";


$isSignedIn = false;

try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['buttonAdminSignIn'])){
        $user = $_POST['username'];
        $pass = md5($_POST['password']);
        $sql = "SELECT * FROM admin";
        $result = $connect->query($sql);
        while($row = $result->fetch()){
            if($row['adminUsername'] == $user && $row['adminPassword'] == $pass){
                $isSignedIn = true;
                $_SESSION['admin'] = $_POST['username'];
                break;
            }
        }
    }
    if(isset($_POST['buttonReduce'])){
        $redElem = $_POST['buttonReduce'];
        $sqlReduce = "UPDATE products SET productQuantity = productQuantity-1 WHERE productID = '$redElem'";
        $connect->exec($sqlReduce);

        $itemLeftQuery = "SELECT productQuantity FROM products WHERE productID = '$redElem'";
        $result = $connect->query($itemLeftQuery);
        $itemLeftArr = $result->fetch();
        $itemLeft = $itemLeftArr[0];
        if($itemLeft==0){
            $sqlDelete = "DELETE FROM products WHERE productID = '$redElem'";
            $connect->exec($sqlDelete);
        }
    }
    if(isset($_POST['buttonRaise'])){
        $raiElem = $_POST['buttonRaise'];
        $sqlRaise= "UPDATE products SET productQuantity = productQuantity+1 WHERE productID = '$raiElem'";
        $connect->exec($sqlRaise);
    }
    if(isset($_POST['buttonDelete'])){
        $delElem = $_POST['buttonDelete'];
        $sqlDelete = "DELETE FROM products WHERE productID = '$delElem'";
        $connect->exec($sqlDelete);
    }
    if(!$isSignedIn && !isset($_SESSION['admin'])){
        header("Location:main_admin_sign_in_page.php?Login=no");
    }

}catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
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

<section>
    <div style="margin-top: 20px; border: 5px solid #564141; border-radius: 15px">
        <div class="filter_products">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                Title:
                <input type="text" name="title">
                Category:
                <input type="text" name="category">
                <input type="submit" name="btnSearch" value="Search" style="color: #c59b66;background-color: #564141;width: 100px; height: 40px;font-weight: bold; border-radius: 5px">
            </form>
        </div>
        <div style="background-color: #564141; border: 2px solid #564141"></div>
        <div class="list_of_products">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <table id="tblProducts" style="width: 60%;margin-right: auto;margin-left: auto">
                    <tr style="background-color: #ccad86">
                        <th>Title</th><th>Category</th><th>Quantity</th><th>Price</th><th style="width: 275px">Change Quantity</th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</section>

<script>
    var searchData=[];
    var idlePageData = [];
    <?php

    if(isset($_POST['btnSearch'])){
        $title = $_POST['title'];
        $category = $_POST['category'];
        $searchQuery = "SELECT * FROM products WHERE productTitle = '$title' or productCategory = '$category'";
        $result = $connect->query($searchQuery);
        $allSearchData = array();
        while($row=$result->fetch()){
            array_push($allSearchData,$row);
        }
        echo "var searchData = " . json_encode($allSearchData) . ";";
    }else{
        $searchQuery = "SELECT * FROM products";
        $result = $connect->query($searchQuery);
        $allIdlePageData = array();
        while($row=$result->fetch()){
            array_push($allIdlePageData,$row);
        }
        echo "var idlePageData = " . json_encode($allIdlePageData) . ";";
    }

    $connect = null;
    ?>
    function PlacedProducts(productList){
        var lengthOfSearch = productList.length;
        for (var i = 0; i < lengthOfSearch; i++){

            var tr = document.createElement('tr');
            tr.style.backgroundColor = "#ccad86";
            var td1 = document.createElement('td');
            var td2 = document.createElement('td');
            var td3 = document.createElement('td');
            var td4 = document.createElement('td');
            var td5 = document.createElement('td');

            var title = document.createTextNode(productList[i][1])
            td1.appendChild(title);
            tr.appendChild(td1)

            var category = document.createTextNode(productList[i][2])
            td2.appendChild(category);
            tr.appendChild(td2)

            var quantity = document.createTextNode(productList[i][3])
            td3.appendChild(quantity);
            tr.appendChild(td3)

            var price = document.createTextNode(productList[i][4])
            td4.appendChild(price);
            tr.appendChild(td4)

            var buttonReduce = document.createElement('button');
            var nodeRed = document.createTextNode('- (reduce)')
            buttonReduce.appendChild(nodeRed);
            buttonReduce.setAttribute('type','submit');
            buttonReduce.setAttribute('name','buttonReduce');
            buttonReduce.setAttribute('value',productList[i][0]);

            var buttonRaise = document.createElement('button');
            var nodeRai = document.createTextNode('+ (increase)')
            buttonRaise.appendChild(nodeRai);
            buttonRaise.setAttribute('type','submit');
            buttonRaise.setAttribute('name','buttonRaise');
            buttonRaise.setAttribute('value',productList[i][0]);


            var buttonDelete = document.createElement('button');
            var nodeDel = document.createTextNode('x (remove)')
            buttonDelete.appendChild(nodeDel);
            buttonDelete.setAttribute('type','submit');
            buttonDelete.setAttribute('name','buttonDelete');
            buttonDelete.setAttribute('value',productList[i][0]);

            td5.appendChild(buttonReduce);
            td5.appendChild(buttonRaise);
            td5.appendChild(buttonDelete);
            tr.appendChild(td5);

            document.getElementById('tblProducts').appendChild(tr);
        }
    }
    PlacedProducts(idlePageData);
    PlacedProducts(searchData);

</script>

</body>

</html>
