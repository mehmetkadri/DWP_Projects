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
function buy(){
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