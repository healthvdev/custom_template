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
	'Vasan' => 'वासन लेसिक, मोतियाबिंद, और नेत्र देखभाल उपचार में विशेषज्ञ है। उनके पास 180 से भी अधिक आई केयर अस्पतालों है। ए एम अरुण द्वारा स्थापित, समूह के मुख्यालय त्रिची में है। वासन आई केयर हॉस्पिटल आंख की बीमारियों के इलाज के केंद्र है। अस्पताल के कॉर्पोरेट कार्यालय चेन्नई में स्थित है।',
	'Fortis' => 'फोर्टिस हेल्थकेयर लिमिटेड के एक सुपर स्पेशियलिटी भारत में स्थित अस्पताल है। फोर्टिस दिल्ली, अमृतसर, कोलकाता, मुंबई, मोहाली, लुधियाना, जयपुर, चेन्नई, कोटा, बेंगलुरू, गुड़गांव, नोएडा, फरीदाबाद, मुंबई, और ओडिशा में शाखाएं हैं। कंपनी भारत, दुबई, मॉरीशस और श्रीलंका में अपने स्वास्थ्य सेवाएं प्रदान करता है। लगभग 10,000 बेड और 314 नैदानिक केन्द्रों। फोर्टिस 10,000 बेड और 314 नैदानिक केन्द्रों के साथ 54 स्वास्थ्य सुविधाओं चलाता है।',
	'Apollo' => 'अपोलो अस्पताल के एक अस्पताल चेन्नई, भारत में आधारित है। यह डॉ प्रताप सी रेड्डी द्वारा 1983 में स्थापित किया गया था और भारत, बांग्लादेश, कुवैत और कतर में अस्पताल हैं। अपोलो की अपनी सूची में अहमदाबाद, बेंगलुरू, चेन्नई, दिल्ली, हैदराबाद, कोलकाता, मुंबई, आरागोंडा, बचेली, भुवनेश्वर, बिलासपुर, गोवा, इंदौर, काकीनाडा, करूर, लवासा, मदुरै, मैसूर, नासिक, नेल्लोर, पुणे, रानीपेट, तिरुवन्नामलाई, त्रिची, विशाखापत्तनम में है।',
	'Narayana' => 'नारायण हृदयालय भारत में एक मल्टी-स्पेशियलिटी अस्पताल नेटवर्क है जो दुनिया में सबसे बड़ा टेलीमेडिसिन नेटवर्क में से एक है। भारत भर में नारायण हृदयालय 23 अस्पतालों, 7 कार्डियो केन्द्रों, और 24 प्राथमिक स्वास्थ्य देखभाल की सुविधा प्रदान करता है। डॉ देवी शेट्टी द्वारा स्थापित, यह बंगलौर में अपनी प्राथमिक अस्पताल है। समूह कोलकाता, अहमदाबाद, जयपुर, रायपुर, जमशेदपुर, गुवाहाटी, मैसूर, धारवाड़, कोलार, शिमोगा और दावणगेरे में अपनी उपस्थिति है।',
	'Cloudnine' => 'क्लाउडनाइन बंगलौर, भारत में मुख्यालय अस्पतालों में से एक नेटवर्क है। यह निओनटोलॉजिस्ट डॉ आर किशोर द्वारा 2007 में स्थापित किया गया था। क्लाउडनाइन भर में 5 शहरों बेंगलुरू, चेन्नई, गुड़गांव, मुंबई और पुणे के लगभग 15 अस्पताल हैं, और 30,000 से अधिक प्रसव किया है। मातृ देखभाल के अलावा, क्लाउडनाइन स्त्री रोग, बाल रोग, गहन देखभाल, प्रजनन और नवजात की देखभाल सेवाएं प्रदान करता है।',
	'Wockhardt' => 'वॉकहार्ट हॉस्पिटल्स एक स्वास्थ्य सेवा प्रदाता है और मुंबई, नागपुर, राजकोट, नासिक, और सूरत में मजबूत उपस्थिति है। 9 मल्टीस्पेशलिटी अस्पताल नेटवर्क के वॉकहार्ट समूह कार्डियोलोजी, हड्डी रोग, न्यूरोलॉजी, गैस्ट्रोएंटरोलॉजी, यूरोलॉजी, सौंदर्यशास्त्र और मिनिमल एक्सेस सर्जरी में विशेषज्ञ।',
	'Cygnus' => 'सिग्नस अस्पतालों 11 सुपरस्पेशलिटी अस्पताल नेटवर्क है। यह 1000 बेड, 1600 मजबूत चिकित्सा पेशेवरों की एक ताकत है। यह उत्तर भारत भर में छोटे समुदायों में 1 लाख से अधिक लोगों की जान को अंतरराष्ट्रीय मानक के स्वास्थ्य सेवा प्रदान करता है।',
	'Vaatsalya' => 'वात्सल्य हेल्थकेयर, भारत के शहरों में अस्पतालों के एक नेटवर्क के निर्माण पर केंद्रित है। वात्सल्य अर्ध-शहरी और ग्रामीण क्षेत्रों में प्राथमिक और माध्यमिक स्वास्थ्य सेवा अस्पतालों का निर्माण करना है। वात्सल्य आंध्र प्रदेश में कर्नाटक में 10 अस्पतालों और 5 है। यह इन अस्पतालों में बिस्तरों की 950+ सेवाएं प्रदान करता है। वात्सल्य भारत में अपनी तरह का सबसे बड़ा अस्पताल नेटवर्क है।',
	'AMRI' => 'एएमआरआई अस्पतालों एक प्राइवेट अस्पताल श्रृंखला है जो कोलकाता, पश्चिम बंगाल, भारत के शहर में मुख्यालय है। यह 1000 बेड, 500 डॉक्टरों से अधिक है, और 10,000 सर्जरी सफलतापूर्वक हर साल आयोजित आयोजित करता है।',
	'Paras' => 'पारस हेल्थकेयर वर्ष 2006 में गुड़गांव में स्थापना के साथ शुरू की। यह समाज के लिए विशेष सुपर स्पेशियलिटी स्वास्थ्य सेवाएं प्रदान करता है। पारस हेल्थकेयर का उद्देश्य यह सुनिश्चित करना है कि \'सभी के लिए स्वास्थ्य सेवा\' के सपने को एक वास्तविकता है।',
	'Sterling' => 'स्टर्लिंग हॉस्पिटल्स गुजरात में सबसे बड़ा अस्पताल श्रृंखलाओं में से एक है। यह स्वतंत्र प्रमाणीकरण, सुविधाओं और उपकरणों, साथ ही आकार और क्षमता के स्तर से अग्रणी माना जाता है। यह स्वामित्व है और स्टर्लिंग AddLife इंडिया लिमिटेड द्वारा प्रबंधित किया जाता है। विशेषता है जिसमें यह चिकित्सा देखभाल प्रदान करता है शामिल हैं: कार्डियोलॉजी, न्यूरोलॉजी, सैनिक चिकित्सा, रुधिर, कैंसर विज्ञान, प्रजनन चिकित्सा, महत्वपूर्ण और आपातकालीन उपचार, मानसिक आघात और आर्थोपेडिक, नयूरोलोजी और जनरल मेडिसिन।',
	 );


$chain_description_map = array(
	'Vasan' => 'Vasan Healthcare Group is a health care groups in India. They specialise in Lasik, Cataract, Diabetic and Pediatric eye care treatments. They have over 180 Eye Care network hospitals. Founded by A. M. Arun, the group is based in Trichy and has more than 170 eye care hospitals and 30 dental care Hospitals across India, including two multi-speciality hospitals in Trichy. Vasan Eye Care Hospitals are day-care centres for treating eye ailments. The corporate office of the hospital is located in Chennai.',
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


}else if($locale_code == "te_IN"){
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

if($locale_code == "te_IN"){
	echo $twig->render('te_IN_hospital_list.html', 
	    array(
	        'is_user_logged_in' => is_user_logged_in(),
	        'response' => $mapData,
	        'additional_filters' => $filters,
			'total_count' => $rounded_count,
	        'title' => $title,
	        'chain_description'=> $chain_description_map_te_IN,
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

}else if($locale_code == "hi_IN"){
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
