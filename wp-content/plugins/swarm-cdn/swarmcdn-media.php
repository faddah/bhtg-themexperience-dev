<?php
class SwarmCDN_Media
{
	public static function scdn_media_tabs($_default_tabs)
	{
		$_default_tabs["swarmvideo"] = "Insert Swarmed Video";
		return $_default_tabs;
	}

	public static function scdn_render_swarmvideo_tab()
	{
		$errors = null;

		wp_enqueue_style('media');
		SwarmCDN_Media::enqueue_scripts();
		wp_enqueue_script('admin-gallery');
		return wp_iframe(array("SwarmCDN_Media", "scdn_swarmvideo_insert_form"), $errors);
	}

	public static function scdn_swarmvideo_insert_form()
	{
		global $redir_tab, $type;

		$redir_tab = 'swarmvideo';
		media_upload_header();

		$post_id = intval($_REQUEST['post_id']);
		$form_action_url = admin_url("media-upload.php?type=$type&tab=swarmvideo&post_id=$post_id");
		$form_action_url = apply_filters('media_upload_form_url', $form_action_url, $type);

		$video_args = array(
			"post_type" => "attachment",
			"numberposts" => 50,
			"post_status" => null,
			"post_mime_type" => "video",
			"post_parent" => null
		);
		$video_attachments = get_posts($video_args);

		foreach($video_attachments as $post)
		{
			$filename = esc_html( wp_basename( $post->guid ) );
			$title = esc_attr( $post->post_title );
			?>
			<div><?php echo $filename ?></div>
			<?php
		}
	}

	public static function media_send_to_editor($html, $send_id, $attachment)
	{
		if ( isset($_POST['attachment']) && isset($_POST['action']) && $_POST['action'] == 'send-attachment-to-editor' && isset($_POST["attachment"]["scdn_insert_player"]) ) {
			$shortcode = new SwarmCDN_Shortcode(null, $_POST['attachment']);
		} else if ( isset($_POST['send'][$send_id]) && $_POST['send'][$send_id] === "Insert with Swarmify" && isset($_POST['attachments'][$send_id]["scdn_posterid"]) ) {
			$shortcode = new SwarmCDN_Shortcode(null, array(
				'mediaid' => $send_id,
				'posterid' => $_POST['attachments'][$send_id]["scdn_posterid"],
				'width' => $_POST['attachments'][$send_id]["scdn_width"],
				'height' => $_POST['attachments'][$send_id]["scdn_height"],
				'controls' => $_POST['attachments'][$send_id]["scdn_controls"],
				'preload' => $_POST['attachments'][$send_id]["scdn_preload"],
				'autoplay' => $_POST['attachments'][$send_id]["scdn_autoplay"],
				'loop' => $_POST['attachments'][$send_id]["scdn_loop"],
				'muted' => $_POST['attachments'][$send_id]["scdn_muted"]
			));
		}

		if ( isset($shortcode) ) return $shortcode->shortcode();
		return $html;
	}

	public static function thumb_select_html($id, $attachments)
	{
		$output = $image_id;
		$thumbnail = get_post_meta($id, "scdn_posterid", true);
		$sel = false;

		if ( $attachments ) {
			if ( is_int($thumbnail) || ctype_digit($thumbnail) ) {
				$image_id = $thumbnail;
			}
		}

		$output .= "<input name='attachments[$id][scdn_posterid]' id='scdn_the_image_value' type='hidden' value='{$thumbnail}' />";

		if ( $attachments ) {
			$output .= "<span id='thumb_select_group' style='width: 100%'>";
			$output .= "<select name='scdn_the_image_id' id='scdn_the_image_id' style='width:100%;'>";
			$output .= "<option value='' title='No thumb' data-thumb=''>No thumbnail</option>";

			foreach($attachments as $post) {
				if ( substr($post->post_mime_type, 0, 5 ) == "image") {
					if ( $post->ID == $image_id ) {
						$selected = "selected='selected'";
						$sel = true;
					} else {
						$selected = "";
					}
					$output .= "<option value='" . $post->ID . "' data-thumb='" . $post->guid . "' " . $selected . ">" . $post->post_title . "</option>";
				}
			}

			if ( !$sel && isset($image_post) && isset($image_id) && $image_id != -1) {
				$image_post = get_post($image_id);
				$output .= "<option value='" . $image_post->ID . "' data-thumb='" . $image_post->guid . "' selected=selected >" . $image_post->post_title . "</option>";
			}

			$output .= "</select>
					<p class='description'>Choose a poster image</p>
				</span>";
		}

		if ( isset($_REQUEST["post_id"]) ) {
			$output .= "
				<div class='scdn_hr'></div>
			";
		}
		return $output;
	}

