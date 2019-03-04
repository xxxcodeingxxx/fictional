<?php
/**
 * Fictional University functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fictional_University
 */

 require get_theme_file_path('/inc/search-route.php');

 // Customize WordPress Rest API

 function university_custom_rest() {
	 register_rest_field('post', 'authorName', array(
		 'get_callback' => function() {return get_the_author();}
	 )); // You can register as many fields as you like!!
 }

add_action( 'rest_api_init', 'university_custom_rest' );



if ( ! function_exists( 'fictionaluniversity_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fictionaluniversity_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Fictional University, use a find and replace
		 * to change 'fictionaluniversity' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fictionaluniversity', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Enable New Custom Image Sizes
		add_image_size( 'professorLandscape', 400, 260, true );
		add_image_size( 'prfessorPortrait', 480, 650, true );
		add_image_size( 'pageBanner', 1500, 350, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'fictionaluniversity' ),
			'footer-1' => esc_html__( 'Footer One', 'fictionaluniversity' ),
			'footer-2' => esc_html__( 'Footer Two', 'fictionaluniversity' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'fictionaluniversity_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'fictionaluniversity_setup' );

function pageBanner( $args = NULL ) {
	if ( !$args['title'] ) {
		$args['title'] = get_the_title();
	}

	if ( !$args['subtitle'] ) {
		$args['subtitle'] = get_field( 'page_banner_subtitle' );
	}

	if ( !$args['photo'] ) {
		if ( get_field( 'page_banner_background_image' ) ) {
			$args['photo'] = get_field( 'page_banner_background_image' )['sizes']['pageBanner'];
		} else {
			$args['photo'] = get_theme_file_uri( '/images/ocean.jpg' );
		}
	}
	?>
	<div class="page-banner">
	<div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);"></div>
	<div class="page-banner__content container container--narrow">
	<h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
	<div class="page-banner__intro">
		<p><?php echo $args['subtitle']; ?></p>
	</div>
	</div>
	</div>
<?php }


function fictional_adjust_queries($query) {
	if( !is_admin() AND is_post_type_archive( 'campus' ) AND $query->is_main_query() ) {
		$query->set( 'posts_per_page', -1 );
	}

	if( !is_admin() AND is_post_type_archive( 'program' ) AND $query->is_main_query() ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', -1 );
	}

	if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
		$today = date('Ymd');
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
			array(
				'key' => 'event_date',
				'compare' => '>=',
				'value' => $today,
				'type' => 'numeric'
			)
		));
	}
}
add_action( 'pre_get_posts', 'fictional_adjust_queries' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fictionaluniversity_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'fictionaluniversity_content_width', 640 );
}
add_action( 'after_setup_theme', 'fictionaluniversity_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fictionaluniversity_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fictionaluniversity' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'fictionaluniversity' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'fictionaluniversity_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fictionaluniversity_scripts() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
	wp_enqueue_script(' fictionaluniversity-javascripts ', get_theme_file_uri( '/js/scripts-bundled.js' ), NULL, '1.0', true );
	wp_enqueue_style( 'fictionaluniversity-style', get_stylesheet_uri() );
	wp_enqueue_script( 'googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAIjLxqaGKNYW4Tjp6XQbIKEGjPiXRtf0Q', NULL, '1.0', false );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'fictionaluniversity_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function fictionaluniversityMapKey($api) {
	$api['key'] = 'AIzaSyAIjLxqaGKNYW4Tjp6XQbIKEGjPiXRtf0Q';
	return $api;
}

add_filter( 'acf/fields/google_map/api', 'fictionaluniversityMapKey' );
