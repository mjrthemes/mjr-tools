<?php
/*
Plugin Name: MJR Tools
Plugin URI: http://www.major-themes.com/
Description: MJR Tools
Version: 1.0.8
Author: Major Themes
Author URI: http://www.major-themes.com/
*/

$mjr_plugin_directory = plugin_dir_url( __FILE__ );

/* Shortcodes */

/* Slideshow */

function mjr_slideshow( $atts, $content = null) {
	global $post;
	shortcode_atts( array(
		'ids' => '',
		'speed' => '10000',
		'animation' => 'slide',
		'direction' => 'horizontal'
	), $atts );

	$mjr_gallery = "<div class='mjr-slider' data-slideshowspeed='".$atts['speed']."' data-animationspeed='600' data-animation='".$atts['animation']."' data-direction='".$atts['direction']."' data-autostart='true'>
	<ul class='slides'>";

	$images = explode(',', $atts['ids']);
	$i = 0;
	foreach($images as $image) {
		$i++;
		$attimg = wp_get_attachment_image_src($image, 'mjr-main');
		$attdata = get_post($image);
		$mjr_gallery .= "<li style='background-image: url(".$attimg[0].");' title='".$attdata->post_title."' ><h3>".$attdata->post_title."</h3>";
		$mjr_gallery .= "</li>";
	}
	$mjr_gallery .= "</ul></div>";

	return $mjr_gallery;
}
add_shortcode( 'slideshow', 'mjr_slideshow' );

/* Button */

function mjr_button( $atts, $content = null) {
	extract( shortcode_atts( array(
		'link' => '',
		'icon' => '',
		'color' => '',
		'size' => 'medium'
	), $atts ) );

	if($size == 'large') {
		$size = 'mjr-button-large';
	}
	if($size == 'small') {
		$size = 'mjr-button-small';
	}

	$returned_button = '';
	$returned_button .= '<a href="'.$link.'" class="mjr-button '.$size.'"';
	if($color) {
		$returned_button .= 'style="background-color: '.$color.';"';
	}
	$returned_button .= '>';
	if($icon) {
		$returned_button .= ' <i class="fa fa-'.$icon.'"></i>';
	}
	$returned_button .= $content.'</a>';

	return $returned_button;
}
add_shortcode( 'button', 'mjr_button' );

/* Profile */

function mjr_profile( $atts, $content = null) {
	extract( shortcode_atts( array(
		'name' => '',
		'bg' => '',
		'avatar' => '',
		'location' => '',
		'text' => ''
	), $atts ) );

	$returned_button = '';
	$returned_button .= "<div class='mjr-profile'>";
	$returned_button .= "<div class='profile-bg' style='background-image: url(".$bg.")'></div>";
	$returned_button .= "<div class='profile-avatar' style='background-image: url(".$avatar.")'></div>";
	$returned_button .= "<div class='profile-name'>".$name."</div>";
	if(!empty($loaction)) {
		$returned_button .= "<div class='profile-location'><i class='fa fa-map-marker'></i> ".$location."</div>";
	}
	$returned_button .= "<div class='profile-text'>".$content."</div>";
	$returned_button .= "</div>";

	return $returned_button;
}
add_shortcode( 'profile', 'mjr_profile' );

/* Linkbox */

function mjr_linkbox( $atts, $content = null) {
	extract( shortcode_atts( array(
		'cat' => '',
		'link' => '',
		'bg' => ''
	), $atts ) );

	$returned_button = '';
	if(!empty($bg)) {
		$returned_button .= "<div class='mjr-linkbox' style='background-image: url(".$bg.")'>";
	} else {
		$returned_button .= "<div class='mjr-linkbox no-bg'>";
	}
	if(!empty($link)) {
		$returned_button .= "<a href='".$link."'>";
	}
	if(!empty($cat)) {
		$returned_button .= "<div class='linkbox-cat'>".$cat."</div>";
	}
	$returned_button .= "<div class='linkbox-text'>".$content."</div>";
	if(!empty($link)) {
		$returned_button .= "</a>";
	}
	$returned_button .= "</div>";

	return $returned_button;
}
add_shortcode( 'linkbox', 'mjr_linkbox' );

/* Notice */

function mjr_notice( $atts, $content = null) {
	extract( shortcode_atts( array(
		'icon' => '',
		'color' => '',
		'size' => 'medium'
	), $atts ) );

	$returned_button = '';
	$returned_button .= '<div class="mjr-notice '.$size.'"';
	if($color) {
		$returned_button .= 'style="background-color: '.$color.';"';
	}
	$returned_button .= '>';
	if($icon) {
		$returned_button .= ' <i class="fa fa-'.$icon.'"></i>';
	}
	$returned_button .= $content.'</div>';

	return $returned_button;
}
add_shortcode( 'notice', 'mjr_notice' );

// Highlight

function mjr_highlight( $atts, $content = null) {
	extract( shortcode_atts( array(
					'color'  => '#ffff99'
				), $atts ) );
	if(!$color)
		$color = '#ffff99';
	return '<span class="mjr-highlight" style="background: '.$color.'">'.$content.'</span>';
}
add_shortcode( 'highlight', 'mjr_highlight' );

// Intro

function mjr_intro( $atts, $content = null) {
	return '<div class="mjr-intro">'.do_shortcode($content).'</div>';
}
add_shortcode( 'intro', 'mjr_intro' );

// Spoiler

function mjr_spoiler( $atts, $content = null) {
	return '<span class="mjr-spoiler"><span>'.$content.'</span></span>';
}
add_shortcode( 'spoiler', 'mjr_spoiler' );

