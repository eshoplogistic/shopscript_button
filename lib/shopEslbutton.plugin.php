<?php

/**
 * Class shopEslbutton
 */
class shopEslbuttonPlugin extends shopPlugin
{

    public function frontendProduct()
    {
        $definesModel = new shopEslbuttonDefinesModel();
        $vars = $definesModel->getDefines();
        if(!isset($vars["init"]) || empty($vars["init"])){
            $definesModel->initActive();
        }

 //       if($vars["init"] == 1)
 //           return false;

        if(!isset($vars['widgettype']))
            return false;

        if(isset($_REQUEST['widgettype'])){
            if($_REQUEST['widgettype'] === 'static' || $_REQUEST['widgettype'] === 'modal'){
                $definesModel->requestType($_REQUEST['widgettype']);
            }
        }

        $checkout_controls = shopEslbuttonHelper::getScript();

        $data = array(
            'cart' => $checkout_controls, //фрагмент HTML-кода
        );

        return $data;
    }
}
