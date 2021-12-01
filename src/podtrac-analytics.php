<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing
// phpcs:disable Squiz.Commenting.BlockComment.LineIndent, Squiz.Commenting.BlockComment.FirstLineIndent, Squiz.Commenting.FileComment.WrongStyle, PEAR.Commenting.FileComment.WrongStyle, Squiz.Commenting.FileComment.Missing, Squiz.Commenting.BlockComment.NoEmptyLineBefore, Squiz.Commenting.BlockComment.NoEmptyLineAfter
/*
Plugin Name: Add Podtrac Analytics for Seriously Simple Podcasting
Description: This is to add Podtrac & Blubrry analytics to Seriously Simple Podcasting Wordpress Plugin.
Author: snightingale
Version: 0.1.8
Donate link: https://nowpayments.io/donation/darthvader666uk
License: GPLv2 or later
Text Domain: add-podtrac-analytics-for-seriously-simple-podcasting
Domain Path: /languages
Author URI: https://profiles.wordpress.org/snightingale/
*/
// phpcs:enable Squiz.Commenting.BlockComment.LineIndent, Squiz.Commenting.BlockComment.FirstLineIndent, Squiz.Commenting.FileComment.WrongStyle, PEAR.Commenting.FileComment.WrongStyle

/**
 * Adding new settings to the Podtrac Analytics tab for Seriously Simple Podcasting
 *
 * @param  array $settings These are the setting passed from the Seriously Simple Podcasting Plugin
 * @return array
 */
