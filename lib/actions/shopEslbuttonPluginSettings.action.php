<?php

class shopEslbuttonPluginSettingsAction extends waViewAction{

    public function execute(){

        $plugin_id = 'eslbutton';

        $vars = array();

        $plugin = waSystem::getInstance()->getPlugin($plugin_id, true);
        $namespace = wa()->getApp() . '_' . $plugin_id;

        $params = array();
        $params['id'] = $plugin_id;
        $params['namespace'] = $namespace;
        $params['title_wrapper'] = '%s';
        $params['description_wrapper'] = '<br><span class="hint">%s</span>';
        $params['control_wrapper'] = '<div class="name">%s</div><div class="value">%s %s</div>';

        $settings_controls = $plugin->getControls($params);
        $this->getResponse()->setTitle(_w(sprintf('Plugin %s settings', $plugin->getName())));

        $vars['plugin_info'] = array(
            'name' => $plugin->getName()
        );
        $vars['plugin_id'] = $plugin_id;
        $vars['settings_controls'] = $settings_controls;
        $vars['settings'] = $plugin->getSettings();
        $vars["shop_plugin_config"] = array();

        $definesModel = new shopEslbuttonDefinesModel();
        $vars["defines"] = $definesModel->getDefines();

        $this->view->assign($vars);

        $this->view->assign('shop_plugin_url', wa("shop")->getPlugin($plugin_id)->getPluginStaticUrl());

        $controls = array();
        $controls_checkout = wa('shop')->getConfig()->getCheckoutSettings();
        $controls_checkout = $controls_checkout["contactinfo"]["fields"];

        $this->view->assign('checkout_controls', $controls_checkout);

    }

}
