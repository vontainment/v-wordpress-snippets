<?php
/*
 * Plugin Name: Github Embeds
 * Plugin URI: https://vontainment.com
 * Description: This plugin creates Github WP Embeds
 * Author: YVontainment
 * Version: 1.0
 * Author URI: https://vontainment.com
 */

function register_github_oembed_provider() {
    wp_oembed_add_provider( '#https?://(www\.)?github\.com/([A-Za-z0-9-_.]+/[A-Za-z0-9-_.]+)/?#', 'https://api.github.com/$2?output=embed', true );
}
add_action( 'init', 'register_github_oembed_provider' );
