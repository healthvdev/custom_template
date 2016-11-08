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

function getHospitalURLParams($hospital_id){
    return "?hospital_id=".rawurlencode($hospital_id);
}


$path    = "/opt/bitnami/apps/wordpress/htdocs/wp-content/themes/optimizer";
require_once 'template/Twig/lib/Twig/Autoloader.php';
require_once 'pest/PestJSON.php';

Twig_Autoloader::register();


try{
$dataApi = new PestJSON('https://vings-prod.appspot.com/_ah/api/dataApi/v1/');

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


$url = '/govhospitals/state/'.rawurlencode($state).'/city/'.rawurlencode($city).'/area/'.rawurlencode($area).'/network/'.rawurlencode($network).'?page='.$page.'&count='.$count.'&specialty='.$specialty.'&tokens='.$chain.'&wp_user_id='.$user_id;


echo $url;

//$mapData = $dataApi->get($url);


$mapData = json_decode('{
"data": [
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Dhule",
"state_id": "27",
"pinCode": "424001",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "142460",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "498",
"id": "6182252195895283456",
"distance": "72",
"area": "Opp Ramwadi, Malegaon Road, Dhule",
"name": "Aastha Intensive Care Centre",
"source_hospital_name": "Aastha Intensive Care Centre Pvt Ltd ",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Opp. Ramwadi, Malegaon Road",
"emergency_num": "NA",
"coordinates": "20.8674848, 74.7744206",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Opp Ramwadi, Malegaon Road",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Opp Ramwadi, Malegaon Road, Dhule",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Thane",
"state_id": "27",
"pinCode": "421301",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "163716",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "517",
"id": "6182252702702497792",
"distance": "0",
"area": "Bldg No. E-2, 2Nd & 3Rd Floor, Radha Nagarshopping Complex, Radha Nagar, Opposite Radha Nagar Police Chowki, Khadakpada, Kalyan (West), Thane",
"name": "Aayush Hospital",
"source_hospital_name": "Aayush Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Building No E 2, 2nd & 3rd Floor, Radha Nagar Shopping Centre, Khadakpada-Kalyan West, Thane -",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Bldg No. E-2, 2Nd & 3Rd Floor, Radha Nagarshopping Complex, Radha Nagar, Opposite Radha Nagar Police Chowki, Khadakpada, Kalyan (West)",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Bldg No. E-2, 2Nd & 3Rd Floor, Radha Nagarshopping Complex, Radha Nagar, Opposite Radha Nagar Police Chowki, Khadakpada, Kalyan (West), Thane",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Pune",
"state_id": "27",
"pinCode": "411028",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "108718",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "521",
"id": "6182252487953730304",
"distance": "0",
"area": "Parmar Complex, Ground Floor, Behind Lokseva Hanuman Mandir, Gadital, Hadapsar",
"name": "Abane Hospital",
"source_hospital_name": "Abane Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Parmar Complex, Ground Floor, Behind Lokseva Hanuman Mandir, Gadital , Hadpsar",
"emergency_num": "NA",
"coordinates": "18.5089197, 73.9260261",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Parmar Complex, Ground Floor, Behind Lokseva Hanuman Mandir, Gadital, Hadapsar",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Parmar Complex, Ground Floor, Behind Lokseva Hanuman Mandir, Gadital, Hadapsar, Pune",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "MaxBupa Health Insurance Co.Ltd",
"shortName": "Max Bupa"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Pune",
"state_id": "27",
"pinCode": "411004",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "2025423253",
"source_id": "50751",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "521",
"id": "6182252466478845184",
"distance": "54",
"area": "32 / 2 A, Erandwane, Gulawani Maharaj Ro,Near Mehendale Garage & Abhishek Hotel,",
"name": "Ace Hospital",
"source_hospital_name": "Ace Hospital ",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "S No. 32/2a  Erandwane  Behind Mehendale Garage   Pune-411004",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "32 / 2 A, Erandwane, Gulawani Maharaj Ro,Near Mehendale Garage & Abhishek Hotel",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "32 / 2 A, Erandwane, Gulawani Maharaj Ro,Near Mehendale Garage & Abhishek Hotel, Pune",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "MaxBupa Health Insurance Co.Ltd",
"shortName": "Max Bupa"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Pune",
"state_id": "27",
"pinCode": "411014",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "55568",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "521",
"id": "6182252475068808192",
"distance": "0",
"area": "45/1+2+5,Sangarsh Chowk Kharodi Road, Chandanagar Pune",
"name": "Agarwal Maternity And General Hospital",
"source_hospital_name": "Agarwal Maternity And General Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Sangharsh Chowk, Kharadi Road, Chandan Nagar, Pune - 411014",
"emergency_num": "NA",
"coordinates": "18.5204303, 73.8567437",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "45/1+2+5,Sangarsh Chowk Kharodi Road, Chandanagar",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "45/1+2+5,Sangarsh Chowk Kharodi Road, Chandanagar, Pune",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Mumbai",
"state_id": "27",
"pinCode": "400064",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "28884488",
"source_id": "68182",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "519",
"id": "6182252371989201920",
"distance": "0",
"area": "1St Floor, Maharaja Appartment, Opposite Telephone Exchange, S.V. Road, Malad (West )",
"name": "Agrawal Eye Hospital",
"source_hospital_name": "Agrawal Eye Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Maharaja Apt, 1st Floor, S.V Road, Opp. Malad Telephone Exc",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "1St Floor, Maharaja Appartment, Opposite Telephone Exchange, S.V. Road, Malad (West )",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "1St Floor, Maharaja Appartment, Opposite Telephone Exchange, S.V. Road, Malad (West ), Mumbai",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Thane",
"state_id": "27",
"pinCode": "421201",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "141627",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "517",
"id": "6182252694112542720",
"distance": "0",
"area": "Rameshwari Appartment Dr Rajendra Prasad Road, Tilak Nagar Dombivli - East Dombivli",
"name": "Amrut Hospital And Endoscopic Clinic",
"source_hospital_name": "Amrut Hospital And Endoscopic Clinic",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Dr Rajendra Prasad Road, Tilak Nagar, Dombivili East",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Rameshwari Appartment Dr Rajendra Prasad Road, Tilak Nagar Dombivli - East Dombivli",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Rameshwari Appartment Dr Rajendra Prasad Road, Tilak Nagar Dombivli - East Dombivli, Thane",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Mumbai",
"state_id": "27",
"pinCode": "400086",
"specialties": "Obstetrics and Gynaecology, Surgery, such as Plastic surgery, Urology related surgeries, Paediatrics, Laparoscopy Surgery, Oncosurgery, \nGeneral Medicine, \nGynaecological operations, such as family planning (tubectomy), Hysterectomy (removal of Uterus), \nUrological problems in women and children, \nGeneral surgeries for Appendix, Hernia, Hydrocele, Piles and Fistula, \nMinimally invasive endoscopic surgery (key hole surgery), \nMale and Female infertility treatments, \nTreatment for kidney stones, prostate and all urinary problems, \nFamily planning center and pre-marital counseling, \nPre- Marital Counselling.",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "64014",
"number_doctor": "NA",
"nodal_person_tele": "9821159402",
"category": "Private",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "drgujars@yahoo.com",
"care_type": "Hospital",
"state": "Maharashtra",
"city_id": "519",
"id": "6182252393464213248",
"distance": "0",
"area": "C Wing, 4th Floor, Bhaveshwar Plaza, L.B.S.Marg, Ghatkopar (West)",
"name": "Amruta Surgical And Maternity Home",
"source_hospital_name": "Amruta Surgical And Maternity Home",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "2001",
"miscellaneous_facilities": "NA",
"source_hospital_address": "C Wing, 4th Floor, Bhaveshwar Palza, L.B.S.Road, Opp.Shreyas Cinema, Ghatkopar(W)",
"emergency_num": "NA",
"coordinates": "19.0898792, 72.908696",
"ambulance_phone_no": "NA",
"facilities": "10 bed facility, \nWell equipped operation theater with multiparty monitors, \nGovernmentrecognized MTP center, \nCashless Mediclaim insurance, \nUltrasonography (USG), \nGovt registered family planning centre, \nLabor room with foetal monitor (NST), \nPainless delivery managed by round the clock anesthetist, \nWell equipped NICU (New born baby care), \nImmunization and well baby clinic, \nChildhood asthma clinic and management, \nNebulization / ECG / Pathology, \nMedical care for Diabetes, Blood Pressure and Heart Problems, \nPediatric - N I C.U.",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "http://www.amrutasurgicalandmaternityhome.com/",
"tariff_range": "NA",
"nodal_person_info": "Dr.Ajay Gujar",
"number_private_wards": "NA",
"address_first_line": "C Wing, 4th Floor, Bhaveshwar Plaza, L.B.S.Marg, Ghatkopar (West)",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "Allopathic",
"ayush": "NA",
"mobile_number": "NA",
"address": "C Wing, 4th Floor, Bhaveshwar Plaza, L.B.S.Marg, Ghatkopar (West), Mumbai",
"nodal_person_email_id": "drgujars@yahoo.com",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Nagpur",
"state_id": "27",
"pinCode": "440026",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "141629",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "505",
"id": "6182252423529069312",
"distance": "0",
"area": "No. 500, Powergrid Square,Nari Ring Road,Opposite Jagat Hall,",
"name": "Anantwar Eye Hospital",
"source_hospital_name": "Anantwar Eye Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "500 Power Grid Square, Ringroad",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "No. 500, Powergrid Square,Nari Ring Road,Opposite Jagat Hall",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "No. 500, Powergrid Square,Nari Ring Road,Opposite Jagat Hall, Nagpur",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "MaxBupa Health Insurance Co.Ltd",
"shortName": "Max Bupa"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Mumbai",
"state_id": "27",
"pinCode": "400092",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "28913322",
"source_id": "63930",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "519",
"id": "6182252380579263744",
"distance": "0",
"area": "Awing Vaishali Heights,Near Standerd Chartered Bank,Chandavarkar Road,Borivali(W)",
"name": "Apex Hospital",
"source_hospital_name": "Apex Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "A-Wing, Vaishali Heights, Near Standard Chartered Bank, Chandravarkar Road, Borivali",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Awing Vaishali Heights,Near Standerd Chartered Bank,Chandavarkar Road,Borivali(W)",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Awing Vaishali Heights,Near Standerd Chartered Bank,Chandavarkar Road,Borivali(W), Mumbai",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "MaxBupa Health Insurance Co.Ltd",
"shortName": "Max Bupa"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Thane",
"state_id": "27",
"pinCode": "421301",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "99009",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "517",
"id": "6182252706997465600",
"distance": "0",
"area": "Shiv Tirtha Apartment Parnaka Kalyan",
"name": "Apex Hospital",
"source_hospital_name": "Apex Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Shiv Tirtha Apartment Parnaka Kalyan",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Shiv Tirtha Apartment Parnaka Kalyan",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Shiv Tirtha Apartment Parnaka Kalyan, Thane",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Kolhapur",
"state_id": "27",
"pinCode": "416003",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "141986",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "530",
"id": "6182252247434961664",
"distance": "29",
"area": "804/2,805/2 ?E? Ward, Kadamwadi Road",
"name": "Apple Hospitals And Research Institute Ltd",
"source_hospital_name": "Apple Hospital And Research Institute Ltd",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "804/2, 805/2, E\' Ward, Circute House, Kadamwadi Road",
"emergency_num": "NA",
"coordinates": "Error",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "804/2,805/2 ?E? Ward, Kadamwadi Road",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "804/2,805/2 ?E? Ward, Kadamwadi Road, Kolhapur",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Nagpur",
"state_id": "27",
"pinCode": "440024",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "63509",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "505",
"id": "6182252423529066752",
"distance": "0",
"area": "Manewada Cement Road, Shirdi Nagar, Opposite Navdurga Mandir,",
"name": "Apulki Vairagade Hospital",
"source_hospital_name": "Apulki Vairagade Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Manewada Cement Road, 150, Shirdi Nagar, Nagpur- 440024",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Manewada Cement Road, Shirdi Nagar, Opposite Navdurga Mandir",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Manewada Cement Road, Shirdi Nagar, Opposite Navdurga Mandir, Nagpur",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Mumbai",
"state_id": "27",
"pinCode": "400092",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "51509",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "519",
"id": "6182252380579264000",
"distance": "0",
"area": "B-104, Gomati Appartments,Above Mandpeshwar Hospital,Near Sudhir Phadke Flyover,S.V.P. Road,Borivali(W),",
"name": "Arihant Eye Care Centre",
"source_hospital_name": "Arihant Eye Care Centre",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "B-104, Gomti Apartments, Above Mandpeshwar Hospital, S.V.P.Road, Borivli(W), Mumbai",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "B-104, Gomati Appartments,Above Mandpeshwar Hospital,Near Sudhir Phadke Flyover,S.V.P. Road,Borivali(W)",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "B-104, Gomati Appartments,Above Mandpeshwar Hospital,Near Sudhir Phadke Flyover,S.V.P. Road,Borivali(W), Mumbai",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Raigarh",
"state_id": "27",
"pinCode": "410206",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "50098",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "520",
"id": "6182252539493453312",
"distance": "0",
"area": "Plot No 86, Sector No 10,Opp Cidco Garden New Panvel, Raigad Panvel Navi Mumbai",
"name": "Arunodaya Clinic",
"source_hospital_name": "Arunodaya Clinic",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Plot No 86, Sector-10, Opp Garden, New Panvel-410206, Opp Garden Sector, New Panvel",
"emergency_num": "NA",
"coordinates": "19.003417, 73.118678",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Plot No 86, Sector No 10,Opp Cidco Garden New Panvel, Raigad Panvel Navi",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Plot No 86, Sector No 10,Opp Cidco Garden New Panvel, Raigad Panvel Navi, Raigarh",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Mumbai",
"state_id": "27",
"pinCode": "400077",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "50104",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "519",
"id": "6182252376284239616",
"distance": "25",
"area": "1, Vivek - 67, Tilak Road, Ghatkopar (E), Mumbai",
"name": "Ashirwad Heart Hospital",
"source_hospital_name": "Ashirwad Heart Hospita",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "67  Tilak Road  Ghatkopar (E), Mumbai-400077",
"emergency_num": "NA",
"coordinates": "19.0762268, 72.9055233",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "# 1, Vivek - 67, Tilak Road, Ghatkopar (E)",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "# 1, Vivek - 67, Tilak Road, Ghatkopar (E), Mumbai",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Raigarh",
"state_id": "27",
"pinCode": "410206",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "143610",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "520",
"id": "6182252539493453568",
"distance": "0",
"area": "Plot No.10,Sector-6,Khanda Colony,New Panvel, Navi Mumbai,",
"name": "Ashtvinayak Hospital",
"source_hospital_name": "Ashtvinayak Hospital",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Plot-10, Sector-6, Khanda Colony, New Panvel(W)",
"emergency_num": "NA",
"coordinates": "19.0091383, 73.1165197",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Plot No.10,Sector-6,Khanda Colony,New Panvel, Navi Mumbai",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Plot No.10,Sector-6,Khanda Colony,New Panvel, Navi Mumbai, Raigarh",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Nagpur",
"state_id": "27",
"pinCode": "440010",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "51190",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "505",
"id": "6182252406349153792",
"distance": "0",
"area": "301/B, 401/B Neeti Gaurav Complex, 21 Central Bazar Road Ramdaspeth",
"name": "Ashwini Kidney And Dialysis Centre",
"source_hospital_name": "Ashwini Kidney And Dialysis Centre",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "301/B, Neeti Gaurav Complex, 21, Central Bazar Road Ramdashpeth, Nagpur",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "301/B, 401/B Neeti Gaurav Complex, 21 Central Bazar Road Ramdaspeth",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "301/B, 401/B Neeti Gaurav Complex, 21 Central Bazar Road Ramdaspeth, Nagpur",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "MaxBupa Health Insurance Co.Ltd",
"shortName": "Max Bupa"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Mumbai",
"state_id": "27",
"pinCode": "400066",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "50119",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "519",
"id": "6182252371989220352",
"distance": "0",
"area": "Plot10A, Satyanarayan Apartment Opp G H High School, Off M G Road, Borivili - East Mumbai",
"name": "Asian Eye Institute And Laser Centre",
"source_hospital_name": "Asian Eye Institute And Laser Centre",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "201, Satyanarayan Apt. Opp. G.H. School, Off. M.G. Road, Borivili (E), Mumbai",
"emergency_num": "NA",
"coordinates": "19.2318937, 72.8586904",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Plot10A, Satyanarayan Apartment Opp G H High School, Off M G Road, Borivili - East",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Plot10A, Satyanarayan Apartment Opp G H High School, Off M G Road, Borivili - East, Mumbai",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
},
{
"associatedInsuranceCompanies": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "LIC Of India",
"shortName": "LIC"
},
{
"fullName": "Medi Assist",
"shortName": "MA"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "Reliance General"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance Life"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Religare"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Royal Sundaram"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "Star Health"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "NIA"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"link_status": "linked",
"subtown": "NA",
"total_num_beds": "NA",
"city": "Thane",
"state_id": "27",
"pinCode": "421201",
"specialties": "NA",
"village": "NA",
"bloodbank_phone_no": "NA",
"emergency_services": "NA",
"subdistrict": "NA",
"fax": "NA",
"source_id": "50121",
"number_doctor": "NA",
"nodal_person_tele": "NA",
"category": "NA",
"num_mediconsultant_or_expert": "NA",
"town": "NA",
"accreditation": "NA",
"primary_email_id": "NA",
"care_type": "NA",
"state": "Maharashtra",
"city_id": "517",
"id": "6182252694112543744",
"distance": "0",
"area": "Ground Floor,Prashant Chs Ltd Agarkar Road,Off Phadke Road Dombivli",
"name": "Asmita Nursing Home",
"source_hospital_name": "Asmita Nursing Home",
"secondary_email_id": "NA",
"tollfree": "NA",
"establised_year": "NA",
"miscellaneous_facilities": "NA",
"source_hospital_address": "Agarkar Road, Off Phadke Road",
"emergency_num": "NA",
"coordinates": "NA",
"ambulance_phone_no": "NA",
"facilities": "NA",
"helpline": "NA",
"num_bed_for_eco_weaker_sec": "NA",
"website": "NA",
"tariff_range": "NA",
"nodal_person_info": "NA",
"number_private_wards": "NA",
"address_first_line": "Ground Floor,Prashant Chs Ltd Agarkar Road,Off Phadke Road Dombivli",
"foreign_pcare": "NA",
"registeration_number_scan": "NA",
"hospital_regis_number": "NA",
"discipline_systems_of_medicine": "NA",
"ayush": "NA",
"mobile_number": "NA",
"address": "Ground Floor,Prashant Chs Ltd Agarkar Road,Off Phadke Road Dombivli, Thane",
"nodal_person_email_id": "NA",
"empanelment_or_collaboration_with": "NA",
"telephone": "NA"
}
],
"header": {
"CITY_COUNT": 22,
"HOSPITAL_COUNT": 251,
"STATE_COUNT": 1,
"NETWORK_COUNT": 25
},
"filter": {
"networks": [
{
"fullName": "Apollo Munich Health Insurance Co. Ltd",
"shortName": "AMHI"
},
{
"fullName": "Bajaj Allianz General Insurance Co. Ltd.",
"shortName": "Bajaj Allianz"
},
{
"fullName": "Bharti AXA General Insurance Company Limited",
"shortName": "Bharathi AXA"
},
{
"fullName": "Cholamandalam MS General Insurance Company Limited",
"shortName": "Cholamandalam"
},
{
"fullName": "Future Generali India Insurance Co. Ltd",
"shortName": "Future Generali"
},
{
"fullName": "HDFC Ergo General Insurance Company Limited",
"shortName": "HDFC EGRO"
},
{
"fullName": "ICICI Lombard General Insurance Co. Ltd.",
"shortName": "ICICI"
},
{
"fullName": "IFFCO-Tokio General Insurance Company Ltd",
"shortName": "IFFCO TOKIO"
},
{
"fullName": "IndiaFirst Life Insurance Company Limited",
"shortName": "India First"
},
{
"fullName": "L&T General Insurance Company Limited",
"shortName": "LIC"
},
{
"fullName": "LIC Of India",
"shortName": "LT"
},
{
"fullName": "Liberty Videocon General Insurance Co. Ltd.",
"shortName": "Liberty Videocan"
},
{
"fullName": "MaxBupa Health Insurance Co.Ltd",
"shortName": "MA"
},
{
"fullName": "Medi Assist",
"shortName": "Max Bupa"
},
{
"fullName": "National Insurance Co. Ltd.",
"shortName": "NIA"
},
{
"fullName": "Oriental Insurance Co. Ltd.",
"shortName": "NIC"
},
{
"fullName": "Reliance General Insurance Co. Ltd.",
"shortName": "OIC"
},
{
"fullName": "Reliance Life Insurance Company Limited",
"shortName": "Reliance General"
},
{
"fullName": "Religare Health Insurance Co. Ltd",
"shortName": "Reliance Life"
},
{
"fullName": "Royal Sundaram Alliance Insurance Co. Ltd.",
"shortName": "Religare"
},
{
"fullName": "SBI General Insurance Company Limited",
"shortName": "Royal Sundaram"
},
{
"fullName": "Star Health and Allied Insurance Company Limited",
"shortName": "SBI"
},
{
"fullName": "The New India Assurance Co. Ltd",
"shortName": "Star Health"
},
{
"fullName": "United India Insurance Co. Ltd",
"shortName": "UIIC"
},
{
"fullName": "Universal Sompo General Insurance Co. Ltd.",
"shortName": "Universal Sampo"
}
],
"cities": [
"Ahmednagar",
"Amravati",
"Aurangabad",
"Beed",
"Buldhana",
"Chandrapur",
"Dhule",
"Jalna",
"Kolhapur",
"Latur",
"Mumbai",
"Nagpur",
"Nanded",
"Nashik",
"Parbhani",
"Pune",
"Raigarh",
"Sangli",
"Satara",
"Solapur",
"Thane",
"Yavatmal"
],
"states": [
"Maharashtra"
]
},
"kind": "dataApi#resourcesItem",
"etag": "\"iHRPerxt5Ap4R6WvTSLBFi2JSTE/z7N8KWzBF3rEuwD9bOKq_72iZno\""
}', true);


