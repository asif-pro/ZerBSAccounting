<?php

/**
 * Plugin Name:       Zero BS Accounting
 * Plugin URI:        https://wppool.dev/zero-bs-accounting
 * Description:       Accounting for the non-accountants.
 * Version:           1.0.9
 * Author:            WPPOOL
 * Author URI:        https://wppool.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       zbs-account
 * Tested up to: 	  6.0
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class Zero_BS_Accounting
{

    public $plugin;

    public function __construct()
    {
        $this->plugin = plugin_basename(__FILE__);
    }

    public function register()
    {
        add_action('init', [$this, 'zbs_register_settings']);
        add_action('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'zbs_account_action_links']);
        add_action('admin_bar_menu', [$this, 'zbs_account_admin_bar_item'], 500);
        add_action('admin_menu', [$this, 'zbs_account_register_custom_menu_link']);
        add_action('admin_init', [$this, 'zbs_account_menu_item_redirect_url'], 1);
        add_filter('page_template', [$this, 'zbs_account_declare_template']);
        add_action('wp_enqueue_scripts', array($this, 'zbs_account_enqueue_assets'));
        add_action('init', [$this, 'zbs_account_post_type']);
        add_action('init', [$this, 'zbs_account_register_post_meta']);
        add_action('transaction_category_add_form_fields', [$this, 'zbs_account_add_icon_on_transaction_category'], 10, 2);
        add_action('transaction_category_edit_form_fields', [$this, 'zbs_account_edit_icon_on_transaction_category'], 10);
        add_action('edited_transaction_category', [$this, 'zbs_account_transaction_category_save_icon']);
        add_action('create_transaction_category', [$this, 'zbs_account_transaction_category_save_icon']);
        add_action('init', [$this, 'zbs_account_register_default_terms']);
        add_action('rest_api_init', [$this, 'zbs_account_formated_date_on_rest']);
        add_action('wp_ajax_zbs_subscribe', [$this, 'zbs_account_subscribe']);
        add_action('init', [$this, 'appsero_init_tracker_zero_bs_accounting']);
        add_action('wp_ajax_zbs_insertProfile', [$this, 'zbs_account_insertProfile']);
        add_action('wp_ajax_nopriv_zbs_insertProfile', [$this, 'zbs_account_insertProfile']);
        add_action('wp_ajax_zbs_updateProfile', [$this, 'zbs_account_updateProfile']);
        add_action('wp_ajax_nopriv_zbs_updateProfile', [$this, 'zbs_account_updateProfile']);
        add_action('wp_ajax_zbs_deleteProfile', [$this, 'zbs_account_deleteProfile']);
        add_action('wp_ajax_nopriv_zbs_deleteProfile', [$this, 'zbs_account_deleteProfile']);
        
        add_action('wp_ajax_zbs_displayProfile', [$this, 'zbs_account_displayProfile']);
        add_action('wp_ajax_nopriv_zbs_displayProfile', [$this, 'zbs_account_displayProfile']);
        add_action('wp_ajax_zbs_set_default_profile', [$this, 'zbs_account_setDefaultProfileID']);
        add_action('wp_ajax_nopriv_zbs_set_default_profile', [$this, 'zbs_account_setDefaultProfileID']);

        add_action('wp_ajax_zbs_get_profile_settings', [$this, 'get_profile_settings']);
        add_action('wp_ajax_zbs_updated_profile_settings', [$this, 'update_profile_settings']);

        add_action('wp_ajax_zbs_update_transaction', [$this, 'zbs_account_update_transaction']);
        add_action('wp_ajax_nopriv_zbs_update_transaction', [$this, 'zbs_account_update_transaction']);

        // on created a new user 
        add_action('user_register', [$this, 'zbs_account_on_user_register']);
    }

    function zbs_register_settings()
    {
        register_setting(
            'zbs_settings',
            'zbs_currency',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'USD',
                'show_in_rest' => true
            )
        );
        register_setting(
            'zbs_settings',
            'zbs_currency_position',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => 'before',
                'show_in_rest' => true
            )
        );
    }

    /**
     * Initialize the plugin tracker
     *
     * @return void
     */
    public function appsero_init_tracker_zero_bs_accounting()
    {
        if (!class_exists('Appsero\Client')) {
            require_once __DIR__ . '/appsero/src/Client.php';
        }

        $client = new Appsero\Client('ea96124c-b9e1-457e-91d9-0d7a1322afaf', 'Zero BS Accounting', __FILE__);

        // Active insights
        $client->insights()->init();

        // Active automatic updater
        $client->updater();
    }

    /**
     * Adding action link
     */
    public function zbs_account_action_links($links)
    {
        $pageID =  get_option('zbs-accountpage');

        if ($pageID) {

            $links = array_merge(array(
                '<a target="_blank" href="' . esc_url(get_page_link(get_option('zbs-accountpage'))) . '">' . __('ZBS Page', 'zbs-account') . '</a>'
            ), $links);
        }

        return $links;
    }

    public function zbs_account_admin_bar_item($admin_bar)
    {
        if (!current_user_can('edit_posts')) {
            return;
        }
        $admin_bar->add_menu(array(
            'id'    => 'zbs-account-site-name',
            'parent' => 'site-name',
            'group'  => null,
            'title' => 'Accounting',
            'href'  => get_the_permalink(get_option('zbs-accountpage')),
            'meta' => [
                'title' => __('Accounting', 'zbs-account'),
            ]
        ));

        $admin_bar->add_menu(array(
            'id'    => 'zbs-account-top-secondary',
            'parent' => 'top-secondary',
            'group'  => null,
            'title' => 'Accounting',
            'href'  => get_the_permalink(get_option('zbs-accountpage')),
            'meta' => [
                'title' => __('Accounting', 'zbs-account'),
            ]
        ));
    }

    public function zbs_account_register_custom_menu_link()
    {
        add_menu_page('Accounting', 'Accounting', 'edit_posts', 'zbs-page', 'zbs_account_menu_item_redirect_url', 'dashicons-money-alt', 3);
    }

    public function zbs_account_menu_item_redirect_url()
    {
        /* if(!is_admin()){
            wp_redirect(get_the_permalink(get_option('zbs-accountpage')));
        } */
        $menu_redirect = isset($_GET['page']) ? __($_GET['page']) : false;

        if (get_option('zbs_accounting_do_activation_redirect', false)) {
            delete_option('zbs_accounting_do_activation_redirect');
            wp_redirect(get_the_permalink(get_option('zbs-accountpage')));
        }

        if ($menu_redirect == 'zbs-page') {
            wp_safe_redirect(get_the_permalink(get_option('zbs-accountpage')));
            exit();
        }
    }

    /**
     * Enqueing assets
     */
    public function zbs_account_enqueue_assets()
    {
        if (is_page('zero-bs-accounting')) {
            wp_enqueue_style("$this->plugin-css", plugins_url('/public/styles.css', __FILE__), [], filemtime(plugin_dir_path(__FILE__) . '/public/styles.css'), 'all');
            wp_enqueue_style("$this->plugin-google-icon", 'https://fonts.googleapis.com/icon?family=Material+Icons+Outlined');
            wp_enqueue_style("$this->plugin-google-font", 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
            wp_enqueue_script("chart-js", plugins_url('/assets/js/chart.min.js', __FILE__));
            wp_enqueue_script("$this->plugin-js", plugins_url('/dist/js/scripts.js', __FILE__), array("jquery"), filemtime(plugin_dir_path(__FILE__) . 'dist/js/scripts.js'), true);
            wp_localize_script("$this->plugin-js", 'zbs_account', array(
                'site'      => site_url('/'),
                'plugin_dir_url' => plugins_url('/public', __FILE__),
                'user'      => is_user_logged_in() ? json_encode(wp_get_current_user()) : null,
                'nonce'     => wp_create_nonce('wp_rest'),
                'login_url' => wp_login_url(site_url('/zero-bs-accounting'), false),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'default_profile'  => get_user_meta(get_current_user_id(), 'zbs_profile', true),
                'ajaxnonce' => wp_create_nonce('ajax-nonce')

            ));
        }
    }

    /**
     * Declaring template
     */
    public function zbs_account_declare_template($page_template)
    {
        /*  $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        
        if(in_array('contributor', $roles)){
            return false;
        } */

        if (is_page('zero-bs-accounting')) {
            $page_template = dirname(__FILE__) . '/templates/index.php';
        }
        return $page_template;
    }

    /**
     * Adding post type
     */
    public function zbs_account_post_type()
    {
        //Transaction
        $labels = array(
            'name'               => __('Transaction', 'zbs-account'),
            'singular_name'      => __('Transaction', 'zbs-account'),
            'menu_name'          => __('Transaction', 'zbs-account'),
            'name_admin_bar'     => __('Transaction', 'zbs-account'),
            'add_new'            => __('Add New', 'zbs-account'),
            'add_new_item'       => __('Add New Transaction', 'zbs-account'),
            'new_item'           => __('New Transaction', 'zbs-account'),
            'edit_item'          => __('Edit Transaction', 'zbs-account'),
            'view_item'          => __('View Transaction', 'zbs-account'),
            'all_items'          => __('All Transaction', 'zbs-account'),
            'search_items'       => __('Search Transaction', 'zbs-account'),
            'parent_item_colon'  => __('Parent Transaction:', 'zbs-account'),
            'not_found'          => __('No transaction found.', 'zbs-account'),
            'not_found_in_trash' => __('No transaction found in Trash.', 'zbs-account')
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __('Transaction for zbs-account', 'zbs-account'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => false,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-money-alt',
            'exclude_from_search' => true,
            'supports'           => array('title', 'author', 'custom-fields'),
            // // all users
            // 'capabilities' => array(
            //     'edit_post'          => 'read', 
            // ),
        );

        register_post_type('transaction', $args);
        register_taxonomy('transaction_category', 'transaction', array(
            'hierarchical'          => true,
            'show_in_rest'          => true
        ));

        //Debt
        $labelsDebt = array(
            'name'               => __('Debt', 'zbs-account'),
            'singular_name'      => __('Debt', 'zbs-account'),
            'menu_name'          => __('Debt', 'zbs-account'),
            'name_admin_bar'     => __('Debt', 'zbs-account'),
            'add_new'            => __('Add New', 'zbs-account'),
            'add_new_item'       => __('Add New Debt', 'zbs-account'),
            'new_item'           => __('New Debt', 'zbs-account'),
            'edit_item'          => __('Edit Debt', 'zbs-account'),
            'view_item'          => __('View Debt', 'zbs-account'),
            'all_items'          => __('All Debt', 'zbs-account'),
            'search_items'       => __('Search Debt', 'zbs-account'),
            'parent_item_colon'  => __('Parent Debt:', 'zbs-account'),
            'not_found'          => __('No debt found.', 'zbs-account'),
            'not_found_in_trash' => __('No debt found in Trash.', 'zbs-account')
        );

        $argsDebt = array(
            'labels'             => $labelsDebt,
            'description'        => __('Debt for zbs-account', 'zbs-account'),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => false,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-money-alt',
            'exclude_from_search' => true,
            'supports'           => array('title', 'author', 'thumbnail', 'custom-fields')
        );

        register_post_type('debt', $argsDebt);
    }

    /**
     * Adding post meta
     */
    public function zbs_account_register_post_meta()
    {
        register_post_meta('transaction', 'transaction_amount', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
        register_post_meta('transaction', 'transaction_note', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
        register_post_meta('transaction', 'transaction_type', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'show_admin_column' => true
        ));   
        register_post_meta('transaction', 'transaction_profile', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'show_admin_column' => true
        ));
        register_post_meta('debt', 'debt_note', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));

        register_post_meta('debt', 'debt_transactions', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
        register_post_meta('debt', 'debt_phone', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
        register_post_meta('debt', 'debt_email', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
    }

    /**
     * Category Add Icon & Color
     */
    public function zbs_account_add_icon_on_transaction_category($term)
    {
?>
        <div class="form-field">
            <label for="taxIcon"><?php _e('Icon', 'zbs-account'); ?></label>
            <input type="text" name="taxIcon" id="taxIcon" value="">
        </div>
        <div class="form-field">
            <label for="taxColor"><?php _e('Color', 'zbs-account'); ?></label>
            <input type="text" name="taxColor" id="taxColor" value="">
        </div>
    <?php
    }

    /**
     * Category edit icon
     */
    public function zbs_account_edit_icon_on_transaction_category($term)
    {
        $t_id = $term->term_id;
        $term_icon = get_term_meta($t_id, 'icon', true);
        $term_color = get_term_meta($t_id, 'color', true); ?>
        <tr class="form-field">
            <th><label for="taxIcon"><?php _e('Icon', 'zbs-account'); ?></label></th>
            <td>
                <input type="text" name="taxIcon" id="taxIcon" value="<?php echo esc_attr($term_icon) ? esc_attr($term_icon) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th><label for="taxColor"><?php _e('Color', 'zbs-account'); ?></label></th>
            <td>
                <input type="text" name="taxColor" id="taxColor" value="<?php echo esc_attr($term_color) ? esc_attr($term_color) : ''; ?>">
            </td>
        </tr>
<?php
    }

    /**
     * Saving Image
     */
    public function zbs_account_transaction_category_save_icon($term_id)
    {
        if (isset($_POST['taxIcon'])) {
            $term_icon = sanitize_html_class($_POST['taxIcon']);
            if ($term_icon) {
                update_term_meta($term_id, 'icon', $term_icon);
            }
        }
        if (isset($_POST['taxColor'])) {
            $term_color = sanitize_hex_color($_POST['taxColor']);
            if ($term_color) {
                update_term_meta($term_id, 'color', $term_color);
            }
        }
    }

    /**
     * Adding default terms
     */
    public function zbs_account_register_default_terms()
    {
        $this->taxonomy = 'transaction_category';
        $this->terms = array(
            array(
                'name'          => 'Expense',
                'slug'          => 'expense',
                'icon'          => '',
                'color'         => '',
                'parent'        => null
            ),
            array(
                'name'          => 'Earning',
                'slug'          => 'earning',
                'icon'          => '',
                'color'         => '',
                'parent'        => null
            ),
            array(
                'name'          => 'Food & Drink',
                'slug'          => 'food-drink',
                'icon'          => 'restaurant',
                'color'         => '#fea800',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Shopping',
                'slug'          => 'shopping',
                'icon'          => 'shopping_bag',
                'color'         => '#e26aef',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Transport',
                'slug'          => 'transport',
                'icon'          => 'train',
                'color'         => '#fbcc00',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Home',
                'slug'          => 'home',
                'icon'          => 'home',
                'color'         => '#b5985b',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Bills & Fees',
                'slug'          => 'bills-fees',
                'icon'          => 'payments',
                'color'         => '#5ec3ab',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Entertainment',
                'slug'          => 'entertainment',
                'icon'          => 'sports_esports',
                'color'         => '#fea800',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Car',
                'slug'          => 'car',
                'icon'          => 'directions_car',
                'color'         => '#45a7e5',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Travel',
                'slug'          => 'travel',
                'icon'          => 'flight_takeoff',
                'color'         => '#f9639f',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Family & Personal',
                'slug'          => 'family-personal',
                'icon'          => 'perm_identity',
                'color'         => '#44a7e5',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Healthcare',
                'slug'          => 'healthcare',
                'icon'          => 'health_and_safety',
                'color'         => '#df6576',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Education',
                'slug'          => 'education',
                'icon'          => 'school',
                'color'         => '#3b73ad',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Groceries',
                'slug'          => 'groceries',
                'icon'          => 'local_grocery_store',
                'color'         => '#db8139',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Sports & Hobbies',
                'slug'          => 'sports-hobbies',
                'icon'          => 'sports_basketball',
                'color'         => '#60d0c9',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Beauty',
                'slug'          => 'beauty',
                'icon'          => 'face_retouching_natural',
                'color'         => '#7843d0',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Work',
                'slug'          => 'work',
                'icon'          => 'work',
                'color'         => '#6d6f8a',
                'parent'        => 'expense'
            ),
            array(
                'name'          => 'Salary',
                'slug'          => 'salary',
                'icon'          => 'payments',
                'color'         => '#1eb174',
                'parent'        => 'earning'
            ),
            array(
                'name'          => 'Business',
                'slug'          => 'business',
                'icon'          => 'storefront',
                'color'         => '#fda207',
                'parent'        => 'earning'
            ),
            array(
                'name'          => 'Extra Income',
                'slug'          => 'extra-income',
                'icon'          => 'paid',
                'color'         => '#74c442',
                'parent'        => 'earning'
            ),
            array(
                'name'          => 'Loan',
                'slug'          => 'loan',
                'icon'          => 'account_balance',
                'color'         => '#df6576',
                'parent'        => 'earning'
            ),
            array(
                'name'          => 'Parental Leander',
                'slug'          => 'parental-leander',
                'icon'          => 'supervisor_account',
                'color'         => '#f9639f',
                'parent'        => 'earning'
            ),
            array(
                'name'          => 'Insurance Payment',
                'slug'          => 'insurance-payment',
                'icon'          => 'verified_user',
                'color'         => '#44a7e5',
                'parent'        => 'earning'
            ),
            array(
                'name'          => 'Gifts',
                'slug'          => 'gifts',
                'icon'          => 'card_giftcard',
                'color'         => '#1eb173',
                'parent'        => null
            ),
            array(
                'name'          => 'Other',
                'slug'          => 'other',
                'icon'          => 'quiz',
                'color'         => '#67686c',
                'parent'        => null
            ),
        );

        $expenseParent = null;
        $earningParent = null;
        $prevTerms = array();

        foreach (get_terms('transaction_category', array('hide_empty' => false)) as $termitem) {
            $prevTerms[] = $termitem->slug;
        }

        foreach ($this->terms as $term_key => $term) {
            if (!in_array($term['slug'], $prevTerms)) {
                $termarray = array(
                    'slug'          => $term['slug']
                );

                if ($term['parent'] == 'expense') {
                    $termarray['parent'] = $expenseParent;
                }

                if ($term['parent'] == 'earning') {
                    $termarray['parent'] = $earningParent;
                }

                $thisterm = wp_insert_term(
                    $term['name'],
                    $this->taxonomy,
                    $termarray
                );

                if (!is_wp_error($thisterm)) {
                    add_term_meta($thisterm['term_id'], 'icon', $term['icon'], false);
                    add_term_meta($thisterm['term_id'], 'color', $term['color'], false);

                    if ($term['name'] == 'Expense') {
                        $expenseParent = $thisterm['term_id'];
                    }

                    if ($term['name'] == 'Earning') {
                        $earningParent = $thisterm['term_id'];
                    }
                }

                unset($term);
            }
        }
    }

    /**
     * Adding formated date to rest response
     */
    public function zbs_account_formated_date_on_rest()
    {
        register_rest_field(
            array('transaction'),
            'formatted_date',
            array(
                'get_callback'    => function () {
                    return get_the_date();
                },
                'update_callback' => null,
                'schema'          => null,
            )
        );

        register_rest_field(
            array('transaction'),
            'category',
            array(
                'get_callback'    => function ($object) {
                    $terms = get_the_terms($object['id'], 'transaction_category');

                    return !empty($terms) ? array_pop($terms) : null;
                },
                'update_callback' => null,
                'schema'          => null,
            )
        );

        register_rest_field(
            'transaction_category',
            'meta',
            array(
                'get_callback'    => function ($object, $field_name, $request, $object_type) {
                    return get_term_meta($object['id']);
                },
                'update_callback' => function ($values, $object, $field_name) {
                    foreach ($values as $key => $value) {
                        update_term_meta($object->term_id, $key, $value);
                    }
                },
                'schema'          => null,
            )
        );
    }

    /**
     * Subscription
     */
    public function zbs_account_subscribe()
    {
        $email = sanitize_email($_POST['email']);

        $users = get_users(array(
            'role'    => 'administrator',
            'orderby' => 'ID',
            'order'   => 'ASC',
            'number'  => 1,
            'paged'   => 1,
        ));

        $admin_user =  (is_array($users) && !empty($users)) ? $users[0] : false;
        $first_name = $last_name = '';

        if ($admin_user) {
            $first_name = $admin_user->first_name ? $admin_user->first_name : $admin_user->display_name;
            $last_name  = $admin_user->last_name;
        }

        $webhook_url = 'https://fluent.wppool.dev/wp-admin/?fluentcrm=1&route=contact&hash=10220b66-9b67-40e6-b05b-63019fbea1a3';

        try {
            $res = wp_remote_post($webhook_url, [
                'body' => [
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'email'      => $email,
                    'tags[]'     => 11,
                    'lists[]'    => 24,
                    'source'     => esc_url(home_url()),
                ],
            ]);

            echo __('You\'re on the waiting list. You\'d be first to know when we launch the premium version of Zero BS Accounting', 'zbs-account');
        } catch (\Exception $exception) {
            print_r($exception, 1);
        }

        die();
    }
    /**
     * Adding Account Profile
     */
    public function zbs_account_insertProfile()
    {

        $inputs = file_get_contents('php://input');
        $data = json_decode($inputs, true);

        global $wpdb;
        $table_name = $wpdb->prefix . 'zbs_profiles';
        $name = null;

        if(isset($data['accountName']) && !empty($data['accountName'])) {
            $name = sanitize_text_field($data['accountName']); 
        } else {
            wp_send_json_error([
                'message'=> __("Account name is required"),
            ]);
        }

        if(empty($name)) {
            wp_send_json_error([
                'message'=> __("Account name is required"),
            ]);
        }

        $uid = get_current_user_id();
        /* $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT `name` FROM {$table_name} WHERE user_id = %d AND name LIKE %s",
                $uid,
                $name
            )
            );

        if(is_null($result)){
            $wpdb->INSERT("{$table_name}",
                    [
                    'name'=>$name,
                    'user_id'=>$uid
                    ]);
            wp_send_json_success([
                'message'=> __("Account created successfully"),
            ]);
        }
        elseif(!is_null($result)){
            wp_send_json_error([
                'message'=> __("Account name already Exists"),
            ]);
        }
        else{
            wp_send_json_error([
                'message'=> __("Account name can't be empty"),
            ]);
        } */

        $check_data = $wpdb->get_row($wpdb->prepare("SELECT * from {$table_name} WHERE user_id = $uid"));

        if (!is_null($check_data)) {
            $result = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT `name` FROM {$table_name} WHERE user_id = %d AND name LIKE %s",
                    $uid,
                    $name
                )
            );
            if (is_null($result)) {
                $wpdb->INSERT(
                    "{$table_name}",
                    [
                        'name' => $name,
                        'user_id' => $uid
                    ]
                );
                wp_send_json_success([
                    'message' => __("Account created successfully"),
                ]);
            } elseif (!is_null($result)) {
                wp_send_json_error([
                    'message' => __("Account name already Exists"),
                ]);
            } else {
                wp_send_json_error([
                    'message' => __("Account name can't be empty"),
                ]);
            }
        } else {
            $wpdb->INSERT(
                "{$table_name}",
                [
                    'name' => $name,
                    'user_id' => $uid
                ]
            );
            wp_send_json_success([
                'message' => __("Account created successfully"),
            ]);
            wp_send_json_success([
                'message' => __("Account created successfully"),
            ]);
        }
    }
    /**
     * Editing Account Profile
     */
    public function zbs_account_updateProfile()
    {
        global $wpdb;
        $user = wp_get_current_user();
        $table_name = $wpdb->prefix . 'zbs_profiles';
        $name = $_POST['updatedName'];
        $id = $_POST['id'];
        $getRow = $wpdb->get_results("SELECT * from {$table_name} WHERE id = $id");
        if ($getRow) {
            if ($user->ID == $getRow->u_id) {
                $wpdb->UPDATE($table_name, ['name' => $name], ['id' => $id]); //get the $id first
                echo "Update Successful";
            } else {
                echo "Invalid User";
            }
        } else {
            echo "No Data Found to Update";
        }

        die();
    }
    /**
     * Deleting Account Profile
     */
    public function zbs_account_deleteProfile()
    {

        $inputs = file_get_contents('php://input');
        $data = json_decode($inputs, true);

        global $wpdb;
        $user = wp_get_current_user();
        $id = $data['id'];
        $table_name = $wpdb->prefix . 'zbs_profiles';
        $getRow = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id = $id AND user_id = $user->ID");
        if ($getRow) {
            $wpdb->delete($table_name, ['id' => $id]); //get the $id first
            echo "Account Deleted";
        } else {
            echo "There is no such Account to Delete";
        }

        die();
    }

    /**
     * Display all the Account Profiles for respected user
     */
    public function zbs_account_displayProfile()
    {
        $user = get_current_user_id(); 
        global $wpdb;
        $table_name = $wpdb->prefix . 'zbs_profiles';
        $result = $wpdb->get_results("SELECT * from {$table_name} WHERE user_id = $user");

        wp_send_json_success($result);
    }

    /**
     * Set user's default profile
     */
    public function zbs_account_setDefaultProfileID($profileID)
    {
        $inputs = file_get_contents('php://input');
        $data = json_decode($inputs, true);

        $current_userID = get_current_user_id();
        $userID = get_current_user_id(); //for postman will be deleted later
        $profileID = $data['profileID'] ?? 0;
        global $wpdb;
        $table_name = $wpdb->prefix . 'zbs_profiles';
        $result = $wpdb->get_row("SELECT * from {$table_name} WHERE id = $profileID AND user_id = $userID");
        if($result) {
            update_user_meta($current_userID, 'zbs_profile', $profileID);
            wp_send_json_success([
                'message' => __('Account Exists'),
            ]);
        } else {
            wp_send_json_error([
                'message' => __('Account does not Exist'),
            ]);
        }
    }


    /**
     * zbs_account_settings
     */
    public function get_profile_settings()
    {
        
        $profile_id = get_user_meta(get_current_user_id(), 'zbs_profile', true);

        global $wpdb;
        $sql = "SELECT * FROM {$wpdb->prefix}zbs_profiles WHERE id = $profile_id";
        $profile = $wpdb->get_row($wpdb->prepare($sql));

        wp_send_json_success([
            'currency' => $profile->currency ? $profile->currency : 'USD',
            'currency_position' => $profile->currency_position ? $profile->currency_position : 'left',
            'currency_thousand_separator' => $profile->currency_thousand_separator ? $profile->currency_thousand_separator : ',',
            'currency_decimal_separator' => $profile->currency_decimal_separator ? $profile->currency_decimal_separator : '.',
        ]);

        wp_die();

    }

    /**
     * Update profile settings 
     */
    public function update_profile_settings()
    {
        $profile_id = get_user_meta(get_current_user_id(), 'zbs_profile', true);

        global $wpdb;
        $wpdb->update(
            "{$wpdb->prefix}zbs_profiles",
            [
                'currency' => $_POST['currency'],
                'currency_position' => $_POST['currency_position'],
                'currency_thousand_separator' => $_POST['currency_thousand_separator'],
                'currency_decimal_separator' => $_POST['currency_decimal_separator'],
            ],
            [
                'id' => $profile_id
            ]
        );

        wp_send_json_success([
            'message' => __('Profile settings updated successfully'),
        ]);

        wp_die();
    }


    /**
     * zbs_account_update_transaction
     */
    public function zbs_account_update_transaction()
    {
        $inputs = file_get_contents('php://input');
        $inputs = json_decode($inputs, true);

        $transaction_id = $inputs['id'] ?? false;
        $profile_id = get_user_meta(get_current_user_id(), 'zbs_profile', true);

        $title = $inputs['title'];

        // category 
        $category_id = $inputs['category'];
        
        // meta
        $amount = $inputs['amount'];
        $type = $inputs['type'];
        $note = $inputs['note'];

        // update or create post transaction 
        $post = [
            'ID' => $transaction_id,
            'post_title' => $title,
            'post_type' => 'transaction',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),

            'meta_input' => [
                'transaction_amount' => $amount,
                'transaction_type' => $type,
                'transaction_note' => $note,
                'transaction_profile' => $profile_id,
            ],
        ];
 

        if ($transaction_id && get_post($transaction_id)) {
            wp_update_post($post);
        } else {
            // remove ID 
            unset($post['ID']);
            $transaction_id = wp_insert_post($post);
        }

        // update or create meta transaction
        
        update_post_meta($transaction_id, 'transaction_amount', $amount);
        update_post_meta($transaction_id, 'transaction_type', $type);
        update_post_meta($transaction_id, 'transaction_note', $note);
        update_post_meta($transaction_id, 'transaction_profile', $profile_id);

        // update category
        wp_set_object_terms($transaction_id, $category_id, 'transaction_category');
 

        wp_send_json_success([
            'message' => __('Transaction updated successfully'),
        ]);
    }

    // zbs_account_get_transaction
    public function zbs_account_get_transaction($transaction_id)
    {
        $transaction = get_post($transaction_id);

        $transaction->meta = get_post_meta($transaction_id);
        $transaction->category = wp_get_object_terms($transaction_id, 'transaction_category');

        return $transaction;
    }


    // zbs_account_on_user_register 
    public function zbs_account_on_user_register($user_id)
    {
        init_zbs_user($user_id);
    }
}

if (class_exists('Zero_BS_Accounting')) {
    $Zero_BS_AccountingPlugin = new Zero_BS_Accounting();
    $Zero_BS_AccountingPlugin->register();
}

/**
 * init_zbs_user
 */
if(!function_exists('init_zbs_user')) {
    function init_zbs_user($user_id = null) {
        $user_id = $user_id ? $user_id : get_current_user_id();

        global $wpdb;
        // check if user has profile, if not create one

        // update zb_profile meta

    }
}

// init_zbs_users
if(!function_exists('init_zbs_users')) {
    function init_zbs_users() {
        $users = get_users();
        foreach ($users as $user) {
            init_zbs_user($user->ID);
        }
    }
}


// Activation
require_once plugin_dir_path(__FILE__)  . 'inc/zbs-account-activate.php';
register_activation_hook(__FILE__, array('Zero_BS_AccountingPluginActivate', 'activate'));

// Deactivation
require_once plugin_dir_path(__FILE__)  . 'inc/zbs-account-deactivate.php';
register_deactivation_hook(__FILE__, array('Zero_BS_AccountingPluginDeactivate', 'deactivate'));
