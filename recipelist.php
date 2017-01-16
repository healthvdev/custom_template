<?php /* Template Name: Recipe List Page */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/


//category
//cuisine
//ingredient
//ingredientcategory
//cookingtime


function getURLParams($new_cuisine, $new_category, $new_ingredient, $new_diet_type, $new_complexity, $new_timecomplexity, $new_count, $new_page){
     return "?cuisine=".rawurlencode($new_cuisine)."&"."category=".rawurlencode($new_category)."&"."ingredient=".rawurlencode($new_ingredient)."&"."diet=".rawurlencode($new_diet_type)."&"."complexity=".rawurlencode($new_complexity)."&"."time=".rawurlencode($new_timecomplexity)."&"."pageCount=".$new_count."&"."pageNumber=".$new_page;
}

function getRecipeURLParams($recipe_id){
    return "?recipe_id=".rawurlencode($recipe_id);
}


$path    = "/var/www/html/wordpress/wordpress/wp-content/themes/optimizer";
//$path    = "/opt/bitnami/apps/wordpress/htdocs/wp-content/themes/optimizer";

if (!class_exists('Twig_Autoloader')) {
	require_once 'template/Twig/lib/Twig/Autoloader.php';
}
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();


try{
$dataApi = new PestJSON('https://vings-prod.appspot.com/_ah/api/dataApi/v1/');

$locale_code = get_locale();
$user_id = get_current_user_id();
$category = (isset($_GET['category']) && $_GET['category']!='')?$_GET['category']:'all';
$ingredient = (isset($_GET['ingredient']) && $_GET['ingredient']!='')?$_GET['ingredient']:'all';
$cuisine = (isset($_GET['cuisine']) && $_GET['cuisine']!='')?$_GET['cuisine']:'all';
$page = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
$pageNumber = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
$count = (isset($_GET['pageCount']) && $_GET['pageCount']!='')?$_GET['pageCount']:50;


$url = '/recipes/'.'cuisine/'.rawurlencode($cuisine).'/category/'.rawurlencode($category).'/ingredient/'.rawurlencode($ingredient).'?page='.$page.'&count='.$count.'&wp_user_id='.$user_id.'&locale='.$locale_code;


$mapData = $dataApi->get($url,[],['User-Agent' => $_SERVER['HTTP_USER_AGENT']]);

$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function_URLParams = new Twig_SimpleFunction('function_getURLParams', function ($new_cuisine, $new_category, $new_ingredient, $new_diet_type, $new_complexity, $new_timecomplexity, $new_count, $new_page) {
    return getURLParams($new_cuisine, $new_category, $new_ingredient, $new_diet_type, $new_complexity, $new_timecomplexity, $new_count, $new_page);
});
$function_RecipeURLParams = new Twig_SimpleFunction('function_getRecipeURLParams', function ($recipe_id) {
    return getRecipeURLParams($recipe_id);
});

$function_EchoTranslation = new Twig_SimpleFunction('__e', function ($string) {
    echo __($string,"optimizer");
});


$twig->addFunction($function_URLParams);
$twig->addFunction($function_RecipeURLParams);
$twig->addFunction($function_EchoTranslation);



$total_count = $mapData['header']['RECIPE_COUNT'];

$start_page = 0;

if($page>3){
	$start_page = $page - 3;
}else {
	$start_page = 0 ;
}

$allPages = array();
for ($x = 0, $i=0; $x <= $total_count && $i<7; $x+=50,$i++) {
    $allPages[$i] = array('index'=> $start_page+$i+1,
        'params'=>getURLParams($cuisine, $category, $ingredient, $area, $specialty, $chain, $count, $start_page+$i)
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

remove_action( 'wp_head', 'rel_canonical' );
add_action('wp_head',  'um_rel_canonical_1', 10 );

function um_rel_canonical_1() {
    $category = (isset($_GET['category']) && $_GET['category']!='')?$_GET['category']:'all';
    $ingredient = (isset($_GET['ingredient']) && $_GET['ingredient']!='')?$_GET['ingredient']:'all';
    $cuisine = (isset($_GET['cuisine']) && $_GET['cuisine']!='')?$_GET['cuisine']:'all';
    $page = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
    $count = (isset($_GET['pageCount']) && $_GET['pageCount']!='')?$_GET['pageCount']:50;
    $link = get_permalink().getURLParams($cuisine, $category, $ingredient,'','','', $count, $page+$i);
    echo "<link rel='canonical' href='$link' />\n";



}


global $title;

$locale_code = "";

// South indian breakfast recipes with oats for diabetics

if($locale_code == "hi_IN"){
	$title = "";


}else{
	$title = $rounded_count . " "
	        . ($cuisine=='all'?' ': __($cuisine,"optimizer").' ')
	        . ($category=='all'?'': __($category,"optimizer").' ')
			. ' Recipes '
	        . ' for diabetics '
	        . ($ingredient=='all'?'': ' (recipes with '. __($ingredient,"optimizer")). ")";
}
?>



<?php


get_header(); 
?>
 
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

	<?php 
		$questions = ap_get_questions(array( 'showposts' => 5, 'sortby' => "newest", 'paged' => 1  ));

		if ( ap_have_questions() ) {
			/* Start the Loop */
			$i = 0;
			while ( ap_questions() ) : ap_the_question();

				$questions->posts{$i}->ans_count = $ans_count = ap_question_get_the_answer_count();
				$questions->posts{$i}->net_vote = $net_vote = ap_question_get_the_net_vote();
				$questions->posts{$i}->permalink = $permalink = ap_question_get_the_permalink();
				$questions->posts{$i}->img_small_banner = $img_small_banner = ap_get_image(ap_question_get_the_ID(), 'banner_img');
				$i++;
			endwhile;


		}else{
			$questions->posts = array();
		}
	?>	
 <?php       

if($locale_code == "hi_IN"){
	echo $twig->render('hi_IN_Recipe_list.html', 
	    array(
	        'is_user_logged_in' => is_user_logged_in(),
	        'response' => $mapData,
	        'title' => $title,
	        'chain_description'=> $chain_description_map_hi_IN,
	              'params' => array(
	              				'category' => $category,
	                            'ingredient' => $ingredient,
	                            'area' => $area,
	                            'cuisine' => $cuisine,
	                            'specialty' => $specialty,
	                            'chain' => $chain,
	                            'count' => $count,
	                            'page' => $pageNumber,
	                            'community_questions' => $questions->posts,
	                            'nextpage' => $page+1),
	              'pages' => $allPages,
	              'baseURL' => strtok($_SERVER["REQUEST_URI"],'?'),
	              'baseRecipeURL' => strtok($_SERVER["REQUEST_URI"],'?')."Recipe"
	                     )
	    );

}else{
	echo $twig->render('recipe_list.html', 
	    array(
	        'is_user_logged_in' => is_user_logged_in(),
	        'response' => $mapData,
	        'title' => $title,
			'params' => array(
						'category' => $category,
						'ingredient' => $ingredient,
						'cuisine' => $cuisine,
						'chain' => $chain,
						'count' => $count,
						'page' => $pageNumber,
						'community_questions' => $questions->posts,
						'nextpage' => $page+1),
			'pages' => $allPages,
			'baseURL' => strtok($_SERVER["REQUEST_URI"],'?'),
			'baseRecipeURL' => strtok($_SERVER["REQUEST_URI"],'?')."recipe"
			     )
	    );
}


}catch (Exception $e){
    echo $e->getMessage();
}

 ?>



    </main><!-- .site-main -->
 
    <?php get_sidebar( 'content-bottom' ); ?>
 
</div><!-- .content-area -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>
