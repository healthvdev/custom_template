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

  if($locale_code == "en_US" || empty($locale_code) ){
    if($path_pieces[1]=="hi" || $path_pieces[1]=="te"){
      unset($path_pieces[1]);
    } 
    $path =  implode("/", $path_pieces);
  } else {
    if($path_pieces[1]=="hi" || $path_pieces[1]=="te"){
      $path =  implode("/", $path_pieces);
    } 
    $pieces = explode("_", $locale_code);
    array_splice( $path_pieces, 1, 0, $pieces[0] );
    $path =  implode("/", $path_pieces);
  }



  return "$scheme$user$pass$host$port$path$query$fragment"; 
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

$function_EchoTranslation_withParameter = new Twig_SimpleFunction('__ep', function ($string, $params) {
    $say = sprintf(__($string,"optimizer"), $params);
    echo $say;
});


$function_getBaseURLOfLocale = new Twig_SimpleFunction('function_getBaseURLOfLocale', function ($url, $locale_code) {
    return getBaseURLOfLocale($url, $locale_code);
});


$twig->addFunction($function);
$twig->addFunction($function_RecipeURLParams);
$twig->addFunction($function_EchoTranslation);
$twig->addFunction($function_EchoTranslation_withParameter);
$twig->addFunction($function_getBaseURLOfLocale);



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


if($locale_code == "hi_IN"){
    $title =  __("recipe_".$obj["id"],"optimizer") . " - मधुमेह (बहुमूत्र) के लिए पौष्टिक आहार" ;

  $description = ""
  .__("recipe_".$obj["id"],"optimizer")
  ." एक स्वस्थ मधुमेह उपयोगी व्यंजन है। "
  ." "
  .__('recipe_'.$obj["id"],"optimizer"). " "
  .__($obj["category"]["title"],"optimizer")
  ." व्यंजन, मधुमेह के प्रबंधन में मदद करता है। " 
  .__('recipe_'.$obj["id"],"optimizer"). " "
  .$obj["preparationMinuteMax"]
  ." मिनटों तैयारी और "
  .$obj["cookingMinuteMax"]
  ." मिनट पकाने के समय में तैयार किया जा सकता है।"
  ." ";

}else{
  $title = "Healthy recipe - ".$obj["title"] . " for Diabetic diet";

  $description = ""
  .__('recipe_'.$obj["id"],"optimizer")
  ." is a healthy diabetic friendly recipe. "
  ." "
  .__('recipe_'.$obj["id"],"optimizer")
  ." is a "
  .__($obj["category"]["title"],"optimizer")
  ." recipe and helps manage diabetes." 
  .__('recipe_'.$obj["id"],"optimizer")
  ." can be prepared with "
  .$obj["preparationMinuteMax"]
  ." mins of preparation time and "
  .$obj["cookingMinuteMax"]
  ." mins of cooking time."
  ."";
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



echo $twig->render('recipe_detail.html', 
      array(
          'is_admin' => $isadmin,
          'is_user_logged_in' => is_user_logged_in(),
          'recipe' => $obj,
          'title' => $title,
          'description' => $description,
                'params' => array('recipe_id' => rawurlencode($recipe_id)),
                'baseURL' => $baseURL,
                'baseRecipeEditURL' => $baseURL."/edit",
                'baseRecipeURL' => strtok($_SERVER["REQUEST_URI"],'?')
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
