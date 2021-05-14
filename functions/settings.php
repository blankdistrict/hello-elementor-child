<?php

// Enables post format support
$global_enable_post_format_support = false;
global $global_enable_post_format_support;


// Enables or disables Gutenberg
$global_enable_gutenberg = false;
global $global_enable_gutenberg;

/**
 * @var array $global_acf_settings
 * ACF settings
 * - enable (bool): Enables the custom ACF integration
 * - options-page (array): Settings to create the options page
 * - - enable (bool): Settings to enable the options page
 * - - settings (array): Settings to create the options page
 * - - subpages (array): Settings to create the option subpages
 * - colors (array): Colors for the color picker (to match theme)
 */
$global_acf_settings = array(
	'enable'       => true,
	'options-page' => array(
		'enable'   => true,
		'settings' => array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'icon_url'   => 'dashicons-art',
			'redirect'   => false,
		),
		'subpages' => array(
			'subpage-1' => array(
				'page_title'  => 'Header Settings',
				'menu_title'  => 'Header',
				'parent_slug' => 'theme-general-settings',
			),
		),
	),
	'colors'       => array(
		'color-1' => '#1a1a1a',
		'color-2' => '#f9f9f9',
		'color-3' => '#2D779C',
		'color-4' => '#0F3A4F',
		'color-5' => '#9C5600',
	),
);
global $global_acf_settings;


// Settings for Gravity Forms
$global_gf_settings = array(
	'enable' => false,
);
global $global_gf_settings;

// Enables Elementor
$global_elementor_settings = array(
	'enable' => true,
);
global $global_elementor_settings;
