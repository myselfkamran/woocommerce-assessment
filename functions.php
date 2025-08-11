<?php
/**
 * Woocommerce Customization functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Woocommerce_Customization
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function woocommerce_customization_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Woocommerce Customization, use a find and replace
		* to change 'woocommerce-customization' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'woocommerce-customization', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'woocommerce-customization' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'woocommerce_customization_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'woocommerce_customization_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function woocommerce_customization_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'woocommerce_customization_content_width', 640 );
}
add_action( 'after_setup_theme', 'woocommerce_customization_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function woocommerce_customization_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'woocommerce-customization' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'woocommerce-customization' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'woocommerce_customization_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function woocommerce_customization_scripts() {
	wp_enqueue_style( 'woocommerce-customization-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'woocommerce-customization-style', 'rtl', 'replace' );

	wp_enqueue_script( 'woocommerce-customization-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'woocommerce_customization_scripts' );

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

// =================================
// ==========Code-By-Me=============
// ================================= 

function yourtheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'yourtheme_add_woocommerce_support' );

add_action('woocommerce_before_add_to_cart_button', 'custom_sheet_size_options');

function custom_sheet_size_options() {
    ?>
    <div id="size-toggle-wrap">
        <label>
            <input type="radio" name="size_mode" value="cts" checked>
            Cut-To-Size
        </label>
        <label>
            <input type="radio" name="size_mode" value="preset">
            Pre-Set Sizes
        </label>
    </div>

    <div id="cts-fields">
        <label>Length (max 96"):
            <input type="number" name="length" max="96" step="1" required>
        </label>
        <label>Width (max 48"):
            <input type="number" name="width" max="48" step="1" required>
        </label>
    </div>

    <div id="preset-fields" style="display:none;">
        <select name="preset_size" required>
    <?php
    for ($l = 12; $l <= 96; $l += 12) {
        for ($w = 12; $w <= 48; $w += 12) {
            $value = "{$l}x{$w}";
            echo "<option value='{$value}'>{$l}\" x {$w}\"</option>";
        }
    }
    ?>
</select>

    </div>

   <script>
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('[name="size_mode"]');
    const cts = document.getElementById('cts-fields');
    const preset = document.getElementById('preset-fields');
    const length = document.querySelector('[name="length"]');
    const width = document.querySelector('[name="width"]');
    const presetSelect = document.querySelector('[name="preset_size"]');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'cts') {
                cts.style.display = 'block';
                preset.style.display = 'none';
                length.required = true;
                width.required = true;
                presetSelect.required = false;
            } else {
                cts.style.display = 'none';
                preset.style.display = 'block';
                length.required = false;
                width.required = false;
                presetSelect.required = true;
            }
        });
    });
});

</script>

    <?php
}

add_filter('woocommerce_add_to_cart_validation', 'validate_sheet_custom_inputs', 10, 3);
function validate_sheet_custom_inputs($passed, $product_id, $quantity) {
    if (isset($_POST['size_mode'])) {
        $size_mode = sanitize_text_field($_POST['size_mode']);

        if ($size_mode === 'cts') {
            $length = floatval($_POST['length'] ?? 0);
            $width = floatval($_POST['width'] ?? 0);

            if ($length <= 0 || $length > 96 || $width <= 0 || $width > 48) {
                wc_add_notice('Invalid dimensions for Cut-To-Size. Max: 96" x 48".', 'error');
                return false;
            }

        } elseif ($size_mode === 'preset') {
            $preset = sanitize_text_field($_POST['preset_size'] ?? '');
            if (empty($preset) || !preg_match('/^\d{1,3}x\d{1,3}$/', $preset)) {

                wc_add_notice('Please select a valid Pre-Set Size.', 'error');
                return false;
            }

        } else {
            wc_add_notice('Invalid size mode selected.', 'error');
            return false;
        }
    }

    return $passed;
}
add_filter('woocommerce_add_cart_item_data', 'add_sheet_custom_data_to_cart', 10, 2);
function add_sheet_custom_data_to_cart($cart_item_data, $product_id) {
    if (isset($_POST['size_mode'])) {
        $cart_item_data['size_mode'] = sanitize_text_field($_POST['size_mode']);

        if ($_POST['size_mode'] === 'cts') {
            $cart_item_data['dimensions'] = [
                'length' => floatval($_POST['length']),
                'width'  => floatval($_POST['width']),
            ];
        } elseif ($_POST['size_mode'] === 'preset') {
            $cart_item_data['preset_size'] = sanitize_text_field($_POST['preset_size']);
        }

        $cart_item_data['unique_key'] = md5(microtime().rand()); 
    }

    return $cart_item_data;
}

add_filter('woocommerce_get_item_data', 'display_sheet_custom_data_cart', 10, 2);
function display_sheet_custom_data_cart($item_data, $cart_item) {
    if (!empty($cart_item['size_mode'])) {
        if ($cart_item['size_mode'] === 'cts') {
            $item_data[] = [
                'name' => 'Cut-To-Size',
                'value' => $cart_item['dimensions']['length'] . '" x ' . $cart_item['dimensions']['width'] . '"',
            ];
        } elseif ($cart_item['size_mode'] === 'preset') {
            $item_data[] = [
                'name' => 'Pre-Set Size',
                'value' => $cart_item['preset_size'] . '"',
            ];
        }
    }
    return $item_data;
}

add_action('woocommerce_checkout_create_order_line_item', 'add_sheet_custom_data_to_order', 10, 4);
function add_sheet_custom_data_to_order($item, $cart_item_key, $values, $order) {
    if (!empty($values['size_mode'])) {
        $item->add_meta_data('Size Mode', $values['size_mode']);

        if ($values['size_mode'] === 'cts') {
            $dims = $values['dimensions'];
            $item->add_meta_data('Cut-To-Size', $dims['length'] . '" x ' . $dims['width'] . '"');
        } elseif ($values['size_mode'] === 'preset') {
            $item->add_meta_data('Pre-Set Size', $values['preset_size'] . '"');
        }
    }
}

add_action('woocommerce_before_calculate_totals', 'adjust_sheet_price_based_on_size', 20, 1);
function adjust_sheet_price_based_on_size($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['size_mode']) && $cart_item['size_mode'] === 'cts') {
            $length = floatval($cart_item['dimensions']['length'] ?? 0);
            $width  = floatval($cart_item['dimensions']['width'] ?? 0);

            if ($length > 0 && $width > 0) {
                $area = $length * $width;
                $price_per_sq_in = 0.05; 

                $custom_price = $area * $price_per_sq_in;
                $cart_item['data']->set_price($custom_price);
            }
        }
    }
}

add_action('rest_api_init', function () {
    register_rest_route('custom-api/v1', '/update-product/', array(
        'methods' => 'POST',
        'callback' => 'update_product_by_sku',
        'permission_callback' => '__return_true'
    ));
});

function update_product_by_sku($request) {
    $params = $request->get_json_params();

    $expected_token = 'kM9g7RT29!woq'; 
    if (!isset($params['token']) || $params['token'] !== $expected_token) {
        return new WP_REST_Response(['status' => 'unauthorized'], 401);
    }

    if (empty($params['sku'])) {
        return new WP_REST_Response(['status' => 'error', 'message' => 'Missing SKU'], 400);
    }

    $product_id = wc_get_product_id_by_sku($params['sku']);
    if (!$product_id) {
        return new WP_REST_Response(['status' => 'error', 'message' => 'Invalid SKU'], 404);
    }

    $product = wc_get_product($product_id);

    if (isset($params['price'])) {
        $product->set_price($params['price']);
        $product->set_regular_price($params['price']);
    }

    if (isset($params['stock'])) {
        $product->set_manage_stock(true);
        $product->set_stock_quantity($params['stock']);
        $product->set_stock_status($params['stock'] > 0 ? 'instock' : 'outofstock');
    }

    $product->save();

    return new WP_REST_Response(['status' => 'ok'], 200);
}

add_action('wp_footer', function () {
    if (!is_product()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const pricePerSqIn = 0.05;
        const lengthInput = document.querySelector('[name="length"]');
        const widthInput = document.querySelector('[name="width"]');
        const presetSelect = document.querySelector('[name="preset_size"]');
        const sizeRadios = document.querySelectorAll('[name="size_mode"]');

        const insertPoint = document.querySelector('.product .summary');
        const priceBox = document.createElement('div');
        priceBox.id = 'custom-dynamic-price';
        priceBox.style.fontSize = '18px';
        priceBox.style.marginBottom = '15px';
        priceBox.style.fontWeight = 'bold';
        priceBox.style.color = '#a46497';
        insertPoint.insertBefore(priceBox, insertPoint.children[1]);

        function updatePrice() {
            let price = 0;
            const mode = document.querySelector('[name="size_mode"]:checked')?.value;

            if (mode === 'cts') {
                const l = parseFloat(lengthInput?.value || 0);
                const w = parseFloat(widthInput?.value || 0);
                if (l && w) price = (l * w * pricePerSqIn).toFixed(2);
            } else if (mode === 'preset') {
                const selected = presetSelect?.value;
                if (selected?.includes('x')) {
                    const [l, w] = selected.toLowerCase().split('x').map(Number);
                    if (l && w) price = (l * w * pricePerSqIn).toFixed(2);
                }
            }

            priceBox.innerHTML = price ? `Estimated Price: <strong>$${price}</strong>` : '';
        }

        [lengthInput, widthInput, presetSelect].forEach(el => {
            if (el) el.addEventListener('input', updatePrice);
        });

        sizeRadios.forEach(r => r.addEventListener('change', updatePrice));

        updatePrice();
    });
    </script>
    <?php
});


