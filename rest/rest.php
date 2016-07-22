<?php

require __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

$woocommerce = new Client(
    'http://magazin.local/wordpress', 
    'ck_f2cca014ecde9f7cbb00f42d5281efccc9ef8ff0', 
    'cs_eb938aef96209397fa079268422a9cf782e5a383',
    [
        'wp_api' => true,
        'version' => 'wc/v1',
    ]
);


/*
//$ch = curl_init('https://www.sima-land.ru/api/v3/cart/');
$ch = curl_init('https://www.sima-land.ru/api/v3/item/775644/?expand=photos');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "evgenybiatl0n@mail.ru:1989931323");
$json = curl_exec($ch);
$json = json_decode($json);
curl_close($ch);

echo "<pre>";
//print_r($json);

$imgArray = $json->photos[0]->url_part;
echo $imgArray;

$ch = curl_init($imgArray);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); 
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "evgenybiatl0n@mail.ru:1989931323");
$out = curl_exec($ch); 

$image_sv = 'name.jpg';  
$img_sc = file_put_contents($image_sv, $out);  

curl_close($ch);

 */

try {
    //echo "<pre>";
    //print_r($woocommerce->get('products/categories'));
    //echo "</pre>";
    
    //_____________________________________________________________________________add_catigory
    //$data = [
    //    'name' => 'Одеждаааааааааааааааааааааааааааааааааааа',
    //    'parent' => '12',
    //    'display' => 'subcategories',
    //    'image' => [
    //        'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
    //    ]
    //];
    //print_r($woocommerce->post('products/categories', $data));
    
    
    $parameters = array("page" => "3",);

    //$results = $woocommerce->get('products/categories', $parameters);
    $results = $woocommerce->get('products/15662');
    echo "<pre>";
    print_r($results);

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

echo "<pre>";
print_r($e);




?>