$loader = new Twig_Loader_Filesystem($path.'/twig_ui/templates');

$twig = new Twig_Environment($loader, array('debug' => true));
$function_URLParams = new Twig_SimpleFunction('function_getURLParams', function ($new_network, $new_state, $new_city,$new_area, $new_specialty,$new_chain, $new_count, $new_page) {
    return getURLParams($new_network, $new_state, $new_city, $new_area, $new_specialty, $new_chain, $new_count, $new_page);
});
$function_HospitalURLParams = new Twig_SimpleFunction('function_getHospitalURLParams', function ($hospital_id) {
    return getHospitalURLParams($hospital_id);
});
$twig->addFunction($function_URLParams);
$twig->addFunction($function_HospitalURLParams);


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
	"specialties" : ["Diabetology", "Cardiology"],
	"chains" : ["Vasan",	"Fortis",	"Apollo",	"Narayana",	"Cloudnine",	"Mewar",	"Wockhardt",	"Cygnus",	"Vaatsalya",		"AMRI",	"Paras",	"Sterling"	]
}');
$specialty_map = array('Diabetology' => 'Diabetes','Cardiology' => 'Heart (Cardiac)', );

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
$title = $rounded_count 
        . ($specialty=='all'?($chain=='all'?' ': ' '.$chain): ' '.$specialty_map[$specialty])
		. ' Hospitals in '
        . ($network=='all'?' ': $network.' Network, ')
        .($area=='all'?'': $area.', ')
        .($city=='all'?'': $city.', ')
        .($state=='all'?'': $state.',')
        .' India';

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
              'specialty_map' => $specialty_map,
              'baseURL' => strtok($_SERVER["REQUEST_URI"],'?'),
              'baseHospitalURL' => strtok($_SERVER["REQUEST_URI"],'?')."hospital"
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
