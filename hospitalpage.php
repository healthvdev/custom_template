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


function getBaseURLOfLocale($url, $locale_code){

  if(empty($locale_code) ){
    $locale_code = "en_US";
  }

  $parsed_url = parse_url($url);
  $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : ''; 
  $host     = isset($parsed_url['host']) ? $parsed_url['host'] : ''; 
  $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : ''; 
  $user     = isset($parsed_url['user']) ? $parsed_url['user'] : ''; 
  $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : ''; 
  $pass     = ($user || $pass) ? "$pass@" : ''; 
  $path     = isset($parsed_url['path']) ? $parsed_url['path'] : ''; 
  $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : ''; 
  $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : ''; 


  $path_pieces = explode("/", $path);

  if($path_pieces[1]=="hi" || $path_pieces[1]=="te"){
    unset($path_pieces[1]);
  }

  if($locale_code == "en_US" || empty($locale_code) ){
    $path =  implode("/", $path_pieces);
  } else {
//    if($path_pieces[1]=="hi" || $path_pieces[1]=="te"){
//      $path =  implode("/", $path_pieces);
//    } 
    $pieces = explode("_", $locale_code);
    array_splice( $path_pieces, 1, 0, $pieces[0] );
    $path =  implode("/", $path_pieces);
  }



  return "$scheme$user$pass$host$port$path$query$fragment"; 
}


function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
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

$function_getBaseURLOfLocale = new Twig_SimpleFunction('function_getBaseURLOfLocale', function ($url, $locale_code) {
    return getBaseURLOfLocale($url, $locale_code);
});


$twig->addFunction($function);
$twig->addFunction($function_HospitalURLParams);
$twig->addFunction($function_EchoTranslation);
$twig->addFunction($function_getBaseURLOfLocale);


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


?>



<?php

global $title;


if($locale_code == "hi_IN"){
  $translation_obj = $obj["translations"][0]["data"];
  $title = $translation_obj["name_hi_IN"] . ", " . __($obj["city"],"optimizer") . ", " .  __($obj["state"],"optimizer");
  $location = $obj["name"] . ", " . $obj["area"]. ", " . $obj["city"] . ", " .  $obj["state"];
}else if($locale_code == "te_IN"){
  $translation_obj = $obj["translations"][1]["data"];
  $title = $translation_obj["name_te_IN"] . ", " . __($obj["city"],"optimizer") . ", " .  __($obj["state"],"optimizer");
  $location = $obj["name"] . ", " . $obj["area"]. ", " . $obj["city"] . ", " .  $obj["state"];
}else{
  $title = $obj["name"] . ", " . $obj["city"] . ", " .  $obj["state"];
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


if($locale_code == "te_IN"){
  echo $twig->render('te_IN_hospital_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'hospital' => $obj,
          'hospital_translation' => $translation_obj,
          'specialties' => $specialties_keywords,
          'location' => $location,
          'title' => $title,
          'insurance_count' => $total_count ,
                'params' => array('hospital_id' => rawurlencode($hospital_id)),
                'url' => $_SERVER["REQUEST_URI"],
                'baseURL' => $baseURL,
                'baseHospitalEditURL' => $baseURL."/edit",
                'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')
                       )
      );
}else if($locale_code == "hi_IN"){
  echo $twig->render('hi_IN_hospital_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'hospital' => $obj,
          'hospital_translation' => $translation_obj,
          'specialties' => $specialties_keywords,
          'location' => $location,
          'title' => $title,
          'insurance_count' => $total_count ,
                'params' => array('hospital_id' => rawurlencode($hospital_id)),
                'url' => $_SERVER["REQUEST_URI"],
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
                'url' => $_SERVER["REQUEST_URI"],
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
