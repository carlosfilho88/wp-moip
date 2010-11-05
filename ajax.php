<?php 
require_once('../../../wp-config.php');
require_once('../../../wp-includes/wp-db.php');
require_once('../../../wp-includes/pluggable.php');

if(!is_user_logged_in())
	die('You must be logged in to perform this action');

	setlocale(LC_MONETARY,"pt_BR", "ptb");
	global $wpdb;

	if($_POST['reload'] == 'true'){
		$option_name = 'mn_ajax_reload' ; 
		$newvalue = 'false' ;
		  if ( get_option($option_name)  != $newvalue) {
			update_option($option_name, $newvalue);
		  } else {
			add_option('mn_ajax_reload', 'false', '', 'no');
		  }
	}

	$total = $wpdb->get_var($wpdb->escape("SELECT COUNT(*) AS `cnt` FROM `" . $wpdb->prefix.MN_TABLE . "`"));
	$per_page = 10;
	
	if(isset($_GET['apage'])) {
		$page=intval($_GET['apage']);
	} else {
		$page=1;
	}
	$start = $offset = ($page-1)*$per_page;

	$page_links = paginate_links(array( 'base'=>add_query_arg( 'apage', '%#%' ),
										'format'=>'',
										'total'=>ceil($total/$per_page),
										'current'=>$page));
	$result = $wpdb->get_results($wpdb->escape("SELECT * FROM `" . $wpdb->prefix.MN_TABLE
												. "` ORDER BY `id_transacao` LIMIT " . $start . ", " . $per_page));
	
	?>
	
		<div class="tablenav">
			<?php
			if ( $page_links )
				echo "<div class='tablenav-pages'>$page_links</div>";
			?>
			<br class="clear" />
		</div>
		
		<table class="widefat">
			<thead>
			  <tr>
				<!--<th scope="col"><?php //_e('Id transa&ccedil;&atilde;o'); ?></th>-->
				<th scope="col"><?php _e("Cod moip"); ?></th>
				<th scope="col"><?php _e('Valor'); ?></th>
				<th scope="col"><?php _e("Status pagamento"); ?></th>
				<!--<th scope="col"><?php //_e('Forma pagamento'); ?></th>-->
				<th scope="col"><?php _e('Tipo pagamento'); ?></th>
				<th scope="col"><?php _e('Forma de Pagamento'); ?></th>
				<th scope="col"><?php _e('Email consumidor'); ?></th>
				
			  </tr>
			</thead>
			
			<tbody id="the-comment-list" class="list:comment">
				<?php foreach($result as $show) { ?>
				<tr>
					<!--<td><?php //echo($show->id_transacao); ?></td>-->
					<td><?php echo($show->cod_moip); ?></td>
					<td><?php echo(money_format('%n', (float)$show->valor/100)); ?></td>
					<td><?php echo(convertStatusPagamento($show->status_pagamento)); ?></td>
					<!--<td><?php //echo($show->forma_pagamento); ?></td>-->
					<td><?php echo(preg_replace('/([a-z0-9])([A-Z])/','$1 $2',$show->tipo_pagamento)); ?></td>
					<td><?php echo(convertFormaPagamento($show->forma_pagamento)); ?></td>
					<td><?php echo($show->email_consumidor); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<div class="tablenav">
			<?php
			if ( $page_links )
				echo "<div class='tablenav-pages'>$page_links</div>";
			?>
			<br class="clear" />
		</div>
		
<?php 
function convertStatusPagamento($status){
	$statusArray = array( "1" => "Autorizado" , 
        	              "2" => "Iniciado", 
			      "3" => "Boleto Impresso", 
                              "4" => "Conclu&iacute;do" , 
	                      "5" => "Cancelado" , 
        	              "6" => "Em An&aacute;lise");
	return $statusArray[$status];
}

function convertFormaPagamento($status)
{
	$formaArray = array("1" => "Saldo MoIP pela Internet",
			    "3" => "Visa Crédito",
			    "4" => "Visa Débito",
			    "5" => "Mastercad Débito",
			    "6" => "Diners Crédito",
			    "7" => "Amex Crédito",
			    "8" => "BB Transferência",
			    "9" => "BB Boleto",
			    "10" => "BB Financiamento",
			    "12" => "Itaú ainda não escolhido",
			    "13" => "Itaú Transferência",
			    "14" => "Itaú Boleto",
			    "21" => "Bradesco Financiamento",
			    "22" => "Bradesco Transferência",
			    "24" => "Bradesco Boleto",
			    "31" => "Real Financiamento",
			    "32" => "Real Transferência",
			    "35" => "Real Boleto",
			    "58" => "MoIP Pelo Celular",
			    "73" => "Boleto Bancário",
			    "75" => "Hipercard",
			    "76" => "Oi Paggo");
	return $formaArray[$status];
}

?>
