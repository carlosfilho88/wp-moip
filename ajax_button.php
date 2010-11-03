<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php');

?>
<div class="mn_ajax_reload" id="mn_ajax_reload" style="float:right;margin: 0px 30px 10px;">
	<input type="submit" name="mn_ajax_submit" id="mn_ajax_submit" value="<?php _e('Update Now! &raquo;') ?>" />
	<input type="hidden" id="mn_show_table" value="<?=get_option("mn_ajax_reload") == "true" ? 1 : 0?>"/>
</div>