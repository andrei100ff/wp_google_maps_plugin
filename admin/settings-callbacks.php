<?php // MyPlugin - Settings Callbacks



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// callback: login section
function myplugin_callback_section_login() {
	
	echo '<p>'. esc_html__('These settings enable you to customize the WP Login screen.', 'myplugin') .'</p>';
	
}



// callback: text field
function myplugin_callback_field_text( $args ) {
	
	$options = get_option( 'myplugin_options', myplugin_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input id="myplugin_options_'. $id .'" name="myplugin_options['. $id .']" type="text" size="80" value="'. $value .'"><br />';
	echo '<label for="myplugin_options_'. $id .'">'. $label .'</label>';
	
}



// radio field options
function myplugin_options_radio() {
	
	return array(
		
		'enable'  => esc_html__('Enable Scrolling', 'myplugin'),
		'disable' => esc_html__('Disable Scrolling', 'myplugin')
		
	);
	
}



// callback: radio field
function myplugin_callback_field_radio( $args ) {
	
	$options = get_option( 'myplugin_options', myplugin_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	$radio_options = myplugin_options_radio();
	
	foreach ( $radio_options as $value => $label ) {
		
		$checked = checked( $selected_option === $value, true, false );
		
		echo '<label><input name="myplugin_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

		
	}
	
}



// callback: textarea field
function myplugin_callback_field_textarea( $args ) {
	
	$options = get_option( 'myplugin_options', myplugin_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$allowed_tags = wp_kses_allowed_html( 'post' );
	
	$value = isset( $options[$id] ) ? wp_kses( stripslashes_deep( $options[$id] ), $allowed_tags ) : '';
	
	echo '<textarea id="myplugin_options_'. $id .'" name="myplugin_options['. $id .']" rows="8" cols="85">'. $value .'</textarea><br />';
	echo '<label for="myplugin_options_'. $id .'">'. $label .'</label>';

	require_once plugin_dir_path( __FILE__ ) .'../includes/connection.php';
	 
	$query="SELECT `id`, `name`,`email`, `phone`,  `city`, `state` FROM `adzlab`";
	$i=0;
	$results=mysqli_query($connection,$query);
	if(mysqli_num_rows($results)>0){
	    while($row=mysqli_fetch_assoc($results)){
	        $location[$i]= array($row['id'],$row['name'],$row['email'],$row['phone'],$row['city'],$row['state']) ;
	        ++$i;
	    }
	}



	$str2 = <<< EOT
<style type="text/css">
thead th {
    padding-left: 11px!important;
}
</style>
<table class="wp-list-table widefat fixed posts" style="margin-top: 60px;">
					<thead>
						<tr>
							<th style="width:40px;">ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone In</th>
							<th>City</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
EOT;
for($i = 0; $i < sizeof($location); ++$i) {
	$str2 .= '<tr><td>'.$location[$i][0].'</td><td>'.$location[$i][1].'</td><td>'.$location[$i][2].'</td><td>'.$location[$i][3].'</td><td>'.$location[$i][4].'</td><td>'.$location[$i][5].'</td></tr>';
}
$str2 .='</tbody></table>';
echo $str2;

													



}