function podtrac_analytics_add_new_settings(array $settings) {
	$settings['podtrac_analytics'] = array(
		'title'       => __('Podtrac & Blubrry Analytics', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
		'description' => __('This is to add Podtrac & Blubrry analytics to Seriously Simple Podcasting Wordpress Plugin.', 'add-podtrac-analytics-for-seriously-simple-podcasting').
		'<ul>'.
			__(' <li><b>Podtrac\'s</b> Measurement Service is free to most publishers. It provides third-party measurement data not available anywhere else. When using this, all enclosure URLs will be prefixed, and do not need to be updated by the user. If you dont have Podtrac Account yet, go to ', 'add-podtrac-analytics-for-seriously-simple-podcasting').'<a href="https://publisher.podtrac.com">Podtrac</a>'.__(' to sign up.', 'add-podtrac-analytics-for-seriously-simple-podcasting').'</li>'.
			__(' <li><b>Blubrry</b> provides Free Basic Podcast Statistics service for podcasters. If you dont have Blubrry Account yet, go to ', 'add-podtrac-analytics-for-seriously-simple-podcasting').'<a href="https://create.blubrry.com/resources/podcast-media-download-statistics/basic-statistics/">Blubrry</a>'.__(' and follow the instructions to sign up.', 'add-podtrac-analytics-for-seriously-simple-podcasting').'</li>'.
			'<br>'.
			__(' <li>If you find <b>Add Podtrac Analytics for Seriously Simple Podcasting</b> useful, Please leave a ', 'add-podtrac-analytics-for-seriously-simple-podcasting') .'<a href="https://wordpress.org/support/plugin/add-podtrac-analytics-for-seriously-simple-podcasting/reviews/#new-post" target="_blank" class="ssp-rating-link" data-rated="Thanks!">★★★★★</a>' .__(' Review. I really appreciate your support and a BIG Thank you in Advance!', 'add-podtrac-analytics-for-seriously-simple-podcasting').'</li>'.
		'</ul>',
		'fields'      => array(
			array(
				'id'          => 'podtrac_analytics_episode_measurement_service',
				'label'       => __('Enable Podtrac Episode Measurement Service', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('This will add the tracking to the podcast media file URL.', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'checkbox',
				'default'     => '',
			),
			array(
				'id'          => 'podtrac_analytics_episode_measurement_service_radio',
				'label'       => __('Podtrac HTTP or HTTPS', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('Switch between HTTP or HTTPS for Podtrac analytics.', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'radio',
				'options'     => array(
					'http'  => __('HTTP: http://dts.podtrac.com/redirect.mp3/', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
					'https' => __('HTTPS: https://dts.podtrac.com/redirect.mp3/', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				),
				'default'     => 'https',
			),
			array(
				'id'          => 'podtrac_blubrry_stats_episode_measurement_service',
				'label'       => __('Enable Blubrry Stats Service', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('This will add the tracking to the podcast media file URL. This can be combined with Podtrac stats. Note: This <b>WILL NOT WORK</b> if you dont have a Podtrac account. Both will need to be setup', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'checkbox',
				'default'     => '',
			),
			array(
				'id'          => 'podtrac_blubrry_stats_episode_measurement_service_radio',
				'label'       => __('Blubrry HTTP or HTTPS', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('Switch between HTTP or HTTPS for Blubrry analytics.', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'radio',
				'options'     => array(
					'http'  => __('HTTP: http://media.blubrry.com/', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
					'https' => __('HTTPS: https://media.blubrry.com/', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				),
				'default'     => 'https',
			),
			array(
				'id'          => 'podtrac_blubrry_stats_episode_measurement_service_name',
				'label'       => __('Blubrry Stats Service Name', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('Please Enter your Blurry Podcast Name. This Can be found under <b>getting_started</b>-><b>Your Media Redirect URL</b>.', 'seriously-simple-podcasting'),
				'type'        => 'text',
				'default'     => '',
				'placeholder' => __('Enter Blubrry Stats Service Name', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'class'       => 'regular-text',
				'callback'    => 'wp_strip_all_tags',
			),
			array(
				'id'          => 'podtrac_analytics_refresh_rss_cache',
				'label'       => __('Refresh RSS Cache', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'description' => __('This will refresh the RSS cache as by default its 12 hours', 'add-podtrac-analytics-for-seriously-simple-podcasting'),
				'type'        => 'checkbox',
				'default'     => '',
			),
		)
	);
	return $settings;
}

add_filter('ssp_settings_fields', 'podtrac_analytics_add_new_settings');

/**
 * If the option is ticked to allow tracking, this will amend the Podcast media URL
 *
 * @param  string  $link       The URL of the Podcast Before adding tracking
 * @param  integer $episode_id The Podcasr Episode ID
 * @param  string  $file       The File of the podcast media
 * @return string
 */
function podtrac_analytics_download_url_filter($link, $episode_id, $file) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- Unused function parameter $episode_id and $file
	// Get the select option for Enable Podtrac Episode Measurement Service
	$podtrac_analytics_redirect = get_option('ss_podcasting_podtrac_analytics_episode_measurement_service', 'off');
	$blubrry_stats_redirect     = get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service', 'off');

	// Default for the normal URL
	$redirect_link = esc_url_raw($link);

	// Get the section from original URL
	$parsed_url = parse_url($link);

	ob_start();
	print("parse_url  \n");
	print_r($parsed_url);
	print ("\n\n");
	$output = ob_get_contents();
	ob_end_clean();
	error_log($output);

	$url_query = isset($parsed_url['query']) ? '?'.$parsed_url['query'] : '';

	// For Just Podtrac
	if ('on' === $podtrac_analytics_redirect) {
		// Get Podtrac radio options
		$podtrac_analytics_radio = get_option('ss_podcasting_podtrac_analytics_episode_measurement_service_radio', 'https');

		// Re-created the URl with additional tracking
		$redirect_link = esc_url($podtrac_analytics_radio.'://dts.podtrac.com/redirect.mp3/'.$parsed_url['host'].$parsed_url['path'].$url_query);
	}

	// For Just Blubrry
	if ('on' === $blubrry_stats_redirect) {
		// Get Blubrry Service Name
		$blubrry_service_name = get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service_name', '');

		// Get Blubrry radio options
		$blubrry_analytics_radio = get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service_radio', 'https');

		// Check to make sure its not empty
		if ($blubrry_service_name) {
			// Re-created the URl with additional tracking
			$redirect_link = esc_url($blubrry_analytics_radio.'://media.blubrry.com/'.$blubrry_service_name.'/'.$parsed_url['host'].$parsed_url['path'].$url_query);
		}
	}


	// For Both Podtrac & BluBrry
	if ('on' === $podtrac_analytics_redirect && 'on' === $blubrry_stats_redirect) {
		// Get Blubrry Service Name
		$blubrry_service_name = get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service_name', '');

		// Get Blubrry radio options
		$blubrry_analytics_radio = get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service_radio', 'https');

		// Check to make sure its not empty
		if ($blubrry_service_name) {
			// Re-created the URl with additional tracking
			$redirect_link = esc_url($blubrry_analytics_radio.'://media.blubrry.com/'.$blubrry_service_name.'/dts.podtrac.com/redirect.mp3/'.$parsed_url['host'].$parsed_url['path'].$url_query);
		}
	}

	// Return Redirect
	return $redirect_link;
}

add_filter('ssp_episode_download_link', 'podtrac_analytics_download_url_filter', 10, 3);

/**
 * Check to make sure Blubrry Name isnt blank otherwise show an error
 */
function podtrac_blubrry_check() {
	// Check to see if Blubrry has been enabled
	if ('on' === get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service', 'off')) {
		// Check to make sure service name isnt empty
		if (empty(get_option('ss_podcasting_podtrac_blubrry_stats_episode_measurement_service_name', ''))) {
			?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e('<b>Blubrry Error:</b> No Blubrry Service has been entered', 'add-podtrac-analytics-for-seriously-simple-podcasting'); ?></p>
			</div>
			<?php
		}
	}
}
add_action('admin_notices', 'podtrac_blubrry_check');

/**
 * Refresh the RSS feed if the option is ticked.  Needed to add the tracking straight away
 *
 * @return integer
 */
function podtrac_analytics_refresh_rss_cache() {
	// Get option for Refresh RSS Cache
	$rss_cache_refresh = get_option('ss_podcasting_podtrac_analytics_refresh_rss_cache', 'off');

	// Check if tick box is true
	if ('on' === $rss_cache_refresh) {
		return 60;
	} else {
		// Default back to 2 hours
		return 43200;
	}
}

add_filter('wp_feed_cache_transient_lifetime', 'podtrac_analytics_refresh_rss_cache', 10, 4);

/**
 * This function will load the languages from /languages/
 *
 * @return void
 */
function add_podtrac_analytics_for_seriously_simple_podcasting_load_plugin_textdomain() {
	load_plugin_textdomain('add-podtrac-analytics-for-seriously-simple-podcasting', false, basename(dirname(__FILE__)).'/languages/');
}
add_action('plugins_loaded', 'add_podtrac_analytics_for_seriously_simple_podcasting_load_plugin_textdomain');