	public static function size_select_html($post)
	{
		$meta = wp_get_attachment_metadata($post->ID);
		$width = isset($meta['width']) ? $meta['width'] : 0;
		$height = isset($meta['height']) ? $meta['height'] : 0;
		$selected = "";
		$hasSelected = false;
		$inputClass = "hidden";

		$sizes = array(
			"small" => array("name" => "Small", "width" => 320, "height" => 240),
			"medium" => array("name" => "Medium", "width" => 640, "height" => 480),
			"large" => array("name" => "Large", "width" => 800, "height" => 600),
			"full" => array("name" => "Full", "width" => $width, "height" => $height),
			"custom" => array("name" => "Custom", "width" => 0, "height" => 0)
		);

		if($width === 0 || $height === 0) {
			unset($sizes["full"]);
		}

		$html = "<select name='scdn_the_size' id='scdn_the_size' style='width:100%;'>";

		foreach($sizes as $key => $size) {
			if(!$size) continue;

			$selected = $width == $size["width"] && $height == $size["height"] ? "selected='selected'" : "";

			if($selected != "") {
				$hasSelected = true;
				if($key == "custom") {
					$inputClass = "";
				}
			} else if($hasSelected == false && $key == "custom") {
				$selected = "selected='selected'";
				$inputClass = "";
			}

			if($key !== "custom") {
				$html .= "<option value='" .$key. "' $selected>". esc_html($size["name"]) . " - " . esc_html($size["width"]) ." x ". esc_html($size["height"]) . "</option>";
			} else {
				$html .= "<option value='" .$key. "' $selected>". esc_html($size["name"]) . "</option>";
			}
		}

		$html .= "</select>";
		$html .= "<div id='scdn_the_size_inputs' class='$inputClass' style='margin-top: 5px;'>";
		$html .=" <input id='scdn_embed_width' name='attachments[{$post->ID}][scdn_width]' type='text' maxlength='4' size='4' style='width: 50px;' value='$width' /> x <input id='scdn_embed_height' name='attachments[{$post->ID}][scdn_height]' type='text' maxlength='4' size='4' style='width: 50px;' value='$height'/>";
		$html .= "</div>";
		$html .= "<p class='description'>Choose your video dimensions</p>";

		return $html;
	}

	public static function generic_select_html($id, $name, $options, $default)
	{
		$html = "<select id='{$name}' name='attachments[{$id}][{$name}]' style='width:100%;'>";

		foreach($options as $key=>$value) {
			$html .= "<option value='{$value}' " . ($default == $value ? "selected" : "") . ">{$value}</option>";
		}

		$html .= "</select>";
		return $html;
	}

	public static function insert_html($post)
	{
		global $wp_version;

		$html = '';

		if ( isset($_GET["post_id"]) || version_compare($wp_version, '3.5', '<') ) {
			$html .= "
				<input type='submit' style='border-color: rgb(190,114,6); background-image: linear-gradient(rgb(235,180,36), rgb(225,128,27)) !important;' class='button button-primary button-large media-button' name='send[{$post->ID}]' value='Insert with Swarmify' />
			";
		} else {
			$html .= "
				<button style='border-color: rgb(190,114,6); background-image: linear-gradient(rgb(235,180,36), rgb(225,128,27)) !important;' class='insert_with_scdn button button-primary button-large media-button'
					data-url='". SCDN_PLUGIN_URL . "swarmcdn.php'>
					Insert with Swarmify
				</button>
			";
		}

		return $html;
	}

