<?php
session_start();
error_reporting(0);

$server = "localhost";
$userName = "root";
$password = "";
$db = "ceramix";

try{
    $connect = new PDO("mysql:host=$server;dbname=$db",$userName,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $ex){
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
    <a href="main_page.php">Main Page</a>

    <a href="main_admin_sign_in_page.php" style="float:right">Admin Sign In</a>
    <a href="main_user_sign_in_page.php" style="float:right">Sign In</a>
    <a href="main_user_sign_up_page.php" style="float:right">Sign Up</a>
</div>


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

    function displayCeramicsOnMainPage(items)      {

        for (let i = 0; i < items.length; i++) {
            let ceramicContainer0 = document.getElementById("ceramic_container")
            let cardVar1 = document.createElement("div")
            let cardBodyVar2 = document.createElement("div")
            let imgLinkVar3 = document.createElement("img")
            let nameVar3 = document.createElement("h4")
            let descVar3 = document.createElement("p")
            let cardFooterVar2 = document.createElement("div")
            let cardInfoVar3 = document.createElement("div")
            let priceVar4 = document.createElement("h3")

            cardVar1.classList.add("card");
            cardVar1.style.alignContent="center"
            cardBodyVar2.classList.add("card__body");
            imgLinkVar3.style.maxHeight="200px"
            nameVar3.style.marginBottom="1px"
            cardFooterVar2.classList.add("card__footer");
            cardInfoVar3.classList.add("user__info");
            priceVar4.style.marginLeft="clamp(12rem, calc(12rem + 2vw), 15rem)"
            descVar3.style.height="80px"

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
            cardFooterVar2.appendChild(cardInfoVar3)
            cardVar1.appendChild(cardBodyVar2)
            cardVar1.appendChild(cardFooterVar2)
            if (items[i][3]>0){
                ceramicContainer0.appendChild(cardVar1)
            }
        }
    }

    displayCeramicsOnMainPage(idlePageData);
    displayCeramicsOnMainPage(searchData);

</script>

</body>

</html>
