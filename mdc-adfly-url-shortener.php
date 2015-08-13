<?php
/*
Plugin Name: MDC Adf.ly Shortener
Author: Nazmul Ahsan
Author URI: http://nazmulahsan.me
Plugin URI: http://medhabi.com
Description: This plugin is an awesome tool to monetize your blog/website. It generates Adf.ly shortened URL like a charm. You don't have to go to Adf.ly website every time you want to shorten a URL. It enables shortcode to generate Adf.ly URLs!
Version: 1.0.0
*/
include 'tinymce-button.php';
include 'options-page.php';

/*Main function to return Adf.ly URL*/
function adfly_url_shortner($url, $key, $uid, $domain = 'adf.ly', $advert_type = 'int'){
	$api = 'http://api.adf.ly/api.php?';

	$query = array(
	'key' => $key,
	'uid' => $uid,
	'advert_type' => $advert_type, // int | banner
	'domain' => $domain, // adf.ly | q.gs
	'url' => $url
	);

	$api = $api . http_build_query($query);
	if ($data = file_get_contents($api))
	return $data;
}

function get_adfly_url($url, $domain = 'adf.ly', $ad_type = 'int'){
	$apiKey = (mdc_get_option('api_key') == '') ? 'd8f32e474db32611c642260dd8aa00a2' : mdc_get_option('api_key'); // Your api key
	$uId = (mdc_get_option('user_id') == '0' || mdc_get_option('user_id') == '') ? '170759' : mdc_get_option('user_id'); // Your user id
	return adfly_url_shortner($url, $apiKey, $uId, $domain, $ad_type);
}

function adfly_url_shortcode($param){
	$url = $param['url'];
	$label_type = $param['label_type'];
	$label_text = $param['label'];
	$domain = $param['domain'];
	$ad_type = $param['ad_type'];
	$target = ($param['target'] == '_blank') ? " target='_blank'" : '';

	if($url == '') {$url = 'http://medhabi.com';}
	if($label_type == '') {$label_type = 'long';}
	if($label_text == '') {$label_text = 'Click Here';}
	if($domain == '') {$domain = 'adf.ly';}
	if($ad_type == '') {$ad_type = 'int';}

	$adfly_url = get_adfly_url($url, $domain, $ad_type);

	if($label_type == 'long') {$label = $url;}
	elseif($label_type == 'short') {$label = $adfly_url;}
	elseif($label_type == 'text') {$label = $label_text;}
	
	return "<a href='".$adfly_url."'".$target.">$label</a>";
}

add_shortcode('mdc_adfly', 'adfly_url_shortcode');

function mdc_get_option($id){
	$options = get_option( 'mdc_adfly_options' );
	return $options[$id];
}


add_action( 'admin_enqueue_scripts', 'mdc_admin_enqueue_scripts' );
function mdc_admin_enqueue_scripts() {
    wp_enqueue_style( 'mdc-adfly-style', plugins_url('/css/admin.css',__FILE__));
    wp_enqueue_script( 'mdc-adfly-scipt', plugins_url('/js/admin.js',__FILE__));

    //localize script
    $wp_ulrs = array( 'adfly_icon' => plugins_url('/images/adfly.png',__FILE__) );
    wp_localize_script( 'mdc-adfly-scipt', 'wp_ulrs', $wp_ulrs );
}