<?php
/*
Plugin Name: sima-land-goods
Plugin URI: http://justlinux.ru
Description: Плагин работает с REST API сайта sima-land и импортирует оттуда товары
Version: 1.0
Author: Евгений Biatl0n Ашурков
Author URI: http://justlinux.ru
License: GPL2
*/

/*
Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : evgeny.biatl0n@gmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>

<?php

add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page(){
        add_menu_page( 
                    'custom menu title', 'sima-land-goods', 'manage_options', 'custompage', 'my_custom_menu_page', plugins_url( 'sima-land-goods/img/icon.png' ), 6  
                ); 
}

function getCatigories(){
    
    $curl = curl_init('https://www.sima-land.ru/api/v3/category/?level=2&path=16&is_not_empty=1');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);

    echo "<pre>";
    $json=json_decode($json);
    $json2=$json->items;
    
    foreach ($json2 as $key => $value) {
        print_r ("$key => $value->name");
        print_r ("   ID:$value->id, Path:$value->path\n");

            $curl = curl_init("https://www.sima-land.ru/api/v3/item/?category_id=$value->id&has_price=1");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
            $jsonGood=json_decode($json);
            $jsonGood2=$jsonGood->items;    
            $PageCount=$jsonGood->_meta->pageCount;

            $jsonGood3=array();
            //for ($i=1; $i<=$PageCount; $i++){
            for ($i=1; $i<=2; $i++){
                $curl = curl_init("https://www.sima-land.ru/api/v3/item/?category_id=$value->id&has_price=1");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                curl_close($curl);
                $jsonGood=json_decode($json);
                $jsonGood2=$jsonGood->items;
                $jsonGood3=array_merge($jsonGood3, $jsonGood2);
            }
            
            foreach ($jsonGood3 as $key2 => $value2) {
                print_r ("              $key2 => $value2->name");
                print_r ("  Price: $value2->price\n");
                //print_r ("$key2 => $value2->description\n");
            }
    }

}


function my_custom_menu_page(){
    getCatigories();
}


?>
