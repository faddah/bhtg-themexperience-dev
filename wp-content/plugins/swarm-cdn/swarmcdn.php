<?php
/*
Plugin Name: Swarmify (formerly Swarm CDN)
Plugin URI: http://swarmify.com
Description: Swarmify is the first peer-to-peer content delivery network using WebRTC. This WordPress plugin, in conjunction with a Swarmify account, will greatly simplify the process of getting Swarmify set up on your WordPress site.
Version: 0.4.1
License: AGPL-3.0
*/

define('SCDNPLUGINOPTIONS_ID', 'scdn-plugin-settings');
define('SCDN_VERSION', '0.4.0');
define('SCDN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SCDN_PLUGIN_DIR', dirname(__FILE__));
define('SCDN_PLUGIN_FILE', plugin_basename(__FILE__));
define('SCDN_IFRAME_FILE', 'swarmcdniframe.html');

// Global variable to manage states.
$scdn_global = array();

require_once dirname(__FILE__) . '/swarmcdn-admin.php';
require_once dirname(__FILE__) . '/swarmcdn-media.php';
require_once dirname(__FILE__) . '/swarmcdn-shortcode.php';

class SwarmCDN
{
	public static function wp_head()
	{
		ob_start(array('SwarmCDN', 'inject_content'));
	}

	public static function wp_footer()
	{
		ob_end_flush();
	}

	public static function get_settings()
	{
		if(!function_exists('is_plugin_active_for_network'))
		{
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		$scdn_enabled = get_option('scdn_enabled', is_multisite() && is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ) ? 'network' : 'on');
		$scdn_api_key = get_option('scdn_api_key', '');
		$scdn_video_scan = get_option('scdn_video_scan', '');
		$scdn_advanced_parameters = get_option('scdn_advanced_parameters', '');
		$scdn_buffering_enabled = get_option('scdn_buffering_enabled', '');

		if($scdn_enabled == 'network' && is_multisite() && is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ))
		{
			$scdn_enabled = get_site_option('scdn_enabled', 'on');
			$scdn_api_key = get_site_option('scdn_api_key', '');
			$scdn_video_scan = get_site_option('scdn_video_scan', '');
			$scdn_advanced_parameters = get_site_option('scdn_advanced_parameters', '');
			$scdn_buffering_enabled = get_site_option('scdn_buffering_enabled', '');
		}

