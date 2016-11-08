<?php /* Template Name: Hospital Detail Page */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/
function getURLParams($new_network, $new_state, $new_city,$new_area, $new_specialty,$new_chain, $new_count, $new_page){
     return "?network=".rawurlencode($new_network)."&"."state=".rawurlencode($new_state)."&"."city=".rawurlencode($new_city)."&"."area=".rawurlencode($new_area)."&"."pageCount=".$new_count."&"."specialty=".$new_specialty."&"."chain=".$new_chain."&"."pageNumber=".$new_page;
}
}



$path    = "/opt/bitnami/apps/wordpress/htdocs/wp-content/themes/optimizer";
require_once 'template/Twig/lib/Twig/Autoloader.php';
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();


try{
$dataApi = new PestJSON('https://vings-prod.appspot.com/_ah/api/dataApi/v1/');

$user_id = get_current_user_id();
$hospital_id = $_GET['hospital_id'];


if(strlen($hospital_id)>10){
    $url = '/govhospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id;
}else{
    $url = '/hospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id;
}
$mapData = $dataApi->get($url);
$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city, $new_area, $new_specialty,$new_chain,          $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_area, $new_specialty, $new_chain, $new_count, $new_page);
});
$twig->addFunction($function);


$insurace_items = $mapData['associatedInsuranceCompanies'];

$total_count = count($insurace_items);


if($total_count<10){
    $rounded_count = $total_count;
} else {
    $rounded_count = round($total_count, -1).'+';
}

$obj = $mapData["data"][0];

$specialties = $obj["specialties"];
$specialties_keywords = [];
if($specialties!='' && $specialties!='NA' ){
    $specialties_keywords = array_map('trim',preg_split("/[\n,]+/", $specialties));
}


$title = $obj["name"] . ", " . $obj["area"]. ", " . $obj["city"] . ", " .  $obj["state"];
}catch (Exception $e){
    echo $e->getMessage();
}
?>



<?php

global $title;
get_header(); 
?>
 
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

 <?php       
try{

$baseURL = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/hospital"));


echo $twig->render('hospital_detail.html', 
    array(
        'is_user_logged_in' => is_user_logged_in(),
        'hospital' => $obj,
        'specialties' => $specialties_keywords,
        'title' => $title,
        'insurance_count' => $total_count ,
              'params' => array('hospital_id' => rawurlencode($hospital_id)),
              'baseURL' => $baseURL,
              'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')
                     )
    );

echo "</div>";

}catch (Exception $e){
    echo $e->getMessage();
}

 ?>
    </main><!-- .site-main -->
 
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>
