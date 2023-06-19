<?php
session_start();
error_reporting(0);
$server = "localhost";
$username = "root";
$password = "";
$db = "ceramix";

try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['buttonAddToCart'])){
        $addItem = $_POST['buttonAddToCart'];
        unset($_POST['buttonAddToCart']);
        $itemLeftQuery = "SELECT productQuantity FROM products WHERE productID = '$addItem'";
        $result = $connect->query($itemLeftQuery);
        $itemLeftArr = $result->fetch();
        $itemLeft = $itemLeftArr[0];
        if ($itemLeft>0){
            $sqlReduce = "UPDATE products SET productQuantity = productQuantity-1 WHERE productID = '$addItem'";
            $connect->exec($sqlReduce);
            $username = $_SESSION['user'];
            $itemInBasketQuery = "SELECT basketProductQuantity FROM basket WHERE basketCustomerUsername  = '$username' AND basketProductID   = '$addItem'";
            $result = $connect->query($itemInBasketQuery);
            $itemInBasketArr = $result->fetch();
            $itemInBasket = $itemInBasketArr[0];
            if ($itemInBasket > 0) {
                $sqlUpdate = "UPDATE basket SET basketProductQuantity = basketProductQuantity+1 WHERE basketCustomerUsername  = '$username' AND basketProductID   = '$addItem'";
                $connect->exec($sqlUpdate);
            } else {
                $sqlRaise = "INSERT INTO `basket`(`basketCustomerUsername`, `basketProductID`, `basketProductQuantity`) VALUES ('$username','$addItem','1')";
                $connect->exec($sqlRaise);
            }
        }
    }
}
catch(PDOException $ex){
    print "Connection Failed" . $ex->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ceramix</title>
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

<form method="post" action="user_main_page.php">
    <div style="width:100%; margin-top: 20px; border: 5px solid #564141; border-radius: 15px">
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
        <div class="list_of_products" >
            <div class="centered_body">
                <div id="ceramic_container" class="container" style="justify-content: initial"></div>
            </div>
        </div>
    </div>
</form>


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

    function displayCeramicsOnUserMainPage(items)      {

        for (let i = 0; i < items.length; i++) {
            console.log(items[i]);
            let ceramicContainer0 = document.getElementById("ceramic_container")
            let cardVar1 = document.createElement("div")
            let cardBodyVar2 = document.createElement("div")
            let imgLinkVar3 = document.createElement("img")
            let nameVar3 = document.createElement("h4")
            let descVar3 = document.createElement("p")
            let cardFooterVar2 = document.createElement("div")
            let cardInfoVar3 = document.createElement("div")
            let priceVar4 = document.createElement("h3")
            let addButtonVar4 = document.createElement("button")

            cardVar1.classList.add("card");
            cardVar1.style.alignContent="center"
            cardBodyVar2.classList.add("card__body");
            imgLinkVar3.style.maxHeight="200px"
            nameVar3.style.marginBottom="1px"
            cardFooterVar2.classList.add("card__footer");
            cardInfoVar3.classList.add("user__info");
            priceVar4.style.marginLeft="clamp(12rem, calc(12rem + 2vw), 15rem)"
            addButtonVar4.classList.add("addToCart");
            addButtonVar4.style.cursor="pointer"
            descVar3.style.height="40px"

            let buttonText = document.createTextNode("Add to Basket")
            addButtonVar4.appendChild(buttonText)
            addButtonVar4.setAttribute('type','submit');
            addButtonVar4.setAttribute('name','buttonAddToCart');
            addButtonVar4.setAttribute('value',items[i][0]);
            addButtonVar4.style.borderRadius = "10px";

            imgLinkVar3.src = items[i][6]
            imgLinkVar3.alt = "image not found"

            let nameText = document.createTextNode(items[i][1])
            nameVar3.appendChild(nameText)

            let descText = document.createTextNode(items[i][5])
            descVar3.appendChild(descText)

            let priceText = document.createTextNode(items[i][4]+" ₺")
            priceVar4.appendChild(priceText)

            cardBodyVar2.appendChild(imgLinkVar3)
            cardBodyVar2.appendChild(nameVar3)
            cardBodyVar2.appendChild(descVar3)
            cardInfoVar3.appendChild(priceVar4)
            cardInfoVar3.appendChild(addButtonVar4)
            cardFooterVar2.appendChild(cardInfoVar3)
            cardVar1.appendChild(cardBodyVar2)
            cardVar1.appendChild(cardFooterVar2)
            if (items[i][3]>0){
                ceramicContainer0.appendChild(cardVar1)
            }
        }

    }

    displayCeramicsOnUserMainPage(idlePageData);
    displayCeramicsOnUserMainPage(searchData);

</script>
</body>
</html>