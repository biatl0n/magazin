<?php
/*
Plugin Name: sima-land-api-client
Plugin URI: http://justlinux.ru
Description: Плагин работает с REST API сайта sima-land.ru и импортирует оттуда товары
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
require_once __DIR__."/func.php";
require_once  __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;
ignore_user_abort(true);
set_time_limit(0);

add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page(){
    add_menu_page( 
        'Sima-Land API client', 'Sima-Land API client', 'manage_options', 'sima-land-api-client', 'my_custom_menu_page', 'dashicons-download', 6  
    ); 
}
 

function my_custom_menu_page(){
    $simaLand = new SimaLandGoods();
    $parentCatsArray=$simaLand->getParentCats();
    $parentCatsCount=count($parentCatsArray);
    require "html.php";

    $catID=$_POST['catName'];

    if ($catID!=NULL){
        echo "<form name='subCat' method='POST' action=".$_SERVER['REQUEST_URI'].">";
        $subCatsArray=$simaLand->getCategories(2, $catID);
        $subCatsCount=count($subCatsArray);

        for ($i=0;$i<$subCatsCount;$i++){
            echo "<input type='radio' name='subCatID' value='".$subCatsArray[$i]->id."'>".$subCatsArray[$i]->name."<br>";
        }

        echo "<input type='hidden' name='catID' value='$catID'>";
        echo "<input type='submit' value='Получить товары'>";
        echo "</form>";
    }

    $subCatID=$_POST['subCatID'];
    $catID=$_POST['catID'];

    if ($subCatID!=NULL){
        $itemCatInfo=$simaLand->getItemCatInfo($catID);
        $SlugCat = $itemCatInfo->full_slug;
        $simaLand->addCat('0', $itemCatInfo->name, $itemCatInfo->icon, "products", $SlugCat);
        $catID=$simaLand->magazinFindCat($itemCatInfo->name);
        $itemCatInfo=$simaLand->getItemCatInfo($subCatID);
        $Slug=$itemCatInfo->full_slug;
        $SlugLen=strlen($SlugCat)+1;
        $Slug2=substr($Slug, $SlugLen);
        $simaLand->addCat($catID, $itemCatInfo->name, $itemCatInfo->icon, "subcategories", $Slug2);
        $is_leaf=$itemCatInfo->is_leaf;

        if ($is_leaf!="1"){
            $path=$itemCatInfo->path;
            $Slug="$SlugCat/$Slug2/";
            $SlugLen=strlen($Slug);
            $catID=$simaLand->magazinFindCat($itemCatInfo->name);
            $subCatsArray=$simaLand->getCategories(3, $path);
            $subCatsCount=count($subCatsArray);

            for($i=0;$i<$subCatsCount;$i++){
                $subCatID=$subCatsArray[$i]->id;
                $itemCatInfo=$simaLand->getItemCatInfo($subCatID);
                $Slug3=$itemCatInfo->full_slug;
                $Slug3=substr($Slug3, $SlugLen);
                $simaLand->addCat($catID, $itemCatInfo->name, $itemCatInfo->icon, "subcategories", $Slug3);
                $goodsArray=$simaLand->getGoods($itemCatInfo->id);
                $MagCatID=$simaLand->magazinFindCat($itemCatInfo->name);
                $simaLand->addGood($goodsArray, $MagCatID);
            }
        }

        if ($is_leaf=="1"){
            $goodsArray=$simaLand->getGoods($itemCatInfo->id);
            $catID=$simaLand->magazinFindCat($itemCatInfo->name);
            $simaLand->addGood($goodsArray, $catID); 
        }
    }
}

?>
