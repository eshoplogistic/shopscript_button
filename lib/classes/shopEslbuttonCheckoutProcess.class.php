<?php

class shopEslbuttonCheckoutProcess{

    protected $plugin_id = "eslbutton";

    public function createOrder($data){

        if($data['offers']){
            $offers = json_decode($data['offers'], true)[0];
            $item_id = (isset($offers['article']))?$offers['article']:false;
            $item_name = (isset($offers['name']))?$offers['name']:false;
            $item_price = (isset($offers['price']))?$offers['price']:false;
            $item_summ = (isset($offers['summ']))?$offers['summ']:false;
            $item_unit = (isset($offers['unit']))?$offers['unit']:false;
            $item_count = (isset($offers['count']))?$offers['count']:1;
            $item_weight = (isset($offers['weight']))?$offers['weight']:1;
        }else{
            return false;
        }

        if(!isset($item_id) && !$item_id)
            return false;

        $contact = new waContact();

        if(isset($data) && is_array($data)){
            foreach($data as $field => $value){
                $contact->set($field, $value);
            }
            $contact->save();
        }

        $product_model = new shopProductModel();
        $item = $product_model->getById($item_id);
        if(!$item)
            return false;

        $item['quantity'] = $item_count;
        $item['type'] = 'product';
        $item['price'] = $item_price;
        $item['product_id'] = $item_id;
        unset($item['id']);
        unset($item['parent_id']);
        $items[] = $item;
        $cart = new shopCart();

        $order = array(
            'contact' => $contact,
            'items' => $items,
            'total' => $cart->total(false),
            'params' => isset($checkout_data['params']) ? $checkout_data['params'] : array(),
        );


        $order['discount_description'] = null;
        $order['discount'] = shopDiscounts::apply($order, $order['discount_description']);

        $order['shipping'] = 0;
        $delivery = array();
        $payment = array();
        $shipper = array();
        if($data['selectedDelivery']){
            $delivery = json_decode($data['selectedDelivery'], true);
            $order['shipping'] = $delivery['price'];
        }
        if($data['selectedPayment'])
            $payment = json_decode($data['selectedPayment'], true);
        if($data['idShipper'])
            $shipper = json_decode($data['idShipper'], true);

        $routing_url = wa()->getRouting()->getRootUrl();
        $order['params']['storefront'] = wa()->getConfig()->getDomain() . ($routing_url ? '/' . $routing_url : '');

        $order['params']['ip'] = waRequest::getIp();
        $order['params']['user_agent'] = waRequest::getUserAgent();


        $order['comment'] = '';
        $add_comment = array();
        (isset($shipper['name']) && $shipper['name'])?$add_comment['Название службы доставки'] = $shipper['name']:false;
        (isset($delivery['name']) && $delivery['name'])?$add_comment['Тип службы доставки'] = $delivery['name']:false;
        (isset($delivery['time']) && $delivery['time'])?$add_comment['Период доставки'] = $delivery['time']:false;
        (isset($delivery['price']) && $delivery['price'])?$add_comment['Цена доставки'] = $delivery['price']:false;
        (isset($data['addressForDelivery']) && $data['addressForDelivery'])?$add_comment['Адрес доставки'] = $data['addressForDelivery']:false;
        (isset($payment['name']) && $payment['name'])?$add_comment['Способ оплаты'] = $payment['name']:false;

        if($add_comment){
            foreach ($add_comment as $key=>$value){
                $order['comment'] .= "\n\n".$key.': '.$value;
            }
        }

        if(isset($data['comment']) && $data['comment']){
            $order['comment'] .=  "\n\nКомментарий: " .$data['comment'];
        }

        $workflow = new shopWorkflow();
        if($order_id = $workflow->getActionById('create')->run($order)){
            return $order_id;
        }else{
            return false;
        }

    }

}