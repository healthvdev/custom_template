<?php /* Template Name: CityPage */ ?>
 
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
$state = (isset($_GET['state']) && $_GET['state']!='')?$_GET['state']:'all';
$city = (isset($_GET['city']) && $_GET['city']!='')?$_GET['city']:'all';
$network = (isset($_GET['network']) && $_GET['network']!='')?$_GET['network']:'all';
$page = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
$count = (isset($_GET['pageCount']) && $_GET['pageCount']!='')?$_GET['pageCount']:50;


$url = '/hospitals/state/'.rawurlencode($state).'/city/'.rawurlencode($city).'/network/'.rawurlencode($network).'?page='.$page.'&count='.$count.'&wp_user_id='.$user_id;

$mapData = $dataApi->get($url);

$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city, $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_count, $new_page);
});
$twig->addFunction($function);


$total_count = $mapData['header']['HOSPITAL_COUNT'];

$allPages = array();
for ($x = 0, $i=0; $x <= $total_count && $i<7; $x+=50,$i++) {
    $allPages[$i] = array('index'=> $page+$i+1,
        'params'=>getURLParams(rawurlencode($network), rawurlencode($state), rawurlencode($city), $count, $page+$i+1)
        );
}

if($total_count<10){
    $rounded_count = $total_count;
} elseif($total_count<100){
    $rounded_count = round($total_count, -1).'+';
} elseif ($total_count<1000) {
    $rounded_count = round($total_count, -2).'+';
} else {
    $rounded_count = round($total_count, -3).'+';
}

$title = $rounded_count. ' Hospitals in '
        . ($network=='all'?' ': $network.' Network, ')
        .($city=='all'?'': $city.', ')
        .($state=='all'?'': $state.',')
        .' India';

?>



<?php

global $title;
get_header(); 
?>
 
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">


 <?php       


echo $twig->render('hospital_list.html', 
    array(
        'is_user_logged_in' => is_user_logged_in(),
        'response' => $mapData,
        'title' => $title,
              'params' => array('state' => rawurlencode($state),
                            'city' => rawurlencode($city),
                            'network' => rawurlencode($network),
                            'count' => $count,
                            'page' => $page,
                            'nextpage' => $page+1),
              'pages' => $allPages,
              'baseURL' => strtok($_SERVER["REQUEST_URI"],'?')
                     )
    );


}catch (Exception $e){
    echo $e->getMessage();
}

 ?>
    </main><!-- .site-main -->
 
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>
