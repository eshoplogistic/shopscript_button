<?php


class shopEslbuttonHelper{

    const plugin_id = "eslbutton";

    public static function isActive(){

        $active = wa("shop")->getPlugin(self::plugin_id)->getSettings("active");

        if($active){
            return true;
        }else{
            return false;
        }

    }

    public static function getScript(){

        $settings = wa("shop")->getPlugin(self::plugin_id)->getSettings();

        $paramsInit = array(
            "urlRequest" => wa()->getRouteUrl("shop/frontend/eslbuttonRequest/"),
        );
        $definesModel = new shopEslbuttonDefinesModel();
        $vars = $definesModel->getDefines();
        $buttonType = (isset($vars['widgettype']))?$vars['widgettype']:'';

        $view = wa()->getView();

        $view->assign("eslbutton_init", $paramsInit);
        $view->assign("eslbutton_defines", $settings);
        $view->assign("eslbutton_type", $buttonType);
        $view->assign("shopEslbuttonPathJS", wa("shop")->getPlugin(self::plugin_id)->getPluginStaticUrl() . "js/");
        $view->assign("shopEslbuttonPathCSS", wa("shop")->getPlugin(self::plugin_id)->getPluginStaticUrl() . "css/");

        $path = wa()->getAppPath(null, "shop") . "/plugins/" . self::plugin_id;
        $content = $view->fetch($path . '/templates/actions/frontend/Script.html');
        return $content;
    }

}