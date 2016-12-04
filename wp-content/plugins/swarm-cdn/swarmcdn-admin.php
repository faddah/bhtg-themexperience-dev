<?php
class SwarmCDN_Admin
{
	public static function phpinfo_array()
	{
		ob_start();
		phpinfo();
		$info_arr = array();
		$info_lines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
		$cat = "General";
		foreach($info_lines as $line)
		{
			// new cat?
			preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
			if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
			{
				$info_arr[$cat][$val[1]] = $val[2];
			}
			elseif(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val))
			{
				$info_arr[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
			}
		}
		return $info_arr;
	}

	public static function admin_init()
	{
		register_setting(SCDNPLUGINOPTIONS_ID, 'scdn_version');
		register_setting(SCDNPLUGINOPTIONS_ID, 'scdn_enabled');
		register_setting(SCDNPLUGINOPTIONS_ID, 'scdn_api_key');
		register_setting(SCDNPLUGINOPTIONS_ID, 'scdn_video_scan');
		register_setting(SCDNPLUGINOPTIONS_ID, 'scdn_advanced_parameters');
		register_setting(SCDNPLUGINOPTIONS_ID, 'scdn_buffering_enabled');

		SwarmCDN_Admin::activate(false);
	}

	public static function admin_menu()
	{
		/* Add an options page for the plugin */
		add_options_page('Swarmify', 'Swarmify', 'manage_options', SCDNPLUGINOPTIONS_ID, array('SwarmCDN_Admin', 'settings'));

		/* Add plugin page settings link */
		add_filter('plugin_action_links', array('SwarmCDN_Admin', 'plugin_action_links'), 10, 2);
	}

