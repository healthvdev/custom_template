<?php /* Template Name: Hospital Add Page */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/
function getURLParams($new_network, $new_state, $new_city, $new_count, $new_page){
    return "?network=".$new_network."&"."state=".$new_state."&"."city=".$new_city."&"."pageCount=".$new_count."&"."pageNumber=".$new_page;
}

function getHospitalURLParams($hospital_id){
    return "?hospital_id=".rawurlencode($hospital_id);
}

//$path    = "/var/www/html/wordpress/wordpress/wp-content/themes/optimizer";
$path    = "/opt/bitnami/apps/wordpress/htdocs/wp-content/themes/optimizer";
require_once 'template/Twig/lib/Twig/Autoloader.php';
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();


try{
$dataApi = new PestJSON('https://vings-dev.appspot.com/_ah/api/dataApi/v1/');

$user_id = get_current_user_id();
$hospital_id = $_GET['hospital_id'];


if($hospital_id>0){

    if(strlen($hospital_id)>10){
        $url = '/govhospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id;
    }else{
        $url = '/hospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id;
    }


    $mapData = $dataApi->get($url);
} else{
    $mapData = [];
}


$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city, $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_count, $new_page);
});
$function_HospitalURLParams = new Twig_SimpleFunction('function_getHospitalURLParams', function ($hospital_id) {
    return getHospitalURLParams($hospital_id);
});
$twig->addFunction($function);
$twig->addFunction($function_HospitalURLParams);



if(isset($mapData["data"])){
    $obj = $mapData["data"][0];
    $specialties = $obj["specialties"];
    $specialties_keywords = [];
    if($specialties!='' && $specialties!='NA' ){
        $specialties_keywords = array_map('trim',preg_split("/[\n,]+/", $specialties));
    }


    $title = $obj["name"] . ", " . $obj["city"] . ", " .  $obj["state"];
}else{
    $obj = [];
}

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

$baseURL = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/health-services/hospital"));


echo $twig->render('hospital_add.html', 
    array(
        'is_user_logged_in' => is_user_logged_in(),
        'hospital' => $obj,
        'create_url' => 'https://vings-prod.appspot.com/_ah/api/dataApi/v1/govhospitals/createvingshospital',
        'update_url' => 'https://vings-prod.appspot.com/_ah/api/dataApi/v1/govhospitals/updatevingshospital',
        'state_url' => 'https://vings-prod.appspot.com/_ah/api/dataApi/v1/govhospitals/getStates',
        'city_url' => 'https://vings-prod.appspot.com/_ah/api/dataApi/v1/govhospitals/getCities/',
        'title' => $title,
        'params' => array('hospital_id' => rawurlencode($hospital_id)),
        'baseHospitalURL' => $baseURL."/health-services/hospital"
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
