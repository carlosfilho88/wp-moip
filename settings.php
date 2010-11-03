<?php

function mn_settings(){

	get_option('mn_check_sandbox') == 1 ? $sandbox = ' checked="checked"' : $sandbox = '';
   			
    if (isset($_POST['mn_submit'])){
		update_option('mn_check_sandbox', $_POST['mn_check_sandbox']);
		update_option('mn_moip_email', $_POST['mn_moip_email']);
		get_option('mn_check_sandbox') == 1 ? $sandbox = ' checked="checked"' : $sandbox = '';
	echo '<div id="message" class="updated fade"><p><b>Options saved!</b></p></div>';
	
    }
    
?>

<div class="wrap">

 	<form id="options_form" method="post" action="">
		<h2>MoIP Settings</h2> 
		
		<table style="width: 850px; margin: 20px 0;" id="tblspacer" class="widefat fixed">

    
                <thead>
					<tr>
						<th width="200px" scope="col">Edit Settings</th>
						<th scope="col">&nbsp;</th>
					</tr>
				</thead>
            
                <tbody>
				<tr>
                    <td class="titledesc" style="padding:12px 7px; vertical-align:top;">
						<label for="mn_check_sandbox">Enable sandbox?</label>
					</td>
					
					<td class="forminp" style="padding:12px 7px; vertical-align:top;">
						<input type="checkbox" id="mn_check_sandbox" name="mn_check_sandbox" value="1" <?php echo $sandbox;?> />
						<br>
						<small>You must have a <a href="http://desenvolvedor.moip.com.br/sandbox/" target="_new" title="">MoIP Sandbox </a>account setup before using this feature.</small>
                    </td>
                </tr>
				
				<tr>
					<td class="titledesc" style="padding:12px 7px; vertical-align:top;">
						Registered MoIP email:
					</td>
					
					<td class="forminp" style="padding:12px 7px; vertical-align:top;">
						<input type="text" name="mn_moip_email" value="<?=get_option('mn_moip_email');?>" />
						<br>
						<small>You must have a <a href="http://www.moip.com.br/" target="_new" title="">MoIP</a> account setup before using this feature.</small>
					</td>
					
				</tr>
		</table>

				<div class="submit">
					<input type="submit" name="mn_submit" id="mn_submit" value="<?php _e('Update Options &raquo;') ?>" />
				</div>

	</form>
	
</div>

<?php }