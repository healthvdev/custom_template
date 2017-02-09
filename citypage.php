<?php /* Template Name: CityPage */ ?>
 
<?php 
?>


<?php 
/*
Custom Code for reading API
*/
function getURLParams($new_network, $new_state, $new_city, $new_area, $new_specialty, $new_chain, $new_count, $new_page){
    return "?network=".rawurlencode($new_network)."&"."state=".rawurlencode($new_state)."&"."city=".rawurlencode($new_city)."&"."area=".rawurlencode($new_area)."&"."pageCount=".$new_count."&"."specialty=".$new_specialty."&"."chain=".$new_chain."&"."pageNumber=".$new_page;
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
		if($path_pieces[1]=="hi"){
			unset($path_pieces[1]);
		} 
		$path =  implode("/", $path_pieces);
	} else {
		if($path_pieces[1]=="hi"){
			$path =  implode("/", $path_pieces);
		} 
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

function getHospitalURLParams($hospital_id){
    return "?hospital_id=".rawurlencode($hospital_id);
}


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
$state = (isset($_GET['state']) && $_GET['state']!='')?$_GET['state']:'all';
$city = (isset($_GET['city']) && $_GET['city']!='')?$_GET['city']:'all';
$area = (isset($_GET['area']) && $_GET['area']!='')?$_GET['area']:'all';
$network = (isset($_GET['network']) && $_GET['network']!='')?$_GET['network']:'all';
$specialty = (isset($_GET['specialty']) && $_GET['specialty']!='')?$_GET['specialty']:'all';
$chain = (isset($_GET['chain']) && $_GET['chain']!='')?$_GET['chain']:'all';
$page = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
$pageNumber = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
$count = (isset($_GET['pageCount']) && $_GET['pageCount']!='')?$_GET['pageCount']:50;


$url = '/govhospitals/state/'.rawurlencode($state).'/city/'.rawurlencode($city).'/area/'.rawurlencode($area).'/network/'.rawurlencode($network).'?page='.$page.'&count='.$count.'&specialty='.$specialty.'&tokens='.$chain.'&wp_user_id='.$user_id.'&locale='.$locale_code;


$mapData = $dataApi->get($url,[],['User-Agent' => $_SERVER['HTTP_USER_AGENT']]);


$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function_URLParams = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city,$new_area, $new_specialty,$new_chain, $new_count, $new_page) {
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



$twig->addFunction($function_URLParams);
$twig->addFunction($function_HospitalURLParams);
$twig->addFunction($function_EchoTranslation);
$twig->addFunction($function_getBaseURLOfLocale);



$total_count = $mapData['header']['HOSPITAL_COUNT'];

$start_page = 0;

if($page>3){
	$start_page = $page - 3;
}else {
	$start_page = 0 ;
}

$allPages = array();
for ($x = 0, $i=0; $x <= $total_count && $i<7; $x+=50,$i++) {
    $allPages[$i] = array('index'=> $start_page+$i+1,
        'params'=>getURLParams($network, $state, $city, $area, $specialty, $chain, $count, $start_page+$i)
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
    $state = (isset($_GET['state']) && $_GET['state']!='')?$_GET['state']:'all';
    $city = (isset($_GET['city']) && $_GET['city']!='')?$_GET['city']:'all';
    $area = (isset($_GET['area']) && $_GET['area']!='')?$_GET['area']:'all';
    $network = (isset($_GET['network']) && $_GET['network']!='')?$_GET['network']:'all';
    $specialty = (isset($_GET['specialty']) && $_GET['specialty']!='')?$_GET['specialty']:'all';
    $chain = (isset($_GET['chain']) && $_GET['chain']!='')?$_GET['chain']:'all';
    $page = (isset($_GET['pageNumber']) && $_GET['pageNumber']!='')?$_GET['pageNumber']:0;
    $count = (isset($_GET['pageCount']) && $_GET['pageCount']!='')?$_GET['pageCount']:50;
    $link = get_permalink().getURLParams($network, $state, $city, $area, $specialty, $chain, $count, $page+$i);
    echo "<link rel='canonical' href='$link' />\n";



}


// "Sankara Nethralaya", "Medanta Medicity", "Columbia Asia","Manipal",	

$filters = json_decode('{
	"specialties" : ["Diabetology", "Cardiology", "Dermatology", "Gastroenterology", "Gynecology", "Oncology", "Ophthalmology", "Orthopedic", "ENT"],
	"chains" : ["Vasan",	"Fortis",	"Apollo",	"Narayana",	"Cloudnine",	"Mewar",	"Wockhardt",	"Cygnus",	"Vaatsalya",		"AMRI",	"Paras",	"Sterling"	]
}');


$chain_description_map_hi_IN = array(
	'Vasan' => '',
	'Fortis' => '',
	'Apollo' => '',
	'Narayana' => '',
	'Cloudnine' => '',
	'Wockhardt' => '',
	'Cygnus' => '',
	'Vaatsalya' => '',
	'AMRI' => '',
	'Paras' => '',
	'Sterling' => '',
	 );


$chain_description_map = array(
	'Vasan' => 'Vasan Healthcare Group is a health care groups in India.They specialise in Lasik, Cataract, Diabetic and Pediatric eye care treatments. They have over 180 Eye Care network hospitals. Founded by A. M. Arun, the group is based in Trichy and has more than 170 eye care hospitals and 30 dental care Hospitals across India, including two multi-speciality hospitals in Trichy. Vasan Eye Care Hospitals are day-care centres for treating eye ailments. The corporate office of the hospital is located in Chennai.',
	'Fortis' => 'Fortis Healthcare Limited is a chain of super speciality hospitals in India. It has its hospitals in Delhi, Amritsar, Kolkata, Navi Mumbai, Mohali, Ludhiana, Jaipur, Chennai, Kota, Bengaluru, Gurgaon, Noida, Faridabad, Mumbai, and Odisha.
Currently, the company also operates its healthcare delivery services in India, Dubai, Mauritius and Sri Lanka with 54 healthcare facilities (including projects under development), approximately 10,000 potential beds and 314 diagnostic centres.
In a global study of the 30 most technologically advanced hospitals in the world, its flagship, the Fortis Memorial Research Institute’ (FMRI), was ranked No.2, by ‘topmastersinhealthcare.com, and placed ahead of many other outstanding medical institutions in the world.',
	'Apollo' => 'Apollo Hospitals is a hospital chain based in Chennai, India. It was founded by Dr Prathap C. Reddy in 1983 and has hospitals in India, Bangladesh, Kuwait and Qatar. Several of the group\'s hospitals have been among the first in India to receive international healthcare accreditation by America-based Joint Commission International (JCI).
Their list of hospitals in India include Ahmedabad, Bengaluru, Chennai, Delhi, Hyderabad, Kolkata, Mumbai, Aragonda, Bacheli, Bhubaneshwar, Bilaspur, Goa, Indore, Kakinada, Karur, Lavasa, Madurai, Mysore, Nashik, Nellore, Pune, Ranipet, Tiruvannamalai, Trichy, Visakhapatnam.',
	'Narayana' => 'Narayana Health is a multi-specialty hospital chain in India which is one of the largest telemedicine networks in the world.
Narayana Health has 23 hospitals, 7 heart centres and 24 primary care facilities across India. Founded by Dr. Devi Shetty, Narayana Health has its flagship hospital in Bangalore at NH Health City. 
Apart from Bangalore, the group has its presence in Kolkata, Ahmedabad, Jaipur, Raipur, Jamshedpur, Guwahati, Mysore, Dharwad, Kolar, Shimoga and Davangere in addition to international subsidiary in Cayman Islands, North America. Narayana Institute of Cardiac Sciences, Bangalore, Narayana Multispeciality Hospital, Jaipur and Health City Cayman Islands, North America are JCI accredited.
Narayana Health offers super-specialty and tertiary care facilities covering wide range of specialization viz. cardiac surgery, cardiology, gastroenterology, vascular, endovascular services, nephrology, urology, neurology, neurosurgery,paediatrics, obstetrics & gynaecology, psychiatry, diabetes, endocrinology, cosmetic surgery and rehabilitation, solid organ transplants for kidney, liver, heart and bone marrow transplant as well as general medicine. The group also offers oncology services for most types of cancer including head, neck, breast, cervical, lungs, ortho, uro-genital and gastrointestinal.
',
	'Cloudnine' => 'Cloudnine is a chain of hospitals headquartered in Bangalore, India. It was founded by the neonatologist Dr. R. Kishore in 2007. Cloudnine Cloudnine has approximately 15 hospitals across 5 cities Bengaluru,Chennai, Gurgaon, Mumbai and Pune, and has more than 30,000 deliveries to its credit. In addition to maternal care, Cloudnine also provides Gynecology, Pediatrics, Intensive Care, Fertility and Neonatal Care services.',
	'Mewar' => 'Mewar Group of Hospitals operate a chain of twenty (20) specialty orthopaedic hospitals, providing solely surgical procedures such as trauma related surgeries and joint replacements, with a focus on Tier-1 to Tier-3 cities in the states of Rajasthan, Madhya Pradesh and Gujarat.
The Group is focussed on delivering affordable quality care in the markets where access to healthcare is limited.
',
	'Wockhardt' => 'Wockhardt Hospitals is a health service provider with its strong presence in the western parts of the country in Mumbai, Nagpur, Rajkot, Nasik and Surat. This group of 9 multi speciality hospital networks specialize in Cardiology, Orthopedics, Neurology, Gastroenterology, Urology, Aesthetics and Minimal Access Surgery.
The chain of hospitals is owned by the parent company Wockhardt Ltd., India\'s 5th largest Pharmaceutical and Healthcare company with a presence in 20 countries across the globe. Wockhardt hospitals, originally called First hospitals and Heart Institute, were one of the early movers among corporate health-care chains in India. The company was established in 1989 and it started its first operations with a medical center in Kolkata, 1989 and a heart hospital in Bangalore two years later. Today the company has its presence across India with 9 multi speciality hospital networks',
	'Cygnus' => 'Cygnus Hospitals has 11 superspeciality hospital chain with strength of more than 1000 beds, served by 1600 strong medical professionals, providing international standard healthcare to over 1 million lives in smaller communities across north India. 
Being a professionally managed group by a team of experienced doctors,  Cygnus aims to take healthcare to tier 2 and tier 3 cities at a price range comfortable to the people of those cities, it wants to ensure that healthcare in this country is available, accessible and affordable. ',
	'Vaatsalya' => 'Vaatsalya Healthcare, focuses on building a network of hospitals in Tier II and Tier III towns in India. Vaatsalya aims to bridge the gap by building primary and secondary care hospitals in semi-urban and rural areas.
Vaatsalya currently has ten hospitals in Karnataka and five in Andhra Pradesh, totaling 950 + beds. Vaatsalya is the largest hospital network of its kind in India with a mission to build a nationwide network of hospitals across Tier II and Tier III towns. ',
	'AMRI' => 'AMRI Hospitals is a private hospital chain which is headquartered at the city of Kolkata, West Bengal, India and it is owned by a unified Group with 1000 beds, over 500 doctors, and 10,000 surgeries successfully held every year.  The company\'s head office is in Kolkata, West Bengal, with 6 branches in the Indian State of West Bengal, 1 at Bhubaneshwar in the Indian State of Odisha and 6 branches in Bangladesh. It’s super specialty tertiary care units are located at Dhakuria, Salt Lake, Mukundapur and Bhubaneswar along with a state of the art day care facility - AMRI Medical Centre at Southern Avenue, Kolkata.',
	'Paras' => 'Paras Healthcare initiated with the inception of Paras Hospitals, Gurgaon in the year 2006, with the vision of providing specialized super specialty tertiary care services to the community at large. The aim of Paras Healthcare is to ensure that the dream of ‘Healthcare for All’ is a reality. We aim at establishing specialized centres at locations where access to healthcare is difficult and super specialty tertiary care is not available.',
	'Sterling' => 'Sterling Hospitals is one of the largest hospital chains in Gujarat, considered to be the leading one by the levels of independent certification, facilities and equipment, as well as size and capacities. It is owned and managed by Sterling AddLife India Ltd.
The specialties in which it provides medical care include: Cardiology, Neurology, GI Medicine, Hematology, Oncology, Reproductive Medicine, Critical and Emergency treatment, Trauma and Orthopedic, Neonatology and General Medicine. Surgery treatments include CVTS-, Neuro- and Onco-surgeries, Nephrology (with Kidney Transplant), GI surgeries and General Surgeries.
Sterling\'s multi-specialty hospitals have presence in six major cities of Gujarat.
These include Ahmedabad (310 beds) , Vadodara (196 beds) ,Rajkot (190 beds), Mundra SEZ (100 beds), Bhavnagar (180 beds) and Gandhidham.',
	 );

global $title;
if($locale_code == "hi_IN"){
	$title = ($area=='all'?'':__($area,"optimizer").', ')
			. ($city=='all'?'': __($city,"optimizer").', ')
			. ($state=='all'?' भारत': __($state,"optimizer"))
			. ' में '
	        . ($network=='all'?' ': __($network,"optimizer") .' नेटवर्क  के ')
			. $rounded_count 
	        . ($specialty=='all'?($chain=='all'?' ': ' '.__($chain,"optimizer")): ' '.__($specialty,"optimizer"). ' के विशेष ')
			.' अस्पताल ('
			. ($specialty=='all'?($chain=='all'?' ': ' '.$chain): ' '.$specialty)
			. ' Hospitals in '
	        . ($network=='all'?' ': $network.' Network, ')
	        . ($city=='all'?'': ' '.$city)
			. ($state=='all'?' India': ' '.$state)
	        . ' in  Hindi)'
			;


}else{
	$title = $rounded_count 
	        . ($specialty=='all'?($chain=='all'?' ': ' '.__($chain,"optimizer")): ' '.__($specialty,"optimizer"))
			. ' Hospitals in '
	        . ($network=='all'?' ': __($network,"optimizer").' Network, ')
	        .($area=='all'?'': __($area,"optimizer").', ')
	        .($city=='all'?'': __($city,"optimizer").', ')
	        .($state=='all'?'': __($state,"optimizer").',')
	        .' India';
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
	echo $twig->render('hi_IN_hospital_list.html', 
	    array(
	        'is_user_logged_in' => is_user_logged_in(),
	        'response' => $mapData,
	        'additional_filters' => $filters,
			'total_count' => $rounded_count,
	        'title' => $title,
	        'chain_description'=> $chain_description_map_hi_IN,
	              'params' => array(
	              				'state' => $state,
	                            'city' => $city,
	                            'area' => $area,
	                            'network' => $network,
	                            'specialty' => $specialty,
	                            'chain' => $chain,
	                            'count' => $count,
	                            'page' => $pageNumber,
	                            'community_questions' => $questions->posts,
	                            'nextpage' => $page+1),
	              'pages' => $allPages,
	              'url' => $_SERVER["REQUEST_URI"],
	              'baseURL' => strtok($_SERVER["REQUEST_URI"],'?'),
	              'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')."hospital"
	                     )
	    );

}else{
	echo $twig->render('hospital_list.html', 
	    array(
	        'is_user_logged_in' => is_user_logged_in(),
	        'response' => $mapData,
	        'additional_filters' => $filters,
			'total_count' => $rounded_count,
	        'title' => $title,
	        'chain_description'=> $chain_description_map,
	              'params' => array(
	              				'state' => $state,
	                            'city' => $city,
	                            'area' => $area,
	                            'network' => $network,
	                            'specialty' => $specialty,
	                            'chain' => $chain,
	                            'count' => $count,
	                            'page' => $pageNumber,
	                            'community_questions' => $questions->posts,
	                            'nextpage' => $page+1),
	              'pages' => $allPages,
	              'url' => $_SERVER["REQUEST_URI"],
	              'baseURL' => strtok($_SERVER["REQUEST_URI"],'?'),
	              'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')."hospital"
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
