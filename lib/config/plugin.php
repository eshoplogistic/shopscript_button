<?php

return array(
    'name' => 'Eshoplogistic',
    'description' => "Оформить быстрый заказ",
    'vendor' => 'eshoplogistic',
    'version' => '1.0',
    'img'=>'img/plugin.png',
    'frontend' => true,
    'shop_settings' => true,
    'handlers' => array(
        'frontend_product' => 'frontendProduct',
    ),
);
