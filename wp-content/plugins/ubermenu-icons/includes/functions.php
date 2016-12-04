<?php

//Load up latest
add_action( 'admin_print_styles-nav-menus.php' , 'ubermenu_icons_admin_menu_load_assets' , 11 );
function ubermenu_icons_admin_menu_load_assets() {

	$assets = UM_ICONS_PLUGIN_URL . 'assets/';
	wp_deregister_style( 'ubermenu-menu-admin-font-awesome' );
	wp_enqueue_style( 'ubermenu-menu-admin-font-awesome', $assets.'font-awesome/css/font-awesome.min.css' );

}


add_action( 'wp_enqueue_scripts' , 'ubermenu_icons_load_assets' , 22 );
function ubermenu_icons_load_assets(){
	
	$assets = UM_ICONS_PLUGIN_URL . 'assets/';

	//Font Awesome
	if( ubermenu_op( 'load_fontawesome' , 'general' ) != 'off' ){
		wp_deregister_style( 'ubermenu-font-awesome' );
		wp_enqueue_style( 'ubermenu-font-awesome' , $assets.'font-awesome/css/font-awesome.min.css' , false , '4.3' );
	}
}






add_filter( 'ubermenu_custom_styles' , 'ubermenu_icons_custom_styles' );
function ubermenu_icons_custom_styles( $styles ){

	$css = "/* Icons */\n";

	//Right
	$css.= ".ubermenu .ubermenu-item-layout-icon_right > .ubermenu-target-title { margin-right: .6em; display: inline-block; }\n";//.
			//".ubermenu .ubermenu-item-layout-icon_right > .ubermenu-icon { float:right; }\n";

	//Vertical Orientation (Top & Bottom Common )
	$css.= ".ubermenu-sub-indicators .ubermenu-has-submenu-drop > .ubermenu-target.ubermenu-item-layout-icon_top:after, ".
			".ubermenu-sub-indicators .ubermenu-has-submenu-drop > .ubermenu-target.ubermenu-item-layout-icon_bottom:after{ ".
	    		"top: auto; bottom:8px; right:auto; margin-left:-4px; }\n";
	$css.= ".ubermenu .ubermenu-target.ubermenu-item-layout-icon_top, .ubermenu .ubermenu-target.ubermenu-item-layout-icon_bottom{ text-align:center; padding:20px; }\n";

	$css.= ".ubermenu .ubermenu-target.ubermenu-item-layout-icon_top, .ubermenu .ubermenu-target.ubermenu-item-layout-icon_top > .ubermenu-target-text, .ubermenu .ubermenu-target.ubermenu-item-layout-icon_bottom > .ubermenu-target-text, .ubermenu .ubermenu-target.ubermenu-item-layout-icon_bottom > .ubermenu-icon{ text-align:center; display:block; width:100%; }\n";

	//Top
	$css.= ".ubermenu .ubermenu-item-layout-icon_top > .ubermenu-icon { padding-bottom:5px; }\n";

	//Bottom
	$css.= ".ubermenu .ubermenu-item-layout-icon_bottom > .ubermenu-icon { padding-top:5px; }\n";


	$styles[80] = $css;

	return $styles;
}






add_action( 'ubermenu_register_icons' , 'ubermenu_icons_register_icons' , 20 );

function ubermenu_icons_register_icons(){
	ubermenu_deregister_icons( 'font-awesome' );
	ubermenu_register_icons( 'font-awesome' , array(
		'title' => 'Font Awesome',
		'class_prefix' => 'fa ',
		'iconmap' => ubermenu_icons_fa_icons()
	));

}

/* Backwards compatibility function */
function umicons_register_icons( $group , $iconmap ){
	_UBERMENU()->register_icons( $group, $iconmap );
}


