<div>
    <button id="buyButton" onclick="openForm();" style="display:block;">Купить в один клик</button>
</div>
<form id="orderForm" onsubmit="sendForm(); return false" style="display:none;">
    <input type="tel" id='phoneNumber' placeholder="********"> Введите номер телефона с кодом оператора
    <input type="hidden" id='elementNumber' value=<?=$arParams["ELEMENT_NUMBER"]?>>
    <input type="hidden" id='personType' value=<?=$arParams["PERSON_TYPE"]?>>
    <input type="hidden" id='delivery' value=<?=$arParams["DELIVERY"]?>>
    <input type="hidden" id='paySystem' value=<?=$arParams["PAYSYSTEM"]?>>
    <br>
    <input type="submit" value='Оформить заказ'>
</form>

