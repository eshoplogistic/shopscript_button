<?php
return array(

    'shop_eslbutton_defines' => array(
        'id' => array('int', 11, 'null' => 0, 'autoincrement' => 1),
        'name' => array('varchar', 64, 'null' => 0),
        'value' => array('text'),
        ':keys' => array(
            'PRIMARY' => 'id',
            'name' => array('name', 'unique' => 1),
        ),
    ),

);