// Icon

function mjr_icon( $atts, $content = null) {
	extract( shortcode_atts( array(
					'name'  => 'wrench',
					'size'  => 'inherit'
				), $atts ) );
	return '<i class="fa fa-'.$name.'" style="font-size: '.$size.'">'.$content.'</i>';
}
add_shortcode( 'icon', 'mjr_icon' );

// Columns

function one( $atts, $content = null ) {
	return '<div class="one">' . do_shortcode($content) . '</div>';
}
add_shortcode('one', 'one'); 

function one_third( $atts, $content = null ) {
	return '<div class="one-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'one_third');

function one_third_last( $atts, $content = null ) {
	return '<div class="one-third last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third_last', 'one_third_last');

function two_thirds( $atts, $content = null ) {
	return '<div class="two-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'two_thirds');

function two_thirds_last( $atts, $content = null ) {
	return '<div class="two-third last">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds_last', 'two_thirds_last');

function one_half( $atts, $content = null ) {
	return '<div class="one-half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'one_half');

function one_half_last( $atts, $content = null ) {
	return '<div class="one-half last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half_last', 'one_half_last');

function one_fourth( $atts, $content = null ) {
	return '<div class="one-fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'one_fourth');

function one_fourth_last( $atts, $content = null ) {
	return '<div class="one-fourth last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth_last', 'one_fourth_last');

// Toggle 

function mjr_toggle($atts, $content = null) {
	extract(shortcode_atts(array("caption" => "Toggle", "collapsable" => "yes"), $atts));
	$html = ''; 
	if ($collapsable == "yes")
	{
		$html .= '<div class="trigger-button"><span>' . $caption . '</span></div> <div class="accordion">';
		$html .= mjr_no_wpautop($content);
		$html .= '</div>';
	}
	else
	{
		$html .= '<div class="toggle-wrap">';
		$html .= '<span class="trigger"><a href="#">' . $caption . '</a></span><div class="toggle-container">';
		$html .= mjr_no_wpautop($content);
		$html .= '</div></div>';
	}
	return $html;
}
add_shortcode('toggle', 'mjr_toggle');

// Tabs

function mjr_tab( $atts, $content = null ) {

	extract(shortcode_atts(array(
		'title' => 'Tab'
	), $atts ));
										
	return '<div id="tab-'. preg_replace('/[^A-Za-z0-9-]/' ,'', sanitize_title($title) ) .'">'. do_shortcode($content) .'</div>';
}
add_shortcode( 'tab', 'mjr_tab' );

function mjr_tabs( $atts, $content = null ) {

	if( preg_match_all( '/\[tab[^\]]*title="([^\"]+)"[^\]]*\]/i', $content, $mjr_tabs ) ) {

		$titles = '';
		
		foreach($mjr_tabs[1] as $mjr_single_tab) {
			$titles.='<li><a href="#tab-'. preg_replace('/[^A-Za-z0-9-]/' ,'', sanitize_title($mjr_single_tab)) .'">'.$mjr_single_tab.'</a></li>';
		}
	}

	$tabs = '
	<div class="mjr-tabs">
		<ul class="tabs-control">'.$titles.'</ul>
		'.do_shortcode($content).'
	</div>';
			
	return $tabs;
}
add_shortcode( 'tabs', 'mjr_tabs' );

// TinyMCE

add_action('init', 'mjr_custom_mce_buttons');
function mjr_custom_mce_buttons() {
	if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
		add_filter('mce_buttons', 'mjr_add_mce_button');
		add_filter('mce_external_plugins', 'mjr_add_mce_plugin');
	}
}

function mjr_add_mce_button($buttons) {
	array_push($buttons, 'mjrdesign');
	return $buttons;
}

function mjr_add_mce_plugin($plugin_array) {
	global $mjr_plugin_directory;
	$plugin_array['blist'] = $mjr_plugin_directory.'js/customcodes.js';
	return $plugin_array;
}

add_action( 'wp_enqueue_scripts', 'mjr_plugin_script_enqueuer' );
function mjr_plugin_script_enqueuer() {
	global $mjr_plugin_directory;
	wp_register_script( 'mjr_plugin_main', $mjr_plugin_directory.'js/main.js', array( 'jquery', 'jqueryui' ), '1.0.0', true );
	wp_enqueue_script( 'mjr_plugin_main' );
}


// Enqueue Admin section styles

add_action('admin_print_styles', 'mjr_admin_styles'); 
function mjr_admin_styles() {
	global $mjr_plugin_directory;
	wp_register_style( 'mjr_admin_styles', $mjr_plugin_directory."css/admin.css");
	wp_enqueue_style( 'mjr_admin_styles' );
	wp_register_style( 'font-awesome', $mjr_plugin_directory."css/font-awesome.min.css");
	wp_enqueue_style( 'font-awesome' );
}

// Enqueue Admin section scripts

add_action( 'admin_enqueue_scripts', 'mjr_admin_scripts' );
function mjr_admin_scripts() {
	global $mjr_plugin_directory;
	wp_register_script( 'mjr_admin_scripts', $mjr_plugin_directory.'js/admin.js', false, '1.0.0' );
	wp_enqueue_script( 'mjr_admin_scripts' );
}


add_action( 'wp_head', 'mjr_theme_directory');
add_action( 'admin_head', 'mjr_theme_directory');
function mjr_theme_directory() {
	global $mjr_plugin_directory;
	echo '<script type="text/javascript">
	var mjr_theme_directory = "'.$mjr_plugin_directory.'";
	</script>';
}