		return array(
			'scdn_enabled' => $scdn_enabled,
			'scdn_api_key' => $scdn_api_key,
			'scdn_video_scan' => $scdn_video_scan,
			'scdn_advanced_parameters' => $scdn_advanced_parameters,
			'scdn_buffering_enabled' => $scdn_buffering_enabled
		);
	}

	public static function inject_content($content)
	{
		$settings = SwarmCDN::get_settings();
		$upload_dir = wp_upload_dir();

		if($settings['scdn_enabled'] == 'on' && $settings['scdn_api_key'] != '')
		{
			$filtered = SwarmCDN::image_tag_filter($content);
			$filtered = SwarmCDN::shortcode_filter($filtered);
			$script = '
				<script data-cfasync="false">
					var swarmcdnkey="'. $settings['scdn_api_key'] .'";
					var swarmvideoscan='. ($settings['scdn_video_scan'] === "on" ? "true" : "false") .';
					var swarmimagescan=false;
					var swarmiframe="' . trailingslashit(preg_replace('/^https?:\/\/[^\/]+/', '', $upload_dir['baseurl'])) . SCDN_IFRAME_FILE .'";
					' .$settings['scdn_advanced_parameters'] .'
				</script>
				<script data-cfasync="false" src="//assets.swarmcdn.com/swarmdetect.js"></script>
			';
			return $script.$filtered;
		}
		else
		{
			return $content;
		}
	}

	public static function the_posts($the_posts)
	{
		$settings = SwarmCDN::get_settings();

		if($settings['scdn_enabled'] == 'on' && $settings['scdn_api_key'] != '')
		{
			foreach($the_posts as $key => $post)
			{
				if(property_exists($post, "post_content"))
				{
					$content = $post->post_content;
					if(!is_null($content))
					{
						$post->post_content = SwarmCDN::filter_content($content);
					}
				}
			}
		}

		return $the_posts;
	}

	public static function the_content($content)
	{
		return SwarmCDN::filter_content($content);
	}

	public static function filter_content($content)
	{
		$filtered = SwarmCDN::image_tag_filter($content);
		$filtered = SwarmCDN::shortcode_filter($filtered);

		return $filtered;
	}

	public static function shortcode_filter($content)
	{
		return preg_replace_callback('/(.?)\[(swarmvideo)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', array("SwarmCDN_Shortcode", "tag_parser"), $content);
	}

	public static function image_tag_filter($content)
	{
    // Do a user agent check and only perform the image tag logic for Chrome
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
    {
		     // New Regex (v0.3.6) regex to replace src attr with data-cdn-attr using negative lookahead to make sure not to double efforts on
		     // img tags with existing data-cdn-src attributes due to filtering both 'the_posts' and 'the_content' using this function
		     return preg_replace("/(<img)(?!(.*)data-cdn-src)([^<]+?)src=\"([^\"]*)\"([^<]+?>)/i", '$1 data-cdn-src="$4"$3src="//assets.swarmcdn.com/images/1x1.gif"$5', $content);
    } else {
         return $content;
    }
	}

	public static function clean_url($url)
	{	global $scdn_global;

		if(isset($scdn_global["urls_to_clean"]) && in_array($url, $scdn_global["urls_to_clean"]))
		{
			return "$url' data-cfasync='false";
		}

		return $url;
	}

	public static function enqueue_script_noasync($handle, $src)
	{
		global $scdn_global;

		if(!isset($scdn_global["urls_to_clean"])) {
			$scdn_global["urls_to_clean"] = array($src);
		} else {
			array_push($scdn_global["urls_to_clean"], $src);
		}

		wp_enqueue_script($handle, $src, null, null);
	}

	public static function enqueue_scripts()
	{
		$settings = SwarmCDN::get_settings();
		$upload_dir = wp_upload_dir();
		$protocol = 'https://';

		SwarmCDN::enqueue_script_noasync('swarmcdnjs', plugin_dir_url(__FILE__) . 'js/swarmcdn.js');
		wp_localize_script('swarmcdnjs', 'swarmParams', array(
			'swarmcdnkey' => $settings['scdn_api_key'],
			'swarmvideoscan' => ($settings['scdn_video_scan'] === "on" ? "true" : "false"),
			'swarmimagescan' => 'false',
			'swarmiframe' => trailingslashit(preg_replace('/^https?:\/\/[^\/]+/', '', $upload_dir['baseurl'])) . SCDN_IFRAME_FILE,
			'swarmadvancedparams' => $settings['scdn_advanced_parameters']
		));
		SwarmCDN::enqueue_script_noasync('swarmdetectjs', $protocol . 'assets.swarmcdn.com/swarmdetect.js');
	}

  public static function add_oembed()
  {
    $url = str_replace(".", "\.", get_site_url());
    $url = str_replace("http", "https?", $url);

    wp_oembed_add_provider('#https?://wp38\.testing\.com/.*.mp4#i', SCDN_PLUGIN_URL.'swarmcdn-oembed.php', true);
  }

	public static function register_actions()
	{
		$settings = SwarmCDN::get_settings();
    add_action('init', array('SwarmCDN', 'add_oembed'));

		if($settings['scdn_buffering_enabled'] == 'on') {
			add_filter('wp_head', array('SwarmCDN', 'wp_head'), 1);
			add_filter('wp_footer', array('SwarmCDN', 'wp_footer'));
		} else {
			add_filter('clean_url', array('SwarmCDN', 'clean_url'), 1);
			add_action('wp_enqueue_scripts', array('SwarmCDN', 'enqueue_scripts'), 1);
			add_filter('the_posts', array('SwarmCDN', 'the_posts'));
			add_filter('the_content', array('SwarmCDN', 'the_content'));
		}

		if( is_admin() ) {
			add_action('admin_init', array('SwarmCDN_Admin', 'admin_init'));
			add_action('admin_menu', array('SwarmCDN_Admin', 'admin_menu'));

			add_action('network_admin_menu', array('SwarmCDN_Admin', 'network_admin_menu'));
			add_action('network_admin_edit_' .SCDNPLUGINOPTIONS_ID, array('SwarmCDN_Admin', 'network_admin_edit_save'));
			add_action('network_admin_notices', array('SwarmCDN_Admin', 'network_admin_notices'));

			// add_filter('media_upload_tabs', array('SwarmCDN_Media', 'scdn_media_tabs'));
			// add_action('media_upload_swarmvideo', array('SwarmCDN_Media', 'scdn_render_swarmvideo_tab'));
			add_filter("attachment_fields_to_edit", array('SwarmCDN_Media', 'attachment_fields_to_edit'), 99, 2);
			// add_filter("attachment_fields_to_save", array('SwarmCDN_Media', 'attachment_fields_to_save'), 99, 2);
			add_filter('media_send_to_editor', array('SwarmCDN_Media', 'media_send_to_editor'), 11, 3);
			add_action("init", array("SwarmCDN_Media", "enqueue_scripts"));

			register_activation_hook(__FILE__, array('SwarmCDN', 'activate'));
		}
	}
}

// Register the actions, filters and hooks
SwarmCDN::register_actions();
?>
