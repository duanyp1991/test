<?php

  // Add Custom header feature  
function destro_custom_header_setup() {
	  
  $destro_customhargs = array(
	'default-image' => get_template_directory_uri() . '/images/defaulth.jpg',
	'flex-width'    => true,
	'width'         => 1200,
	'flex-height'    => true,
	'height'        => 500,
	'header-text'   => false,
	'uploads'       => true,
  );
  add_theme_support( 'custom-header', $destro_customhargs ); 

}
add_action( 'after_setup_theme', 'destro_custom_header_setup' );
?>