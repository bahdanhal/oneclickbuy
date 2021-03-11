function openForm(){
    $('#orderForm').show();
    $('#buyButton').hide();
}
function sendForm(){
    var request = BX.ajax.runComponentAction('custom:oneclickbuy', 'order', {
        mode:'class',
        data: {
            phoneNumber: document.getElementById("phoneNumber").value,
            elementNumber: document.getElementById("elementNumber").value,
            personType: document.getElementById("personType").value,
            delivery: document.getElementById("delivery").value,
            paySystem: document.getElementById("paySystem").value,
        }
    });
     
    request.then(function(response){
        if (response.status === "success" && response.data.error == undefined){
            alert("Заказ оформлен!");
        } else {
            alert("Ошибка! " + response.data.error);
        }
    });
}