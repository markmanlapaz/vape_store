<?php
/**
 * Theme Customizer – registers all panels, sections, settings & controls.
 *
 * @package Flavor_Starter
 */

defined( 'ABSPATH' ) || exit;

function flavor_starter_customize_register( $wp_customize ) {

	/*------------------------------------------------------------------
	 * Panel: Theme Options
	 *----------------------------------------------------------------*/
	$wp_customize->add_panel( 'fs_theme_options', array(
		'title'    => __( 'Flavor Starter Options', 'flavor-starter' ),
		'priority' => 30,
	) );

	/*------------------------------------------------------------------
	 * Section: Colors
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_colors', array(
		'title' => __( 'Theme Colors', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$color_settings = array(
		'fs_color_accent_primary'   => array( __( 'Accent Primary (Purple)', 'flavor-starter' ),   '#8b5cf6' ),
		'fs_color_accent_secondary' => array( __( 'Accent Secondary (Cyan)', 'flavor-starter' ),   '#06b6d4' ),
		'fs_color_accent_tertiary'  => array( __( 'Accent Tertiary (Pink)', 'flavor-starter' ),    '#ec4899' ),
		'fs_color_bg_primary'       => array( __( 'Background Primary', 'flavor-starter' ),        '#0a0a0f' ),
		'fs_color_bg_secondary'     => array( __( 'Background Secondary', 'flavor-starter' ),      '#12121a' ),
		'fs_color_bg_card'          => array( __( 'Card Background', 'flavor-starter' ),           '#1a1a25' ),
		'fs_color_text_primary'     => array( __( 'Text Primary', 'flavor-starter' ),              '#f1f1f4' ),
		'fs_color_text_secondary'   => array( __( 'Text Secondary', 'flavor-starter' ),            '#a1a1b5' ),
	);

	foreach ( $color_settings as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data[1],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => $data[0],
			'section' => 'fs_colors',
		) ) );
	}

	/*------------------------------------------------------------------
	 * Section: Typography
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_typography', array(
		'title' => __( 'Typography', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$font_choices = array(
		"'Outfit', sans-serif"       => 'Outfit',
		"'DM Sans', sans-serif"      => 'DM Sans',
		"'Space Mono', monospace"    => 'Space Mono',
		"'Inter', sans-serif"        => 'Inter',
		"'Poppins', sans-serif"      => 'Poppins',
		"'Montserrat', sans-serif"   => 'Montserrat',
	);

	$wp_customize->add_setting( 'fs_font_heading', array(
		'default'           => "'Outfit', sans-serif",
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_font_heading', array(
		'label'   => __( 'Heading Font', 'flavor-starter' ),
		'section' => 'fs_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'fs_font_body', array(
		'default'           => "'DM Sans', sans-serif",
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_font_body', array(
		'label'   => __( 'Body Font', 'flavor-starter' ),
		'section' => 'fs_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'fs_font_accent', array(
		'default'           => "'Space Mono', monospace",
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_font_accent', array(
		'label'   => __( 'Accent / Mono Font', 'flavor-starter' ),
		'section' => 'fs_typography',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	/*------------------------------------------------------------------
	 * Section: Header
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_header', array(
		'title' => __( 'Header', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_header_layout', array(
		'default'           => 'default',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_header_layout', array(
		'label'   => __( 'Header Layout', 'flavor-starter' ),
		'section' => 'fs_header',
		'type'    => 'select',
		'choices' => array(
			'default'  => __( 'Default (Logo Left)', 'flavor-starter' ),
			'centered' => __( 'Centered Logo', 'flavor-starter' ),
		),
	) );

	$wp_customize->add_setting( 'fs_topbar_show', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_starter_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fs_topbar_show', array(
		'label'   => __( 'Show Top Bar', 'flavor-starter' ),
		'section' => 'fs_header',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'fs_topbar_text', array(
		'default'           => __( 'Free shipping on orders over $50! Use code VAPE15 for 15% off.', 'flavor-starter' ),
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'fs_topbar_text', array(
		'label'   => __( 'Top Bar Text', 'flavor-starter' ),
		'section' => 'fs_header',
		'type'    => 'text',
	) );

	/*------------------------------------------------------------------
	 * Section: Hero Banner
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_hero', array(
		'title' => __( 'Hero Banner', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_hero_style', array(
		'default'           => 'gradient',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_hero_style', array(
		'label'   => __( 'Hero Style', 'flavor-starter' ),
		'section' => 'fs_hero',
		'type'    => 'select',
		'choices' => array(
			'gradient' => __( 'Gradient (Default)', 'flavor-starter' ),
			'image'    => __( 'Background Image', 'flavor-starter' ),
		),
	) );

	$hero_text_settings = array(
		'fs_hero_title'    => array( __( 'Title', 'flavor-starter' ),    __( 'Premium Vape & E-Liquids', 'flavor-starter' ) ),
		'fs_hero_subtitle' => array( __( 'Subtitle', 'flavor-starter' ), __( 'Experience the finest flavors crafted for enthusiasts', 'flavor-starter' ) ),
		'fs_hero_btn_text' => array( __( 'Button 1 Text', 'flavor-starter' ), __( 'Shop Now', 'flavor-starter' ) ),
		'fs_hero_btn_url'  => array( __( 'Button 1 URL', 'flavor-starter' ),  '#' ),
		'fs_hero_btn2_text'=> array( __( 'Button 2 Text', 'flavor-starter' ), __( 'New Arrivals', 'flavor-starter' ) ),
		'fs_hero_btn2_url' => array( __( 'Button 2 URL', 'flavor-starter' ),  '#' ),
	);

	foreach ( $hero_text_settings as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $data[0],
			'section' => 'fs_hero',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_setting( 'fs_hero_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fs_hero_bg_image', array(
		'label'   => __( 'Hero Background Image', 'flavor-starter' ),
		'section' => 'fs_hero',
	) ) );

	$wp_customize->add_setting( 'fs_hero_product_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fs_hero_product_image', array(
		'label'   => __( 'Hero Product Image', 'flavor-starter' ),
		'section' => 'fs_hero',
	) ) );

	/*------------------------------------------------------------------
	 * Section: Homepage Sections
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_homepage', array(
		'title' => __( 'Homepage Sections', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$homepage_texts = array(
		'fs_categories_title'    => array( __( 'Categories Title', 'flavor-starter' ),    __( 'Shop by Category', 'flavor-starter' ) ),
		'fs_categories_subtitle' => array( __( 'Categories Subtitle', 'flavor-starter' ), __( "Find exactly what you're looking for", 'flavor-starter' ) ),
		'fs_featured_title'      => array( __( 'Featured Title', 'flavor-starter' ),      __( 'Featured Products', 'flavor-starter' ) ),
		'fs_featured_subtitle'   => array( __( 'Featured Subtitle', 'flavor-starter' ),   __( 'Our most popular picks, hand-selected for you', 'flavor-starter' ) ),
		'fs_arrivals_title'      => array( __( 'New Arrivals Title', 'flavor-starter' ),  __( 'New Arrivals', 'flavor-starter' ) ),
		'fs_arrivals_subtitle'   => array( __( 'New Arrivals Subtitle', 'flavor-starter' ), __( 'Just dropped — be the first to try', 'flavor-starter' ) ),
	);

	foreach ( $homepage_texts as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $data[0],
			'section' => 'fs_homepage',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_setting( 'fs_featured_count', array(
		'default'           => 8,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'fs_featured_count', array(
		'label'   => __( 'Featured Products Count', 'flavor-starter' ),
		'section' => 'fs_homepage',
		'type'    => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 16, 'step' => 1 ),
	) );

	$wp_customize->add_setting( 'fs_home_show_blog', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_starter_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fs_home_show_blog', array(
		'label'   => __( 'Show Latest Blog Posts', 'flavor-starter' ),
		'section' => 'fs_homepage',
		'type'    => 'checkbox',
	) );

	/*------------------------------------------------------------------
	 * Section: Promo Banners
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_promos', array(
		'title' => __( 'Promo Banners', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_promo_show', array(
		'default'           => true,
		'sanitize_callback' => 'flavor_starter_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fs_promo_show', array(
		'label'   => __( 'Show Promo Banners', 'flavor-starter' ),
		'section' => 'fs_promos',
		'type'    => 'checkbox',
	) );

	$promo_fields = array(
		'fs_promo1_title' => array( __( 'Promo 1 Title', 'flavor-starter' ),  __( 'Starter Kits', 'flavor-starter' ) ),
		'fs_promo1_text'  => array( __( 'Promo 1 Text', 'flavor-starter' ),   __( 'Everything you need to get started', 'flavor-starter' ) ),
		'fs_promo1_btn'   => array( __( 'Promo 1 Button', 'flavor-starter' ), __( 'Shop Kits', 'flavor-starter' ) ),
		'fs_promo1_url'   => array( __( 'Promo 1 URL', 'flavor-starter' ),    '#' ),
		'fs_promo2_title' => array( __( 'Promo 2 Title', 'flavor-starter' ),  __( 'Premium E-Liquids', 'flavor-starter' ) ),
		'fs_promo2_text'  => array( __( 'Promo 2 Text', 'flavor-starter' ),   __( 'Over 200 flavors to choose from', 'flavor-starter' ) ),
		'fs_promo2_btn'   => array( __( 'Promo 2 Button', 'flavor-starter' ), __( 'Browse Flavors', 'flavor-starter' ) ),
		'fs_promo2_url'   => array( __( 'Promo 2 URL', 'flavor-starter' ),    '#' ),
	);

	foreach ( $promo_fields as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $data[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $data[0],
			'section' => 'fs_promos',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_setting( 'fs_promo1_bg', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fs_promo1_bg', array(
		'label' => __( 'Promo 1 Background', 'flavor-starter' ), 'section' => 'fs_promos',
	) ) );

	$wp_customize->add_setting( 'fs_promo2_bg', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fs_promo2_bg', array(
		'label' => __( 'Promo 2 Background', 'flavor-starter' ), 'section' => 'fs_promos',
	) ) );

	/*------------------------------------------------------------------
	 * Section: Footer
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_footer', array(
		'title' => __( 'Footer', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_footer_layout', array(
		'default'           => 'default',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_footer_layout', array(
		'label'   => __( 'Footer Layout', 'flavor-starter' ),
		'section' => 'fs_footer',
		'type'    => 'select',
		'choices' => array(
			'default' => __( 'Default (4 columns)', 'flavor-starter' ),
			'minimal' => __( 'Minimal', 'flavor-starter' ),
		),
	) );

	$wp_customize->add_setting( 'fs_footer_newsletter', array(
		'default' => true, 'sanitize_callback' => 'flavor_starter_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fs_footer_newsletter', array(
		'label' => __( 'Show Newsletter Section', 'flavor-starter' ), 'section' => 'fs_footer', 'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'fs_newsletter_title', array(
		'default' => __( 'Get 15% Off Your First Order', 'flavor-starter' ), 'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_newsletter_title', array(
		'label' => __( 'Newsletter Title', 'flavor-starter' ), 'section' => 'fs_footer', 'type' => 'text',
	) );

	$wp_customize->add_setting( 'fs_newsletter_text', array(
		'default' => __( 'Subscribe for exclusive deals, new arrivals, and vaping tips.', 'flavor-starter' ), 'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_newsletter_text', array(
		'label' => __( 'Newsletter Text', 'flavor-starter' ), 'section' => 'fs_footer', 'type' => 'text',
	) );

	$wp_customize->add_setting( 'fs_footer_copyright', array(
		'default' => '', 'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'fs_footer_copyright', array(
		'label' => __( 'Copyright Text (leave empty for default)', 'flavor-starter' ), 'section' => 'fs_footer', 'type' => 'text',
	) );

	$wp_customize->add_setting( 'fs_footer_back_to_top', array(
		'default' => true, 'sanitize_callback' => 'flavor_starter_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fs_footer_back_to_top', array(
		'label' => __( 'Show Back to Top button', 'flavor-starter' ), 'section' => 'fs_footer', 'type' => 'checkbox',
	) );

	/*------------------------------------------------------------------
	 * Section: Social Media
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_social', array(
		'title' => __( 'Social Media Links', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$socials = array(
		'fs_social_facebook'  => __( 'Facebook URL', 'flavor-starter' ),
		'fs_social_instagram' => __( 'Instagram URL', 'flavor-starter' ),
		'fs_social_twitter'   => __( 'X / Twitter URL', 'flavor-starter' ),
		'fs_social_youtube'   => __( 'YouTube URL', 'flavor-starter' ),
		'fs_social_tiktok'    => __( 'TikTok URL', 'flavor-starter' ),
	);

	foreach ( $socials as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default' => '', 'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( $id, array(
			'label' => $label, 'section' => 'fs_social', 'type' => 'url',
		) );
	}

	/*------------------------------------------------------------------
	 * Section: Contact Info
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_contact', array(
		'title' => __( 'Contact Information', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_contact_email', array(
		'default' => get_bloginfo( 'admin_email' ), 'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'fs_contact_email', array(
		'label' => __( 'Email', 'flavor-starter' ), 'section' => 'fs_contact', 'type' => 'email',
	) );

	$wp_customize->add_setting( 'fs_contact_phone', array(
		'default' => '', 'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_contact_phone', array(
		'label' => __( 'Phone', 'flavor-starter' ), 'section' => 'fs_contact', 'type' => 'text',
	) );

	$wp_customize->add_setting( 'fs_contact_address', array(
		'default' => '', 'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fs_contact_address', array(
		'label' => __( 'Address', 'flavor-starter' ), 'section' => 'fs_contact', 'type' => 'text',
	) );

	/*------------------------------------------------------------------
	 * Section: Age Verification
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_age_verify', array(
		'title' => __( 'Age Verification', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_age_verify_enable', array(
		'default' => true, 'sanitize_callback' => 'flavor_starter_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'fs_age_verify_enable', array(
		'label' => __( 'Enable Age Verification Popup', 'flavor-starter' ), 'section' => 'fs_age_verify', 'type' => 'checkbox',
	) );

	$age_fields = array(
		'fs_age_verify_title'   => array( __( 'Popup Title', 'flavor-starter' ),      __( 'Age Verification', 'flavor-starter' ) ),
		'fs_age_verify_message' => array( __( 'Popup Message', 'flavor-starter' ),     __( 'You must be at least 21 years old to enter this site.', 'flavor-starter' ) ),
		'fs_age_verify_confirm' => array( __( 'Confirm Button Text', 'flavor-starter' ), __( 'I am 21 or older', 'flavor-starter' ) ),
		'fs_age_verify_deny'    => array( __( 'Deny Button Text', 'flavor-starter' ),    __( 'I am under 21', 'flavor-starter' ) ),
		'fs_age_verify_deny_url'=> array( __( 'Deny Redirect URL', 'flavor-starter' ),   'https://www.google.com' ),
	);

	foreach ( $age_fields as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default' => $data[1], 'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label' => $data[0], 'section' => 'fs_age_verify', 'type' => 'text',
		) );
	}

	$wp_customize->add_setting( 'fs_age_verify_cookie_days', array(
		'default' => 30, 'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'fs_age_verify_cookie_days', array(
		'label' => __( 'Cookie Duration (days)', 'flavor-starter' ), 'section' => 'fs_age_verify', 'type' => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 365 ),
	) );

	/*------------------------------------------------------------------
	 * Section: Store Notices
	 *----------------------------------------------------------------*/
	$wp_customize->add_section( 'fs_store_notices', array(
		'title' => __( 'Store Notices', 'flavor-starter' ),
		'panel' => 'fs_theme_options',
	) );

	$wp_customize->add_setting( 'fs_free_shipping_min', array(
		'default' => 50, 'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'fs_free_shipping_min', array(
		'label' => __( 'Free Shipping Minimum ($)', 'flavor-starter' ), 'section' => 'fs_store_notices', 'type' => 'number',
	) );
}
add_action( 'customize_register', 'flavor_starter_customize_register' );

/*--------------------------------------------------------------
 * Sanitization helpers
 *------------------------------------------------------------*/
function flavor_starter_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/*--------------------------------------------------------------
 * Live preview JS
 *------------------------------------------------------------*/
function flavor_starter_customize_preview_js() {
	wp_enqueue_script( 'flavor-starter-customizer', FS_URI . '/assets/js/customizer.js', array( 'customize-preview' ), FS_VERSION, true );
}
add_action( 'customize_preview_init', 'flavor_starter_customize_preview_js' );