function ubermenu_icons_fa_icons(){

	$icons = array(
		'fa-glass'	=>	array(
			'title'	=>	'Glass',
			'v3'	=>	'icon-glass',
		),
		'fa-music'	=>	array(
			'title'	=>	'Music',
			'v3'	=>	'icon-music',
		),
		'fa-search'	=>	array(
			'title'	=>	'Search',
			'v3'	=>	'icon-search',
		),
		'fa-envelope-o'	=>	array(
			'title'	=>	'Envelope (Outline)',
			'v3'	=>	'icon-envelope',
		),
		'fa-heart'	=>	array(
			'title'	=>	'Heart',
			'v3'	=>	'icon-heart',
		),
		'fa-star'	=>	array(
			'title'	=>	'Star',
			'v3'	=>	'icon-star',
		),
		'fa-star-o'	=>	array(
			'title'	=>	'Star (Outline)',
			'v3'	=>	'icon-star-empty',
		),
		'fa-user'	=>	array(
			'title'	=>	'User',
			'v3'	=>	'icon-user',
		),
		'fa-film'	=>	array(
			'title'	=>	'Film',
			'v3'	=>	'icon-film',
		),
		'fa-th-large'	=>	array(
			'title'	=>	'TH Large',
			'v3'	=>	'icon-th-large',
		),
		'fa-th'	=>	array(
			'title'	=>	'TH',
			'v3'	=>	'icon-th',
		),
		'fa-th-list'	=>	array(
			'title'	=>	'th-list',
			'v3'	=>	'icon-th-list',
		),
		'fa-check'	=>	array(
			'title'	=>	'Checkmark',
			'v3'	=>	'icon-ok',
		),
		'fa-times'	=>	array(
			'title'	=>	'Times',
			'v3'	=>	'icon-remove',
		),
		'fa-search-plus'	=>	array(
			'title'	=>	'Search Plus (Zoom In)',
			'v3'	=>	'icon-zoom-in',
		),
		'fa-search-minus'	=>	array(
			'title'	=>	'Search Minus (Zoom Out)',
			'v3'	=>	'icon-zoom-out',
		),
		'fa-power-off'	=>	array(
			'title'	=>	'Power Off',
			'v3'	=>	'icon-off',
		),
		'fa-signal'	=>	array(
			'title'	=>	'Signal',
			'v3'	=>	'icon-signal',
		),
		'fa-cog'	=>	array(
			'title'	=>	'Cog',
			'v3'	=>	'icon-cog',
		),
		'fa-trash-o'	=>	array(
			'title'	=>	'Trash (Outline)',
			'v3'	=>	'icon-trash',
		),
		'fa-home'	=>	array(
			'title'	=>	'Home',
			'v3'	=>	'icon-home',
		),
		'fa-file-o'	=>	array(
			'title'	=>	'File (Outline)',
			'v3'	=>	'icon-file',
		),
		'fa-clock-o'	=>	array(
			'title'	=>	'Clock (Outline)',
			'v3'	=>	'icon-time',
		),
		'fa-road'	=>	array(
			'title'	=>	'Road',
			'v3'	=>	'icon-road',
		),
		'fa-download'	=>	array(
			'title'	=>	'Download',
			'v3'	=>	'icon-download-alt',
		),
		'fa-arrow-circle-o-down'	=>	array(
			'title'	=>	'Arrow (Circle/Outline/Down)',
			'v3'	=>	'icon-download',
		),
		'fa-arrow-circle-o-up'	=>	array(
			'title'	=>	'Arrow (Circle/Outline/Up)',
			'v3'	=>	'icon-upload',
		),
		'fa-inbox'	=>	array(
			'title'	=>	'Inbox',
			'v3'	=>	'icon-inbox',
		),
		'fa-play-circle-o'	=>	array(
			'title'	=>	'Play (Circle/Outline)',
			'v3'	=>	'icon-play-circle',
		),
		'fa-repeat'	=>	array(
			'title'	=>	'Repeat',
			'v3'	=>	'icon-repeat',
		),
		'fa-refresh'	=>	array(
			'title'	=>	'Refresh',
			'v3'	=>	'icon-refresh',
		),
		'fa-list-alt'	=>	array(
			'title'	=>	'List (Alternative)',
			'v3'	=>	'icon-list-alt',
		),
		'fa-lock'	=>	array(
			'title'	=>	'Lock',
			'v3'	=>	'icon-lock',
		),
		'fa-flag'	=>	array(
			'title'	=>	'Flag',
			'v3'	=>	'icon-flag',
		),
		'fa-headphones'	=>	array(
			'title'	=>	'Headphones',
			'v3'	=>	'icon-headphones',
		),
		'fa-volume-off'	=>	array(
			'title'	=>	'Volume Off',
			'v3'	=>	'icon-volume-off',
		),
		'fa-volume-down'	=>	array(
			'title'	=>	'Volume Down',
			'v3'	=>	'icon-volume-down',
		),
		'fa-volume-up'	=>	array(
			'title'	=>	'Volume Up',
			'v3'	=>	'icon-volume-up',
		),
		'fa-qrcode'	=>	array(
			'title'	=>	'QR Code',
			'v3'	=>	'icon-qrcode',
		),
		'fa-barcode'	=>	array(
			'title'	=>	'Barcode',
			'v3'	=>	'icon-barcode',
		),
		'fa-tag'	=>	array(
			'title'	=>	'Tag',
			'v3'	=>	'icon-tag',
		),
		'fa-tags'	=>	array(
			'title'	=>	'tags',
			'v3'	=>	'icon-tags',
		),
		'fa-book'	=>	array(
			'title'	=>	'Book',
			'v3'	=>	'icon-book',
		),
		'fa-bookmark'	=>	array(
			'title'	=>	'Bookmark',
			'v3'	=>	'icon-bookmark',
		),
		'fa-print'	=>	array(
			'title'	=>	'Print',
			'v3'	=>	'icon-print',
		),
		'fa-camera'	=>	array(
			'title'	=>	'Camera',
			'v3'	=>	'icon-camera',
		),
		'fa-font'	=>	array(
			'title'	=>	'Font',
			'v3'	=>	'icon-font',
		),
		'fa-bold'	=>	array(
			'title'	=>	'Bold',
			'v3'	=>	'icon-bold',
		),
		'fa-italic'	=>	array(
			'title'	=>	'Italic',
			'v3'	=>	'icon-italic',
		),
		'fa-text-height'	=>	array(
			'title'	=>	'Text Height',
			'v3'	=>	'icon-text-height',
		),
		'fa-text-width'	=>	array(
			'title'	=>	'Text Width',
			'v3'	=>	'icon-text-width',
		),
		'fa-align-left'	=>	array(
			'title'	=>	'Align Left',
			'v3'	=>	'icon-align-left',
		),
		'fa-align-center'	=>	array(
			'title'	=>	'Align Center',
			'v3'	=>	'icon-align-center',
		),
		'fa-align-right'	=>	array(
			'title'	=>	'Align Right',
			'v3'	=>	'icon-align-right',
		),
		'fa-align-justify'	=>	array(
			'title'	=>	'Align Justify',
			'v3'	=>	'icon-align-justify',
		),
		'fa-list'	=>	array(
			'title'	=>	'List',
			'v3'	=>	'icon-list',
		),
		'fa-outdent'	=>	array(
			'title'	=>	'Outdent',
			'v3'	=>	'icon-indent-left',
		),
		'fa-indent'	=>	array(
			'title'	=>	'Indent',
			'v3'	=>	'icon-indent-right',
		),
		'fa-video-camera'	=>	array(
			'title'	=>	'video-camera',
			'v3'	=>	'icon-facetime-video',
		),
		'fa-picture-o'	=>	array(
			'title'	=>	'Picture (Outline)',
			'v3'	=>	'icon-picture',
		),
		'fa-pencil'	=>	array(
			'title'	=>	'Pencil',
			'v3'	=>	'icon-pencil',
		),
		'fa-map-marker'	=>	array(
			'title'	=>	'Map Marker',
			'v3'	=>	'icon-map-marker',
		),
		'fa-adjust'	=>	array(
			'title'	=>	'Adjust',
			'v3'	=>	'icon-adjust',
		),
		'fa-tint'	=>	array(
			'title'	=>	'Tint',
			'v3'	=>	'icon-tint',
		),
		'fa-pencil-square-o'	=>	array(
			'title'	=>	'Pencil (Square/Outline)',
			'v3'	=>	'icon-edit',
		),
		'fa-share-square-o'	=>	array(
			'title'	=>	'Share (Square/Outline)',
			'v3'	=>	'icon-share',
		),
		'fa-check-square-o'	=>	array(
			'title'	=>	'Check (Square/Outline)',
			'v3'	=>	'icon-check',
		),
		'fa-arrows'	=>	array(
			'title'	=>	'Arrows',
			'v3'	=>	'icon-move',
		),
		'fa-step-backward'	=>	array(
			'title'	=>	'Step Backward',
			'v3'	=>	'icon-step-backward',
		),
		'fa-fast-backward'	=>	array(
			'title'	=>	'Fast Backward',
			'v3'	=>	'icon-fast-backward',
		),
		'fa-backward'	=>	array(
			'title'	=>	'Backward',
			'v3'	=>	'icon-backward',
		),
		'fa-play'	=>	array(
			'title'	=>	'Play',
			'v3'	=>	'icon-play',
		),
		'fa-pause'	=>	array(
			'title'	=>	'Pause',
			'v3'	=>	'icon-pause',
		),
		'fa-stop'	=>	array(
			'title'	=>	'Stop',
			'v3'	=>	'icon-stop',
		),
		'fa-forward'	=>	array(
			'title'	=>	'Forward',
			'v3'	=>	'icon-forward',
		),
		'fa-fast-forward'	=>	array(
			'title'	=>	'Fast Forward',
			'v3'	=>	'icon-fast-forward',
		),
		'fa-step-forward'	=>	array(
			'title'	=>	'Step Forward',
			'v3'	=>	'icon-step-forward',
		),
		'fa-eject'	=>	array(
			'title'	=>	'Eject',
			'v3'	=>	'icon-eject',
		),
		'fa-chevron-left'	=>	array(
			'title'	=>	'Chevron Left',
			'v3'	=>	'icon-chevron-left',
		),
		'fa-chevron-right'	=>	array(
			'title'	=>	'Chevron Right',
			'v3'	=>	'icon-chevron-right',
		),
		'fa-plus-circle'	=>	array(
			'title'	=>	'Plus (Circle)',
			'v3'	=>	'icon-plus-sign',
		),
		'fa-minus-circle'	=>	array(
			'title'	=>	'Minus (Circle)',
			'v3'	=>	'icon-minus-sign',
		),
		'fa-times-circle'	=>	array(
			'title'	=>	'Times (Circle)',
			'v3'	=>	'icon-remove-sign',
		),
		'fa-check-circle'	=>	array(
			'title'	=>	'Check (Circle)',
			'v3'	=>	'icon-ok-sign',
		),
		'fa-question-circle'	=>	array(
			'title'	=>	'Question (Circle)',
			'v3'	=>	'icon-question-sign',
		),
		'fa-info-circle'	=>	array(
			'title'	=>	'Info (Circle)',
			'v3'	=>	'icon-info-sign',
		),
		'fa-crosshairs'	=>	array(
			'title'	=>	'Crosshairs',
			'v3'	=>	'icon-screenshot',
		),
		'fa-times-circle-o'	=>	array(
			'title'	=>	'Times (Circle/Outline)',
			'v3'	=>	'icon-remove-circle',
		),
		'fa-check-circle-o'	=>	array(
			'title'	=>	'Check (Circle/Outline)',
			'v3'	=>	'icon-ok-circle',
		),
		'fa-ban'	=>	array(
			'title'	=>	'Ban',
			'v3'	=>	'icon-ban-circle',
		),
		'fa-arrow-left'	=>	array(
			'title'	=>	'Arrow Left',
			'v3'	=>	'icon-arrow-left',
		),
		'fa-arrow-right'	=>	array(
			'title'	=>	'Arrow Right',
			'v3'	=>	'icon-arrow-right',
		),
		'fa-arrow-up'	=>	array(
			'title'	=>	'Arrow Up',
			'v3'	=>	'icon-arrow-up',
		),
		'fa-arrow-down'	=>	array(
			'title'	=>	'Arrow Down',
			'v3'	=>	'icon-arrow-down',
		),
		'fa-share'	=>	array(
			'title'	=>	'Share',
			'v3'	=>	'icon-share-alt',
		),
		'fa-expand'	=>	array(
			'title'	=>	'Expand',
			'v3'	=>	'icon-resize-full',
		),
		'fa-compress'	=>	array(
			'title'	=>	'Compress',
			'v3'	=>	'icon-resize-small',
		),
		'fa-plus'	=>	array(
			'title'	=>	'Plus',
			'v3'	=>	'icon-plus',
		),
		'fa-minus'	=>	array(
			'title'	=>	'Minus',
			'v3'	=>	'icon-minus',
		),
		'fa-asterisk'	=>	array(
			'title'	=>	'Asterisk',
			'v3'	=>	'icon-asterisk',
		),
		'fa-exclamation-circle'	=>	array(
			'title'	=>	'Exclamation Circle',
			'v3'	=>	'icon-exclamation-sign',
		),
		'fa-gift'	=>	array(
			'title'	=>	'Gift',
			'v3'	=>	'icon-gift',
		),
		'fa-leaf'	=>	array(
			'title'	=>	'Leaf',
			'v3'	=>	'icon-leaf',
		),
		'fa-fire'	=>	array(
			'title'	=>	'Fire',
			'v3'	=>	'icon-fire',
		),
		'fa-eye'	=>	array(
			'title'	=>	'Eye',
			'v3'	=>	'icon-eye-open',
		),
		'fa-eye-slash'	=>	array(
			'title'	=>	'Eye Slash',
			'v3'	=>	'icon-eye-close',
		),
		'fa-exclamation-triangle'	=>	array(
			'title'	=>	'Exclamation Triangle',
			'v3'	=>	'icon-warning-sign',
		),
		'fa-plane'	=>	array(
			'title'	=>	'Plane',
			'v3'	=>	'icon-plane',
		),
		'fa-calendar'	=>	array(
			'title'	=>	'Calendar',
			'v3'	=>	'icon-calendar',
		),
		'fa-random'	=>	array(
			'title'	=>	'Random',
			'v3'	=>	'icon-random',
		),
		'fa-comment'	=>	array(
			'title'	=>	'Comment',
			'v3'	=>	'icon-comment',
		),
		'fa-magnet'	=>	array(
			'title'	=>	'Magnet',
			'v3'	=>	'icon-magnet',
		),
		'fa-chevron-up'	=>	array(
			'title'	=>	'Chevron Up',
			'v3'	=>	'icon-chevron-up',
		),
		'fa-chevron-down'	=>	array(
			'title'	=>	'Chevron Down',
			'v3'	=>	'icon-chevron-down',
		),
		'fa-retweet'	=>	array(
			'title'	=>	'Retweet',
			'v3'	=>	'icon-retweet',
		),
		'fa-shopping-cart'	=>	array(
			'title'	=>	'Shopping Cart',
			'v3'	=>	'icon-shopping-cart',
		),
		'fa-folder'	=>	array(
			'title'	=>	'Folder',
			'v3'	=>	'icon-folder-close',
		),
		'fa-folder-open'	=>	array(
			'title'	=>	'Folder Open',
			'v3'	=>	'icon-folder-open',
		),
		'fa-arrows-v'	=>	array(
			'title'	=>	'Arrows V',
			'v3'	=>	'icon-resize-vertical',
		),
		'fa-arrows-h'	=>	array(
			'title'	=>	'Arrows H',
			'v3'	=>	'icon-resize-horizontal',
		),
		'fa-bar-chart-o'	=>	array(
			'title'	=>	'Bar Chart O',
			'v3'	=>	'icon-bar-chart',
		),
		'fa-twitter-square'	=>	array(
			'title'	=>	'Twitter Square',
			'v3'	=>	'icon-twitter-sign',
		),
		'fa-facebook-square'	=>	array(
			'title'	=>	'Facebook Square',
			'v3'	=>	'icon-facebook-sign',
		),
		'fa-camera-retro'	=>	array(
			'title'	=>	'Camera Retro',
			'v3'	=>	'icon-camera-retro',
		),
		'fa-key'	=>	array(
			'title'	=>	'Key',
			'v3'	=>	'icon-key',
		),
		'fa-cogs'	=>	array(
			'title'	=>	'Cogs',
			'v3'	=>	'icon-cogs',
		),
		'fa-comments'	=>	array(
			'title'	=>	'Comments',
			'v3'	=>	'icon-comments',
		),
		'fa-thumbs-o-up'	=>	array(
			'title'	=>	'Thumbs O Up',
			'v3'	=>	'icon-thumbs-up',
		),
		'fa-thumbs-o-down'	=>	array(
			'title'	=>	'Thumbs O Down',
			'v3'	=>	'icon-thumbs-down',
		),
		'fa-star-half'	=>	array(
			'title'	=>	'Star Half',
			'v3'	=>	'icon-star-half',
		),
		'fa-heart-o'	=>	array(
			'title'	=>	'Heart O',
			'v3'	=>	'icon-heart-empty',
		),
		'fa-sign-out'	=>	array(
			'title'	=>	'Sign Out',
			'v3'	=>	'icon-signout',
		),
		'fa-linkedin-square'	=>	array(
			'title'	=>	'Linkedin Square',
			'v3'	=>	'icon-linkedin-sign',
		),
		'fa-thumb-tack'	=>	array(
			'title'	=>	'Thumb Tack',
			'v3'	=>	'icon-pushpin',
		),
		'fa-external-link'	=>	array(
			'title'	=>	'External Link',
			'v3'	=>	'icon-external-link',
		),
		'fa-sign-in'	=>	array(
			'title'	=>	'Sign In',
			'v3'	=>	'icon-signin',
		),
		'fa-trophy'	=>	array(
			'title'	=>	'Trophy',
			'v3'	=>	'icon-trophy',
		),
		'fa-github-square'	=>	array(
			'title'	=>	'Github Square',
			'v3'	=>	'icon-github-sign',
		),
		'fa-upload'	=>	array(
			'title'	=>	'Upload',
			'v3'	=>	'icon-upload-alt',
		),
		'fa-lemon-o'	=>	array(
			'title'	=>	'Lemon O',
			'v3'	=>	'icon-lemon',
		),
		'fa-phone'	=>	array(
			'title'	=>	'Phone',
			'v3'	=>	'icon-phone',
		),
		'fa-square-o'	=>	array(
			'title'	=>	'Square O',
			'v3'	=>	'icon-check-empty',
		),
		'fa-bookmark-o'	=>	array(
			'title'	=>	'Bookmark O',
			'v3'	=>	'icon-bookmark-empty',
		),
		'fa-phone-square'	=>	array(
			'title'	=>	'Phone Square',
			'v3'	=>	'icon-phone-sign',
		),
		'fa-twitter'	=>	array(
			'title'	=>	'Twitter',
			'v3'	=>	'icon-twitter',
		),
		'fa-facebook'	=>	array(
			'title'	=>	'Facebook',
			'v3'	=>	'icon-facebook',
		),
		'fa-github'	=>	array(
			'title'	=>	'Github',
			'v3'	=>	'icon-github',
		),
		'fa-unlock'	=>	array(
			'title'	=>	'Unlock',
			'v3'	=>	'icon-unlock',
		),
		'fa-credit-card'	=>	array(
			'title'	=>	'Credit Card',
			'v3'	=>	'icon-credit-card',
		),
		'fa-rss'	=>	array(
			'title'	=>	'Rss',
			'v3'	=>	'icon-rss',
		),
		'fa-hdd-o'	=>	array(
			'title'	=>	'Hdd O',
			'v3'	=>	'icon-hdd',
		),
		'fa-bullhorn'	=>	array(
			'title'	=>	'Bullhorn',
			'v3'	=>	'icon-bullhorn',
		),
		'fa-bell'	=>	array(
			'title'	=>	'Bell',
			'v3'	=>	'icon-bell',
		),
		'fa-certificate'	=>	array(
			'title'	=>	'Certificate',
			'v3'	=>	'icon-certificate',
		),
		'fa-hand-o-right'	=>	array(
			'title'	=>	'Hand O Right',
			'v3'	=>	'icon-hand-right',
		),
		'fa-hand-o-left'	=>	array(
			'title'	=>	'Hand O Left',
			'v3'	=>	'icon-hand-left',
		),
		'fa-hand-o-up'	=>	array(
			'title'	=>	'Hand O Up',
			'v3'	=>	'icon-hand-up',
		),
		'fa-hand-o-down'	=>	array(
			'title'	=>	'Hand O Down',
			'v3'	=>	'icon-hand-down',
		),
		'fa-arrow-circle-left'	=>	array(
			'title'	=>	'Arrow Circle Left',
			'v3'	=>	'icon-circle-arrow-left',
		),
		'fa-arrow-circle-right'	=>	array(
			'title'	=>	'Arrow Circle Right',
			'v3'	=>	'icon-circle-arrow-right',
		),
		'fa-arrow-circle-up'	=>	array(
			'title'	=>	'Arrow Circle Up',
			'v3'	=>	'icon-circle-arrow-up',
		),
		'fa-arrow-circle-down'	=>	array(
			'title'	=>	'Arrow Circle Down',
			'v3'	=>	'icon-circle-arrow-down',
		),
		'fa-globe'	=>	array(
			'title'	=>	'Globe',
			'v3'	=>	'icon-globe',
		),
		'fa-wrench'	=>	array(
			'title'	=>	'Wrench',
			'v3'	=>	'icon-wrench',
		),
		'fa-tasks'	=>	array(
			'title'	=>	'Tasks',
			'v3'	=>	'icon-tasks',
		),
		'fa-filter'	=>	array(
			'title'	=>	'Filter',
			'v3'	=>	'icon-filter',
		),
		'fa-briefcase'	=>	array(
			'title'	=>	'Briefcase',
			'v3'	=>	'icon-briefcase',
		),
		'fa-arrows-alt'	=>	array(
			'title'	=>	'Arrows Alt',
			'v3'	=>	'icon-fullscreen',
		),
		'fa-users'	=>	array(
			'title'	=>	'Users',
			'v3'	=>	'icon-group',
		),
		'fa-link'	=>	array(
			'title'	=>	'Link',
			'v3'	=>	'icon-link',
		),
		'fa-cloud'	=>	array(
			'title'	=>	'Cloud',
			'v3'	=>	'icon-cloud',
		),
		'fa-flask'	=>	array(
			'title'	=>	'Flask',
			'v3'	=>	'icon-beaker',
		),
		'fa-scissors'	=>	array(
			'title'	=>	'Scissors',
			'v3'	=>	'icon-cut',
		),
		'fa-files-o'	=>	array(
			'title'	=>	'Files O',
			'v3'	=>	'icon-copy',
		),
		'fa-paperclip'	=>	array(
			'title'	=>	'Paperclip',
			'v3'	=>	'icon-paper-clip',
		),
		'fa-floppy-o'	=>	array(
			'title'	=>	'Floppy O',
			'v3'	=>	'icon-save',
		),
		'fa-square'	=>	array(
			'title'	=>	'Square',
			'v3'	=>	'icon-sign-blank',
		),
		'fa-bars'	=>	array(
			'title'	=>	'Bars',
			'v3'	=>	'icon-reorder',
		),
		'fa-list-ul'	=>	array(
			'title'	=>	'List Ul',
			'v3'	=>	'icon-list-ul',
		),
		'fa-list-ol'	=>	array(
			'title'	=>	'List Ol',
			'v3'	=>	'icon-list-ol',
		),
		'fa-strikethrough'	=>	array(
			'title'	=>	'Strikethrough',
			'v3'	=>	'icon-strikethrough',
		),
		'fa-underline'	=>	array(
			'title'	=>	'Underline',
			'v3'	=>	'icon-underline',
		),
		'fa-table'	=>	array(
			'title'	=>	'Table',
			'v3'	=>	'icon-table',
		),
		'fa-magic'	=>	array(
			'title'	=>	'Magic',
			'v3'	=>	'icon-magic',
		),
		'fa-truck'	=>	array(
			'title'	=>	'Truck',
			'v3'	=>	'icon-truck',
		),
		'fa-pinterest'	=>	array(
			'title'	=>	'Pinterest',
			'v3'	=>	'icon-pinterest',
		),
		'fa-pinterest-square'	=>	array(
			'title'	=>	'Pinterest Square',
			'v3'	=>	'icon-pinterest-sign',
		),
		'fa-google-plus-square'	=>	array(
			'title'	=>	'Google Plus Square',
			'v3'	=>	'icon-google-plus-sign',
		),
		'fa-google-plus'	=>	array(
			'title'	=>	'Google Plus',
			'v3'	=>	'icon-google-plus',
		),
		'fa-money'	=>	array(
			'title'	=>	'Money',
			'v3'	=>	'icon-money',
		),
		'fa-caret-down'	=>	array(
			'title'	=>	'Caret Down',
			'v3'	=>	'icon-caret-down',
		),
		'fa-caret-up'	=>	array(
			'title'	=>	'Caret Up',
			'v3'	=>	'icon-caret-up',
		),
		'fa-caret-left'	=>	array(
			'title'	=>	'Caret Left',
			'v3'	=>	'icon-caret-left',
		),
		'fa-caret-right'	=>	array(
			'title'	=>	'Caret Right',
			'v3'	=>	'icon-caret-right',
		),
		'fa-columns'	=>	array(
			'title'	=>	'Columns',
			'v3'	=>	'icon-columns',
		),
		'fa-sort'	=>	array(
			'title'	=>	'Sort',
			'v3'	=>	'icon-sort',
		),
		'fa-sort-asc'	=>	array(
			'title'	=>	'Sort Asc',
			'v3'	=>	'icon-sort-down',
		),
		'fa-sort-desc'	=>	array(
			'title'	=>	'Sort Desc',
			'v3'	=>	'icon-sort-up',
		),
		'fa-envelope'	=>	array(
			'title'	=>	'Envelope',
			'v3'	=>	'icon-envelope-alt',
		),
		'fa-linkedin'	=>	array(
			'title'	=>	'Linkedin',
			'v3'	=>	'icon-linkedin',
		),
		'fa-undo'	=>	array(
			'title'	=>	'Undo',
			'v3'	=>	'icon-undo',
		),
		'fa-gavel'	=>	array(
			'title'	=>	'Gavel',
			'v3'	=>	'icon-legal',
		),
		'fa-tachometer'	=>	array(
			'title'	=>	'Tachometer',
			'v3'	=>	'icon-dashboard',
		),
		'fa-comment-o'	=>	array(
			'title'	=>	'Comment O',
			'v3'	=>	'icon-comment-alt',
		),
		'fa-comments-o'	=>	array(
			'title'	=>	'Comments O',
			'v3'	=>	'icon-comments-alt',
		),
		'fa-bolt'	=>	array(
			'title'	=>	'Bolt',
			'v3'	=>	'icon-bolt',
		),
		'fa-sitemap'	=>	array(
			'title'	=>	'Sitemap',
			'v3'	=>	'icon-sitemap',
		),
		'fa-umbrella'	=>	array(
			'title'	=>	'Umbrella',
			'v3'	=>	'icon-umbrella',
		),
		'fa-clipboard'	=>	array(
			'title'	=>	'Clipboard',
			'v3'	=>	'icon-paste',
		),
		'fa-lightbulb-o'	=>	array(
			'title'	=>	'Lightbulb O',
			'v3'	=>	'icon-lightbulb',
		),
		'fa-exchange'	=>	array(
			'title'	=>	'Exchange',
			'v3'	=>	'icon-exchange',
		),
		'fa-cloud-download'	=>	array(
			'title'	=>	'Cloud Download',
			'v3'	=>	'icon-cloud-download',
		),
		'fa-cloud-upload'	=>	array(
			'title'	=>	'Cloud Upload',
			'v3'	=>	'icon-cloud-upload',
		),
		'fa-user-md'	=>	array(
			'title'	=>	'User Md',
			'v3'	=>	'icon-user-md',
		),
		'fa-stethoscope'	=>	array(
			'title'	=>	'Stethoscope',
			'v3'	=>	'icon-stethoscope',
		),
		'fa-suitcase'	=>	array(
			'title'	=>	'Suitcase',
			'v3'	=>	'icon-suitcase',
		),
		'fa-bell-o'	=>	array(
			'title'	=>	'Bell O',
			'v3'	=>	'icon-bell-alt',
		),
		'fa-coffee'	=>	array(
			'title'	=>	'Coffee',
			'v3'	=>	'icon-coffee',
		),
		'fa-cutlery'	=>	array(
			'title'	=>	'Cutlery',
			'v3'	=>	'icon-food',
		),
		'fa-file-text-o'	=>	array(
			'title'	=>	'File Text O',
			'v3'	=>	'icon-file-alt',
		),
		'fa-building-o'	=>	array(
			'title'	=>	'Building O',
			'v3'	=>	'icon-building',
		),
		'fa-hospital-o'	=>	array(
			'title'	=>	'Hospital O',
			'v3'	=>	'icon-hospital',
		),
		'fa-ambulance'	=>	array(
			'title'	=>	'Ambulance',
			'v3'	=>	'icon-ambulance',
		),
		'fa-medkit'	=>	array(
			'title'	=>	'Medkit',
			'v3'	=>	'icon-medkit',
		),
		'fa-fighter-jet'	=>	array(
			'title'	=>	'Fighter Jet',
			'v3'	=>	'icon-fighter-jet',
		),
		'fa-beer'	=>	array(
			'title'	=>	'Beer',
			'v3'	=>	'icon-beer',
		),
		'fa-h-square'	=>	array(
			'title'	=>	'H Square',
			'v3'	=>	'icon-h-sign',
		),
		'fa-plus-square'	=>	array(
			'title'	=>	'Plus Square',
			'v3'	=>	'icon-plus-sign-alt',
		),
		'fa-angle-double-left'	=>	array(
			'title'	=>	'Angle Double Left',
			'v3'	=>	'icon-double-angle-left',
		),
		'fa-angle-double-right'	=>	array(
			'title'	=>	'Angle Double Right',
			'v3'	=>	'icon-double-angle-right',
		),
		'fa-angle-double-up'	=>	array(
			'title'	=>	'Angle Double Up',
			'v3'	=>	'icon-double-angle-up',
		),
		'fa-angle-double-down'	=>	array(
			'title'	=>	'Angle Double Down',
			'v3'	=>	'icon-double-angle-down',
		),
		'fa-angle-left'	=>	array(
			'title'	=>	'Angle Left',
			'v3'	=>	'icon-angle-left',
		),
		'fa-angle-right'	=>	array(
			'title'	=>	'Angle Right',
			'v3'	=>	'icon-angle-right',
		),
		'fa-angle-up'	=>	array(
			'title'	=>	'Angle Up',
			'v3'	=>	'icon-angle-up',
		),
		'fa-angle-down'	=>	array(
			'title'	=>	'Angle Down',
			'v3'	=>	'icon-angle-down',
		),
		'fa-desktop'	=>	array(
			'title'	=>	'Desktop',
			'v3'	=>	'icon-desktop',
		),
		'fa-laptop'	=>	array(
			'title'	=>	'Laptop',
			'v3'	=>	'icon-laptop',
		),
		'fa-tablet'	=>	array(
			'title'	=>	'Tablet',
			'v3'	=>	'icon-tablet',
		),
		'fa-mobile'	=>	array(
			'title'	=>	'Mobile',
			'v3'	=>	'icon-mobile-phone',
		),
		'fa-circle-o'	=>	array(
			'title'	=>	'Circle O',
			'v3'	=>	'icon-circle-blank',
		),
		'fa-quote-left'	=>	array(
			'title'	=>	'Quote Left',
			'v3'	=>	'icon-quote-left',
		),
		'fa-quote-right'	=>	array(
			'title'	=>	'Quote Right',
			'v3'	=>	'icon-quote-right',
		),
		'fa-spinner'	=>	array(
			'title'	=>	'Spinner',
			'v3'	=>	'icon-spinner',
		),
		'fa-circle'	=>	array(
			'title'	=>	'Circle',
			'v3'	=>	'icon-circle',
		),
		'fa-reply'	=>	array(
			'title'	=>	'Reply',
			'v3'	=>	'icon-reply',
		),
		'fa-github-alt'	=>	array(
			'title'	=>	'Github Alt',
			'v3'	=>	'icon-github-alt',
		),
		'fa-folder-o'	=>	array(
			'title'	=>	'Folder O',
			'v3'	=>	'icon-folder-close-alt',
		),
		'fa-folder-open-o'	=>	array(
			'title'	=>	'Folder Open O',
			'v3'	=>	'icon-folder-open-alt',
		),
		'fa-smile-o'	=>	array(
			'title'	=>	'Smile O',
			'v3'	=>	'icon-smile',
		),
		'fa-frown-o'	=>	array(
			'title'	=>	'Frown O',
			'v3'	=>	'icon-frown',
		),
		'fa-meh-o'	=>	array(
			'title'	=>	'Meh O',
			'v3'	=>	'icon-meh',
		),
		'fa-gamepad'	=>	array(
			'title'	=>	'Gamepad',
			'v3'	=>	'icon-gamepad',
		),
		'fa-keyboard-o'	=>	array(
			'title'	=>	'Keyboard O',
			'v3'	=>	'icon-keyboard',
		),
		'fa-flag-o'	=>	array(
			'title'	=>	'Flag O',
			'v3'	=>	'icon-flag-alt',
		),
		'fa-flag-checkered'	=>	array(
			'title'	=>	'Flag Checkered',
			'v3'	=>	'icon-flag-checkered',
		),
		'fa-terminal'	=>	array(
			'title'	=>	'Terminal',
			'v3'	=>	'icon-terminal',
		),
		'fa-code'	=>	array(
			'title'	=>	'Code',
			'v3'	=>	'icon-code',
		),
		'fa-reply-all'	=>	array(
			'title'	=>	'Reply All',
			'v3'	=>	'icon-reply-all',
		),
		'fa-mail-reply-all'	=>	array(
			'title'	=>	'Mail Reply All',
			'v3'	=>	'icon-mail-reply-all',
		),
		'fa-star-half-o'	=>	array(
			'title'	=>	'Star Half O',
			'v3'	=>	'icon-star-half-full',
		),
		'fa-location-arrow'	=>	array(
			'title'	=>	'Location Arrow',
			'v3'	=>	'icon-location-arrow',
		),
		'fa-crop'	=>	array(
			'title'	=>	'Crop',
			'v3'	=>	'icon-crop',
		),
		'fa-code-fork'	=>	array(
			'title'	=>	'Code Fork',
			'v3'	=>	'icon-code-fork',
		),
		'fa-chain-broken'	=>	array(
			'title'	=>	'Chain Broken',
			'v3'	=>	'icon-unlink',
		),
		'fa-question'	=>	array(
			'title'	=>	'Question',
			'v3'	=>	'icon-question',
		),
		'fa-info'	=>	array(
			'title'	=>	'Info',
			'v3'	=>	'icon-info',
		),
		'fa-exclamation'	=>	array(
			'title'	=>	'Exclamation',
			'v3'	=>	'icon-exclamation',
		),
		'fa-superscript'	=>	array(
			'title'	=>	'Superscript',
			'v3'	=>	'icon-superscript',
		),
		'fa-subscript'	=>	array(
			'title'	=>	'Subscript',
			'v3'	=>	'icon-subscript',
		),
		'fa-eraser'	=>	array(
			'title'	=>	'Eraser',
			'v3'	=>	'icon-eraser',
		),
		'fa-puzzle-piece'	=>	array(
			'title'	=>	'Puzzle Piece',
			'v3'	=>	'icon-puzzle-piece',
		),
		'fa-microphone'	=>	array(
			'title'	=>	'Microphone',
			'v3'	=>	'icon-microphone',
		),
		'fa-microphone-slash'	=>	array(
			'title'	=>	'Microphone Slash',
			'v3'	=>	'icon-microphone-off',
		),
		'fa-shield'	=>	array(
			'title'	=>	'Shield',
			'v3'	=>	'icon-shield',
		),
		'fa-calendar-o'	=>	array(
			'title'	=>	'Calendar O',
			'v3'	=>	'icon-calendar-empty',
		),
		'fa-fire-extinguisher'	=>	array(
			'title'	=>	'Fire Extinguisher',
			'v3'	=>	'icon-fire-extinguisher',
		),
		'fa-rocket'	=>	array(
			'title'	=>	'Rocket',
			'v3'	=>	'icon-rocket',
		),
		'fa-maxcdn'	=>	array(
			'title'	=>	'Maxcdn',
			'v3'	=>	'icon-maxcdn',
		),
		'fa-chevron-circle-left'	=>	array(
			'title'	=>	'Chevron Circle Left',
			'v3'	=>	'icon-chevron-sign-left',
		),
		'fa-chevron-circle-right'	=>	array(
			'title'	=>	'Chevron Circle Right',
			'v3'	=>	'icon-chevron-sign-right',
		),
		'fa-chevron-circle-up'	=>	array(
			'title'	=>	'Chevron Circle Up',
			'v3'	=>	'icon-chevron-sign-up',
		),
		'fa-chevron-circle-down'	=>	array(
			'title'	=>	'Chevron Circle Down',
			'v3'	=>	'icon-chevron-sign-down',
		),
		'fa-html5'	=>	array(
			'title'	=>	'Html5',
			'v3'	=>	'icon-html5',
		),
		'fa-css3'	=>	array(
			'title'	=>	'Css3',
			'v3'	=>	'icon-css3',
		),
		'fa-anchor'	=>	array(
			'title'	=>	'Anchor',
			'v3'	=>	'icon-anchor',
		),
		'fa-unlock-alt'	=>	array(
			'title'	=>	'Unlock Alt',
			'v3'	=>	'icon-unlock-alt',
		),
		'fa-bullseye'	=>	array(
			'title'	=>	'Bullseye',
			'v3'	=>	'icon-bullseye',
		),
		'fa-ellipsis-h'	=>	array(
			'title'	=>	'Ellipsis H',
			'v3'	=>	'icon-ellipsis-horizontal',
		),
		'fa-ellipsis-v'	=>	array(
			'title'	=>	'Ellipsis V',
			'v3'	=>	'icon-ellipsis-vertical',
		),
		'fa-rss-square'	=>	array(
			'title'	=>	'Rss Square',
			'v3'	=>	'icon-rss-sign',
		),
		'fa-play-circle'	=>	array(
			'title'	=>	'Play Circle',
			'v3'	=>	'icon-play-sign',
		),
		'fa-ticket'	=>	array(
			'title'	=>	'Ticket',
			'v3'	=>	'icon-ticket',
		),
		'fa-minus-square'	=>	array(
			'title'	=>	'Minus Square',
			'v3'	=>	'icon-minus-sign-alt',
		),
		'fa-minus-square-o'	=>	array(
			'title'	=>	'Minus Square O',
			'v3'	=>	'icon-check-minus',
		),
		'fa-level-up'	=>	array(
			'title'	=>	'Level Up',
			'v3'	=>	'icon-level-up',
		),
		'fa-level-down'	=>	array(
			'title'	=>	'Level Down',
			'v3'	=>	'icon-level-down',
		),
		'fa-check-square'	=>	array(
			'title'	=>	'Check Square',
			'v3'	=>	'icon-check-sign',
		),
		'fa-pencil-square'	=>	array(
			'title'	=>	'Pencil Square',
			'v3'	=>	'icon-edit-sign',
		),
		'fa-external-link-square'	=>	array(
			'title'	=>	'External Link Square',
			'v3'	=>	'icon-external-link-sign',
		),
		'fa-share-square'	=>	array(
			'title'	=>	'Share Square',
			'v3'	=>	'icon-share-sign',
		),
		'fa-compass'	=>	array(
			'title'	=>	'Compass',
			'v3'	=>	'icon-compass',
		),
		'fa-caret-square-o-down'	=>	array(
			'title'	=>	'Caret Square O Down',
			'v3'	=>	'icon-collapse',
		),
		'fa-caret-square-o-up'	=>	array(
			'title'	=>	'Caret Square O Up',
			'v3'	=>	'icon-collapse-top',
		),
		'fa-caret-square-o-right'	=>	array(
			'title'	=>	'Caret Square O Right',
			'v3'	=>	'icon-expand',
		),
		'fa-eur'	=>	array(
			'title'	=>	'Eur',
			'v3'	=>	'icon-eur',
		),
		'fa-gbp'	=>	array(
			'title'	=>	'Gbp',
			'v3'	=>	'icon-gbp',
		),
		'fa-usd'	=>	array(
			'title'	=>	'Usd',
			'v3'	=>	'icon-usd',
		),
		'fa-inr'	=>	array(
			'title'	=>	'Inr',
			'v3'	=>	'icon-inr',
		),
		'fa-jpy'	=>	array(
			'title'	=>	'Jpy',
			'v3'	=>	'icon-jpy',
		),
		'fa-rub'	=>	array(
			'title'	=>	'Rub',
			'v3'	=>	'icon-cny',
		),
		'fa-krw'	=>	array(
			'title'	=>	'Krw',
			'v3'	=>	'icon-krw',
		),
		'fa-btc'	=>	array(
			'title'	=>	'Btc',
			'v3'	=>	'icon-btc',
		),
		'fa-file'	=>	array(
			'title'	=>	'File',
			'v3'	=>	'icon-file',
		),
		'fa-file-text'	=>	array(
			'title'	=>	'File Text',
			'v3'	=>	'icon-file-text',
		),
		'fa-sort-alpha-asc'	=>	array(
			'title'	=>	'Sort Alpha Asc',
			'v3'	=>	'icon-sort-by-alphabet',
		),
		'fa-sort-alpha-desc'	=>	array(
			'title'	=>	'Sort Alpha Desc',
			'v3'	=>	'icon-sort-by-alphabet-alt',
		),
		'fa-sort-amount-asc'	=>	array(
			'title'	=>	'Sort Amount Asc',
			'v3'	=>	'icon-sort-by-attributes',
		),
		'fa-sort-amount-desc'	=>	array(
			'title'	=>	'Sort Amount Desc',
			'v3'	=>	'icon-sort-by-attributes-alt',
		),
		'fa-sort-numeric-asc'	=>	array(
			'title'	=>	'Sort Numeric Asc',
			'v3'	=>	'icon-sort-by-order',
		),
		'fa-sort-numeric-desc'	=>	array(
			'title'	=>	'Sort Numeric Desc',
			'v3'	=>	'icon-sort-by-order-alt',
		),
		'fa-thumbs-up'	=>	array(
			'title'	=>	'Thumbs Up',
			'v3'	=>	'icon-thumbs-up',
		),
		'fa-thumbs-down'	=>	array(
			'title'	=>	'Thumbs Down',
			'v3'	=>	'icon-thumbs-down',
		),
		'fa-youtube-square'	=>	array(
			'title'	=>	'Youtube Square',
			'v3'	=>	'icon-youtube-sign',
		),
		'fa-youtube'	=>	array(
			'title'	=>	'Youtube',
			'v3'	=>	'icon-youtube',
		),
		'fa-xing'	=>	array(
			'title'	=>	'Xing',
			'v3'	=>	'icon-xing',
		),
		'fa-xing-square'	=>	array(
			'title'	=>	'Xing Square',
			'v3'	=>	'icon-xing-sign',
		),
		'fa-youtube-play'	=>	array(
			'title'	=>	'Youtube Play',
			'v3'	=>	'icon-youtube-play',
		),
		'fa-dropbox'	=>	array(
			'title'	=>	'Dropbox',
			'v3'	=>	'icon-dropbox',
		),
		'fa-stack-overflow'	=>	array(
			'title'	=>	'Stack Overflow',
			'v3'	=>	'icon-stackexchange',
		),
		'fa-instagram'	=>	array(
			'title'	=>	'Instagram',
			'v3'	=>	'icon-instagram',
		),
		'fa-flickr'	=>	array(
			'title'	=>	'Flickr',
			'v3'	=>	'icon-flickr',
		),
		'fa-adn'	=>	array(
			'title'	=>	'Adn',
			'v3'	=>	'icon-adn',
		),
		'fa-bitbucket'	=>	array(
			'title'	=>	'Bitbucket',
			'v3'	=>	'icon-bitbucket',
		),
		'fa-bitbucket-square'	=>	array(
			'title'	=>	'Bitbucket Square',
			'v3'	=>	'icon-bitbucket-sign',
		),
		'fa-tumblr'	=>	array(
			'title'	=>	'Tumblr',
			'v3'	=>	'icon-tumblr',
		),
		'fa-tumblr-square'	=>	array(
			'title'	=>	'Tumblr Square',
			'v3'	=>	'icon-tumblr-sign',
		),
		'fa-long-arrow-down'	=>	array(
			'title'	=>	'Long Arrow Down',
			'v3'	=>	'icon-long-arrow-down',
		),
		'fa-long-arrow-up'	=>	array(
			'title'	=>	'Long Arrow Up',
			'v3'	=>	'icon-long-arrow-up',
		),
		'fa-long-arrow-left'	=>	array(
			'title'	=>	'Long Arrow Left',
			'v3'	=>	'icon-long-arrow-left',
		),
		'fa-long-arrow-right'	=>	array(
			'title'	=>	'Long Arrow Right',
			'v3'	=>	'icon-long-arrow-right',
		),
		'fa-apple'	=>	array(
			'title'	=>	'Apple',
			'v3'	=>	'icon-apple',
		),
		'fa-windows'	=>	array(
			'title'	=>	'Windows',
			'v3'	=>	'icon-windows',
		),
		'fa-android'	=>	array(
			'title'	=>	'Android',
			'v3'	=>	'icon-android',
		),
		'fa-linux'	=>	array(
			'title'	=>	'Linux',
			'v3'	=>	'icon-linux',
		),
		'fa-dribbble'	=>	array(
			'title'	=>	'Dribbble',
			'v3'	=>	'icon-dribbble',
		),
		'fa-skype'	=>	array(
			'title'	=>	'Skype',
			'v3'	=>	'icon-skype',
		),
		'fa-foursquare'	=>	array(
			'title'	=>	'Foursquare',
			'v3'	=>	'icon-foursquare',
		),
		'fa-trello'	=>	array(
			'title'	=>	'Trello',
			'v3'	=>	'icon-trello',
		),
		'fa-female'	=>	array(
			'title'	=>	'Female',
			'v3'	=>	'icon-female',
		),
		'fa-male'	=>	array(
			'title'	=>	'Male',
			'v3'	=>	'icon-male',
		),
		'fa-gittip'	=>	array(
			'title'	=>	'Gittip',
			'v3'	=>	'icon-gittip',
		),
		'fa-sun-o'	=>	array(
			'title'	=>	'Sun O',
			'v3'	=>	'icon-sun',
		),
		'fa-moon-o'	=>	array(
			'title'	=>	'Moon O',
			'v3'	=>	'icon-moon',
		),
		'fa-archive'	=>	array(
			'title'	=>	'Archive',
			'v3'	=>	'icon-archive',
		),
		'fa-bug'	=>	array(
			'title'	=>	'Bug',
			'v3'	=>	'icon-bug',
		),
		'fa-vk'	=>	array(
			'title'	=>	'Vk',
			'v3'	=>	'icon-vk',
		),
		'fa-weibo'	=>	array(
			'title'	=>	'Weibo',
			'v3'	=>	'icon-weibo',
		),
		'fa-renren'	=>	array(
			'title'	=>	'Renren',
			'v3'	=>	'icon-renren',
		),
		'fa-pagelines'	=>	array(
			'title'	=>	'Pagelines',
			'v3'	=>	'',
		),
		'fa-stack-exchange'	=>	array(
			'title'	=>	'Stack Exchange',
			'v3'	=>	'',
		),
		'fa-arrow-circle-o-right'	=>	array(
			'title'	=>	'Arrow Circle O Right',
			'v3'	=>	'',
		),
		'fa-arrow-circle-o-left'	=>	array(
			'title'	=>	'Arrow Circle O Left',
			'v3'	=>	'',
		),
		'fa-caret-square-o-left'	=>	array(
			'title'	=>	'Caret Square O Left',
			'v3'	=>	'',
		),
		'fa-dot-circle-o'	=>	array(
			'title'	=>	'Dot Circle O',
			'v3'	=>	'',
		),
		'fa-wheelchair'	=>	array(
			'title'	=>	'Wheelchair',
			'v3'	=>	'',
		),
		'fa-vimeo-square'	=>	array(
			'title'	=>	'Vimeo Square',
			'v3'	=>	'',
		),
		'fa-try'	=>	array(
			'title'	=>	'Try',
			'v3'	=>	'',
		),
		'fa-plus-square-o'	=>	array(
			'title'	=>	'Plus Square O',
			'v3'	=>	'',
		),


		//4.1
		'fa-automobile'	=>	array(
			'title'	=>	'Automobile',
		),
		'fa-bank'	=>	array(
			'title'	=>	'Bank',
		),
		'fa-behance'	=>	array(
			'title'	=>	'Behance',
		),
		'fa-behance-square'	=>	array(
			'title'	=>	'Behance square',
		),
		'fa-bomb'	=>	array(
			'title'	=>	'Bomb',
		),
		'fa-building'	=>	array(
			'title'	=>	'Building',
		),
		'fa-cab'	=>	array(
			'title'	=>	'Cab',
		),
		'fa-car'	=>	array(
			'title'	=>	'Car',
		),
		'fa-child'	=>	array(
			'title'	=>	'Child',
		),
		'fa-circle-o-notch'	=>	array(
			'title'	=>	'Circle o-notch',
		),
		'fa-circle-thin'	=>	array(
			'title'	=>	'Circle thin',
		),
		'fa-codepen'	=>	array(
			'title'	=>	'Codepen',
		),
		'fa-cube'	=>	array(
			'title'	=>	'Cube',
		),
		'fa-cubes'	=>	array(
			'title'	=>	'Cubes',
		),
		'fa-database'	=>	array(
			'title'	=>	'Database',
		),
		'fa-delicious'	=>	array(
			'title'	=>	'Delicious',
		),
		'fa-deviantart'	=>	array(
			'title'	=>	'Deviantart',
		),
		'fa-digg'	=>	array(
			'title'	=>	'Digg',
		),
		'fa-drupal'	=>	array(
			'title'	=>	'Drupal',
		),
		'fa-empire'	=>	array(
			'title'	=>	'Empire',
		),
		'fa-envelope-square'	=>	array(
			'title'	=>	'Envelope square',
		),
		'fa-fax'	=>	array(
			'title'	=>	'Fax',
		),
		'fa-file-archive-o'	=>	array(
			'title'	=>	'File archive-o',
		),
		'fa-file-audio-o'	=>	array(
			'title'	=>	'File audio-o',
		),
		'fa-file-code-o'	=>	array(
			'title'	=>	'File code-o',
		),
		'fa-file-excel-o'	=>	array(
			'title'	=>	'File excel-o',
		),
		'fa-file-image-o'	=>	array(
			'title'	=>	'File image-o',
		),
		'fa-file-movie-o'	=>	array(
			'title'	=>	'File movie-o',
		),
		'fa-file-pdf-o'	=>	array(
			'title'	=>	'File pdf-o',
		),
		'fa-file-photo-o'	=>	array(
			'title'	=>	'File photo-o',
		),
		'fa-file-picture-o'	=>	array(
			'title'	=>	'File picture-o',
		),
		'fa-file-powerpoint-o'	=>	array(
			'title'	=>	'File powerpoint-o',
		),
		'fa-file-sound-o'	=>	array(
			'title'	=>	'File sound-o',
		),
		'fa-file-video-o'	=>	array(
			'title'	=>	'File video-o',
		),
		'fa-file-word-o'	=>	array(
			'title'	=>	'File word-o',
		),
		'fa-file-zip-o'	=>	array(
			'title'	=>	'File zip-o',
		),
		'fa-ge'	=>	array(
			'title'	=>	'Ge',
		),
		'fa-git'	=>	array(
			'title'	=>	'Git',
		),
		'fa-git-square'	=>	array(
			'title'	=>	'Git square',
		),
		'fa-google'	=>	array(
			'title'	=>	'Google',
		),
		'fa-graduation-cap'	=>	array(
			'title'	=>	'Graduation cap',
		),
		'fa-hacker-news'	=>	array(
			'title'	=>	'Hacker news',
		),
		'fa-header'	=>	array(
			'title'	=>	'Header',
		),
		'fa-history'	=>	array(
			'title'	=>	'History',
		),
		'fa-institution'	=>	array(
			'title'	=>	'Institution',
		),
		'fa-joomla'	=>	array(
			'title'	=>	'Joomla',
		),
		'fa-jsfiddle'	=>	array(
			'title'	=>	'Jsfiddle',
		),
		'fa-language'	=>	array(
			'title'	=>	'Language',
		),
		'fa-life-bouy'	=>	array(
			'title'	=>	'Life bouy',
		),
		'fa-life-ring'	=>	array(
			'title'	=>	'Life ring',
		),
		'fa-life-saver'	=>	array(
			'title'	=>	'Life saver',
		),
		'fa-mortar-board'	=>	array(
			'title'	=>	'Mortar board',
		),
		'fa-openid'	=>	array(
			'title'	=>	'Openid',
		),
		'fa-paper-plane'	=>	array(
			'title'	=>	'Paper plane',
		),
		'fa-paper-plane-o'	=>	array(
			'title'	=>	'Paper plane-o',
		),
		'fa-paragraph'	=>	array(
			'title'	=>	'Paragraph',
		),
		'fa-paw'	=>	array(
			'title'	=>	'Paw',
		),
		'fa-pied-piper'	=>	array(
			'title'	=>	'Pied piper',
		),
		'fa-pied-piper-alt'	=>	array(
			'title'	=>	'Pied piper-alt',
		),
		'fa-pied-piper-square'	=>	array(
			'title'	=>	'Pied piper-square',
		),
		'fa-qq'	=>	array(
			'title'	=>	'Qq',
		),
		'fa-ra'	=>	array(
			'title'	=>	'Ra',
		),
		'fa-rebel'	=>	array(
			'title'	=>	'Rebel',
		),
		'fa-recycle'	=>	array(
			'title'	=>	'Recycle',
		),
		'fa-reddit'	=>	array(
			'title'	=>	'Reddit',
		),
		'fa-reddit-square'	=>	array(
			'title'	=>	'Reddit square',
		),
		'fa-send'	=>	array(
			'title'	=>	'Send',
		),
		'fa-send-o'	=>	array(
			'title'	=>	'Send o',
		),
		'fa-share-alt'	=>	array(
			'title'	=>	'Share alt',
		),
		'fa-share-alt-square'	=>	array(
			'title'	=>	'Share alt-square',
		),
		'fa-slack'	=>	array(
			'title'	=>	'Slack',
		),
		'fa-sliders'	=>	array(
			'title'	=>	'Sliders',
		),
		'fa-soundcloud'	=>	array(
			'title'	=>	'Soundcloud',
		),
		'fa-space-shuttle'	=>	array(
			'title'	=>	'Space shuttle',
		),
		'fa-spoon'	=>	array(
			'title'	=>	'Spoon',
		),
		'fa-spotify'	=>	array(
			'title'	=>	'Spotify',
		),
		'fa-steam'	=>	array(
			'title'	=>	'Steam',
		),
		'fa-steam-square'	=>	array(
			'title'	=>	'Steam square',
		),
		'fa-stumbleupon'	=>	array(
			'title'	=>	'Stumbleupon',
		),
		'fa-stumbleupon-circle'	=>	array(
			'title'	=>	'Stumbleupon circle',
		),
		'fa-support'	=>	array(
			'title'	=>	'Support',
		),
		'fa-taxi'	=>	array(
			'title'	=>	'Taxi',
		),
		'fa-tencent-weibo'	=>	array(
			'title'	=>	'Tencent weibo',
		),
		'fa-tree'	=>	array(
			'title'	=>	'Tree',
		),
		'fa-university'	=>	array(
			'title'	=>	'University',
		),
		'fa-vine'	=>	array(
			'title'	=>	'Vine',
		),
		'fa-wechat'	=>	array(
			'title'	=>	'Wechat',
		),
		'fa-weixin'	=>	array(
			'title'	=>	'Weixin',
		),
		'fa-wordpress'	=>	array(
			'title'	=>	'Wordpress',
		),
		'fa-yahoo'	=>	array(
			'title'	=>	'Yahoo',
		),




		//4.2
		'fa-angellist' => array(
			'title' => 'Angellist',
		),
		'fa-area-chart' => array(
			'title' => 'Area-chart',
		),
		'fa-at' => array(
			'title' => 'At',
		),
		'fa-bell-slash' => array(
			'title' => 'Bell-slash',
		),
		'fa-bell-slash-o' => array(
			'title' => 'Bell-slash-o',
		),
		'fa-bicycle' => array(
			'title' => 'Bicycle',
		),
		'fa-binoculars' => array(
			'title' => 'Binoculars',
		),
		'fa-birthday-cake' => array(
			'title' => 'Birthday-cake',
		),
		'fa-bus' => array(
			'title' => 'Bus',
		),
		'fa-calculator' => array(
			'title' => 'Calculator',
		),
		'fa-cc' => array(
			'title' => 'Cc',
		),
		'fa-cc-amex' => array(
			'title' => 'Cc-amex',
		),
		'fa-cc-discover' => array(
			'title' => 'Cc-discover',
		),
		'fa-cc-mastercard' => array(
			'title' => 'Cc-mastercard',
		),
		'fa-cc-paypal' => array(
			'title' => 'Cc-paypal',
		),
		'fa-cc-stripe' => array(
			'title' => 'Cc-stripe',
		),
		'fa-cc-visa' => array(
			'title' => 'Cc-visa',
		),
		'fa-copyright' => array(
			'title' => 'Copyright',
		),
		'fa-eyedropper' => array(
			'title' => 'Eyedropper',
		),
		'fa-futbol-o' => array(
			'title' => 'Futbol-o',
		),
		'fa-google-wallet' => array(
			'title' => 'Google-wallet',
		),
		'fa-ils' => array(
			'title' => 'Ils',
		),
		'fa-ioxhost' => array(
			'title' => 'Ioxhost',
		),
		'fa-lastfm' => array(
			'title' => 'Lastfm',
		),
		'fa-lastfm-square' => array(
			'title' => 'Lastfm-square',
		),
		'fa-line-chart' => array(
			'title' => 'Line-chart',
		),
		'fa-meanpath' => array(
			'title' => 'Meanpath',
		),
		'fa-newspaper-o' => array(
			'title' => 'Newspaper-o',
		),
		'fa-paint-brush' => array(
			'title' => 'Paint-brush',
		),
		'fa-paypal' => array(
			'title' => 'Paypal',
		),
		'fa-pie-chart' => array(
			'title' => 'Pie-chart',
		),
		'fa-plug' => array(
			'title' => 'Plug',
		),
		'fa-shekel' => array(
			'title' => 'Shekel',
		),
		'fa-sheqel' => array(
			'title' => 'Sheqel',
		),
		'fa-slideshare' => array(
			'title' => 'Slideshare',
		),
		'fa-soccer-ball-o' => array(
			'title' => 'Soccer-ball-o',
		),
		'fa-toggle-off' => array(
			'title' => 'Toggle-off',
		),
		'fa-toggle-on' => array(
			'title' => 'Toggle-on',
		),
		'fa-trash' => array(
			'title' => 'Trash',
		),
		'fa-tty' => array(
			'title' => 'Tty',
		),
		'fa-twitch' => array(
			'title' => 'Twitch',
		),
		'fa-wifi' => array(
			'title' => 'Wifi',
		),
		'fa-yelp' => array(
			'title' => 'Yelp',
		),







		//4.3
		'fa-bed' => array(
			'title' => 'Bed',
		),
		'fa-buysellads' => array(
			'title' => 'Buysellads',
		),
		'fa-cart-arrow-down' => array(
			'title' => 'Cart-arrow-down',
		),
		'fa-cart-plus' => array(
			'title' => 'Cart-plus',
		),
		'fa-connectdevelop' => array(
			'title' => 'Connectdevelop',
		),
		'fa-dashcube' => array(
			'title' => 'Dashcube',
		),
		'fa-diamond' => array(
			'title' => 'Diamond',
		),
		'fa-facebook-official' => array(
			'title' => 'Facebook-official',
		),
		'fa-forumbee' => array(
			'title' => 'Forumbee',
		),
		'fa-heartbeat' => array(
			'title' => 'Heartbeat',
		),
		'fa-hotel' => array(
			'title' => 'Hotel',
		),
		'fa-leanpub' => array(
			'title' => 'Leanpub',
		),
		'fa-mars' => array(
			'title' => 'Mars',
		),
		'fa-mars-double' => array(
			'title' => 'Mars-double',
		),
		'fa-mars-stroke' => array(
			'title' => 'Mars-stroke',
		),
		'fa-mars-stroke-h' => array(
			'title' => 'Mars-stroke-h',
		),
		'fa-mars-stroke-v' => array(
			'title' => 'Mars-stroke-v',
		),
		'fa-medium' => array(
			'title' => 'Medium',
		),
		'fa-mercury' => array(
			'title' => 'Mercury',
		),
		'fa-motorcycle' => array(
			'title' => 'Motorcycle',
		),
		'fa-neuter' => array(
			'title' => 'Neuter',
		),
		'fa-pinterest-p' => array(
			'title' => 'Pinterest-p',
		),
		'fa-sellsy' => array(
			'title' => 'Sellsy',
		),
		'fa-server' => array(
			'title' => 'Server',
		),
		'fa-ship' => array(
			'title' => 'Ship',
		),
		'fa-shirtsinbulk' => array(
			'title' => 'Shirtsinbulk',
		),
		'fa-simplybuilt' => array(
			'title' => 'Simplybuilt',
		),
		'fa-skyatlas' => array(
			'title' => 'Skyatlas',
		),
		'fa-street-view' => array(
			'title' => 'Street-view',
		),
		'fa-subway' => array(
			'title' => 'Subway',
		),
		'fa-train' => array(
			'title' => 'Train',
		),
		'fa-transgender' => array(
			'title' => 'Transgender',
		),
		'fa-transgender-alt' => array(
			'title' => 'Transgender-alt',
		),
		'fa-user-plus' => array(
			'title' => 'User-plus',
		),
		'fa-user-secret' => array(
			'title' => 'User-secret',
		),
		'fa-user-times' => array(
			'title' => 'User-times',
		),
		'fa-venus' => array(
			'title' => 'Venus',
		),
		'fa-venus-double' => array(
			'title' => 'Venus-double',
		),
		'fa-venus-mars' => array(
			'title' => 'Venus-mars',
		),
		'fa-viacoin' => array(
			'title' => 'Viacoin',
		),
		'fa-whatsapp' => array(
			'title' => 'Whatsapp',
		),



		//4.4
		'fa-500px' => array(
			'title' => '500px', 
		),
		'fa-amazon' => array(
			'title' => 'Amazon', 
		),
		'fa-balance-scale' => array(
			'title' => 'Balance-scale', 
		),
		'fa-battery-0' => array(
			'title' => 'Battery-0', 
		),
		'fa-battery-1' => array(
			'title' => 'Battery-1', 
		),
		'fa-battery-2' => array(
			'title' => 'Battery-2', 
		),
		'fa-battery-3' => array(
			'title' => 'Battery-3', 
		),
		'fa-battery-4' => array(
			'title' => 'Battery-4', 
		),
		'fa-battery-empty' => array(
			'title' => 'Battery-empty', 
		),
		'fa-battery-full' => array(
			'title' => 'Battery-full', 
		),
		'fa-battery-half' => array(
			'title' => 'Battery-half', 
		),
		'fa-battery-quarter' => array(
			'title' => 'Battery-quarter', 
		),
		'fa-battery-three-quarters' => array(
			'title' => 'Battery-three-quarters', 
		),
		'fa-black-tie' => array(
			'title' => 'Black-tie', 
		),
		'fa-calendar-check-o' => array(
			'title' => 'Calendar-check-o', 
		),
		'fa-calendar-minus-o' => array(
			'title' => 'Calendar-minus-o', 
		),
		'fa-calendar-plus-o' => array(
			'title' => 'Calendar-plus-o', 
		),
		'fa-calendar-times-o' => array(
			'title' => 'Calendar-times-o', 
		),
		'fa-cc-diners-club' => array(
			'title' => 'Cc-diners-club', 
		),
		'fa-cc-jcb' => array(
			'title' => 'Cc-jcb', 
		),
		'fa-chrome' => array(
			'title' => 'Chrome', 
		),
		'fa-clone' => array(
			'title' => 'Clone', 
		),
		'fa-commenting' => array(
			'title' => 'Commenting', 
		),
		'fa-commenting-o' => array(
			'title' => 'Commenting-o', 
		),
		'fa-contao' => array(
			'title' => 'Contao', 
		),
		'fa-creative-commons' => array(
			'title' => 'Creative-commons', 
		),
		'fa-expeditedssl' => array(
			'title' => 'Expeditedssl', 
		),
		'fa-firefox' => array(
			'title' => 'Firefox', 
		),
		'fa-fonticons' => array(
			'title' => 'Fonticons', 
		),
		'fa-genderless' => array(
			'title' => 'Genderless', 
		),
		'fa-get-pocket' => array(
			'title' => 'Get-pocket', 
		),
		'fa-gg' => array(
			'title' => 'Gg', 
		),
		'fa-gg-circle' => array(
			'title' => 'Gg-circle', 
		),
		'fa-hand-grab-o' => array(
			'title' => 'Hand-grab-o', 
		),
		'fa-hand-lizard-o' => array(
			'title' => 'Hand-lizard-o', 
		),
		'fa-hand-paper-o' => array(
			'title' => 'Hand-paper-o', 
		),
		'fa-hand-peace-o' => array(
			'title' => 'Hand-peace-o', 
		),
		'fa-hand-pointer-o' => array(
			'title' => 'Hand-pointer-o', 
		),
		'fa-hand-rock-o' => array(
			'title' => 'Hand-rock-o', 
		),
		'fa-hand-scissors-o' => array(
			'title' => 'Hand-scissors-o', 
		),
		'fa-hand-spock-o' => array(
			'title' => 'Hand-spock-o', 
		),
		'fa-hand-stop-o' => array(
			'title' => 'Hand-stop-o', 
		),
		'fa-hourglass' => array(
			'title' => 'Hourglass', 
		),
		'fa-hourglass-1' => array(
			'title' => 'Hourglass-1', 
		),
		'fa-hourglass-2' => array(
			'title' => 'Hourglass-2', 
		),
		'fa-hourglass-3' => array(
			'title' => 'Hourglass-3', 
		),
		'fa-hourglass-end' => array(
			'title' => 'Hourglass-end', 
		),
		'fa-hourglass-half' => array(
			'title' => 'Hourglass-half', 
		),
		'fa-hourglass-o' => array(
			'title' => 'Hourglass-o', 
		),
		'fa-hourglass-start' => array(
			'title' => 'Hourglass-start', 
		),
		'fa-houzz' => array(
			'title' => 'Houzz', 
		),
		'fa-i-cursor' => array(
			'title' => 'I-cursor', 
		),
		'fa-industry' => array(
			'title' => 'Industry', 
		),
		'fa-internet-explorer' => array(
			'title' => 'Internet-explorer', 
		),
		'fa-map' => array(
			'title' => 'Map', 
		),
		'fa-map-o' => array(
			'title' => 'Map-o', 
		),
		'fa-map-pin' => array(
			'title' => 'Map-pin', 
		),
		'fa-map-signs' => array(
			'title' => 'Map-signs', 
		),
		'fa-mouse-pointer' => array(
			'title' => 'Mouse-pointer', 
		),
		'fa-object-group' => array(
			'title' => 'Object-group', 
		),
		'fa-object-ungroup' => array(
			'title' => 'Object-ungroup', 
		),
		'fa-odnoklassniki' => array(
			'title' => 'Odnoklassniki', 
		),
		'fa-odnoklassniki-square' => array(
			'title' => 'Odnoklassniki-square', 
		),
		'fa-opencart' => array(
			'title' => 'Opencart', 
		),
		'fa-opera' => array(
			'title' => 'Opera', 
		),
		'fa-optin-monster' => array(
			'title' => 'Optin-monster', 
		),
		'fa-registered' => array(
			'title' => 'Registered', 
		),
		'fa-safari' => array(
			'title' => 'Safari', 
		),
		'fa-sticky-note' => array(
			'title' => 'Sticky-note', 
		),
		'fa-sticky-note-o' => array(
			'title' => 'Sticky-note-o', 
		),
		'fa-television' => array(
			'title' => 'Television', 
		),
		'fa-trademark' => array(
			'title' => 'Trademark', 
		),
		'fa-tripadvisor' => array(
			'title' => 'Tripadvisor', 
		),
		'fa-tv' => array(
			'title' => 'Tv', 
		),
		'fa-vimeo' => array(
			'title' => 'Vimeo', 
		),
		'fa-wikipedia-w' => array(
			'title' => 'Wikipedia-w', 
		),
		'fa-y-combinator' => array(
			'title' => 'Y-combinator', 
		),
		'fa-yc' => array(
			'title' => 'Yc', 
		),




		//4.5.0
		'fa-bluetooth' => array(
			'title' => 'Bluetooth', 
		),
		'fa-bluetooth-b' => array(
			'title' => 'Bluetooth-b', 
		),
		'fa-codiepie' => array(
			'title' => 'Codiepie', 
		),
		'fa-credit-card-alt' => array(
			'title' => 'Credit-card-alt', 
		),
		'fa-edge' => array(
			'title' => 'Edge', 
		),
		'fa-fort-awesome' => array(
			'title' => 'Fort-awesome', 
		),
		'fa-hashtag' => array(
			'title' => 'Hashtag', 
		),
		'fa-mixcloud' => array(
			'title' => 'Mixcloud', 
		),
		'fa-modx' => array(
			'title' => 'Modx', 
		),
		'fa-pause-circle' => array(
			'title' => 'Pause-circle', 
		),
		'fa-pause-circle-o' => array(
			'title' => 'Pause-circle-o', 
		),
		'fa-percent' => array(
			'title' => 'Percent', 
		),
		'fa-product-hunt' => array(
			'title' => 'Product-hunt', 
		),
		'fa-reddit-alien' => array(
			'title' => 'Reddit-alien', 
		),
		'fa-scribd' => array(
			'title' => 'Scribd', 
		),
		'fa-shopping-bag' => array(
			'title' => 'Shopping-bag', 
		),
		'fa-shopping-basket' => array(
			'title' => 'Shopping-basket', 
		),
		'fa-stop-circle' => array(
			'title' => 'Stop-circle', 
		),
		'fa-stop-circle-o' => array(
			'title' => 'Stop-circle-o', 
		),
		'fa-usb' => array(
			'title' => 'USB', 
		),


	);

	return $icons;
}
