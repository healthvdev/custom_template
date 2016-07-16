<?php /* Template Name: Hospital Detail Page */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/
function getURLParams($new_network, $new_state, $new_city, $new_count, $new_page){
    return "?network=".$new_network."&"."state=".$new_state."&"."city=".$new_city."&"."pageCount=".$new_count."&"."pageNumber=".$new_page;
}



$path    = "/var/www/html/wp-content/themes/optimizer";
require_once 'template/Twig/lib/Twig/Autoloader.php';
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();


try{
$dataApi = new PestJSON('https://1-dot-vings-dev.appspot.com/_ah/api/dataApi/v1/');

$user_id = get_current_user_id();
$hospital_id = $_GET['hospital_id'];

$url = '/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id;

$mapData = $dataApi->get($url);
$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city, $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_count, $new_page);
});
$twig->addFunction($function);


$insurace_items = $mapData['associatedInsuranceCompanies'];

$total_count = count($insurace_items);


if($total_count<10){
    $rounded_count = $total_count;
} else {
    $rounded_count = round($total_count, -1).'+';
}


$title = $mapData["name"].' in '.$mapData["address"].', '. $mapData["state"].', '. $mapData["city"]. 
        ' India';
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

echo $twig->render('hospital_detail.html', 
    array(
        'is_user_logged_in' => is_user_logged_in(),
        'hospital' => $mapData,
        'title' => $title,
        'insurance_count' => $total_count ,
              'params' => array('hospital_id' => rawurlencode($hospital_id)),
              'baseURL' => strtok($_SERVER["REQUEST_URI"],'?')
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
