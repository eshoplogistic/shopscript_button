<?php

class shopEslbuttonPluginFrontendEslbuttonRequestController extends waJsonController{

    protected $plugin_id = "eslbutton";

    public function execute(){

        $post = waRequest::post();
        $definesModel = new shopEslbuttonDefinesModel();
        $vars = $definesModel->getDefines();

        $result = array();
        if($vars['widgettype'] == 'modal'){
            $result = $this->initButtonModal($post);
        }
        if($vars['widgettype'] == 'static'){
            $result = $this->initButtonStatic($post);
        }
        $this->response = array("content" => $result, "type" => $vars['widgettype']);

        return true;

    }

    protected function initButtonModal($post){

        $definesModel = new shopEslbuttonDefinesModel();
        $vars = $definesModel->getDefines();

        $widgetKey = (isset($vars['widgetkey']))?$vars['widgetkey']:'';

        if(!$widgetKey)
            return '';

        if(!isset($post['sku_currect'])){
            $sku = $post;
        }else{
            $sku = $post['skus'][$post['sku_currect']['id']];
        }


        $button_content = sprintf(
            '<button type="button" 
            class="s-submit-button js-submit-button esl-button_modal"
            data-widget-button="" 
            data-article="%1$s" 
            data-name="%2$s" 
            data-price="%3$s" 
            data-unit="" 
            data-weight="%4$s">
            Заказать с доставкой
            </button>',
            $post['id'],
            $post['name'],
            $sku['price'],
            1
        );
        $block_content = sprintf(
            '<div id="esl-box">%1$s<div id="eShopLogisticApp" data-key="%2$s"></div></div>',
            $button_content,
            $widgetKey
        );


        return $block_content;
    }


    protected function initButtonStatic($post){

        $definesModel = new shopEslbuttonDefinesModel();
        $vars = $definesModel->getDefines();

        $widgetKey = (isset($vars['widgetkey']))?$vars['widgetkey']:'';

        if(!$widgetKey)
            return '';

        if(!isset($post['sku_currect'])){
            $sku = $post;
        }else{
            $sku = $post['skus'][$post['sku_currect']['id']];
        }

        $button_content = '<button type="button" class="esl-button_static" id="wtpbtn" data-widget-load="">Заказать с доставкой</button>';

        $button_content .= sprintf(
            '<div id="eShopLogisticStatic" 
                    data-article="%1$s"
                    data-name="%2$s" 
                    data-price="%3$s"  
                    data-weight="%4$s"
                    data-key="%5$s"
                    ></div>',
            $post['id'],
            $post['name'],
            $sku['price'],
            1,
            $widgetKey
        );

        $block_content = sprintf(
            '<div id="esl-box">%1$s</div>',
            $button_content
        );

        return $block_content;
    }
}