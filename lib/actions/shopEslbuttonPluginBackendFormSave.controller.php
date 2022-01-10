<?php

class shopEslbuttonPluginBackendFormSaveController extends waJsonController{

    public function execute(){

        $post = waRequest::post();
        $errors = array();

        if(isset($post["shop_eslbutton_defines"]) && !empty($post["shop_eslbutton_defines"])){
            $definesModel = new shopEslbuttonDefinesModel();
            foreach($post["shop_eslbutton_defines"] as $name => $value){
                $result = $definesModel->replace(array("name" => $name, "value" => $value));
            }
        }

        if(!empty($errors)){
            $this->errors = $errors;
            return false;
        }

        return true;

    }


}