<?php

function ps_print_wp_shopping_cart() {
	if (!ps_cart_not_empty()) {
		return;
	}
    $email = get_bloginfo('admin_email');
    $defaultEmail = get_option('cart_moip_email');
    $moip_symbol = 'R$';
	
$url_images = get_bloginfo('wpurl')."/wp-content/plugins/wp-moip/images/";

   if (!empty($defaultEmail))
        $email = $defaultEmail;
    $decimal = '.';
	$urls = '';
	$title = get_option('wp_cart_title');

	if (empty($title)) $title = 'Suas compras';

    $output .= '<div class="shopping_cart" style=" padding: 5px;">';
    $output .= "<input type='image' src='".get_bloginfo('wpurl')."/wp-content/plugins/wordpress-carrinho-moip/images/moip_checkout.png' value='Carrinho' title='Carrinho' />";
    $output .= "<h2>";
    $output .= $title;
    $output .= "</h2>";
    $output .= "<br /><span id='pinfo' class='msg_alent' style='display: none; font-weight: bold;'><img src='".get_bloginfo('wpurl')."/wp-content/plugins/wordpress-carrinho-moip/images/info.png' />Pressione ENTER para atualizar a quantidade.</span>";
	$output .= '<table style="width: 100%;" border="0">';

    $count = 1;
    $total_items = 0;
    $total = 0;
    $form = '';

    if ($_SESSION['pssimpleCart'] && is_array($_SESSION['pssimpleCart'])) {
        $output .= '
        <tr>
        <th>Produto</th><th><center>Qtde</center></th><th><center>Valor</center></th>
        </tr>';

    foreach ($_SESSION['pssimpleCart'] as $item) {
        $total += $item['valor'] * $item['quantity'];
        $total_items +=  $item['quantity'];
        $item['total'] == $total;
    }

    foreach ($_SESSION['pssimpleCart'] as $item) {
        $output .= "
        <tr><td class='wp_cart_campo' style='overflow: hidden;'><a href='".$item['cartLink']."'>".$item['name']."</a></td>
        <td style='text-align: center'><form method=\"post\"  action=\"\" name='pcquantity' style='display: inline'>
        <input type='hidden' class='wp_cart_campo' name='product' value='".$item['name']."' />
        <input type='hidden' name='cquantity' value='1' /><input type='text' class='wp_cart_input' name='quantity' value='".$item['quantity']."' size='1' onchange='document.pcquantity.submit();' onkeypress='document.getElementById(\"pinfo\").style.display = \"\";' /></form></td>
        <td class='wp_cart_campo' style='text-align: center'>".ps_print_payment_currency(($item['valor'] * $item['quantity']), $moip_symbol, $decimal)."</td>
        <td><form method=\"post\"  action=\"\">
        <input type='hidden' name='product' value='".$item['name']."' />
        <!--<input type='hidden' name='product' value='".$pieces['0']."' />-->
        <input type='hidden' name='delcart' value='1' />
        <input type='image' class='wp_cart_button' src='".get_bloginfo('wpurl')."/wp-content/plugins/wordpress-carrinho-moip/images/btn_delete.png' value='Remove' title='Remover' />
         </form></td></tr>
        ";

        $form .= "
            <input type=\"hidden\" name=\"nome\" value=\"Total de [".$total_items."] produtos.\" />
            <input type=\"hidden\" name=\"valor\" value='".trata_valor($total)."' />
            <input type='hidden' name='descricao' value='Adquiridos no site [".ps_cart_current_page_url()."], produto indicativo [".$item['name']."].' />
        ";
        $form .= "<input type=\"hidden\" name=\"frete\" value=\"0\" />";
        $count++;
    }
    }
       	$count--;
       	if ($count) {
       		$output .= '<tr><td></td><td></td><td></td></tr>';
       		$output .= "
       		<tr><td colspan='2' style='font-weight: bold; text-align: right;'>Total: </td><td style='text-align: center'>".ps_print_payment_currency(($total), $moip_symbol, $decimal)."</td><td></td></tr>
       		<tr><td colspan='4'>";

				$url = get_option('mn_check_sandbox') == 1 ? "https://desenvolvedor.moip.com.br/sandbox/PagamentoMoIP.do" : "https://www.moip.com.br/PagamentoMoIP.do";
              	$output .= "<form action=\"$url\" target=\"moip\" method=\"post\">$form";
    			if ($count)
            		$output .= '<input type="image" class="wp_cart_button" src="https://www.moip.com.br/imgs/buttons/bt_pagar_c01_e04.png" name="submit" alt="MoIP" />';
    			$output .= $urls.'
			    <input type="hidden" name="id_carteira" value="'.get_option("mn_moip_email").'" />
			    </form>';
       	}

       	$output .= "
       	</td></tr>
    	</table></div>
    	";
		
		$output .='
	<script type="text/javascript" >

		var $k = jQuery.noConflict();
		var loadUrl = "/wp-content/plugins/wp-moip/wp-shopping-ajax.php";
		var ajax_load = "<img src=\'images/loading.gif\' alt=\'loading...\' />";
		

		$k(document).ready(function() {

			var data = {
				action: "pedido"				
			};
			
			$k(window).load(function() {
				$k(".shopping_cart").html(ajax_load).load(loadUrl);
				return false;
			});
		});
	</script>
	';	
	return $output;
}
ps_print_wp_shopping_cart();