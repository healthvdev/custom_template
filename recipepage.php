<?php /* Template Name: Recipe Detail Page */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/
function getURLParams($new_cuisine, $new_category, $new_ingredient, $new_diet_type, $new_complexity, $new_timecomplexity, $new_count, $new_page){
     return "?cuisine=".rawurlencode($new_cuisine)."&"."category=".rawurlencode($new_category)."&"."ingredient=".rawurlencode($new_ingredient)."&"."diet=".rawurlencode($new_diet_type)."&"."complexity=".rawurlencode($new_complexity)."&"."time=".rawurlencode($new_timecomplexity)."&"."pageCount=".$new_count."&"."pageNumber=".$new_page;
}
function getRecipeURLParams($recipe_id){
    return "?recipe_id=".rawurlencode($recipe_id);
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
$recipe_id = $_GET['recipe_id'];


    $url = '/recipes/recipe/'.rawurlencode($recipe_id ).'?wp_user_id='.$user_id.'&locale='.$locale_code;

$mapData = $dataApi->get($url);


$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function = new Twig_SimpleFunction('function_getURLParams', function ($new_cuisine, $new_category, $new_ingredient, $new_diet_type, $new_complexity, $new_timecomplexity, $new_count, $new_page) {
    return getURLParams($new_cuisine, $new_category, $new_ingredient, $new_diet_type, $new_complexity, $new_timecomplexity, $new_count, $new_page);
});

$function_RecipeURLParams = new Twig_SimpleFunction('function_getRecipeURLParams', function ($recipe_id) {
    return getRecipeURLParams($recipe_id);
});

$function_EchoTranslation = new Twig_SimpleFunction('__e', function ($string) {
    echo __($string,"optimizer");
});


$twig->addFunction($function);
$twig->addFunction($function_RecipeURLParams);
$twig->addFunction($function_EchoTranslation);



$total_count = count($insurace_items);


if($total_count<10){
    $rounded_count = $total_count;
} else {
    $rounded_count = round($total_count, -1).'+';
}

$obj = $mapData["data"][0];




?>



<?php

global $title;

$locale_code = "";

if($locale_code == "hi_IN"){
//  $title = $translation_obj["name_hi_IN"] . ", " . __($obj["ingredient"],"optimizer") . ", " .  __($obj["category"],"optimizer");
}else{
  $title = "Healthy recipe - ".$obj["title"] ;
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

$baseURL = substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/recipe"));


if($locale_code == "hi_IN"){
  echo $twig->render('hi_IN_recipe_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'recipe' => $obj,
          'title' => $title,
                'params' => array('recipe_id' => rawurlencode($recipe_id)),
                'baseURL' => $baseURL,
                'baseRecipeEditURL' => $baseURL."/edit",
                'baseRecipeURL' => strtok($_SERVER["REQUEST_URI"],'?')
                       )
      );
}else{
echo $twig->render('recipe_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'recipe' => $obj,
          'title' => $title,
                'params' => array('recipe_id' => rawurlencode($recipe_id)),
                'baseURL' => $baseURL,
                'baseRecipeEditURL' => $baseURL."/edit",
                'baseRecipeURL' => strtok($_SERVER["REQUEST_URI"],'?')
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
