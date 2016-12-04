<?php

add_filter( 'ubermenu_menu_item_settings' , 'ubermenu_icons_item_settings' );
function ubermenu_icons_item_settings( $settings ){

	$settings['icon'][20] = array(
		'id'	=> 'icon_custom_class',
		'title'	=> __( 'Custom Icon Class' , 'ubermenu' ),
		'type'	=> 'text',
		'default'=> '',
		'desc'	=> __( 'Add a custom class to the i tag.  Requires UberMenu 3.2+  If an icon is set above, this class will be appended.  If no icon is set above, an icon will appear with this class.', 'ubermenu' ),

	);

	return $settings;
}



add_filter( 'ubermenu_icon_custom_class' , 'ubermenu_icons_custom_class_setting' , 10 , 3 );
function ubermenu_icons_custom_class_setting( $icon_classes , $item_id , $custom_class ){
	if( $custom_class ){
		$icon_classes.= ' '.$custom_class;
	}
	return $icon_classes;
}
