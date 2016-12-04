<?php 

function ubermenu_icon_layout_default( &$umitem , $config_id = false ){

	if( !$config_id ) $config_id = $umitem->get_config_id();
	$layout = 'icon_left';

	//Top Level
	if( $umitem->get_depth() == 0 ){
		$layout = ubermenu_op( 'icon_top_level_position' , $config_id );
	}
	else{
		$item_display = $umitem->getSetting( 'item_display_calc' );
		
		//Header
		if( $item_display == 'header' ){
			$layout = ubermenu_op( 'icon_header_position' , $config_id );
		}

		//Submenu Link
		else{
			$layout = ubermenu_op( 'icon_normal_position' , $config_id );
		}
	}
	//uberp( $umitem );
	//uberp( $umitem->get_settings() );

	return $layout ? $layout : 'icon_left';
}

add_filter( 'ubermenu_item_layout_ops' , 'ubermenu_icon_item_layout_ops' );
function ubermenu_icon_item_layout_ops( $ops ){
	
	$ops['icons']['icon_right'] = array(
			'name'	=> __( 'Icon Right', 'ubermenu' ),
		);

	$ops['icons']['icon_top'] = array(
			'name'	=> __( 'Icon Top', 'ubermenu' ),
		);

	$ops['icons']['icon_bottom'] = array(
			'name'	=> __( 'Icon Bottom', 'ubermenu' ),
		);


	return $ops;
}

add_filter( 'ubermenu_item_layouts' , 'ubermenu_icon_item_layouts' );
function ubermenu_icon_item_layouts( $layouts ){

	$layouts['icon_top'] = array(
		'order'	=> array(
			'icon',
			'title',
			'description',
		),
	);
	
	$layouts['icon_right'] = array(
		'order'	=> array(
			'title',
			'description',
			'icon',
		),
	);

	$layouts['icon_bottom'] = array(
		'order'	=> array(
			'title',
			'description',
			'icon',
		),
	);

	return $layouts;
}