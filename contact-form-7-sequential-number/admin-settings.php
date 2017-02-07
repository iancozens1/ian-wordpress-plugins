<?php

add_action( 'admin_menu', 'cf7sng_add_admin_menu' );
add_action( 'admin_init', 'cf7sng_settings_init' );

function cf7sng_add_admin_menu(  ) { 

	add_options_page( 'Contact Form 7 Sequential Number Generator', 'Contact Form 7 Sequential Number Generator', 'manage_options', 'contact_form_7_sequential_number_generator', 'cf7sng_options_page' );

}


function cf7sng_settings_init(  ) { 

	register_setting( 'pluginPage', 'cf7sng_settings' );

	add_settings_section(
		'cf7sng_pluginPage_section', 
		__( 'Settings', 'wordpress' ), 
		'cf7sng_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'cf7sng_text_field_0', 
		__( 'Contact Form ID', 'wordpress' ), 
		'cf7sng_text_field_0_render', 
		'pluginPage', 
		'cf7sng_pluginPage_section' 
	);

	add_settings_field( 
		'cf7sng_text_field_1', 
		__( 'Current Value', 'wordpress' ), 
		'cf7sng_text_field_1_render', 
		'pluginPage', 
		'cf7sng_pluginPage_section' 
	);

	add_settings_field( 
		'cf7sng_text_field_2', 
		__( 'Prefix', 'wordpress' ), 
		'cf7sng_text_field_2_render', 
		'pluginPage', 
		'cf7sng_pluginPage_section' 
	);
	
	


}
//form id

function cf7sng_text_field_0_render(  ) { 

	$options = get_option( 'cf7sng_settings' );
	?>
	<input type='int' name='cf7sng_settings[cf7sng_text_field_0]' value='<?php echo $options['cf7sng_text_field_0']; ?>'>
	<?php

}
//option number update

function cf7sng_text_field_1_render(  ) { 

	$options = get_option( 'cf7sng_settings' );
	?>
	<input type='int' name='cf7sng_settings[cf7sng_text_field_1]' value='<?php echo $options['cf7sng_text_field_1']; ?>'>
	<?php

}

//prefix
function cf7sng_text_field_2_render(  ) { 

	$options = get_option( 'cf7sng_settings' );
	?>
	<input type='text' name='cf7sng_settings[cf7sng_text_field_2]' value='<?php echo $options['cf7sng_text_field_2']; ?>'>
	<?php

}



function cf7sng_settings_section_callback(  ) { 

	echo __( '', 'wordpress' );
	

}

function cf7sng_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>Contact Form 7 Sequential Number Generator</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		
		$options = get_option( 'cf7sng_settings' );
		$id_option = 'wpcf7sg_' .  $options['cf7sng_text_field_0'];

		update_option($id_option, $options['cf7sng_text_field_1']);
		
		$prefix_option = 'wpcf7sg_' .  $options['cf7sng_text_field_0'] . '_prefix';
		update_option($prefix_option, $options['cf7sng_text_field_2']);
		
		
?>

	</form>
	<?php

}

?>

