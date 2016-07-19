<?php
require_once __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

class SimaLandGoods {
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
            $requestString = "$this->urlGoods?category_id=$category_id&has_balance=1&has_photo=0&is_disabled=0&has_price=1";
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
        return $woocommerce;
    }

    public function magazinFindCat ($catName){
        $woocommerce=$this->magazinAuth(NULL, NULL, NULL);
        $json=$woocommerce->get('products/categories');
        foreach ($json as $key => $value) {
            if($catName==$value['name']){
               $result=$value['id']; 
            }
        }
        return $result;
    }

    public function addCat2(){

        $woocommerce=$simaLand->magazinAuth(NULL, NULL, NULL);
        $json=$simaLand->getCategories(2, 16); //Получаем список подкатегорий категории "спорт и отдых" магазина sima land
        $catCount = count($json);
    
        for ($i=0; $i<=$catCount; $i++){
            $parent=9;  //Подкатегория спорт и отдых в нашем магазине
            $display="subcategories"; //Вид отображения как подкатегория в нашем магазине
            $catName = $json[$i]->name."\n"; //название категории
            $catSlug = $catName;
            $catIcon = $json[$i]->icon."\n";
    
            $data = [
                'name'=> "$catName",
                'parent'=> "9",
                'display'=> "$display",
                'image'=> [
                    'src'=> "$catIcon"
                ]
            ];
            try {
                $woocommerce->post('products/categories', $data);
                $lastRequest = $woocommerce->http->getRequest();
                $lastRequest->getUrl(); // Requested URL (string).
                $lastRequest->getMethod(); // Request method (string).
                $lastRequest->getParameters(); // Request parameters (array).
                $lastRequest->getHeaders(); // Request headers (array).
                $lastRequest->getBody(); // Request body (JSON).
                $lastResponse = $woocommerce->http->getResponse();
                $lastResponse->getCode(); // Response code (int).
                $lastResponse->getHeaders(); // Response headers (array).
                $lastResponse->getBody(); // Response body (JSON).
            }
            catch (HttpClientException $e) {
                $e->getMessage();
                $e->getRequest();
                $e->getResponse();
            }
        }
    }

    public function addCat($idParentCat, $catName, $catIcon, $display){
        $woocommerce=$this->magazinAuth(NULL, NULL, NULL);
        $data = [
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
                'images' => [
                    ['src' => "$value->img",'position' => 0],
                    ['src' => "$value->img",'position' => 1]
                ],
                'categories'=> [['id'=> $catID]]
            ]; 
            try {
                $woocommerce->post('products', $data);
            }
            catch (HttpClientException $e) {
                $e->getMessage();
                $e->getRequest();
                $e->getResponse();
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