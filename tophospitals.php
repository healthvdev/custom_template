<?php /* Template Name: Top Hospitals */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/

function getURLParams($new_network, $new_state, $new_city, $new_count, $new_page){
    return "?network=".rawurlencode($new_network)."&"."state=".rawurlencode($new_state)."&"."city=".rawurlencode($new_city)."&"."pageCount=".$new_count."&"."pageNumber=".$new_page;
}

function getTopHospitalURLParams( $new_city, $speciality){
    return "?city=".$new_city."&"."speciality=".$speciality;
}


function getHospitalURLParams($hospital_id){
    return "?hospital_id=".rawurlencode($hospital_id);
}


//$path    = "/var/www/html/wordpress/wordpress/wp-content/themes/optimizer";
$path = "/opt/bitnami/apps/wordpress/htdocs/wp-content/themes/optimizer";
require_once 'template/Twig/lib/Twig/Autoloader.php';
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();

$list = '{
    "Pune" : {
        "all":["50837", "142100", "50242", "61655", "143689", "53092", "50760", "51205"]
    },
    "Delhi" : {
        "all":[ ' 
        //. '"aiims", '
        .'"95568", "54280", "114386", "50987", "55275", "95748", "116523", "57271", '
        //.'"max", "vardhaman",'
        .'"55914"]
    },
    "Bengaluru" : {
        "all":["50610", ' 
        //.'"stjohns", "RAMAIAH",  ' 
        .'"91192", "61428", "50598", "132862", "123278", "101050", "69167" ' 
        //.'"kempegowda"  ' 
        .']
    },
    "Kolkata" : {
        "all":["72001",  ' 
        //.'"institute",  ' 
        .'"57482",  ' 
        //.'"nilratan", "medicalcollege",  ' 
        .'"91188", "50797",  ' 
        //.'"medica", ' 
         .'"52931" ' 
        //.'"peerless" ' 
        .']
    },
    "Chennai" : {
        "all":["134297",  ' 
        //.'"madrasmedical", '  
        .'"50594",  ' 
        //.'"madrasinstitute",  ' 
        .'"51022", "81021", "89684",  ' 
        //.'"stanley",  ' 
        .'"50206",  ' 
        //.'"sims",  ' 
        .'"73691", "50274",  ' 
        //.'"rajiv gandhi",  ' 
        .'"50584"] 
    },
    "Mumbai": {
        "all":["92744", "76566", "82046",  ' 
        //.'"kingedward",  ' 
        .'"50430",  ' 
        //.'"bombay", "grantmedical",  ' 
        .'"91193", "51498", "50176", "133716",  ' 
        //.'"topiwala",  ' 
        .'"50272",  ' 
        //.'"lokmanya",  ' 
        .'"143781"]
    }
}';

try{
$dataApi = new PestJSON('https://vings-dev.appspot.com/_ah/api/dataApi/v1/');

$user_id = get_current_user_id();
$hospital_id = $_GET['hospital_id'];
$city = $_GET['city'];
$speciality = (isset($_GET['speciality']) && $_GET['speciality']!='')?$_GET['speciality']:'all';

$top_list = json_decode( $list, true);


$city_filter = json_decode('{"cities":["Delhi","Bengaluru","Mumbai","Kolkata","Chennai","Pune"]}', true);
$id_list = $top_list[$city][$speciality];


$url = '/hospitals/hospital/'.rawurlencode($hospital_id ).'?wp_user_id='.$user_id;


$mapData = $dataApi->post($url, 
    array(
        'ids' => $id_list
    )
);

$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getTopHospitalURLParams', function ($city, $speciality) {
    return getTopHospitalURLParams($city, $speciality);
});
$function_URLParams = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city, $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_count, $new_page);
});
$function_HospitalURLParams = new Twig_SimpleFunction('function_getHospitalURLParams', function ($hospital_id) {
    return getHospitalURLParams($hospital_id);
});


$twig->addFunction($function);
$twig->addFunction($function_URLParams);
$twig->addFunction($function_HospitalURLParams);


$insurace_items = $mapData['associatedInsuranceCompanies'];

$total_count = count($insurace_items);


if($total_count<10){
    $rounded_count = $total_count;
} else {
    $rounded_count = round($total_count, -1).'+';
}

$obj = $mapData["data"][0];

$title = "Best ".($speciality=='all'?'':$speciality)." hospitals in " . $city ;
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

echo $twig->render('top_hospital_list.html', 
    array(
        'is_user_logged_in' => is_user_logged_in(),
        'ranking' => $id_list,
        'response' => $mapData,
        'title' => $title,
        'filter' => $city_filter,
              'params' => array('city' => rawurlencode($city)),
              'baseURL' => "/health-services/",
              'currentURL' => strtok($_SERVER["REQUEST_URI"],'?'),
              'baseHospitalURL' => "/health-services/hospital" 
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
