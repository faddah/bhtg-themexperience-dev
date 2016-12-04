<?php
class SwarmCDN_Shortcode
{
	protected $media_params = array(
		'mediaid' 	=> null,
		'posterid'	=> null,
		'width' 	=> null,
		'height'	=> null,
		'controls'	=> 'true',
		'preload'	=> 'auto',
		'autoplay'	=> 'false',
		'muted'		=> 'false',
		'loop'		=> 'false'
	);

	protected $media_defaults = array();

	public function __construct($shortcode = null, $post_data = false)
	{
		foreach($this->media_params as $param => $value) {
			$this->media_defaults[$param] = $value;
		}

		if(null === $shortcode) {
			return $this->_init_from_post_data($post_data);
		} else {
			return $this->_init_from_shortcode($shortcode);
		}
	}

	protected function _init_from_post_data($post_data = false)
	{
		$post = ($post_data && is_array($post_data)) ? $post_data : $_POST;

		foreach($this->media_params as $param => $value) {
			if ( isset($post["scdn_" . $param]) && $post["scdn_" . $param] ) {
				$this->media_params[$param] = $post["scdn_" . $param];
			} else if ( isset($post[$param]) && $post[$param] ) {
				$this->media_params[$param] = $post[$param];
			}
		}
	}

  protected function _init_from_shortcode($shortcode)
	{
		// Check fixed params
		foreach ($this->media_params as $param => $value) {
			if ( isset($shortcode[$param]) ) {
				$this->media_params[$param] = $shortcode[$param];
				unset($shortcode[$param]);
			}
		}
	}

	public function shortcode()
	{
		$params = array();

		// Media
		foreach ($this->media_params as $param => $value) {
			if ( $value && $value != $this->media_defaults[$param] ) {
				$params[$param] = $value;
			}
		}

		$param_pairs = array();
		foreach ($params as $key => $value) {
			array_push($param_pairs , $key . '="' . $value . '"');
		}

		return '[swarmvideo ' .join(" ", $param_pairs).']';
	}

	public function embedcode()
	{
		global $scdn_global;

		if(!isset($scdn_global["shortcode_count"])) {
			$scdn_global["shortcode_count"] = 0;
		}
		$scdn_global["shortcode_count"] += 1;

    $settings = SwarmCDN::get_settings();
		$options = '';

		// Make the code a little easier to read
		foreach ($this->media_params as $param => $value)
		{
			// $html .= " " . $param . " = " . $value . "<br />";
			$$param = $value;
		}

		// mediaid
		if ( is_int($mediaid) || ctype_digit($mediaid) )
		{
			$media_post = get_post($mediaid);
			$video_url = $media_post->guid ? $media_post->guid : null;
		}

		// posterid
		if ( is_int($posterid) || ctype_digit($posterid) )
		{
			$poster_post = get_post($posterid);
			$poster_url = $poster_post->guid ? $poster_post->guid : null;

			$options .= "&poster=$poster_url";
		}

		// width and height
		if( (is_int($width) || ctype_digit($width))  && intval($width) > 0 )
		{
			$width = "width=\"{$width}\"";
		} else { $width = ""; }
		if( (is_int($height) || ctype_digit($height)) && intval($height) > 0 )
		{
			$height = "height=\"{$height}\"";
		} else { $height = ""; }

		// controls, preload, autoplay, muted, loop
		if( isset($controls) && filter_var($controls, FILTER_VALIDATE_BOOLEAN) == true )
		{
			$options .= "&controls=true";
		}
		if( isset($preload) && in_array($preload, array("auto", "meta", "none")) )
		{
			$options .= "&preload=$preload";
		}
		if( isset($autoplay) && filter_var($autoplay, FILTER_VALIDATE_BOOLEAN) == true )
		{
			$options .= "&autoplay=true";
		}
		if( isset($muted) && filter_var($muted, FILTER_VALIDATE_BOOLEAN) == true )
		{
			$options .= "&muted=true";
		}
		if( isset($loop) && filter_var($loop, FILTER_VALIDATE_BOOLEAN) == true )
		{
			$options .= "&loop=true";
		}

    $options .= "&api-key=" . $settings["scdn_api_key"];

		return "<iframe id=\"video_{$mediaid}_{$scdn_global["shortcode_count"]}\" $width $height src=\"http://assets.swarmcdn.com/embed.html?url=$video_url$options\" frameborder=\"0\" allowfullscreen></iframe>";
	}

	public static function tag_parser($matches)
	{
		if ($matches[1] == "[" && $matches[6] == "]")
		{
			return substr($matches[0], 1, -1);
		}

		$param_regex = '/([\w.]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w.]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w.]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
		$text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $matches[3]);
		$atts = array();

		if (preg_match_all($param_regex, $text, $match, PREG_SET_ORDER))
		{
			foreach ($match as $p_match) {
				if (!empty($p_match[1]))
					$atts[$p_match[1]] = stripcslashes($p_match[2]);
				elseif (!empty($p_match[3]))
					$atts[$p_match[3]] = stripcslashes($p_match[4]);
				elseif (!empty($p_match[5]))
					$atts[$p_match[5]] = stripcslashes($p_match[6]);
				elseif (isset($p_match[7]) and strlen($p_match[7]))
					$atts[] = stripcslashes($p_match[7]);
				elseif (isset($p_match[8]))
					$atts[] = stripcslashes($p_match[8]);
			}
		}
		else
		{
			$atts = ltrim($text);
		}

		$shortcode = new SwarmCDN_Shortcode($atts);
		return $matches[1] . $shortcode->embedcode() . $matches[6];
	}
}
?>
