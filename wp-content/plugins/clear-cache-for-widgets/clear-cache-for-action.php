<?php

/**
 * Clear the caches for menus.
 */
function ccfm_clear_cache_for_menus() {
    ccfm_clear_cache_for_me( 'menu' );
}

/**
 * Clear the caches for widgets.  Thanks to Ov3rfly
 */
function ccfm_clear_cache_for_widgets_wp_ajax_action() {
    // wp-admin/admin-ajax.php
    // 'widgets-order', 'save-widget'
    ccfm_clear_cache_for_me( 'widget' );
}
function ccfm_clear_cache_for_widgets_sidebar_admin_setup() {
    // wp-admin/widgets.php
    // We're saving/deleting a widget without js/ajax
    if ( !empty( $_POST ) && ( isset($_POST['savewidget']) || isset($_POST['removewidget']) ) ) {
        ccfm_clear_cache_for_me( 'widget' );
    }
}

/**
 * Clear the cache when a theme customizations are saved (in Appearance->Customize)
 */
function ccfm_clear_cache_for_customized_theme() {
    ccfm_clear_cache_for_me( 'customize' );   
}

/**
 * Clear the cache when a settings are updated from any settings page.
 * Not ideal to do this in a filter, but one of the only available hooks to do this for just settings pages.
 */
function ccfm_clear_cache_for_settings( $settings_errors ) {
    //only clear cache when successfully updated
    if ( count( $settings_errors ) == 1 ) {
        $settings_error = $settings_errors[0];
        if ( isset( $settings_error['code'] ) && $settings_error['code'] == 'settings_updated' ) {
            ccfm_clear_cache_for_me( 'settings' );
        }
    }
    return $settings_errors;
}

/**
 * Clear cache when Contact Form 7 forms are saved.
 */
function ccfm_clear_cache_for_cf7() {
    ccfm_clear_cache_for_me( 'cf7' );
}

/**
 * Clear cache when WooThemes options are updated.
 */
function ccfm_clear_cache_for_woo_options() {
    ccfm_clear_cache_for_me( 'woo_options' );
}

/**
 * Clear cache when NextGen Gallery galleries and albums are updated.
 */
function ccfm_clear_cache_for_ngg() {
    ccfm_clear_cache_for_me( 'ngg' );
}
