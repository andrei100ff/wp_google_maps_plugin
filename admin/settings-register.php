<?php // MyPlugin - Register Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// register plugin settings
function myplugin_register_settings() {
	
	/*
	
	register_setting( 
		string   $option_group, 
		string   $option_name, 
		callable $sanitize_callback = ''
	);
	
	*/
	
	register_setting( 
		'myplugin_options', 
		'myplugin_options', 
		'myplugin_callback_validate_options' 
	); 
	
	/*
	
	add_settings_section( 
		string   $id, 
		string   $title, 
		callable $callback, 
		string   $page
	);
	
	*/
	
	add_settings_section( 
		'myplugin_section_login', 
		esc_html__('Customize Login Page', 'myplugin'), 
		'myplugin_callback_section_login', 
		'myplugin'
	);
		
	/*
	
	add_settings_field(
    	string   $id, 
		string   $title, 
		callable $callback, 
		string   $page, 
		string   $section = 'default', 
		array    $args = []
	);
	
	*/
	
	
	add_settings_field(
		'custom_title',
		esc_html__('API Key', 'myplugin'),
		'myplugin_callback_field_text',
		'myplugin', 
		'myplugin_section_login', 
		[ 'id' => 'custom_title', 'label' => esc_html__('Google Maps API Key', 'myplugin') ]
	);
	
	add_settings_field(
		'custom_style',
		esc_html__('Scrolling', 'myplugin'),
		'myplugin_callback_field_radio',
		'myplugin', 
		'myplugin_section_login', 
		[ 'id' => 'custom_style', 'label' => esc_html__('Google Maps Scrolling', 'myplugin') ]
	);
	
	add_settings_field(
		'custom_message',
		esc_html__('Map Styling', 'myplugin'),
		'myplugin_callback_field_textarea',
		'myplugin', 
		'myplugin_section_login', 
		[ 'id' => 'custom_message', 'label' => esc_html__('Google Maps Styling (please refer to SnazzyMaps for more examples)', 'myplugin') ]
	);
    
} 
add_action( 'admin_init', 'myplugin_register_settings' );


