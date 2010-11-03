<?php

if (!defined( 'MN_TABLE' ) )
	define(MN_TABLE, "mn_payments");
	
	function mn_show_table() {
		?>
			
		<div class="wrap">
			<h2><?php _e("Transactions List"); ?></h2>
		</div>
		
		<div class="ajax_reload"></div>		
		<div class="showtable"></div>
		
	<?php }