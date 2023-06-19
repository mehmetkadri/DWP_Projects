function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}
function myFunc(){
    if (document.getElementById("firstH").innerText==="New Header"){
        document.getElementById("firstH").innerHTML = "Demo JS in Head"
        document.getElementById("firstP").innerHTML = "Lorem ipsum"
        document.getElementById("firstB").innerHTML = "Change"
        let colors = ["red", "green", "blue"]
        document.getElementById("firstB").innerHTML = "Change"
        //let arr = document.getElementsByTagName("button")
        //for (let i = 0; i<arr.length; i++){

        //    arr[i].style.display="initial"


        //}
        //let arr2 = document.getElementsByTagName("button")
        //for (let i = 0; i<arr2.length; i++){

        //    arr2[i].style.visibility="hidden"


        //}
        document.getElementById("firstH").style.color="red"
        document.getElementById("firstP").style.color="red"
        document.getElementById("firstB").style.color="red"
    }else{
        document.getElementById("firstH").innerHTML = "New Header"
        document.getElementById("firstP").innerHTML = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
        document.getElementById("firstB").innerHTML = "Changed"
        document.getElementById("firstH").style.color="blue"
        document.getElementById("firstP").style.color="yellow"
        document.getElementById("firstB").style.color="red"
        //let arr = document.getElementsByTagName("button")
        //for (let i = 0; i<arr.length; i++){

        //    arr[i].style.display="none"


        //}
        //let arr2 = document.getElementsByTagName("button")
        //for (let i = 0; i<arr2.length; i++){

        //    arr2[i].style.visibility="visible"


        //}
    }
}

function sumFunc(){
    let operator = document.getElementById("operatorContainer").innerHTML
    let operand1 = parseInt(document.getElementById("fname").value)
    let operand2 = parseInt(document.getElementById("lname").value)
    if(operator==="sum"){
        document.getElementById("sumRes").innerHTML = operand1 + operand2

    }else if(operator==="sub"){
        document.getElementById("sumRes").innerHTML = operand1 - operand2

    }else if(operator==="mul"){
        document.getElementById("sumRes").innerHTML = operand1 * operand2

    }else if(operator==="div"){
        document.getElementById("sumRes").innerHTML = operand1 / operand2

    }else{
        document.getElementById("sumRes").innerHTML = "?"
    }
}

function setOperator(id){
    document.getElementById("operatorContainer").innerHTML = id
}

function sumArrFunc(){
    let arr = document.getElementById("numArr").value.split(" ")
    let sum = 0
    for(let i = 0; i<arr.length; i++) {
        let element = parseInt(arr[i])
        if (!isNaN(element) && typeof element===typeof 3){
            sum+=element;
        }else{
            alert("You've entered an invalid input")
        }
    }
    document.getElementById("sumArrRes").innerHTML = sum
}

function calcFunc(){

}

function createList(){
    let separator = document.getElementById("separator").value
    let arr = document.getElementById("listElem").value.split(separator)
    let output = "<ul>"
    for(const listElement of arr){
        output += "<li>" + listElement
    }
    document.getElementById("list").innerHTML=output
}
