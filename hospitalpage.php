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
function getHospitalURLParams($hospital_id){
    return "?hospital_id=".rawurlencode($hospital_id);
}

$isadmin = current_user_can('administrator');

//$path    = "/var/www/html/wordpress/wordpress/wp-content/themes/optimizer";
$path    = "/opt/bitnami/apps/wordpress/htdocs/wp-content/themes/optimizer";
if (!class_exists('Twig_Autoloader')) {
    require_once 'template/Twig/lib/Twig/Autoloader.php';
}
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();


try{
$dataApi = new PestJSON('https://vings-prod.appspot.com/_ah/api/dataApi/v1/');

$locale_code = get_locale();
$user_id = get_current_user_id();
$hospital_id = $_GET['hospital_id'];


if(strlen($hospital_id)>10){
    $url = '/govhospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id.'&locale='.$locale_code;
}else{
    $url = '/hospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id.'&locale='.$locale_code;
}
$mapData = $dataApi->get($url);
$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city, $new_area, $new_specialty,$new_chain,          $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_area, $new_specialty, $new_chain, $new_count, $new_page);
});

$function_HospitalURLParams = new Twig_SimpleFunction('function_getHospitalURLParams', function ($hospital_id) {
    return getHospitalURLParams($hospital_id);
});

$function_EchoTranslation = new Twig_SimpleFunction('__e', function ($string) {
    echo __($string,"optimizer");
});


$twig->addFunction($function);
$twig->addFunction($function_HospitalURLParams);
$twig->addFunction($function_EchoTranslation);


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

$translation_obj = $obj["translations"][0]["data"];

?>



<?php

global $title;


if($locale_code == "hi_IN"){
  $title = $translation_obj["name"] . ", " . $translation_obj["area"]. ", " . $translation_obj["city"] . ", " .  $translation_obj["state"];
  $location = $obj["name"] . ", " . $obj["area"]. ", " . $obj["city"] . ", " .  $obj["state"];
}else{
  $title = $obj["name"] . ", " . $obj["area"]. ", " . $obj["city"] . ", " .  $obj["state"];
  $location = $obj["name"] . ", " . $obj["area"]. ", " . $obj["city"] . ", " .  $obj["state"];
}
}catch (Exception $e){
    echo $e->getMessage();
}

get_header(); 
?>
 
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

 <?php       
try{

$baseURL = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/hospital"));


if($locale_code == "hi_IN"){
  echo $twig->render('hi_IN_hospital_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'hospital' => $obj,
          'hospital_translation' => $translation_obj,
          'specialties' => $specialties_keywords,
          'location' => $location,
          'title' => $hi_IN_title,
          'insurance_count' => $total_count ,
                'params' => array('hospital_id' => rawurlencode($hospital_id)),
                'baseURL' => $baseURL,
                'baseHospitalEditURL' => $baseURL."/edit",
                'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')
                       )
      );
}else{
echo $twig->render('hospital_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'hospital' => $obj,
          'specialties' => $specialties_keywords,
          'location' => $location,
          'title' => $title,
          'insurance_count' => $total_count ,
                'params' => array('hospital_id' => rawurlencode($hospital_id)),
                'baseURL' => $baseURL,
                'baseHospitalEditURL' => $baseURL."/edit",
                'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')
                       )
      );
}

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
