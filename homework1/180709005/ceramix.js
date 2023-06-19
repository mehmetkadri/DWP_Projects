let items = []
let basket =  []

class Ceramix{
    constructor(name, desc, price, imgLink) {
        this.name = name;
        this.desc = desc;
        this.price = price;
        this.imgLink = imgLink;
    }
}

let ceramic_1 = new Ceramix("Vase", "This vase will look gorgeous on your dining table.", "80", "https://static.zarahome.net/8/photos4/2022/V/4/1/p/6371/046/802/6371046802_2_1_1.jpg?t=1637746249685")
let ceramic_2 = new Ceramix("Mugs", "These mugs will make you want to drink lattes.", "120", "https://cdn.webshopapp.com/shops/65545/files/343528692/660x900x2/hk-living-ceramic-70s-latte-mugs-set-of-2.jpg")
let ceramic_3 = new Ceramix("Pitcher", "This pitcher will make you want to drink water.", "160", "https://cdn20.pamono.com/p/s/5/0/501252_o8022okzio/ceramic-pitcher-from-guerrieri-murano-1950s.jpg")

items.push(ceramic_1)
items.push(ceramic_2)
items.push(ceramic_3)
items.push(ceramic_3)


function displayCeramicsOnPage()      {
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
        let addButtonVar4 = document.createElement("button")
        addButtonVar4.onclick = addToCart

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
        descVar3.style.height="80px"

        let buttonText = document.createTextNode("Add to Cart")
        addButtonVar4.appendChild(buttonText)

        imgLinkVar3.src = items[i].imgLink
        imgLinkVar3.alt = "image not found"

        let nameText = document.createTextNode(items[i].name)
        nameVar3.appendChild(nameText)

        let descText = document.createTextNode(items[i].desc)
        descVar3.appendChild(descText)

        let priceText = document.createTextNode(items[i].price+" ₺")
        priceVar4.appendChild(priceText)

        cardBodyVar2.appendChild(imgLinkVar3)
        cardBodyVar2.appendChild(nameVar3)
        cardBodyVar2.appendChild(descVar3)
        cardInfoVar3.appendChild(priceVar4)
        cardInfoVar3.appendChild(addButtonVar4)
        cardFooterVar2.appendChild(cardInfoVar3)
        cardVar1.appendChild(cardBodyVar2)
        cardVar1.appendChild(cardFooterVar2)
        ceramicContainer0.appendChild(cardVar1)
    }

}

function openBasket(){

    if (basket.length!==0){
        document.getElementById("buyButton").disabled = false
        document.getElementById("buyButton").style.backgroundColor = "#564141"

        document.getElementById("cost").innerHTML=costCalculation()
    }else{
        document.getElementById("buyButton").disabled = true
        document.getElementById("buyButton").style.backgroundColor = "gray"
    }
    document.getElementById('basket').style.display = 'initial'
}

function costCalculation(){
    let totalCost = 0
    for (let i = 0; i < basket.length; i++) {
        let itemCost = parseInt(basket[i].price.split(" "))
        totalCost=totalCost+itemCost
    }
    return totalCost + " ₺"
}

function openAddCeramic(){
    document.getElementById('newItem').style.display = 'initial'
}

function addCeramic(){
    let ceramicName = document.getElementById("itemName").value;
    let ceramicPrice = document.getElementById("itemPrice").value;
    let ceramicDesc = document.getElementById("itemDescription").value;
    let ceramicImageUrl = document.getElementById("itemPictureLink").value;

    if (ceramicName!=="" && ceramicPrice!=="" && ceramicDesc!=="" && ceramicImageUrl!==""){

        let temp = new Ceramix(ceramicName,ceramicDesc,ceramicPrice,ceramicImageUrl);
        items.push(temp)

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
        descVar3.style.height="80px"
        addButtonVar4.onclick = addToCart

        let buttonText = document.createTextNode("Add to Cart")
        addButtonVar4.appendChild(buttonText)

        imgLinkVar3.src = temp.imgLink
        imgLinkVar3.alt = "image not found"

        let nameText = document.createTextNode(temp.name)
        nameVar3.appendChild(nameText)

        let descText = document.createTextNode(temp.desc)
        descVar3.appendChild(descText)

        let priceText = document.createTextNode(temp.price+" ₺")
        priceVar4.appendChild(priceText)

        cardBodyVar2.appendChild(imgLinkVar3)
        cardBodyVar2.appendChild(nameVar3)
        cardBodyVar2.appendChild(descVar3)
        cardInfoVar3.appendChild(priceVar4)
        cardInfoVar3.appendChild(addButtonVar4)
        cardFooterVar2.appendChild(cardInfoVar3)
        cardVar1.appendChild(cardBodyVar2)
        cardVar1.appendChild(cardFooterVar2)
        ceramicContainer0.appendChild(cardVar1)

        document.getElementById("itemName").value = ""
        document.getElementById("itemPrice").value = ""
        document.getElementById("itemDescription").value = ""
        document.getElementById("itemPictureLink").value = ""
    }
}

function addToCart(){
    if (document.getElementById("basket").style.display==="none"){
        let parent = event.target.parentElement.children;
        let parent2 = event.target.parentElement.parentElement.parentElement.children;
        let price = parent[0].innerHTML;
        let image_url = parent2[0].children[0].src
        let name = parent2[0].children[1].innerHTML;
        let desc = parent2[0].children[2].innerHTML;

        let temp = new Ceramix(name,desc,price,image_url);

        document.getElementById("cost").innerHTML=costCalculation()

        basket.push(temp)
        displayBasket()
    }
}