	public static function insert_js_for_attachment_fields($post)
	{
		$meta = wp_get_attachment_metadata($post->ID, true);
		$width = isset($meta['width']) ? $meta['width'] : 0;
		$height = isset($meta['height']) ? $meta['height'] : 0;

		$sizes = array(
			"small" => array("name" => "Small", "width" => 320, "height" => 240),
			"medium" => array("name" => "Medium", "width" => 640, "height" => 480),
			"large" => array("name" => "Large", "width" => 800, "height" => 600),
			"full" => array("name" => "Full", "width" => $width, "height" => $height),
			"custom" => array("name" => "Custom", "width" => 0, "height" => 0)
		);

		if($width === 0 || $height === 0) {
			unset($sizes["full"]);
		}

		$size_map = "var sizes = {};";

		foreach($sizes as $key => $size) {
			if($size) {
				$size_map .= "\nsizes['$key'] = {width:". $size['width'] .", height:" .$size['height'] ."};";
			}
		}

		return "
			<script type='text/javascript'>
				" . $size_map . "
				function scdn_insert_player() {

					wp.media.post('send-attachment-to-editor', {
						nonce: wp.media.view.settings.nonce.sendToEditor,
						attachment: {
							'id': " . $post->ID . ",
							'scdn_insert_player': true,
                            'scdn_mediaid': " . $post->ID . ",
							'scdn_posterid': jQuery('#scdn_the_image_value').val(),
							'scdn_width': jQuery('#scdn_embed_width').val(),
							'scdn_height': jQuery('#scdn_embed_height').val(),
							'scdn_controls': jQuery('#scdn_controls').val(),
							'scdn_preload': jQuery('#scdn_preload').val(),
							'scdn_autoplay': jQuery('#scdn_autoplay').val(),
							'scdn_muted': jQuery('#scdn_muted').val(),
							'scdn_loop': jQuery('#scdn_loop').val()
						},
						html: '',
						post_id: wp.media.view.settings.post.id

					}).done(function(response) {
						manage_video_insert_buttons(false);
						send_to_editor(response);
					});
				}

				function manage_video_insert_buttons(hideDefault, removeSwarm) {
					if(hideDefault) {
						jQuery('a.media-button-insert').css('display', 'none');
						jQuery('<div style=\'font-size: 11px; line-height: 14px; width: 100px; float: left; margin: 15px 0px 0px 10px;\' ><a href=\'#\'>?</a> Looking for the default video insert option?</div>').appendTo(jQuery('a.media-button-insert').parent()).find('a').click(function() {
							manage_video_insert_buttons(false, false);
						});
					} else {
						jQuery('a.media-button-insert').css('display', 'inline');
						jQuery('a.media-button-insert').parent().find('div').remove();
					}

					if(removeSwarm) {
						jQuery('a.media-button-insert').parent().find('button.insert_with_scdn').remove();
					}
				}

				function scdn_init_select2() {
					jQuery('div.wrap table.compat-attachment-fields').css('width', '100%');
					jQuery('div.wrap table.compat-attachment-fields td').css('width', '75%');
					jQuery('select[id^=scdn]').select2({
						'minimumResultsForSearch': 8,
						'formatResult': function(opt) {
							var thumb = jQuery(opt.element).data('thumb'), style;
							if(thumb) {
								style = (thumb.length > 10) ? ' style=\"background-image: url(' + thumb + ');\"' : '';
								return '<span class=\"thumbedoption\"><span class=\"thumboption\"' + style + '></span>' + opt.text + '</span>';
							}
							return opt.text;
						},
						'formatSelection': function(opt) {
							return opt.text;
						}
					}).bind('change', function(){
						if(jQuery(this).attr('id') === 'scdn_the_size') {

							if(jQuery(this).val() === 'custom') {
								jQuery('#scdn_the_size_inputs').removeClass('hidden');
							} else {
								jQuery('#scdn_the_size_inputs input:eq(0)').val(sizes[jQuery(this).val()].width);
								jQuery('#scdn_the_size_inputs input:eq(1)').val(sizes[jQuery(this).val()].height);
								jQuery('#scdn_the_size_inputs').addClass('hidden');
							}
						}

						if(jQuery(this).attr('id') === 'scdn_the_image_id') {
							jQuery('#scdn_the_image_value').val(jQuery(this).val());
						}
					})

					manage_video_insert_buttons(jQuery('form.compat-item button.insert_with_scdn').length > 0, true);
                    jQuery('form.compat-item button.insert_with_scdn').bind('click', scdn_insert_player).detach().prependTo(jQuery('a.media-button-insert').parent());
					jQuery('a.media-button-insert').click(function() {
						manage_video_insert_buttons(false, true);
					});
				}

				jQuery(document).ready(function(e) {
					var in_media_manager = jQuery('.media-modal').length > 0,
						timeout = (in_media_manager) ? 200 : 0;

					setTimeout(scdn_init_select2, timeout);
				});
			</script>
		";
	}

