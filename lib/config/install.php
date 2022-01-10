<?php

$model = new waModel();

$data = array(
    array("name" => "init", "value" => '0'),
);

foreach($data as $item){
    $model->query("REPLACE `shop_eslbutton_defines` (`name`, `value`) VALUES ('{$item["name"]}', '{$item["value"]}')");
}