function orderCompleted(){
    document.getElementById("checkOut").style.display="none"
    alert("Order is successful")
    basket = []
    document.getElementById("cost").innerHTML=costCalculation()
    displayBasket()
    document.getElementById("address").value = ""
    if (document.getElementById("radio1").checked === true){
        document.getElementById("radio1").checked = false
    }else if (document.getElementById("radio2").checked === true){
        document.getElementById("radio2").checked = false
    }
    document.getElementById("read").checked = false
    document.getElementById("wire_info").style.display = "none"
    document.getElementById("card_info").style.display = "none"
    document.getElementById("confirmButton").disabled = true
    document.getElementById("confirmButton").style.backgroundColor = "gray"
    document.getElementById("checkOut").style.bottom = "100px"
    document.getElementById("checkOut").style.top = "100px"
}

function read(){
    if (document.getElementById("address").value !== "" &&
        (document.getElementById("radio1").checked === true ||
            document.getElementById("radio2").checked === true) &&
    document.getElementById("read").checked === true){
        document.getElementById("confirmButton").disabled = false
        document.getElementById("confirmButton").style.backgroundColor = "#564141"
    }else{
        document.getElementById("confirmButton").disabled = true
        document.getElementById("confirmButton").style.backgroundColor = "gray"
    }
}

function orderCancelled(){
    document.getElementById("checkOut").style.display="none"
    document.getElementById("address").value = ""
    if (document.getElementById("radio1").checked === true){
        document.getElementById("radio1").checked = false
    }else if (document.getElementById("radio2").checked === true){
        document.getElementById("radio2").checked = false
    }
    document.getElementById("read").checked = false
    document.getElementById("wire_info").style.display = "none"
    document.getElementById("card_info").style.display = "none"
    document.getElementById("confirmButton").disabled = true
    document.getElementById("confirmButton").style.backgroundColor = "gray"
    document.getElementById("checkOut").style.bottom = "100px"
    document.getElementById("checkOut").style.top = "100px"
}

function displayBasket(){
    let basketContainer = document.getElementById("container_basket")
    basketContainer.innerHTML=""
    for (let i = 0; i < basket.length; i++) {
        basketContainer = document.getElementById("container_basket")
        let card_basket = document.createElement("div")
        let card__body_basket = document.createElement("div")
        let img_basket = document.createElement("img")
        let card__footer_basket = document.createElement("div")
        let user__info_basket = document.createElement("div")
        let item_name_basket = document.createElement("h4")
        let item_price_basket = document.createElement("h3")
        let deleteFromCart_basket = document.createElement("button")
        deleteFromCart_basket.onclick = deleteFromCart

        card_basket.style.alignContent="center";
        card_basket.classList.add("card_cart");
        card__body_basket.classList.add("card__body_cart");
        img_basket.classList.add("img_cart");
        card__footer_basket.classList.add("card__footer_cart");
        user__info_basket.classList.add("user__info_cart");
        item_name_basket.classList.add("item_name_cart");
        item_price_basket.classList.add("item_price_cart");
        deleteFromCart_basket.classList.add("deleteFromCart_cart");

        let buttonText = document.createTextNode("Delete")
        deleteFromCart_basket.appendChild(buttonText)

        img_basket.src = basket[i].imgLink

        let nameText = document.createTextNode(basket[i].name)
        item_name_basket.appendChild(nameText)

        let priceText = document.createTextNode(basket[i].price.split(" ")[0]+" ₺")
        item_price_basket.appendChild(priceText)

        card__body_basket.appendChild(img_basket)
        card_basket.appendChild(card__body_basket)
        user__info_basket.appendChild(item_name_basket)
        user__info_basket.appendChild(item_price_basket)
        card__footer_basket.appendChild(user__info_basket)
        card__footer_basket.appendChild(deleteFromCart_basket)
        card_basket.appendChild(card__footer_basket)
        basketContainer.appendChild(card_basket)

    }

}

function deleteFromCart(){
    let parent = event.target.parentElement.children;
    let deletedItemName = parent[0].children[0].innerHTML

    for (let i = 0; i < basket.length; i++) {
        if (basket[i].name===deletedItemName){
            basket.splice(i,1)
            break
        }
    }
    displayBasket()
    document.getElementById("cost").innerHTML=costCalculation()
    if (basket.length===0){
        document.getElementById("buyButton").disabled = true
        document.getElementById("buyButton").style.backgroundColor = "gray"
    }
}

function buy(){
    document.getElementById("basket").style.display = "none"
    document.getElementById("checkOut").style.display = "initial"
    document.getElementById("checkOut").style.top = "125px"
    document.getElementById("checkOut").style.bottom = "125px"

}

function pay_wire(){
    document.getElementById("wire_info").style.display = "initial"
    document.getElementById("card_info").style.display = "none"
    document.getElementById("checkOut").style.bottom = "65px"
    document.getElementById("checkOut").style.top = "65px"
}

function pay_card(){
    document.getElementById("card_info").style.display = "initial"
    document.getElementById("wire_info").style.display = "none"
    document.getElementById("checkOut").style.bottom = "20px"
    document.getElementById("checkOut").style.top = "20px"
}
