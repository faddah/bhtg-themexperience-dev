<?php

add_action( 'ubermenu_customizer_register_subsections' , 'ubermenu_icons_customizer_section' , 10 , 2 );
function ubermenu_icons_customizer_section( $wp_customize , $panel_id ){
	$wp_customize->add_section( $panel_id.'_icons', array(
		'title'		=> __( 'Icons', 'ubermenu' ),
		'priority'	=> 200,
		'panel'		=> $panel_id,
	) );
}

add_filter( 'ubermenu_settings_panel_fields' , 'ubermenu_icons_settings_fields' , 100 );
function ubermenu_icons_settings_fields( $fields ){

	$menus = ubermenu_get_menu_instances( true );

	foreach( $menus as $menu ){
		$mid = UBERMENU_PREFIX.$menu;

		$fields[$mid][1032] = array(
			'name'	=> 'icon_top_level_color',
			'label'	=> __( 'Top Level Icon Color' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to inherited text color' , 'ubermenu' ) , 
			'type'	=> 'color',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_top_level_color',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1033] = array(
			'name'	=> 'icon_top_level_color_hover',
			'label'	=> __( 'Top Level Icon Color [Active]' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to inherited text color' , 'ubermenu' ) ,
			'type'	=> 'color',
			'group'	=> 'icons',
			'custom_style'=> 'icon_top_level_color_hover',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1034] = array(
			'name'	=> 'icon_top_level_size',
			'label'	=> __( 'Top Level Icon Font Size' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to same size as text when left blank. Example: 40px' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_top_level_size',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);


		//_POSITION
		$fields[$mid][1035] = array(
			'name'	=> 'icon_top_level_position',
			'label'	=> __( 'Top Level Icon Position' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to Left.  You can override this on a per-item basis using the Item Layout setting in the Menu Item Settings.' , 'ubermenu' ),
			'type'	=> 'radio',
			'options' => array(
				'icon_left'	=> __( 'Left' , 'ubermenu' ),
				'icon_right' => __( 'Right' , 'ubermenu' ),
				'icon_top'	=> __( 'Top' , 'ubermenu' ),
				'icon_bottom' => __( 'Bottom' , 'ubermenu' ),
			),
			'default' 	=> 'icon_left',
			'group'		=> 'icons',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);


		$fields[$mid][1036] = array(
			'name'	=> 'icon_top_level_padding_v',
			'label'	=> __( 'Top Level Vertical Padding' , 'ubermenu' ),
			'desc'	=> __( 'For "Top" and "Bottom" layouts' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_top_level_padding_v',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1037] = array(
			'name'	=> 'icon_top_level_padding_h',
			'label'	=> __( 'Top Level Horizontal Padding' , 'ubermenu' ),
			'desc'	=> __( 'For "Top" and "Bottom" layouts' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_top_level_padding_h',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);



		//////////////////////////
		///HEADERS
		//////////////////////////

		$fields[$mid][1040] = array(
			'name'	=> 'icon_header_color',
			'label'	=> __( 'Header Icon Color' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to inherited text color' , 'ubermenu' ) , 
			'type'	=> 'color',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_header_color',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1041] = array(
			'name'	=> 'icon_header_color_hover',
			'label'	=> __( 'Header Icon Color [Hover]' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to inherited text color' , 'ubermenu' ) ,
			'type'	=> 'color',
			'group'	=> 'icons',
			'custom_style'=> 'icon_header_color_hover',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1042] = array(
			'name'	=> 'icon_header_size',
			'label'	=> __( 'Header Icon Font Size' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to same size as text when left blank. Example: 40px' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_header_size',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1043] = array(
			'name'	=> 'icon_header_position',
			'label'	=> __( 'Header Icon Position' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to Left.  You can override this on a per-item basis using the Item Layout setting in the Menu Item Settings.' , 'ubermenu' ),
			'type'	=> 'radio',
			'options' => array(
				'icon_left'	=> __( 'Left' , 'ubermenu' ),
				'icon_right' => __( 'Right' , 'ubermenu' ),
				'icon_top'	=> __( 'Top' , 'ubermenu' ),
				'icon_bottom' => __( 'Bottom' , 'ubermenu' ),
			),
			'default' 	=> 'icon_left',
			'group'		=> 'icons',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);


		$fields[$mid][1044] = array(
			'name'	=> 'icon_header_padding_v',
			'label'	=> __( 'Header Vertical Padding' , 'ubermenu' ),
			'desc'	=> __( 'For "Top" and "Bottom" layouts' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_header_padding_v',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1045] = array(
			'name'	=> 'icon_header_padding_h',
			'label'	=> __( 'Header Horizontal Padding' , 'ubermenu' ),
			'desc'	=> __( 'For "Top" and "Bottom" layouts' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_header_padding_h',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);



		//////////////////////////
		///NORMAL
		//////////////////////////

		$fields[$mid][1047] = array(
			'name'	=> 'icon_normal_color',
			'label'	=> __( 'Normal Icon Color' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to inherited text color' , 'ubermenu' ) , 
			'type'	=> 'color',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_normal_color',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1048] = array(
			'name'	=> 'icon_normal_color_hover',
			'label'	=> __( 'Normal Icon Color [Hover]' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to inherited text color' , 'ubermenu' ) ,
			'type'	=> 'color',
			'group'	=> 'icons',
			'custom_style'=> 'icon_normal_color_hover',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1049] = array(
			'name'	=> 'icon_normal_size',
			'label'	=> __( 'Normal Icon Font Size' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to same size as text when left blank. Example: 40px' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_normal_size',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1050] = array(
			'name'	=> 'icon_normal_position',
			'label'	=> __( 'Normal Icon Position' , 'ubermenu' ),
			'desc'	=> __( 'Defaults to Left.  You can override this on a per-item basis using the Item Layout setting in the Menu Item Settings.' , 'ubermenu' ),
			'type'	=> 'radio',
			'options' => array(
				'icon_left'	=> __( 'Left' , 'ubermenu' ),
				'icon_right' => __( 'Right' , 'ubermenu' ),
				'icon_top'	=> __( 'Top' , 'ubermenu' ),
				'icon_bottom' => __( 'Bottom' , 'ubermenu' ),
			),
			'default' 	=> 'icon_left',
			'group'		=> 'icons',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);


		$fields[$mid][1051] = array(
			'name'	=> 'icon_normal_padding_v',
			'label'	=> __( 'Normal Vertical Padding' , 'ubermenu' ),
			'desc'	=> __( 'For "Top" and "Bottom" layouts' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_normal_padding_v',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);

		$fields[$mid][1052] = array(
			'name'	=> 'icon_normal_padding_h',
			'label'	=> __( 'Normal Horizontal Padding' , 'ubermenu' ),
			'desc'	=> __( 'For "Top" and "Bottom" layouts' , 'ubermenu' ),
			'type'	=> 'text',
			'group'	=> 'icons',
			'custom_style'	=> 'icon_normal_padding_h',
			'customizer'	=> true,
			'customizer_section'	=> 'icons',
		);
	

	}

	return $fields;
}

/*
add_filter( 'ubermenu_settings_subsections' , 'ubermenu_settings_subsection_icons' , 50 , 2 );
function ubermenu_settings_subsection_icons( $subsections ){
	$subsections['icons'] = array(
		'title'	=> __( 'Icons' ),
	);
	return $subsections;
}
*/