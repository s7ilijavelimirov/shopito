<?php
function custom_product_slider_enqueue_scripts()
{
    wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . 'assets/custom-script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'custom_product_slider_enqueue_scripts');


function custom_product_slider_enqueue_styles()
{
    wp_enqueue_style('custom-style', plugin_dir_url(__FILE__) . 'assets/custom-style.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'custom_product_slider_enqueue_styles');

function custom_shop_product_gallery1($product)
{
    // Check if the product object is available and is an instance of WP_Post
    if (is_a($product, 'WP_Post')) {
        $product_id = $product->ID;

        // Generate a unique gallery ID based on the product ID and a counter
        static $gallery_counter = 1;
        $gallery_id = 'product-gallery-' . $product_id . '-' . $gallery_counter;
        $gallery_counter++;

        // Check if the product has a gallery
        $gallery_ids = get_post_meta($product_id, '_product_image_gallery', true);
        if (!empty($gallery_ids)) {
            $gallery_ids = explode(',', $gallery_ids);
            $total_images = count($gallery_ids) + 1;

            // Output the gallery HTML
            $output = '<div class="product-gallery" id="' . $gallery_id . '">';
            $output .= '<div class="product-gallery-images">';

            $output .= '<div class="product-gallery-image active">';
            $output .= wp_get_attachment_image(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail', false, array('class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail'));
            $output .= '</div>';

            // Gallery images
            foreach ($gallery_ids as $attachment_id) {
                $output .= '<div class="product-gallery-image">';
                $output .= wp_get_attachment_image($attachment_id, 'woocommerce_thumbnail', false, array('class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail'));
                $output .= '</div>';
            }

            $output .= '</div>'; // .product-gallery-images

            // Gallery pager dots
            $output .= '<div class="product-gallery-pager">';
            for ($i = 0; $i < $total_images; $i++) {
                $active_class = ($i === 0) ? 'active' : '';
                $output .= '<span class="product-gallery-pager-dot ' . $active_class . '" data-index="' . $i . '" data-gallery="' . $gallery_id . '"></span>';
            }
            $output .= '</div>';

            $output .= '</div>'; // .product-gallery

            echo $output;
        } else {
            // Product doesn't have a gallery, display a default image or handle it accordingly
            $output = '<div class="product-gallery" id="' . $gallery_id . '">';
            $output .= '<div class="product-gallery-images">';
            $output .= '<div class="product-gallery-image active">';
            $output .= wp_get_attachment_image(get_post_thumbnail_id($product_id), 'woocommerce_thumbnail', false, array('class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail'));
            $output .= '</div>';
            $output .= '</div>'; // .product-gallery-images
            $output .= '</div>'; // .product-gallery

            echo $output;
        }
    } else {
        echo 'NEMA12';
    }
}

function custom_product_thumbnail1($product)
{
    // Prilagodite prikaz slike proizvoda prema vašim potrebama
    $output = '<div class="custom-product-thumbnail">';

    // Check if the product has a gallery
    if (is_a($product, 'WP_Post')) {
        $gallery_id = 'product-gallery-' . $product->ID;
        custom_shop_product_gallery1($product, $gallery_id);
    } else {
        $output .= $product->get_image('thumbnail');
    }

    $output .= '</div>';

    return $output;
}

function custom_product_slider_admin_menu()
{
    add_menu_page(
        'Slider Product Settings',
        'Slider Product',
        'manage_options',
        'custom-product-slider-settings',
        'custom_product_slider_settings_page',
        'dashicons-slides',
        30
    );
}
add_action('admin_menu', 'custom_product_slider_admin_menu');

// Settings page content
function custom_product_slider_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $categories = get_categories(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));

    if (isset($_POST['submit'])) {
        // Premium Slider Categories
        $selected_categories_premium = isset($_POST['selected_categories_premium']) ? $_POST['selected_categories_premium'] : array();
        update_option('custom_product_slider_categories_premium', $selected_categories_premium);
        $selected_product_ids_premium = isset($_POST['selected_products_premium']) ? $_POST['selected_products_premium'] : array();
        update_option('selected_products_premium', $selected_product_ids_premium);
        update_option('custom_product_slider_product_premium', $selected_product_ids_premium);

        $selected_categories_akcije = isset($_POST['selected_categories_akcije']) ? $_POST['selected_categories_akcije'] : array();
        update_option('custom_product_slider_categories_akcije', $selected_categories_akcije);
        $selected_product_ids_akcije = isset($_POST['selected_products_akcije']) ? $_POST['selected_products_akcije'] : array();
        update_option('selected_products_akcije', $selected_product_ids_akcije);
        update_option('custom_product_slider_product_akcije', $selected_product_ids_akcije);

        $selected_categories_outlet = isset($_POST['selected_categories_outlet']) ? $_POST['selected_categories_outlet'] : array();
        update_option('custom_product_slider_categories_outlet', $selected_categories_outlet);
        $selected_product_ids_outlet = isset($_POST['selected_products_outlet']) ? $_POST['selected_products_outlet'] : array();
        update_option('selected_products_outlet', $selected_product_ids_outlet);
        update_option('custom_product_slider_product_outlet', $selected_product_ids_outlet);

        // Save product order
        $product_order_premium = isset($_POST['product_order_premium']) ? sanitize_text_field($_POST['product_order_premium']) : 'default';
        update_option('custom_product_slider_product_order_premium', $product_order_premium);

        $product_order_akcije = isset($_POST['product_order_akcije']) ? sanitize_text_field($_POST['product_order_akcije']) : 'default';
        update_option('custom_product_slider_product_order_akcije', $product_order_akcije);

        $product_order_outlet = isset($_POST['product_order_outlet']) ? sanitize_text_field($_POST['product_order_outlet']) : 'default';
        update_option('custom_product_slider_product_order_outlet', $product_order_outlet);

        echo '<div class="updated"><p>Settings saved.</p></div>';
    }
    $selected_product_ids_premium = get_option('custom_product_slider_product_premium', array());
    $selected_product_ids_akcije = get_option('custom_product_slider_product_akcije', array());
    $selected_product_ids_outlet = get_option('custom_product_slider_product_outlet', array());

    $selected_categories_premium = get_option('custom_product_slider_categories_premium', array());
    $selected_categories_akcije = get_option('custom_product_slider_categories_akcije', array());
    $selected_categories_outlet = get_option('custom_product_slider_categories_outlet', array());

    $product_order_premium = get_option('custom_product_slider_product_order_premium', 'default');
    $product_order_akcije = get_option('custom_product_slider_product_order_akcije', 'default');
    $product_order_outlet = get_option('custom_product_slider_product_order_outlet', 'default');
?>
    <div class="wrap">
        <h1>Slider Product Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Premium Slider Categories:</th>
                    <td>
                        <?php foreach ($categories as $category) : ?>
                            <label>
                                <input type="checkbox" name="selected_categories_premium[]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, (array) $selected_categories_premium)); ?>>
                                <?php echo esc_html($category->name); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <h4><b>NAPOMENA</b>: Koristite sledeći kratki kod da biste prikazali Premium klizač na svojoj stranici ili objavi</h4>
                        <p style="color:red;">[custom_product_slider category="premium"]</p>
                        <h4>Selektovani proizvodi koji ce se ispisati u slajderu. Ako nema nijednog chekiranog bice ispisani svi, ukoliko chekirate neke ti ce biti ispisani.</h4>
                        <?php
                        $selected_product_ids_premium = array();
                        if (!empty($selected_categories_premium)) {
                            $selected_product_ids_premium = get_posts(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1, // Retrieve all posts
                                'fields' => 'ids',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $selected_categories_premium,
                                    ),
                                ),
                            ));
                        }

                        if (!empty($selected_product_ids_premium)) {
                            $selected_product_ids = get_option('selected_products_premium', array());

                            // Query for the selected products
                            $premium_slider_query = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1, // Retrieve all posts
                                'post__in' => $selected_product_ids_premium,
                            ));

                            // Display the selected products
                            echo '<div style="display: flex; border: 1px solid silver; padding: 30px; background: white; flex-wrap: wrap;">';

                            while ($premium_slider_query->have_posts()) {
                                $premium_slider_query->the_post();
                                $product_id = get_the_ID();
                                $checked = in_array($product_id, (array) $selected_product_ids) ? 'checked' : '';

                                echo '<div style="width: 120px; margin-right: 10px; margin-bottom: 10px; position:relative;">';
                                echo '<div style="width: 60px; height: 60px; margin:0 auto; display: block;">';
                                echo get_the_post_thumbnail($product_id, array(50, 50), array('style' => 'width: 50px; height: 50px; display:block;overflow: visible;'));
                                echo '</div>';
                                echo '<div style="text-align:center;">' . get_the_title($product_id) . '</div>';
                                echo '<div style="position: absolute;top: 0px;right: 0px;">';
                                echo '<input type="checkbox" name="selected_products_premium[]" value="' . esc_attr($product_id) . '" ' . $checked . '>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';

                            // Save selected product IDs to the database
                            update_option('selected_products_premium', $selected_product_ids);
                        } else {
                            echo 'Nema selektovane kategorije.';
                        }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Akcije Slider Categories:</th>
                    <td>
                        <?php foreach ($categories as $category) : ?>
                            <label>
                                <input type="checkbox" name="selected_categories_akcije[]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, $selected_categories_akcije)); ?>>
                                <?php echo esc_html($category->name); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <h4><b>NAPOMENA:</b> Koristite sledeći kratki kod da biste prikazali klizač Akcije na svojoj stranici ili objavi</h4>
                        <p style="color:red;">[custom_product_slider category="akcije"]</p>
                        <h4>Selektovani proizvodi koji ce se ispisati u slajderu. Ako nema nijednog chekiranog bice ispisani svi, ukoliko chekirate neke ti ce biti ispisani.</h4>
                        <?php
                        $selected_product_ids_akcije = array();
                        if (!empty($selected_categories_akcije)) {
                            $selected_product_ids_akcije = get_posts(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'fields' => 'ids',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $selected_categories_akcije,
                                    ),
                                ),
                            ));
                        }

                        if (!empty($selected_product_ids_akcije)) {
                            $selected_product_ids = get_option('selected_products_akcije', array());

                            // Query for the selected products
                            $akcije_slider_query = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1, // Retrieve all posts
                                'post__in' => $selected_product_ids_akcije,

                            ));

                            echo '<div style="display: flex; border:1px solid silver; padding:30px; background:white; flex-wrap: wrap;">';

                            while ($akcije_slider_query->have_posts()) {
                                $akcije_slider_query->the_post();
                                $product_id = get_the_ID();
                                $checked = in_array($product_id, (array) $selected_product_ids) ? 'checked' : '';

                                echo '<div style="width: 120px; margin-right: 10px; margin-bottom: 10px;position:relative;">';
                                echo '<div style="width: 60px; height: 60px; margin:0 auto; display: block;">';
                                echo get_the_post_thumbnail($product_id, array(50, 50), array('style' => 'width: 50px; height: 50px;display:block;overflow: visible;'));
                                echo '</div>';
                                echo '<div style="text-align:center;">' . get_the_title($product_id) . '</div>';
                                echo '<div style="position: absolute;top: 0px;right: 0px;">';
                                echo '<input type="checkbox" name="selected_products_akcije[]" value="' . esc_attr($product_id) . '" ' . $checked . '>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';

                            // Save selected product IDs to the database
                            update_option('selected_products_akcije', $selected_product_ids);
                        } else {
                            echo 'Nema selektovane kategorije.';
                        }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Outlet Slider Categories:</th>

                    <td>

                        <?php foreach ($categories as $category) : ?>
                            <label>
                                <input type="checkbox" name="selected_categories_outlet[]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, $selected_categories_outlet)); ?>>
                                <?php echo esc_html($category->name); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <h4><b>NAPOMENA:</b> Koristite sledeći kratki kod da biste prikazali klizač za izlaz na vašoj stranici ili objavi</h4>
                        <p style="color:red;">[custom_product_slider category="outlet"]</p>
                        <h4>Selektovani proizvodi koji ce se ispisati u slajderu. Ako nema nijednog chekiranog bice ispisani svi, ukoliko chekirate neke ti ce biti ispisani.</h4>
                        <?php
                        $selected_product_ids_outlet = array();
                        if (!empty($selected_categories_outlet)) {
                            $selected_product_ids_outlet = get_posts(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'fields' => 'ids',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $selected_categories_outlet,
                                    ),
                                ),
                            ));
                        }

                        if (!empty($selected_product_ids_outlet)) {
                            $selected_product_ids = get_option('selected_products_outlet', array());

                            // Query for the selected products
                            $outlet_slider_query = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => -1, // Retrieve all posts
                                'post__in' => $selected_product_ids_outlet,

                            ));

                            echo '<div style="display: flex; border:1px solid silver; padding:30px; background:white; flex-wrap: wrap;">';

                            while ($outlet_slider_query->have_posts()) {
                                $outlet_slider_query->the_post();
                                $product_id = get_the_ID();
                                $checked = in_array($product_id, (array) $selected_product_ids) ? 'checked' : '';

                                echo '<div style="width: 120px; margin-right: 10px; margin-bottom: 10px;position:relative;">';
                                echo '<div style="width: 60px; height: 60px; margin:0 auto; display: block;">';
                                echo get_the_post_thumbnail($product_id, array(50, 50), array('style' => 'width: 50px; height: 50px;display:block;overflow: visible;'));
                                echo '</div>';
                                echo '<div style="text-align:center;">' . get_the_title($product_id) . '</div>';
                                echo '<div style="position: absolute;top: 0px;right: 0px;">';
                                echo '<input type="checkbox" name="selected_products_outlet[]" value="' . esc_attr($product_id) . '" ' . $checked . '>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';

                            // Save selected product IDs to the database
                            update_option('selected_products_outlet', $selected_product_ids);
                        } else {
                            echo 'Nema selektovane kategorije.';
                        }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Premium Slider Settings:</th>
                    <td>
                        <label for="product_order_premium">Redosled prikaza proizvoda:</label><br>
                        <label>
                            <input type="radio" name="product_order_premium" value="price" <?php checked($product_order_premium, 'price'); ?>>
                            Po ceni
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_premium" value="title" <?php checked($product_order_premium, 'title'); ?>>
                            Po abecedi
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_premium" value="random" <?php checked($product_order_premium, 'random'); ?>>
                            Nasumično
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_premium" value="newest" <?php checked($product_order_premium, 'newest'); ?>>
                            Najnovije
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_premium" value="oldest" <?php checked($product_order_premium, 'oldest'); ?>>
                            Najstarije
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Akcije Slider Settings:</th>
                    <td>
                        <label for="product_order_akcije">Redosled prikaza proizvoda:</label><br>
                        <label>
                            <input type="radio" name="product_order_akcije" value="price" <?php checked($product_order_akcije, 'price'); ?>>
                            Po ceni
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_akcije" value="title" <?php checked($product_order_akcije, 'title'); ?>>
                            Po abecedi
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_akcije" value="random" <?php checked($product_order_akcije, 'random'); ?>>
                            Nasumično
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_akcije" value="newest" <?php checked($product_order_akcije, 'newest'); ?>>
                            Najnovije
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_akcije" value="oldest" <?php checked($product_order_akcije, 'oldest'); ?>>
                            Najstarije
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Outlet Slider Settings:</th>
                    <td>
                        <label for="product_order_outlet">Redosled prikaza proizvoda:</label><br>
                        <label>
                            <input type="radio" name="product_order_outlet" value="price" <?php checked($product_order_outlet, 'price'); ?>>
                            Po ceni
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_outlet" value="title" <?php checked($product_order_outlet, 'title'); ?>>
                            Po abecedi
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_outlet" value="random" <?php checked($product_order_outlet, 'random'); ?>>
                            Nasumično
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_outlet" value="newest" <?php checked($product_order_outlet, 'newest'); ?>>
                            Najnovije
                        </label><br>
                        <label>
                            <input type="radio" name="product_order_outlet" value="oldest" <?php checked($product_order_outlet, 'oldest'); ?>>
                            Najstarije
                        </label>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>

<?php
}