	public static function attachment_fields_to_edit($form_fields, $post)
	{
		$image_args = array(
			"post_type" => "attachment",
			"numberposts" => 50,
			"post_status" => null,
			"post_mime_type" => "image",
			"post_parent" => null
		);
		$image_attachments = get_posts($image_args);
		$mime_type = $post->post_mime_type;

		if ('video/mp4' == $mime_type) {
			if ( isset($_REQUEST["post_id"]) ) {
				$form_fields["swarmcdn_thumbnail"] = array(
					"label" => "Poster Image",
					"input" => "html",
					"html" => SwarmCDN_Media::thumb_select_html($post->ID, $image_attachments)
				);

				$form_fields["swarmcdn_size"] = array(
					"label" => "Size",
					"input" => "html",
					"html" => SwarmCDN_Media::size_select_html($post)
				);

				$form_fields["swarmcdn_controls"] = array(
					"label" => "Controls",
					"input" => "html",
					"html" => SwarmCDN_Media::generic_select_html($post->ID, "scdn_controls", array("true", "false"), "true"),
					"helps" => "Include video player controls"
				);

				$form_fields["swarmcdn_preload"] = array(
					"label" => "Preload",
					"input" => "html",
					"html" => SwarmCDN_Media::generic_select_html($post->ID, "scdn_preload", array("auto", "metadata", "none"), "auto"),
					"helps" => "Preload video"
				);

				/*
				$form_fields["swarmcdn_autoplay"] = array(
					"label" => "Autoplay",
					"input" => "html",
					"html" => SwarmCDN_Media::generic_select_html($post->ID, "scdn_autoplay", array("true", "false"), "false"),
					"helps" => "Autoplay video after loading"
				);

				$form_fields["swarmcdn_muted"] = array(
					"label" => "Mute",
					"input" => "html",
					"html" => SwarmCDN_Media::generic_select_html($post->ID, "scdn_muted", array("true", "false"), "false"),
					"helps" => "Mute video by default"
				);
				*/

				$form_fields["swarmcdn_loop"] = array(
					"label" => "Loop",
					"input" => "html",
					"html" => SwarmCDN_Media::generic_select_html($post->ID, "scdn_loop", array("true", "false"), "false"),
					"helps" => "Loop video"
				);

				$form_fields["swarmcdn_insert"] = array(
					"label" => "",
					"input" => "html",
					"html" => SwarmCDN_Media::insert_html($post)
				);

				$form_fields["swarmcdn_js"] = array(
					"label" => "",
					"input" => "html",
					"html" => SwarmCDN_Media::insert_js_for_attachment_fields($post)
				);
			}
		} elseif ( isset($_REQUEST["post_id"]) ) {
			$form_fields["swarmcdn_js"] = array(
				"label" => "",
				"input" => "html",
				"html" => SwarmCDN_Media::insert_js_for_attachment_fields($post)
			);
		}
		return $form_fields;
	}

	public static function enqueue_scripts()
	{
		wp_enqueue_script(
			'jquerySelect2',
			SCDN_PLUGIN_URL.'js/jquery.select2.js',
			array('jquery')
		);

		wp_enqueue_style(
			'jquerySelect2Style',
			SCDN_PLUGIN_URL.'css/jquery.select2.css'
		);
	}
}
?>