	public static function network_admin_menu()
	{
		if(is_multisite() && is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ))
		{
			/* Add a network options page for the plugin */
			add_submenu_page('settings.php', 'Swarmify', 'Swarmify', 'manage_network_options', SCDNPLUGINOPTIONS_ID, array('SwarmCDN_Admin', 'network_settings'));

			/* Add plugin page settings link */
			add_filter('network_admin_plugin_action_links', array('SwarmCDN_Admin', 'network_admin_plugin_action_links'), 10, 2);
		}
	}

	public static function network_admin_edit_save()
	{
		$scdn_enabled = $_POST["scdn_enabled"];
		$scdn_api_key = preg_replace('/\s+/', '', $_POST["scdn_api_key"]);
		$scdn_video_scan = $_POST["scdn_video_scan"];
		$scdn_advanced_parameters = $_POST["scdn_advanced_parameters"];
		$scdn_buffering_enabled = $_POST["scdn_buffering_enabled"];

		update_site_option("scdn_enabled", $scdn_enabled);
		update_site_option("scdn_api_key", $scdn_api_key);
		update_site_option("scdn_video_scan", $scdn_video_scan);
		update_site_option("scdn_advanced_parameters", $scdn_advanced_parameters);
		update_site_option("scdn_buffering_enabled", $scdn_buffering_enabled);

		global $wpdb, $current_user;
		get_currentuserinfo();
		$current_blog_id = get_current_blog_id();
		$this_user = $current_user->ID;
		$blogs = get_blogs_of_user($this_user);

		foreach($blogs as $blog)
		{
			$scdn_enabled = $_POST["scdn_enabled_" . $blog->userblog_id];
			$scdn_api_key =  preg_replace('/\s+/', '', $_POST["scdn_api_key_" . $blog->userblog_id]);
			$scdn_video_scan = $_POST["scdn_video_scan_" . $blog->userblog_id];
			$scdn_advanced_parameters = $_POST["scdn_advanced_parameters_" . $blog->userblog_id];
			$scdn_buffering_enabled = $_POST["scdn_buffering_enabled_" . $blog->userblog_id];

			switch_to_blog($blog->userblog_id);
			update_option("scdn_enabled", $scdn_enabled);
			update_option("scdn_api_key", $scdn_api_key);
			update_option("scdn_video_scan", $scdn_video_scan);
			update_option("scdn_advanced_parameters", $scdn_advanced_parameters);
			update_option("scdn_buffering_enabled", $scdn_buffering_enabled);
		}

		switch_to_blog($current_blog_id);

		wp_redirect(network_admin_url('settings.php?page=' . SCDNPLUGINOPTIONS_ID . '&updated=true'));
		exit();
	}

	public static function network_admin_notices()
	{
		if(isset($_GET['updated']) && 'settings_page_scdn-plugin-settings-network' === $GLOBALS['current_screen'] -> id)
		{
			$message = 'Settings saved.';
			$notice  = '<div id="message" class="updated"><p>' .$message . '</p></div>';
			echo $notice;
		}
	}

	public static function plugin_action_links($links, $file)
	{
		if($file == SCDN_PLUGIN_FILE)
		{
			$settings_link = '<a href="' . admin_url('options-general.php?page=' . SCDNPLUGINOPTIONS_ID) . '">' . __('Settings', 'swarm-cdn') . '</a>';
			array_unshift($links, $settings_link);
		}

		return $links;
	}

	public static function network_admin_plugin_action_links($links, $file)
	{
		if($file == SCDN_PLUGIN_FILE)
		{
			$settings_link = '<a href="' . network_admin_url('settings.php?page=' . SCDNPLUGINOPTIONS_ID) . '">' . __('Settings', 'swarm-cdn') . '</a>';
			array_unshift($links, $settings_link);
		}

		return $links;
	}

	public static function settings_info()
	{
		global $wp_version;
		$phpinfo = SwarmCDN_Admin::phpinfo_array();

		return '
			<hr/>
			<h2>Swarmify Video How To</h2>
			<div style="padding-left: 230px; max-width: 640px;">
				<h2>Embed a Video</h2>
				<p>
				The Swarmify Wordpress plugin comes packaged with a custom video player which allows
				you to embed swarmed videos in your posts and pages.
				</p>

				<div style="display: ' . (version_compare($wp_version, '3.5', '>=') ? "inline" : "none") . '">
					<p>
					Start a new post/page or edit an existing one. From there, click on the <em>Add Media</em> button to be presented with the familiar
					Media Manager. If you do not already have an MP4 uploaded to work with, click on the <em>Upload Files</em> tab to upload an MP4<sup>*</sup>. After
					the file has been uploaded you should be returned to the <em>Media Library</em>.
					<br />
					<sub>* Please see the "Known Issues, Solutions and Things to be Aware of" below for information on upload limits with Wordpress.</sub>
					</p>

					<h2>Media Library</h2>
					<p>
					On the <em>Media Library</em> tab, click on the video you wish to embed. Once the video is
					selected, you will see its properties displayed on the right side of the screen. In addition to the default title, caption and description
					properties, Swarmify has added a <strong>Poster Image</strong> property, a <strong>Size</strong> property and an <strong>Embed with Swarmify</strong>
					button.
					</p>
				</div>

				<div style="display: ' . (version_compare($wp_version, '3.5', '<') ? "inline" : "none") . '">
					<p>
					Start a new post/page or edit an existing one. From here, click on the <em>Upload/Insert</em> button to be presented with the familiar
					Media Manager. If you do not already have an MP4 uploaded to work with, go ahead and upload one on the <em>From Computer</em> tab<sup>*</sup>. After
					the file has been uploaded you should be returned to the <em>Media Library</em>.
					<br />
					<sub>* Please see the "Known Issues, Solutions and Things to be Aware of" below for information on upload limits with Wordpress.</sub>
					</p>

					<h2>Media Library</h2>
					<p>
					On the <em>Media Library</em> tab, click on the <em>show</em> link next to the video you wish to embed. Once the video is
					selected, you will see its properties displayed below. In addition to the default title, caption and description
					properties, Swarmify has added a <strong>Poster Image</strong> property, a <strong>Size</strong> property and an <strong>Embed with Swarmify</strong>
					button.
					</p>
				</div>

				<p>
				The <strong>Poster Image</strong> property allows you to select an image from the library to be displayed as a poster image for the
				video. This poster image is displayed on your post/page in place of the video until the video is started. Poster images are optional,
				but can really dress up the look of your videos.
				</p>

				<p>
				The <strong>Size</strong> property allows you to choose from a set of default embed sizes for your video or, alternately,
				specify a custom width and height.
				</p>

				<p>
				The <strong>Embed with Swarmify</strong> button will insert a custom shortcode into your post or page. Click the button and the Media Manager
				will close, revealing the post/page editor. The new Swarmify shortcode, a small bit of text between square brackets, is now inserted into your post.
				This shortcode will be handled by the Swarmify plugin when your page is rendered, displaying your video in the custom player, complete with Swarming capability.
				</p>
			</div>

			<hr />
			<div>
				<h2>Known Issues, Solutions and Things to be Aware of.</h2>
				<div style="padding-left: 230px; max-width: 640px;">
					<ul style="list-style-type: disc;">
						<li>
							<strong>Cross Domain Image/Video Hosting</strong> -
							If you\'re hosting content on a different domain or subdomain (possibly a CDN),
							please see this <a href="https://swarmlabs.zendesk.com/entries/25400078-You-host-images-video-on-a-different-domain-CDN-host-or-subdomain-You-NEED-to-do-the-following-">article</a>.
						</li>
						<li>
							<strong>Lazy Loading</strong> -
							 If you\'re using a Lazy Loading script go ahead and turn it off as
							 it conflicts with our script and the best part is we already use Lazy Loading.
						</li>
						<li>
							<strong>Inflated Analytics numbers when using Cloudflare.</strong> -
							Swarm uses an iframe to resolve a known issue with cross domain content loading.
							When you use Cloudflare they insert your Analytics code in this iframe and therefore your hits (numbers)
							will appear inflated. See this <a href="https://swarmlabs.zendesk.com/entries/27583186-Inflated-Analytics-adwords-numbers-when-I-use-Swarm-">forum post</a> for a simple quick fix solution.
						</li>
						<li>
							<strong>Upload File Size Limitations</strong> -
							Wordpress traditionally has limits on the size of files you can upload, which may impact your ability to upload large videos.
							<strong>Your current upload limit appears to be ' . ( wp_max_upload_size() / 1024 / 1024 ).'M per file </strong>.
							If you\'re finding that this limit is not sufficient, you can contact your hosting provider to increase this limit (they just
							have to edit the <em>php.ini</em> file to increase the limit).
							For advanced users, you may also be able to edit your <em>php.ini</em> file yourself to increase these limits.

							<div style="display: ' . (is_multisite() ? "inline" : "none") . '">
								<hr />
								<h4>Multisite Installations</h4>
								If you are operating more than one site off of a single Wordpress installation, there are additional settings that limit
								the size of individual file uploads as well as the total size of all uploaded files. You can find these settings in your
								Network Admin -> Dashboard -> Settings -> Upload Settings area or click <a href="' . network_admin_url('settings.php#fileupload_maxk') . '">here</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		';
	}

	public static function settings_template($do_descriptions, $is_network, $field_suffix, $scdn_enabled, $scdn_api_key, $scdn_video_scan, $scdn_advanced_parameters, $scdn_buffering_enabled)
	{
		$is_indv_site_on_network = is_multisite() && is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ) && !$is_network;

		$template = '
			<script>
			jQuery(function($) {
				$("input[name=scdn_enabled' . $field_suffix . ']:radio").change(function() {
					if($(this).val() !== "on") {
						$(".scdn_settings_' . $field_suffix . '").hide();
					} else {
						$(".scdn_settings_' . $field_suffix . '").show();
					}
				});

				$("input[name=scdn_enabled' . $field_suffix . '][value=' . $scdn_enabled. ']:radio").change();
			});
			</script>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<label for="scdn_enabled">Enabled</label>
						</th>
						<td>
							' .
							(
							$is_indv_site_on_network ? '
							<label><input type="radio" name="scdn_enabled' . $field_suffix . '" value="network" ' . ($scdn_enabled === "network" ? "checked" : "") . '/> - Use Network Settings</label><br />' : ''
							)
							. '
							<label><input type="radio" name="scdn_enabled' . $field_suffix . '" value="on" ' . ($scdn_enabled === "on" ? "checked" : "") . '/> - ' . ($is_indv_site_on_network ? 'Override Network Settings' : 'Enabled') . '</label>
							<br />
							<label><input type="radio" name="scdn_enabled' . $field_suffix . '" value="off" ' . ($scdn_enabled === "off" ? "checked" : "") . '/> - Disabled</label>
						</td>
					</tr>
					<tr valign="top" class="scdn_settings_' . $field_suffix . '">
						<th scope="row">
							<label for="scdn_api_key">API Key</label>
						</th>
						<td>
							<input type="text" name="scdn_api_key' . $field_suffix . '" value="'.$scdn_api_key.'" class="regular-text" style="width: 250px;" />
							<p class="description" style="display:' . ($do_descriptions ? "inline" : "none") . ';">Please enter your API KEY. You can get an API KEY by creating a free account at <a href="http://swarmify.com">swarmify.com</a>.</p>
						</td>
					</tr>
					<tr valign="top" class="scdn_settings_' . $field_suffix . '">
						<th scope="row">
							<label for="scdn_video_scan">Video Scan</label>
						</th>
						<td>
							<input type="checkbox" name="scdn_video_scan' . $field_suffix . '" '.$scdn_video_scan. ' />
							<p class="description" style="display:' . ($do_descriptions ? "inline" : "none") . ';">Please check this box if you would like your video served peer-to-peer.</p>
						</td>
					</tr>
					<tr valgin="top" class="scdn_settings_' . $field_suffix . '">
						<th scope="row">
							<label for="scdn_buffering_enabled">Page Buffering</label>
						</th>
						<td>
							<input type="checkbox" name="scdn_buffering_enabled' . $field_suffix . '" '.$scdn_buffering_enabled. ' />
							<p class="description" style="display:' . ($do_descriptions ? "inline" : "none") . ';">Check this to allow Swarmify to serve more images via the Swarm, such as those in your themes and layouts. (Note: This may interact with other plugins in unexpected ways, so please disable if you are experiencing any issues.)</p>
						</td>
					</tr>
					<tr valign="top" class="scdn_settings_' . $field_suffix . '">
						<th scope="row">
							<label for="scdn_advanced_parameters">Advanced Parameters</label>
						</th>
						<td>
							<textarea name="scdn_advanced_parameters' . $field_suffix . '" rows="5" class="regular-text" style="width: 250px;">'.$scdn_advanced_parameters.'</textarea>
						</td>
					</tr>
				</tbody>
			</table>
		';

		return $template;
	}


	public static function network_settings()
	{
		$scdn_enabled = get_site_option('scdn_enabled', 'on');
		$scdn_api_key = get_site_option('scdn_api_key', '');
		$scdn_video_scan = get_site_option('scdn_video_scan', '') == 'on' ? 'checked' : '';
		$scdn_advanced_parameters = get_site_option('scdn_advanced_parameters', '');
		$scdn_buffering_enabled = get_site_option('scdn_buffering_enabled', '') == 'on' ? 'checked' : '';
		$html = '
			<div class="wrap" style="font-family: helvetica; font-size: 13px; line-height: 24px">
				<img src="'.plugins_url('swarmcdn-logo.png', __FILE__).'" />
				<form action="edit.php?action='.SCDNPLUGINOPTIONS_ID.'" method="post">
					' . wp_nonce_field('update-network-options') . '
					<h2>Swarmify Plugin for Video and Images</h2>
					<hr />
					<h2>Swarmify - Network Settings</h2>
					' . SwarmCDN_Admin::settings_template(true, true, '', $scdn_enabled, $scdn_api_key, $scdn_video_scan, $scdn_advanced_parameters, $scdn_buffering_enabled);

		global $wpdb, $current_user;
		get_currentuserinfo();
		$current_blog_id = get_current_blog_id();
		$this_user = $current_user->ID;
		$blogs = get_blogs_of_user($this_user);

		foreach($blogs as $blog)
		{
			switch_to_blog($blog->userblog_id);

			$scdn_enabled = get_option('scdn_enabled', 'network');
			$scdn_api_key = get_option('scdn_api_key', '');
			$scdn_video_scan = get_option('scdn_video_scan', '') == 'on' ? 'checked' : '';
			$scdn_advanced_parameters = get_option('scdn_advanced_parameters', '');
			$scdn_buffering_enabled = get_option('scdn_buffering_enabled', '') == 'on' ? 'checked' : '';

			$html = $html . '
			<hr />
			<div>
				<h2>Swarmify - Site Settings: [' . $blog->blogname .']</h2>
			</div>
			' . SwarmCDN_Admin::settings_template(false, false, '_' . $blog->userblog_id, $scdn_enabled, $scdn_api_key, $scdn_video_scan, $scdn_advanced_parameters, $scdn_buffering_enabled);
		}

		$html = $html . '
				<input type="submit" name="Submit" value="Save Settings" class="button-primary" />
				'. SwarmCDN_Admin::settings_info() . '
				</form>
				<hr />
				<p style="font-size: 10px;">Visit <a href="http://swarmify.com">swarmify.com</a> for additional information.</p>
			</div>
		';

		switch_to_blog($current_blog_id);
		echo($html);
	}

	public static function settings()
	{
		$scdn_enabled = get_option('scdn_enabled', is_multisite() && is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ) ? 'network' : 'on');
		$scdn_api_key = get_option('scdn_api_key', '');
		$scdn_video_scan = get_option('scdn_video_scan', '') == 'on' ? 'checked' : '';
		$scdn_advanced_parameters = get_option('scdn_advanced_parameters', '');
		$scdn_buffering_enabled = get_option('scdn_buffering_enabled', '') == 'on' ? 'checked' : '';

		if(is_multisite() && !is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ))
		{
			if($scdn_enabled === 'network')
			{
				$scdn_enabled = 'off';
			}
		}

		$html = '
			<div class="wrap" style="font-family: helvetica; font-size: 13px; line-height: 24px">
				<img src="'.plugins_url('swarmcdn-logo.png', __FILE__).'" />
				<form action="options.php" method="post">
					' . wp_nonce_field('update-options') . '
					<h2>Swarmify Plugin for Video and Images</h2>
					<hr />
					<h2>Swarmify - Settings</h2>
					' . SwarmCDN_Admin::settings_template(true, false, '', $scdn_enabled, $scdn_api_key, $scdn_video_scan, $scdn_advanced_parameters, $scdn_buffering_enabled) . '
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options", value="scdn_enabled,scdn_api_key,scdn_video_scan,scdn_advanced_parameters,scdn_buffering_enabled" />
					<input type="submit" name="Submit" value="Save Settings" class="button-primary" />
					' . SwarmCDN_Admin::settings_info() . '
				</form>
				<hr />
				<p style="font-size: 10px;">Visit <a href="http://swarmify.com">swarmify.com</a> for additional information.</p>
			</div>
		';

		echo($html);
	}

	public static function activate($network_activation)
	{
		/* If this is a network activation, switch to each blog and activate the plugin. */
		if(is_multisite() && $network_activation)
		{
			global $wpdb, $current_user;
			get_currentuserinfo();
			$current_blog_id = get_current_blog_id();
			$this_user = $current_user->ID;
			$blogs = get_blogs_of_user($this_user);

			foreach($blogs as $blog)
			{
				switch_to_blog($blog->userblog_id);
				do_action('activate_swarm-cdn/swarmcdn.php');
				do_action('activate_plugin', 'swarm-cdn/swarmcdn.php');
			}

			switch_to_blog($current_blog_id);
			return;
		}

		/* Retrieve the current plugin version. */
		$scdn_version = get_option('scdn_version', '0');
		$scdn_version_arr = preg_split('/\./', $scdn_version);
		$scdn_version_major = intval($scdn_version_arr[0]);
		$scdn_version_minor = intval($scdn_version_arr[1]);
		$scdn_version_build = intval($scdn_version_arr[2]);

		/* If the latest version is not in the database, update it and run the activation code. */
		if($scdn_version != SCDN_VERSION)
		{
			if(is_multisite() && is_plugin_active_for_network( 'swarm-cdn/swarmcdn.php' ))
			{
				/* Trim the network api key just in case. */
				update_site_option('scdn_api_key', preg_replace('/\s+/', '', get_site_option('scdn_api_key', '')));

				global $wpdb, $current_user;
				get_currentuserinfo();
				$current_blog_id = get_current_blog_id();
				$this_user = $current_user->ID;
				$blogs = get_blogs_of_user($this_user);

				foreach($blogs as $blog)
				{
					switch_to_blog($blog->userblog_id);

					/* Update the database to the latest version. */
					update_option('scdn_version', SCDN_VERSION);

					/* Trim the api key just in case. */
					update_option('scdn_api_key', preg_replace('/\s+/', '', get_option('scdn_api_key', '')));

					/* Update the enabled flag if we have an API KEY and this is the version we introduced the flag. */
					if($scdn_version_minor < 2 && get_option('scdn_api_api', '') != '' && get_option('scdn_enabled', '') == '')
					{
						update_option('scdn_enabled', 'on');
					}
				}

				/* Switch back to the current blog. */
				switch_to_blog($current_blog_id);
			}
			else
			{
				/* Update the database to the latest version. */
				update_option('scdn_version', SCDN_VERSION);

				/* Trim the api key just in case. */
				update_option('scdn_api_key', preg_replace('/\s+/', '', get_option('scdn_api_key', '')));

				/* Update the enabled flag if we have an API KEY and this is the version we introduced the flag. */
				if($scdn_version_minor < 2 && get_option('scdn_api_api', '') != '' && get_option('scdn_enabled', '') == '')
				{
					update_option('scdn_enabled', 'on');
				}
			}

			/* Write out our Swarm iFrame file. */
			$upload_dir = wp_upload_dir();
			$contents = '<!DOCTYPE html>
						<html>
							<head>
							  <script src="http://assets.swarmcdn.com/javascript/manticors.js" type="text/javascript"></script>
							  <script>
									manticors.iframe.setup_window_message_receive();
							  </script>
							</head>
							<body>
							  <h1>This iframe should be hidden</h1>
							</body>
						</html>';

			file_put_contents(trailingslashit($upload_dir['basedir']). SCDN_IFRAME_FILE, $contents);
		}
	}
}
?>
