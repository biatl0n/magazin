<?php
require __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;

class SimaLandGoods {
    public $level;
    public $path;
    public $has_price=1;
    public $is_not_empty=1;
    public $urlCategory="https://www.sima-land.ru/api/v3/category/";
    public $urlGoods="https://www.sima-land.ru/api/v3/item/";
    //public $requestCategory = "https://www.sima-land.ru/api/v3/category/?level=2&path=16&is_not_empty=1";
    //public $requestGoods = "https://www.sima-land.ru/api/v3/item/?category_id=$value->id&has_price=1";
    //

    public function getCategories($level, $path) {
        $requestString = "$this->urlCategory?level=$level&path=$path&is_not_epmty=$this->is_not_empty";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);

        $json=json_decode($json);
        $json=$json->items;
        foreach ($json as $key => $value) {
            print_r ("$key => $value->name");
            print_r ("   ID:$value->id, Path:$value->path\n");
        }   
    }

    public function getGoodsPageCount ($category_id){
        $requestString = "$this->urlGoods?category_id=$category_id&has_price=1";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $jsonGood=json_decode($json);
        $jsonGood2=$jsonGood->items;    
        $PageCount=$jsonGood->_meta->pageCount;
        return $PageCount;
    }

    public function getGoods ($category_id){
        $PageCount=$this->getGoodsPageCount($category_id);

        $jsonGood3=array();
        //for ($i=1; $i<=$PageCount;$i++)
        for ($i=1; $i<=2; $i++){
            $requestString = "$this->urlGoods?category_id=$category_id&has_price=1";
            $curl = curl_init($requestString);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
            $jsonGood=json_decode($json);
            $jsonGood2=$jsonGood->items;
            $jsonGood3=array_merge($jsonGood3, $jsonGood2);
        }
        foreach ($jsonGood3 as $key2 => $value2) {
            print_r ("  $key2 => $value2->name");
            print_r ("  Price: $value2->price\n");
            //print_r ("$key2 => $value2->description\n");
        }
    }

    public function magazinAuth($siteURL, $ck, $cs) {
        if ($siteURL==NULL) $siteURL="http://magazin.local/wordpress"; 
        if ($ck==NULL) $ck="ck_f2cca014ecde9f7cbb00f42d5281efccc9ef8ff0";
        if ($cs==NULL) $cs="cs_eb938aef96209397fa079268422a9cf782e5a383";

            $woocommerce = new Client(
            $siteURL, 
            $ck, 
            $cs,
            [
                'wp_api' => true,
                'version' => 'wc/v1',
            ]
        );
        $parameters = array("page" => "2", "per_page" => "50");
        $results = $woocommerce->get('products/categories', $parameters);
        echo "<pre>";
        print_r($results);
    }

}

/*
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
 */
?>
