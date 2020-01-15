<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing
// phpcs:disable Squiz.Commenting.BlockComment.LineIndent, Squiz.Commenting.BlockComment.FirstLineIndent, Squiz.Commenting.FileComment.WrongStyle, PEAR.Commenting.FileComment.WrongStyle, Squiz.Commenting.FileComment.Missing, Squiz.Commenting.BlockComment.NoEmptyLineBefore, Squiz.Commenting.BlockComment.NoEmptyLineAfter
/*
Plugin Name: Podtrac Analytics for Seriously Simple Podcasting
Description: This is to add Podtrac analytics to Seriously Simple Podcasting Wordpress Plugin.
Author: snightingale
Version: 0.1.0
Donate link: https://www.paypal.me/darthvader666uk
License: GPLv2 or later
Text Domain: podtrac-analytics-for-seriously-simple-podcasting
Domain Path: /languages
Author URI: https://profiles.wordpress.org/snightingale/
*/
// phpcs:enable Squiz.Commenting.BlockComment.LineIndent, Squiz.Commenting.BlockComment.FirstLineIndent, Squiz.Commenting.FileComment.WrongStyle, PEAR.Commenting.FileComment.WrongStyle

add_filter('ssp_settings_fields', 'podtrac_analytics_add_new_settings');

/**
 * Adding new settings to the Podtrac Analytics tab for Seriously Simple Podcasting
 *
 * @param  array $settings These are the setting passed from the Seriously Simple Podcasting Plugin
 * @return array
 */
function podtrac_analytics_add_new_settings(array $settings) {
	$settings['podtrac_analytics'] = array(
		'title'       => __('Podtrac Analytics', 'podtrac-analytics-for-seriously-simple-podcasting'),
		'description' => __('This is to add Podtrac analytics to Seriously Simple Podcasting Wordpress Plugin.', 'podtrac-analytics-for-seriously-simple-podcasting').__(' Podtrac\'s Measurement Service is free to most publishers. It provides third-party measurement data not available anywhere else. When using this, all enclosure URLs will be prefixed, and do not need to be updated by the user. If you dont have Podtrac Account yet, go to ', 'podtrac-analytics-for-seriously-simple-podcasting').'<a href="https://publisher.podtrac.com">Podtrac</a>'.__(' to sign up.', 'podtrac-analytics-for-seriously-simple-podcasting'),
		'fields'      => array(
			array(
				'id'          => 'podtrac_analytics_episode_measurement_service',
				'label'       => __('Enable Podtrac Episode Measurement Service', 'podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('This will add the tracking to the podcast media file URL. Defaulted to HTTPS', 'podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'checkbox',
				'default'     => '',
			),
			array(
				'id'          => 'podtrac_analytics_refresh_rss_cache',
				'label'       => __('Refresh RSS Cache', 'podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('This will refresh the RSS cache as by default its 12 hours', 'podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'checkbox',
				'default'     => '',
			),
		),
	);
	return $settings;
}

add_filter('ssp_episode_download_link', 'podtrac_analytics_download_url_filter', 10, 3);

/**
 * If the option is ticked to allow tracking, this will amend the Podcast media URL
 *
 * @param  string  $link       The URL of the Podcast Before adding tracking
 * @param  integer $episode_id The Podcasr Episode ID
 * @param  string  $file       The File of the podcast media
 * @return string
 */
function podtrac_analytics_download_url_filter(string $link, int $episode_id, string $file) {
	// Get the select option for Enable Podtrac Episode Measurement Service
	$podtrac_analytics_redirect = get_option('ss_podcasting_podtrac_analytics_episode_measurement_service', 'off');

	// Check if Tick box is true
	if ('on' === $podtrac_analytics_redirect) {
		// Get the section from original URL
		$parsed_url = parse_url($link);

		// Re-created the URl with additional tracking
		$redirect_link = esc_url('https://dts.podtrac.com/redirect.mp3/'.$parsed_url['host'].$parsed_url['path']);
	} else {
		$redirect_link = esc_url_raw($link);
	}

	// Return Redirect
	return $redirect_link;
}

// Refresh feed if tracking updated
add_filter('wp_feed_cache_transient_lifetime', 'podtrac_analytics_refresh_rss_cache', 10, 4);

/**
 * Refresh the RSS feed if the option is ticked.  Needed to add the tracking straight away
 *
 * @param  integer $lifetime Cache duration in seconds. Default is 43200 seconds (12 hours).
 * @param  string  $filename Unique identifier for the cache object.
 * @return void
 */
function podtrac_analytics_refresh_rss_cache(int $lifetime, string $filename) {
	// Get option for Refresh RSS Cache
	$rss_cache_refresh = get_option('ss_podcasting_podtrac_analytics_refresh_rss_cache', 'off');

	// Check if tick box is true
	if ('on' === $rss_cache_refresh) {
		create_function('', 'return 60;');
	} else {
		// Default back to 2 hours
		create_function('', 'return 43200;');
	}
}
