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


    if (isset($_POST['orderGiven'])){
        $userName = $_SESSION['user'];
        $sqlUpdate = "DELETE FROM basket WHERE basketCustomerUsername  = '$userName'";
        $connect->exec($sqlUpdate);
    }
    if(isset($_POST['buttonInc'])){

        $incElem = $_POST['buttonInc'];
        $incProduct = explode("/",$incElem)[0];
        $incCustomer = explode("/",$incElem)[1];
        unset($_POST['buttonInc']);

        $itemLeftQuery = "SELECT productQuantity FROM products WHERE productID = '$incProduct'";
        $result = $connect->query($itemLeftQuery);
        $itemLeftArr = $result->fetch();
        $itemLeft = $itemLeftArr[0];
        if($itemLeft>0){
            $sqlRaise= "UPDATE basket SET basketProductQuantity = basketProductQuantity+1 WHERE basketCustomerUsername  = '$incCustomer' AND basketProductID   = '$incProduct'";
            $connect->exec($sqlRaise);
            $sqlReduce = "UPDATE products SET productQuantity = productQuantity-1 WHERE productID = '$incProduct'";
            $connect->exec($sqlReduce);
        }
    }
    if(isset($_POST['buttonDec'])){
        $decElem = $_POST['buttonDec'];
        $decProduct = explode("/",$decElem)[0];
        $decCustomer = explode("/",$decElem)[1];
        unset($_POST['buttonDec']);
        $sqlDelete = "UPDATE basket SET basketProductQuantity = basketProductQuantity-1 WHERE basketCustomerUsername  = '$decCustomer' AND basketProductID   = '$decProduct'";
        $connect->exec($sqlDelete);
        $sqlReduce = "UPDATE products SET productQuantity = productQuantity+1 WHERE productID = '$decProduct'";
        $connect->exec($sqlReduce);
        $itemLeftQuery = "SELECT basketProductQuantity FROM basket WHERE basketCustomerUsername  = '$decCustomer' AND basketProductID   = '$decProduct'";
        $result = $connect->query($itemLeftQuery);
        $itemLeftArr = $result->fetch();
        $itemLeft = $itemLeftArr[0];
        if($itemLeft==0){
            $sqlDelete = "DELETE FROM basket WHERE basketCustomerUsername  = '$decCustomer' AND basketProductID   = '$decProduct'";
            $connect->exec($sqlDelete);
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
    <title>Basket</title>
    <link rel="stylesheet" href="ceramix.css">
    <script src="ceramix.js"></script>
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

<form method="post" action="user_basket.php">
    <div class="list_of_products" >
        <h2>Basket</h2>
        <div class="flex_body">

            <div id="ceramic_container" class="container" style="justify-content: initial; width: 100%">
                <div id="container_basket" class="container_basket">

                </div>
            </div>
            <div class="basket_total" style="; width: 30%">
                <div class="container">
                    <h4 style="font-size: 20px; margin: 1px 120px;">TOTAL</h4>
                </div>
                <div class="container" style=" margin-top: 1px">
                    <h4 id="cost" style="font-size: 20px; margin: 1px 100px;">0 ₺</h4>
                </div>
                <div class="container" style="position: center; margin-top: 10px">
                    <button id="buyButton" onclick="buy()" type="button"><strong style="font-size: 20px">BUY</strong></button>
                </div>
            </div>
        </div>
    </div>
</form>

<div id="checkOut" class="basket" style="left:400px;right: 400px;">
    <div style="display: flex; flex-direction: column">
        <label for="address" style="margin-left: 20px; margin-top: 20px"><strong>Shipping Address:</strong><br><br><textarea id="address" style="width: 400px; height: 170px"></textarea></label>
        <strong style="margin-left: 20px; margin-top: 30px">Payment Method:</strong><br><br>

        <label id="wire" for="radio1" style="margin-left: 15px"><input type="radio" id="radio1" name="1" onclick="pay_wire()">Wire Transfer</label>
        <label id="card" for="radio2" style="margin-left: 15px"><input type="radio" id="radio2" name="1" onclick="pay_card()">Credit Card</label>

        <div id="wire_info" style="display: none; margin-left: 15px; margin-top: 15px; margin-bottom: 15px">
            <h4> You will be notified about your shipment after you have completed the transaction to the account number below.</h4>
            <strong> TR09 0392 1923 4958 8275 8493 21</strong>
        </div>
        <div id="card_info" style="display: none; margin-left: 15px; margin-top: 15px; margin-bottom: 15px">
            <label for="userName"> <strong style="color: #564141">Name:</strong> <br></label> <input type="text" id="userName" style="margin-top: 10px; margin-bottom: 10px; height: 30px; width: 400px">  <br>
            <label for="cardNumber"> <strong style="color: #564141">Credit Card Number:</strong> <br></label> <input type="number" id="cardNumber" style="margin-top: 10px; height: 30px; width: 400px">  <br>
            <div style="display: flex; margin-top: 10px">
                <table>
                    <tr>
                        <td>
                            <label for="expDay"> <strong style="color: #564141">Expiration Day:</strong> <br></label> <input type="number" id="expDay" style="margin-top: 10px; height: 30px; width: 100px">  <br>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <label for="expMonth"> <strong style="color: #564141">Expiration Month:</strong> <br></label> <input type="number" id="expMonth" style="margin-top: 10px; height: 30px; width: 100px">  <br>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <label for="CVV"> <strong style="color: #564141">CVV:</strong> <br></label> <input type="number" id="CVV" style="margin-top: 10px; height: 30px; width: 100px">  <br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <label onclick="read()" for="read" style="margin-left: 15px"><input type="checkbox" id="read" name="2">I've read ...</label>

        <div style="display: flex; flex-direction: row">
            <button onclick="orderCancelled()" style="color: white; background-color: #be0101; border-radius: 10px; height: 50px; width: 200px; margin-top: 20px; margin-left: 450px"><strong style="font-size: 20px">Cancel</strong></button>
            <form method="post" action="user_basket.php">
                <button id="confirmButton" disabled type="submit" name="orderGiven" style="color: white; background-color: gray; border-radius: 10px; height: 50px; width: 150px; margin-top: 20px; margin-left: 10px; margin-right: 20px"><strong style="font-size: 20px">Confirm</strong></button>
            </form>
        </div>
    </div>
</div>


<script>

    var product_arr = [];

    <?php

    $userName = $_SESSION['user'];

    $searchQuery = "SELECT productTitle, productPrice, productPhotoURL, basketProductQuantity, basketProductID, basketCustomerUsername FROM basket JOIN products ON basket.basketProductID=products.productID WHERE basketCustomerUsername = '$userName'";
    $result = $connect->query($searchQuery);
    $allSearchData = array();
    while($row=$result->fetch()){
        array_push($allSearchData,$row);
    }
    echo "var product_arr = " . json_encode($allSearchData) . ";";

    ?>


    function displayBasket(basket){
        let basketContainer = document.getElementById("container_basket")
        basketContainer.innerHTML=""
        let totalCost = 0
        for (let i = 0; i < basket.length; i++) {
            basketContainer = document.getElementById("container_basket")
            let card_basket = document.createElement("div")
            let card__body_basket = document.createElement("div")
            let img_basket = document.createElement("img")
            let card__footer_basket = document.createElement("div")
            let user__info_basket = document.createElement("div")
            let item_name_basket = document.createElement("h4")
            let item_price_basket = document.createElement("h3")
            let decreaseFromCart_basket = document.createElement("button")
            let quantityInCart_basket = document.createElement("h3")
            let increaseFromCart_basket = document.createElement("button")

            card_basket.style.alignContent="center";
            card_basket.classList.add("card_cart");
            card__body_basket.classList.add("card__body_cart");
            img_basket.classList.add("img_cart");
            card__footer_basket.classList.add("card__footer_cart");
            user__info_basket.classList.add("user__info_cart");
            item_name_basket.classList.add("item_name_cart");
            item_price_basket.classList.add("item_price_cart");
            decreaseFromCart_basket.classList.add("decreaseFromCart_cart");
            increaseFromCart_basket.classList.add("increaseFromCart_cart");
            quantityInCart_basket.classList.add("quantityInCart_cart");

            let decButtonText = document.createTextNode("-")
            decreaseFromCart_basket.appendChild(decButtonText)
            decreaseFromCart_basket.setAttribute('type','submit');
            decreaseFromCart_basket.setAttribute('name','buttonDec');
            let primaryForDec = basket[i][4]+"/"+basket[i][5];
            decreaseFromCart_basket.setAttribute('value',primaryForDec);

            let incButtonText = document.createTextNode("+")
            increaseFromCart_basket.appendChild(incButtonText)
            increaseFromCart_basket.setAttribute('type','submit');
            increaseFromCart_basket.setAttribute('name','buttonInc');
            let primaryForInc = basket[i][4]+"/"+basket[i][5];
            increaseFromCart_basket.setAttribute('value',primaryForInc);

            let quantity = document.createTextNode(basket[i][3])
            quantityInCart_basket.appendChild(quantity)

            img_basket.src = basket[i][2]


            let nameText = document.createTextNode(basket[i][0])
            item_name_basket.appendChild(nameText)

            let priceText = document.createTextNode(basket[i][1]+" ₺")
            item_price_basket.appendChild(priceText)

            let tempCost = basket[i][1] * basket[i][3]
            totalCost+=tempCost

            card__body_basket.appendChild(img_basket)
            card_basket.appendChild(card__body_basket)
            user__info_basket.appendChild(item_name_basket)
            user__info_basket.appendChild(item_price_basket)
            card__footer_basket.appendChild(user__info_basket)
            card__footer_basket.appendChild(decreaseFromCart_basket)
            card__footer_basket.appendChild(quantityInCart_basket)
            card__footer_basket.appendChild(increaseFromCart_basket)
            card_basket.appendChild(card__footer_basket)
            basketContainer.appendChild(card_basket)

        }

        document.getElementById("cost").innerText = totalCost+" ₺"
    }

    displayBasket(product_arr);


</script>

</body>
</html>