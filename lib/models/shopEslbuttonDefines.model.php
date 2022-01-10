<?php

class shopEslbuttonDefinesModel extends waModel{

    protected $table = 'shop_eslbutton_defines';

    public function getDefines(){

        $definesArray = $this->getAll();
        $defines = array();

        foreach($definesArray as $data){
            $defines[$data["name"]] = $data["value"];
        }

        return $defines;

    }

    public function initActive(){

        $this->updateByField("name", "init", array("value" => 1));

    }

    public function requestType($type = 'modal'){

        $this->updateByField("name", "widgettype", array("value" => $type));

    }

}
