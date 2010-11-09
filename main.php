<?php
/*
Plugin Name: WP MoIP
Plugin URI: http://www.webjasper.net/wordpress/wp-moip-nasp
Version: 0.1
Description: Provide a fully integration with MoIP Payment System.
Author: Carlos Bezerra Braga Filho
Author URI: http://www.zoomnaweb.com.br/
*/
  
require_once(WP_PLUGIN_DIR . "/wp-moip/settings.php");
require_once(WP_PLUGIN_DIR . "/wp-moip/transactions.php");
require_once(WP_PLUGIN_DIR . "/wp-moip/wp_shopping_cart.php");
require_once(WP_PLUGIN_DIR . "/wp-moip/install-script.php");

register_activation_hook(__FILE__, 'mn_install');
register_deactivation_hook(__FILE__, 'mn_uninstall');

    $widget_options = array('classname' => 'widget_wp_moip_shopping_cart', 'description' => __( "Mostra o carrinho de compras MoIP.") );
    wp_register_sidebar_widget('wp_moip_shopping_cart_widgets', __('Carrinho MoIP'), 'show_wp_moip_shopping_cart_widget', $widget_options);
    wp_register_widget_control('wp_moip_shopping_cart_widgets', __('Carrinho MoIP'), 'wp_moip_shopping_cart_widget_control' );
    
    add_filter('the_content', 'ps_print_wp_cart_button');
    add_filter('the_content', 'ps_shopping_cart_show');
    add_action('admin_head' , 'mn_admin_hd');
    add_action('wp_head', 'wp_cart_css');
    //add_action('wp_head' , 'mn_ajax_shopcart');

    add_action('admin_menu', 'mn_add_men_pg');
    
    function mn_add_men_pg() {
         if (function_exists('add_menu_page')){
            add_menu_page('MoIP', 'MoIP', 8, __FILE__, 'mn_opt_mng_page');
            add_submenu_page(__FILE__, 'Support', 'Support', 8, __FILE__, 'mn_opt_mng_page');
            add_submenu_page(__FILE__, 'Shopping Cart', 'Shopping Cart', 8, 'wp_shopping_cart', 'ps_wp_cart_options');
            add_submenu_page(__FILE__, 'General Settings', 'Settings', 8, 'settings', 'mn_settings');
            add_submenu_page(__FILE__, 'Transactions List', 'Transactions', 8, 'transactions', 'mn_show_table');
         }
    }
            
    function wp_cart_css() {
        echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('wpurl').'/wp-content/plugins/wp-moip/moip_style.css" />'."\n";
    }

    function mn_admin_hd(){
        echo '<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/wp-moip/js/moip_admin_scripts.js"></script>'."\n";
    }
    
    /*
    function mn_ajax_shopcart(){
        echo '<script type="text/javascript" src="'.get_bloginfo('wpurl').'/wp-content/plugins/wp-moip/js/mn_ajax_shopcart.js"></script>'."\n";
    }
    */


function mn_opt_mng_page() {

        ?>
<div class="wrap">
        <h2>MoIP Plugin</h2>  
    <!--<div id='update-nag'>A new version of WP MoIP NASP is available! Get it!</div>-->

    <div id="dashboard-widgets-wrap">
        <div style="clear:both;"></div>
    </div>

    <br /><em>For comments, suggestions, bug reporting, etc please <a href="http://webjasper.net/">click here</a>.</em>
             Plugin by <a href="http://zoomnaweb.com.br/" title="Zoom na Web">Zoom na Web</a>
</div>

<?php } 
