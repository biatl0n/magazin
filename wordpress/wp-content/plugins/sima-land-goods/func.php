<?php
require_once __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

class SimaLandGoods {
    public $ck="ck_f2cca014ecde9f7cbb00f42d5281efccc9ef8ff0";
    public $cs="cs_eb938aef96209397fa079268422a9cf782e5a383";
    public $siteURL="http://magazin.local/wordpress";
    public $level;
    public $path;
    public $has_price=1;
    public $is_not_empty=1;
    public $urlCategory="https://www.sima-land.ru/api/v3/category/";
    public $urlGoods="https://www.sima-land.ru/api/v3/item/";
    public $woocommerce;
    //public $requestCategory = "https://www.sima-land.ru/api/v3/category/?level=2&path=16&is_not_empty=1";
    //public $requestGoods = "https://www.sima-land.ru/api/v3/item/?category_id=$value->id&has_price=1";

    public function getCategories($level, $path) {
        $requestString = "$this->urlCategory?level=$level&path=$path&is_not_empty=$this->is_not_empty";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $json=json_decode($json);
        $json=$json->items;
        return $json;
    }

    public function getGoodsPageCount ($category_id){
        $requestString = "$this->urlGoods?category_id=$category_id&has_balance=1&has_photo=0&is_disabled=0&has_price=1";
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
        for ($i=1; $i<=$PageCount;$i++){
        //for ($i=1; $i<=1; $i++)
            $requestString = "$this->urlGoods?category_id=$category_id&has_balance=1&has_photo=1&is_disabled=0&has_price=1&expand=photos,photo_sizes&page=$i";
            $curl = curl_init($requestString);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);
            $jsonGood=json_decode($json);
            $jsonGood2=$jsonGood->items;
            $jsonGood3=array_merge($jsonGood3, $jsonGood2);
        }
        return $jsonGood3;
    }

    public function magazinAuth($siteURL, $ck, $cs) {
        //if ($siteURL==NULL) $siteURL="http://magazin.local/wordpress"; 
        //if ($ck==NULL) $ck="ck_f2cca014ecde9f7cbb00f42d5281efccc9ef8ff0";
        //if ($cs==NULL) $cs="cs_eb938aef96209397fa079268422a9cf782e5a383";

            $woocommerce = new Client(
            $siteURL, 
            $ck, 
            $cs,
            [
                'wp_api' => true,
                'version' => 'wc/v1',
            ]
        );
        return $woocommerce;
    }

    public function magazinFindCat ($catName){
        $woocommerce=$this->magazinAuth(NULL, NULL, NULL);
        $json=$woocommerce->get('products/categories');
        $lastResponse = $woocommerce->http->getResponse();
        $arr=$lastResponse->getHeaders();
        $pageCount=$arr['X-WP-TotalPages'];
        
        $jsonMerge=array();
        for ($i=1; $i<=$pageCount; $i++) {
            $parameters = array("page" => "$i",);
            $json=$woocommerce->get('products/categories', $parameters);
            $jsonMerge=array_merge($jsonMerge, $json);
        }

        foreach ($jsonMerge as $key => $value) {
            if($catName==$value['name']){
               $result=$value['id']; 
            }
        }
        return $result;
    }

    public function magazinFindProduct ($productName, $catID){
        $woocommerce=$this->magazinAuth(NULL, NULL, NULL);
        $parameters = array("category" => "$catID");
        $json=$woocommerce->get('products', $parameters);
        $lastResponse = $woocommerce->http->getResponse();
        $arr=$lastResponse->getHeaders();
        $pageCount=$arr['X-WP-TotalPages'];
        
        $jsonMerge=array();
        for ($i=1; $i<=$pageCount; $i++) {
            $parameters = array("page" => "$i", "category" => "$catID");
            $json=$woocommerce->get('products', $parameters);
            $jsonMerge=array_merge($jsonMerge, $json);
        }
        foreach ($jsonMerge as $key => $value) {
            if($productName==$value['name']){
               $result=$value['id']; 
            }
        }
        return $result;
    }

    public function addCat($idParentCat, $catName, $catIcon, $display, $slug){
        $woocommerce=$this->magazinAuth(NULL, NULL, NULL);
        $data = [
            'slug'=>"$slug",
            'name'=> "$catName",
            'parent'=> "$idParentCat",
            'display'=> "$display",
            'image'=> [
                'src'=> "$catIcon"
            ]
        ];
        try {
            $woocommerce->post('products/categories', $data);
        }
        catch (HttpClientException $e) {
            $e->getMessage();
            $e->getRequest();
            $e->getResponse();
        }
    }

    public function addGood($goodsArray, $catID){
        $woocommerce=$this->magazinAuth(NULL, NULL, NULL); 
        foreach ($goodsArray as $key => $value){
            $data=[
                'name' => "$value->name",
                'slug' => "$value->slug",
                'type'=>'simple',
                'regular_price' => "$value->price",
                'status'=>'publish',
                'description'=>$value->description,
                'images' => [[]],
                'categories'=> [['id'=> $catID]],
                'sku'=>"$value->sid",
                //'weight'=>"$value->weight"
            ]; 
            $photoCount=count($value->photos);
            for ($i=0;$i<$photoCount;$i++){
                $photoAddr = $value->photos[$i]->url_part."400.jpg";
                array_push($data['images'],array("src"=>"$photoAddr", "position"=>$i, "name"=>"400"));
            }
            echo "<br>$value->name цена: $value->price Артикул: $value->sid Вес: $value->weight<br>";
            try {
                $woocommerce->post('products', $data);
            }
            catch (HttpClientException $e) {
                $e->getMessage();
                $e->getRequest();
                $e->getResponse();
            }
            if ($e){
                $message=$e->getResponse();
                $code=$message->getCode();
            }
            if ($code="400"){
                try {
                    $productID=$this->magazinFindProduct($value->name, $catID);
                    $woocommerce->put("products/$productID", $data);
                }
                catch (HttpClientException $e) {
                    $e->getMessage();
                    $e->getRequest();
                    $e->getResponse();
                }
            }
        }
    }

    public function getParentCats(){
        $requestString = "$this->urlCategory?level=1&is_not_empty=1";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $json=json_decode($json);
        $json=$json->items;
        return $json;
    }
    
    public function getItemCatInfo($catID){
        $requestString = "$this->urlCategory$catID/";
        $curl = curl_init($requestString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $json=json_decode($json);
        return $json;
    }

}


?>
