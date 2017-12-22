<?php // MyPlugin - Core Functionality



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}

function shortcode_function($atts){

	do_action('twd_action_hook');

}
add_shortcode('googlemaps_form', 'shortcode_function');



function twd_action_function() {
    
	wp_enqueue_style( 'twd-css', plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/main.css', array(), null, 'screen' );

	wp_enqueue_script( 'twd-js', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/main.js', array(), null, true );
	wp_enqueue_script( 'twd-js1', plugin_dir_url( dirname( __FILE__ ) ) . 'includes/section-map.js', array(), null, true );
			
	wp_enqueue_style( 'twd-font', '//fonts.googleapis.com/css?family=Raleway:200,300,400,500');
	wp_enqueue_style( 'twd-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
	wp_enqueue_style( 'twd-fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
	wp_enqueue_style( 'twd-bootstrapresp', '//getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css');
	wp_enqueue_style( 'twd-bootstrapValidator', '//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'twd-bootstrapjs', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'),'1.0',true);
	wp_enqueue_script( 'twd-bootstrapvalidatorjs', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js', array('jquery'),'1.0',true);
	wp_localize_script('twd-js', 'child_script_vars', array(
			'path' => plugin_dir_url( dirname( __FILE__ ) )
		)
	);

	$options = get_option( 'myplugin_options', myplugin_options_default() );
	
	if ( isset( $options['custom_title'] ) && ! empty( $options['custom_title'] ) ) {
		
		$gmapi = esc_attr( $options['custom_title'] );

		wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?key='.$gmapi.'&callback=initMap&language=en', array(), null, true);

	}
		
	if ( isset( $options['custom_message'] ) && ! empty( $options['custom_message'] ) ) {

		$styledmaps='';
		$styledmaps = wp_kses_post( $options['custom_message'] ) . $styledmaps;
		
	}

	$styles = false;
	$maps_zoom = false;
		
	if ( isset( $options['custom_style'] ) && ! empty( $options['custom_style'] ) ) {
		
		$styles = sanitize_text_field( $options['custom_style'] );
		
	}
	
	if ( 'enable' === $styles ) {
		
		$maps_zoom=true;

	}


	include('connection.php');
	 
	$query="SELECT `practice`, `lat`, `lng` FROM `adzlab`";
	$i=0;
	$results=mysqli_query($connection,$query);
	if(mysqli_num_rows($results)>0){
	    while($row=mysqli_fetch_assoc($results)){
	        $location[$i]= array($row['practice'],$row['lat'],$row['lng']) ;
	        ++$i;
	    }
	}

	mysqli_close($connection);

	wp_localize_script('twd-js1', 'php_vars', array(
				'locat' => json_encode($location),
				'styledmaps' => $styledmaps,
				'maps_zoom' => $maps_zoom
			)
	);

	readfile(plugin_dir_path( __FILE__ ) . apply_filters( 'twd-filter-hook', 'form' ));

}
add_action('twd_action_hook', 'twd_action_function');


// custom admin footer
function twd_custom_admin_footer( $message ) {
	
	$message.='.html';
	
	return $message;
	
}
add_filter( 'twd-filter-hook', 'twd_custom_admin_footer' );




