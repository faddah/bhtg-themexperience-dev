<?php
/*
  Plugin Name: CDN Buster
  Plugin URI: http://www.thulasidas.com/plugins/cdn-buster
  Description: A tool to invalidate the files cached on your CDN server en masse.
  Version: 1.40
  Author: Manoj Thulasidas
  Author URI: http://www.thulasidas.com
 */

/*
  Copyright (C) 2008 www.ads-ez.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



if (!class_exists("CdnBuster")) {

  require_once('EzOptions.php');

  class CdnBuster extends EzBasePlugin {

    var $siteUrl, $endPoint, $wpRoot;

    function __construct() { //constructor
      parent::__construct("cdn-buster", "CDN Buster", __FILE__);
      $this->prefix = 'cdnBuster';
      $defaultOptions = $this->mkDefaultOptions();
      $this->optionName = $this->prefix;
      $this->options = get_option($this->optionName);
      if (empty($this->options)) {
        $this->options = $defaultOptions;
      }
      else {
        $this->options = array_merge($defaultOptions, $this->options);
      }
      $this->siteUrl = trailingslashit(site_url());
      $this->endPoint = trailingslashit($this->options['pull_folder']) .
              trailingslashit($this->options['version_string']);
      $this->wpRoot = parse_url($this->siteUrl, PHP_URL_PATH);
      if (empty($this->wpRoot) || $this->wpRoot == DIRECTORY_SEPARATOR) {
        $this->wpRoot = "";
      }
      else {
        $this->wpRoot = trailingslashit($this->wpRoot);
      }
    }

    function mkDefaultOptions() {
      $defaultOptions = array(
          'pull_folder' => '',
          'version_string' => '') +
              parent::mkDefaultOptions();
      return $defaultOptions;
    }

    function mkEzOptions() {
      if (!empty($this->ezOptions)) {
        return;
      }
      parent::mkEzOptions();

      $o = new EzText('pull_folder');
      $o->title = __('Specify the location from which your CDN will pull your static files. If your CDN is <br><code>http://cdn.example.com/</code><br> and it pulls data from <br><code>http://www.example.com/static/img</code>,<br> specify it as <code>static/img</code> in the text box.', 'cdn-buster');
      $o->desc = __('CDN Origin Pull Location:', 'cdn-buster');
      $o->style = "width:50%;float:right";
      $o->after = "<br /><br />";
      $o->tipWidth = "300";
      $this->ezOptions['pull_folder'] = clone $o;

      $o = new EzText('version_string');
      $o->title = __('Enter a version string to invalidate all the currently cached files and make your CDN pull your static files afresh. After entering the version string, please enter the CDN URL in your WP Super Cache or W3 Total Cache settings. In the Pro version of this plugin, this step will not be necessary.', 'cdn-buster');
      $o->desc = __('Version String:', 'cdn-buster');
      $o->style = "width:50%;float:right";
      $o->after = "<br />";
      $o->tipWidth = "300";
      $this->ezOptions['version_string'] = clone $o;
    }

    function handleSubmits() {
      if (empty($_POST)) {
        return;
      }
      parent::handleSubmits();
      echo $this->adminMsg;
    }

    function adminPrintFooterScripts() {
      parent::adminPrintFooterScripts();
      ?>
      <script type='text/javascript'>
        jQuery(document).ready(function () {
          jQuery('body').on('click', '#hideshow', function (event) {
            jQuery('#supercache, #w3tc').hide('show');
            jQuery('#details').toggle('show');
            jQuery("#hideshow").prop('value', 'Show/Hide Detailed Info');
          });
          jQuery('body').on('click', '.supercache', function (event) {
            jQuery('#details, #w3tc').hide('show');
            jQuery('#supercache').toggle('show');
          });
          jQuery('body').on('click', '.w3tc', function (event) {
            jQuery('#details, #supercache').hide('show');
            jQuery('#w3tc').toggle('show');
          });
        });
      </script>
      <?php
    }

    //Prints out the admin page
    function printAdminPage() {
      $ez = parent::printAdminPage();
      if (empty($ez)) {
        return;
      }
      $this->handleSubmits();
      $this->mkEzOptions();
      $this->setOptionValues();

      echo <<<EOF1
<div class="wrap" style="width:1000px;">
    <h2>{$this->name}{$this->strPro}<a href="http://validator.w3.org/" target="_blank"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid HTML5" title="{$this->name}{$this->strPro} Admin Page is certified Valid HTML5" height="31" onmouseover="Tip('{$this->name}{$this->strPro} Admin Page is certified Valid HTML5, with no errors in the HTML code generated by the plugin.')" onmouseout="UnTip()" width="88" class="alignright"/></a>
</h2>
EOF1;
      $permaStructure = get_option('permalink_structure');
      if (empty($permaStructure)) {
        $permalink = admin_url('options-permalink.php');
        ?>
        <div class='error' style='padding:10px;margin:10px;color:#a00;font-weight:500;background-color:#fee;' id="permalinks">
          <p><strong>Permalinks</strong> are not enabled on your blog, which this plugin needs. Please <a href='<?php echo $permalink; ?>'>enable a permalink structure</a> for your blog from <strong><a href='<?php echo $permalink; ?>'>Settings &rarr; Permalinks</a></strong>.<br> Any structure (other than the ugly default structure using <code><?php echo site_url(); ?>/?p=123</code>) will do.</p>
        </div>
        <?php
      }
      ?>
      <h3>
        <?php
        _e('Introduction', 'cdn-buster');
        ?>
      </h3>
      <div style="width:45%;float:left;display:inline-block;padding:10px">
        <p>CDN Buster is a tool to invalidate the files cached on your CDN server <em>en masse</em>. It helps you update the stale files on your CDN server without spending money and time to track them down and invalidate them one by one.</p>
        <p>In the Pro version of this plugin, you can have the plugin automatically update Super Cache and W3 Cache CDN entries, or change the origin pull location on your CDN server without having to move any files on your blog. You can also specify the file types or individual files that you would like to invalidate.</p>
        <p><input type='button' id='hideshow' value='Show Detailed Info' class='button-secondary'/></p>
      </div>
      <div style="width:45%;float:left;display:inline-block;padding:10px">
        <table class="form-table">
          <tr style="vertical-align:middle">
            <?php
            $ez->renderHeadText();
            ?>
          </tr>
        </table>
      </div>
      <div style='clear:both'></div>
      <div id='details' style='clear:both;display:none;padding:10px;background-color:#ddf;font-size:1.1em'>
        <p><strong>Content Delivery Network</strong> (CDN) is a collection of geographically distributed servers that mirror and serve you static contents (images, JavaScrip/CSS files, movies etc.) to your readers much faster than your own blog server can. It speeds up your blog tremendously:</p>
        <ol>
          <li>It serves a large part of your website payload from servers that are close to the readers. CDN servers are specifically optimized for such contents.</li>
          <li>Since your resources on the CDN have different address (URL), the reader's browser loads the statc content and the dynamic content (from your blog server) in parallel, enhancing the user experience.</li>
          <li>The load on your blog server goes down becuase it is no longer serving a large part of the page content, which improves its performance.</li>
        </ol>
        <p>In short, if you are not using a CDN yet, you should. It is very easy to set it up if you use any popular cacching plugins (such as WP Super Cache or W3 Total Cache). Most CNDs are of the so-called Origin Pull kind, where the CDN server automatically pulls a file from a location (typically your blog itself) whenever it is asked to serve a file it doesn't have in its cache. This is usually a one-time operation, which is slow. The CDN then proceeds to mirror the file on its servers all over the world. Thereafter, whenever the file is requested, the file is served instantly from a server closest to the reader.</p>
        <p>Once you use a Content Delivery Network (CDN) such as Amazon Cloudfront to speed up your blog, you will come across instances when you update a static file (a style or image file, for instance), but your readers keep getting the stale file from the CDN. No amount of cache clearing on your blog server is going to help because the stale file is in the CDN. The only way would be to "invalidate" the file, which will signal the CDN to pull a fresh copy from the origin location. But this necessitates you to log on to the CDN server, locate the file, generate a proper invalidation request, and wait for it to percolate to all the mirrors. And it often costs money.</p>
        <p><strong>CDN Buster</strong> offers a much easier alternative. You enter a <em>Version String</em> in the option below, and append the same string where you define the CDN address in your caching plugins, such as <a href='#' class="supercache">WP Super Cache</a> or <a href='#' class="w3tc">W3 Total Cache</a>. This way, when your reader loads a page, he is looking for a different file, and your CDN server will query your blog server for it, where this plugin will intercept the query and serve the modified file from the <em>original</em> location. Thus, the modified file will get loaded on your CDN and all will be well.</p>
        <p>The <a href="http://buy.thulasidas.com/cdn-buster" title="Buy the Pro version of CDN Buster for $5.95. Instant download link." class="popup">Pro version</a> gives you more tools to control how the invalidation works. You can set it to automatically update the CDN settings in your WP Super Cache or W3 Total Cache plugin. Or you can change origin pull location on your CDN server to a generic string (e.g. <code>cdn-bustor-*</code> where <code>*</code> can be anything) without touching your blog settings to invalidate the cache. You can even specify the file name or file type to further control your invalidations. <a href="http://buy.thulasidas.com/cdn-buster" title="Buy the Pro version of CDN Buster for $5.95. Instant download link." class="popup">CDN Bustoer Pro</a> is a complete CDN invalidation tool for managing any origin pull networks.</p>
      </div>
      <div id='supercache' style='clear:both;display:none;padding:10px;background-color:#ddf;font-size:1.1em'>
        <p><strong>WP Super Cache</strong> is a popular plugin that supports CDNs. In order to set up your CDN, please follow the steps below:</p>
        <ol>
          <li>Get a CDN account (on Amazon Cloudfront or any other network) and generate an origin pull distribution for your blog.</li>
          <li>Copy the CDN address from your server interface.</li>
          <li>Visit WP Super Cache admin page on your blog, open the CDN tab, and enter the CDN details.</li>
          <li><strong>When you want to invalidate your CDN, change the <em>Version String</em> option below.</strong></li>
          <li><strong>Visit WP Super Cache admin page on your blog, CDN tab, and append <em>Version String</em> to the CDN address.</strong></li>
        </ol>
        <p>In the <a href="http://buy.thulasidas.com/cdn-buster" title="Buy the Pro version of CDN Buster for $5.95. Instant download link." class="popup">Pro version</a>, you can set the plugin  to automatically update the CDN settings in WP Super Cache.</p>
        <p><input type='button' value='Hide Info on WP Super Cache' class='button-secondary supercache'/></p>
      </div>
      <div id='w3tc' style='clear:both;display:none;padding:10px;background-color:#ddf;font-size:1.1em'>
        <p><strong>W3 Total Cache</strong> is a very popular plugin that supports CDNs. You can set up your CDN in multiple ways in W3 Total Cache. <strong>CDN Buster</strong> works only if you need to set it up as <em>Generic Mirror</em>. In order to set up your CDN in this mode, please follow the steps below:</p>
        <ol>
          <li>Get a CDN account (on Amazon Cloudfront or any other network) and generate an origin pull distribution for your blog.</li>
          <li>Copy the CDN address from your server interface.</li>
          <li>Visit W3 Total Cache admin page on your blog by clicking <em>General Settings</em> under the <strong>Performance</strong> menu.</li>
          <li>Specify the <em>CDN Type</em> as <em>Generic Mirror</em>.</li>
          <li>open the CDN tab, and enter the CDN details.</li>
          <li>Click on the <em>CDN</em> menu item under the <strong>Performance</strong> menu.</li>
          <li>Enter the CDN details in the <strong>Configuration</strong> section where it says <em>Repalce site's hostname with</em>.</li>
          <li><strong>When you want to invalidate your CDN, change the <em>Version String</em> option below.</strong></li>
          <li><strong>Append <em>Version String</em> to the CDN address (where it says <em>Repalce site's hostname with</em>).</strong></li>
        </ol>
        <p>In the <a href="http://buy.thulasidas.com/cdn-buster" title="Buy the Pro version of CDN Buster for $5.95. Instant download link." class="popup">Pro version</a>, you can set the plugin  to automatically update the CDN settings in W3 Total Cache.</p>
        <p><input type='button' value='Hide Info on W3 Total Cache' class='button-secondary w3tc'/></p>
      </div>
      <form method='post' action='#'>
        <?php
        $this->renderNonce();
        ?>
        <h3>
          <?php
          printf(__('CDN Buster', 'cdn-buster'));
          ?>
        </h3>
        <div style="width:45%;float:left;display:inline-block;padding:10px">
          <?php
          $this->ezOptions['pull_folder']->render();
          $this->ezOptions['version_string']->render();
          $this->ezOptions['kill_author']->render();
          ?>
        </div>
        <div style="width:45%;float:right;display:inline-block;">
          <p>The current CDN pull location is <code><?php echo $this->siteUrl . $this->options['pull_folder']; ?></code></p>
          <p>Append the folder location <code><?php echo $this->options['version_string']; ?></code> to your CDN specifications in your caching plugins to make it pull your static files again.</p>
          <p>Help: <a href='#' class="supercache">WP Super Cache</a> or <a href='#' class="w3tc">W3 Total Cache</a></p>
        </div>
        <div style="clear:both"></div>
        <div class="submit">
          <?php
          $this->renderSubmitButtons();
          ?>
        </div>
      </form>

      <?php
      $ez->renderWhyPro();
      $ez->renderSupport();
      $ez->renderTailText();
      ?>
      </div>
      <?php
    }

    function parseRequest(&$wp) {
      if (strpos($_SERVER['REQUEST_URI'], $this->endPoint) === false) {
        return;
      }
      $request = $_SERVER['REQUEST_URI'];
      $request = preg_replace('/\?.*/', '', $request);
      $request = str_replace($this->options['version_string'], "", $request);
      if (!empty($this->wpRoot)) {
        $request = str_replace($this->wpRoot, "", $request);
      }
      $request = trim($request, DIRECTORY_SEPARATOR . "\\/");
      $target = trailingslashit(ABSPATH) . $request;
      if (file_exists($target)) {
        $headers = get_headers($this->siteUrl . $request);
        foreach ($headers as $h) {
          header($h);
        }
        readfile(self::getRealPath($target));
        exit();
      }
    }

  }

} //End Class CdnBuster

if (class_exists("CdnBuster")) {
  $cdnBuster = new CdnBuster();
  add_action('parse_request', array($cdnBuster, 'parseRequest'));
}