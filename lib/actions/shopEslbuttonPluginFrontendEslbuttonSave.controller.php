<?php

class shopEslbuttonPluginFrontendEslbuttonSaveController extends waJsonController{

    protected $plugin_id = "eslbutton";

    public function execute(){

        $definesModel = new shopEslbuttonDefinesModel();
        $vars = $definesModel->getDefines();

        $widgetSecret = (isset($vars['widgetsecret']))?$vars['widgetsecret']:'';
        $post = waRequest::get();

        if(!isset($post["secret"]) || $post["secret"] !== $widgetSecret){
            $this->errors[] = "Ошибка проверки запроса";
            return false;
        }

        $this->processCart($post);

        if(!empty($this->errors)){
            return false;
        }

        $this->response = array(
            "success" => true,
            "message" => "Заказ отправлен!"
        );

    }

    protected function processCart($post){

        $checkoutObject = new shopEslbuttonCheckoutProcess();
        $checkoutObject->createOrder($post);

        if(!empty($errors)){
            $this->errors["form"] = $errors;
            return false;
        }

        return true;

    }

}