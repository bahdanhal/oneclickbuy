<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Sale;

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;

class COneclickbuy extends CBitrixComponent implements Controllerable
{
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }
    private $phoneNumber;
    private $elementNumber;
    private $fUserID;

    public function configureActions()
    {
        return [
            'order' => [
                'prefilters' => [],

            ],
        ];
    }

    public function orderAction($phoneNumber, $elementNumber, $personType, $delivery, $paySystem)
    {
        \Bitrix\Main\Loader::includeModule('sale');
        $this->phoneNumber  = $phoneNumber;
        $this->elementNumber = $elementNumber;
        if(!$this->phoneValidation()){
            return[
                'error' => "Неверно указан номер"
            ];
        }
        $this->fUserID = \Bitrix\Sale\Fuser::getId();
        $basket = $this->createBasket();
        $order = \Bitrix\Sale\Order::create(SITE_ID, $this->fUserID);
        $order->setPersonTypeId($personType);
        $order->setBasket($basket);
        $this->setShipment($order, $delivery);
        $this->setPayment($order, $paySystem);
        $this->setPhone($order);

        $result = $order->save();
        if (!$result->isSuccess())
        {
            return [
                'error' => "заказ не отправлен",
            ];            
        }
        return [
            'success' => true,
        ];

    }

    private function phoneValidation()
    {
        if(!preg_match("/^[0-9]{9,9}+$/", $this->phoneNumber)){        
            return false;
        }
        return true;
    }

    private function createBasket()
    {
        if(isset($this->elementNumber)){
            $product = [
                'PRODUCT_ID' => $this->elementNumber,
                'PRODUCT_PROVIDER_CLASS' => '\Bitrix\Catalog\Product\CatalogProvider',
                'QUANTITY' => 1
            ];

            $basket = Sale\Basket::create(SITE_ID);

            $item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
            unset($product["PRODUCT_ID"]);
            $item->setFields($product);
        } else {
            $basket = Sale\Basket::loadItemsForFUser($this->fUserID, SITE_ID);
        }
        return $basket;
    }

    private function setShipment($order, $delivery)
    {
        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(
            Sale\Delivery\Services\Manager::getObjectById($delivery)
        );
        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        foreach ($this->basket as $basketItem)
        {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }
    }

    private function setPayment($order, $paySystem)
    {
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(
            Sale\PaySystem\Manager::getObjectById($paySystem)
        );
        $payment->setField("SUM", $order->getPrice());
        $payment->setField("CURRENCY", $order->getCurrency());
    }

    private function setPhone($order)
    {
        $propertyCollection = $order->getPropertyCollection();
        $phoneProp = $propertyCollection->getPhone();
        $phoneProp->setValue($this->phoneNumber);
    }
}
