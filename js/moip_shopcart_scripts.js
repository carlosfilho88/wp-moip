/*

var $cart = jQuery.noConflict();
var server_name = "http://"+location.host.split('www.')[1];
var ajax_loading_image = "<img src='"+server_name+"/wp-content/plugins/wp-moip/images/loading-white.gif' alt='loading...' />";

$cart(document).ready(function(){
	$cart(".wp_cart_button_add").click(function(){
		if($cart('.shopping_cart').length == 0) {
			$cart(".xoxo").append("<div class='ajax_shopping_cart'");
			$cart(".ajax_shopping_cart").html(ajax_loading_image).load("/wp-content/plugins/wp-moip/wp_shopping_cart.php .shopping_cart");
		}
		else {
			//$cart(".shopping_cart").html();
			$cart(".ajax_shopping_cart").html(ajax_loading_image).load("/wp-content/plugins/wp-moip/wp_shopping_cart.php .shopping_cart");
		}
		return false;
	});
});

*/