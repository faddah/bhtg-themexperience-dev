<?php

//////////////////////////////
///TOP LEVEL
//////////////////////////////

/* 
 * TOP LEVEL ICON COLOR
 */
function ubermenu_get_menu_style_icon_top_level_color( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );

	if( $val ){

		$selector = ".ubermenu-$menu_id .ubermenu-item-level-0 > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['color'] = $val;

	}
}

/* 
 * TOP LEVEL ICON COLOR - HOVER
 */
function ubermenu_get_menu_style_icon_top_level_color_hover( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );

	if( $val ){

		$selector = ".ubermenu-$menu_id .ubermenu-item-level-0.ubermenu-active > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['color'] = $val;

	}
}

/* 
 * TOP LEVEL ICON SIZE
 */
function ubermenu_get_menu_style_icon_top_level_size( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-level-0 > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['font-size'] = $val;

	}
}

/* 
 * TOP LEVEL PADDING - VERTICAL
 */
function ubermenu_get_menu_style_icon_top_level_padding_v( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-level-0 > .ubermenu-target.ubermenu-item-layout-icon_top, ".
					".ubermenu-$menu_id .ubermenu-item-level-0 > .ubermenu-target.ubermenu-item-layout-icon_bottom";
		$menu_styles[$selector]['padding-top'] = $val;
		$menu_styles[$selector]['padding-bottom'] = $val;

	}
}

/* 
 * TOP LEVEL PADDING - HORIZONTAL
 */
function ubermenu_get_menu_style_icon_top_level_padding_h( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-level-0 > .ubermenu-target.ubermenu-item-layout-icon_top, ".
					".ubermenu-$menu_id .ubermenu-item-level-0 > .ubermenu-target.ubermenu-item-layout-icon_bottom";
		$menu_styles[$selector]['padding-left'] = $val;
		$menu_styles[$selector]['padding-right'] = $val;

	}
}











//////////////////////////////
///HEADER
//////////////////////////////

/* 
 * HEADER ICON COLOR
 */
function ubermenu_get_menu_style_icon_header_color( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );

	if( $val ){

		$selector = ".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['color'] = $val;

	}
}

/* 
 * HEADER ICON COLOR - HOVER
 */
function ubermenu_get_menu_style_icon_header_color_hover( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );

	if( $val ){

		$selector = ".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target:hover .ubermenu-icon";
		$menu_styles[$selector]['color'] = $val;

	}
}

/* 
 * HEADER ICON SIZE
 */
function ubermenu_get_menu_style_icon_header_size( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['font-size'] = $val;

	}
}

/* 
 * HEADER PADDING - VERTICAL
 */
function ubermenu_get_menu_style_icon_header_padding_v( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target.ubermenu-item-layout-icon_top, ".
					".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target.ubermenu-item-layout-icon_bottom";
		$menu_styles[$selector]['padding-top'] = $val;
		$menu_styles[$selector]['padding-bottom'] = $val;

	}
}

/* 
 * HEADER PADDING - HORIZONTAL
 */
function ubermenu_get_menu_style_icon_header_padding_h( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target.ubermenu-item-layout-icon_top, ".
					".ubermenu-$menu_id .ubermenu-item-header > .ubermenu-target.ubermenu-item-layout-icon_bottom";
		$menu_styles[$selector]['padding-left'] = $val;
		$menu_styles[$selector]['padding-right'] = $val;

	}
}











//////////////////////////////
///NORMAL
//////////////////////////////

/* 
 * NORMAL ICON COLOR
 */
function ubermenu_get_menu_style_icon_normal_color( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );

	if( $val ){

		$selector = ".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['color'] = $val;

	}
}

/* 
 * NORMAL ICON COLOR - HOVER
 */
function ubermenu_get_menu_style_icon_normal_color_hover( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );

	if( $val ){

		$selector = ".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target:hover .ubermenu-icon";
		$menu_styles[$selector]['color'] = $val;

	}
}

/* 
 * NORMAL ICON SIZE
 */
function ubermenu_get_menu_style_icon_normal_size( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target .ubermenu-icon";
		$menu_styles[$selector]['font-size'] = $val;

	}
}

/* 
 * NORMAL PADDING - VERTICAL
 */
function ubermenu_get_menu_style_icon_normal_padding_v( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target.ubermenu-item-layout-icon_top, ".
					".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target.ubermenu-item-layout-icon_bottom";
		$menu_styles[$selector]['padding-top'] = $val;
		$menu_styles[$selector]['padding-bottom'] = $val;

	}
}

/* 
 * NORMAL PADDING - HORIZONTAL
 */
function ubermenu_get_menu_style_icon_normal_padding_h( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){

		if( is_numeric( $val ) ) $val.='px';

		$selector = ".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target.ubermenu-item-layout-icon_top, ".
					".ubermenu-$menu_id .ubermenu-item-normal > .ubermenu-target.ubermenu-item-layout-icon_bottom";
		$menu_styles[$selector]['padding-left'] = $val;
		$menu_styles[$selector]['padding-right'] = $val;

	}
}