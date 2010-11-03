var $mn = jQuery.noConflict();
var server_name = location.host;
var loadUrl = '/wp-content/plugins/wp-moip/ajax.php';
var ajax_load = "<img src='/wp-content/plugins/wp-moip/images/loading-white.gif' alt='loading...' />";

addLoadEvent(function() {
  $mn(".showtable").html(ajax_load).load(loadUrl, {type: 'POST'});
});

$mn.ajaxSetup ({
    // Disable caching of AJAX responses */
    cache: false
});

$mn(document).ready(function(){

		//Event Bubbling
		$mn('body').click(function(event) {
		if ($mn(event.target).is('#mn_ajax_submit')) {
			$mn('.widefat').fadeOut('fast');
			$mn('.showtable').html(); 
			$mn('.showtable').html(ajax_load).load(loadUrl, {type: 'POST', reload: 'true'});
			$mn('#mn_ajax_submit').fadeOut('slow');
			$mn('.widefat').fadeIn('slow');
		}
		});

	var loading = $mn(ajax_load).appendTo('.showtable').fadeOut('fast')
		loading.ajaxStart(function(){
			$mn(this).fadeIn('slow');
		});
		loading.ajaxStop(function(){
			$mn(this).fadeOut('fast');
		});
		
	var refreshId = setInterval(function(){
		$mn('.ajax_reload').html(); 
		$mn('.ajax_reload').load('/wp-content/plugins/wp-moip/ajax_button.php', {type: 'POST'});
		if ($mn('#mn_show_table').val() == 1){
			$mn('.ajax_reload').fadeIn('slow');
		}
		else{
			$mn('.ajax_reload').fadeOut('fast');
		}
	}, 10000);
});
