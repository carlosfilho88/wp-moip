<?php

require_once('../../../wp-config.php');
require_once('../../../wp-includes/wp-db.php');

if (!defined( 'MN_TABLE' ) )
	define(MN_TABLE, "mn_payments");
	
//Get effective NASP response and save into database
	if ($_POST) {
	global $wpdb;
	
	$select = "SELECT cod_moip FROM " . $wpdb->prefix.MN_TABLE
			. " WHERE cod_moip  = '" . $wpdb->escape($_POST['cod_moip']) . "';";
			
    $result = $wpdb->query($wpdb->prepare($select));
							
	//Get new transaction
    if($result == 0) {
	
			$insert = "INSERT INTO " . $wpdb->prefix.MN_TABLE . 
				" (valor, status_pagamento, cod_moip, forma_pagamento, tipo_pagamento, email_consumidor) 
					VALUES ('"
						  . $wpdb->escape($_POST['valor']). "','"
						  . $wpdb->escape($_POST['status_pagamento']). "','"
						  . $wpdb->escape($_POST['cod_moip']). "','"
						  . $wpdb->escape($_POST['forma_pagamento']). "','"
						  . $wpdb->escape($_POST['tipo_pagamento']). "','"
						  . $wpdb->escape($_POST['email_consumidor'])
				. "');";
					
			$ok = $wpdb->query($wpdb->prepare($insert));
	} else {
		$update = "UPDATE " . $wpdb->prefix.MN_TABLE 
				. " SET status_pagamento = " . $wpdb->escape($_POST['status_pagamento'])
				. " WHERE cod_moip = " . $wpdb->escape($_POST['cod_moip']);
					
		$ok = $wpdb->query($wpdb->prepare($update));
	}
			
		if($ok){ 	
			$option_name = 'mn_ajax_reload' ; 
			$newvalue = 'true' ;
			  if ( get_option($option_name)  != $newvalue) {
				update_option($option_name, $newvalue);
			  } else {
				add_option('mn_ajax_reload', 'true', '', 'no');
			  }
			header("HTTP/1.0 200 OK");  // sends response to MOIP 
		} else { // if any processing error not expected 
			header("HTTP/1.0 404 Not Found");  // log error and MoIP continues to send posts to your system (7 days, each 15 minutes)
		} 
			
	} 
		  		  
	/* 
		Use only for testing 
		You must enable cURL to use this
	*/
	//Create new instruction
	if($_GET['key']) {
		function moip_request($url, $xml, $token, $key, $user, $passwd) {
			$base = $token . ":" . $key;
			$auth = base64_encode($base);
			$header[] = "Authorization: Basic " . $auth;

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $passwd);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0");
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$ret = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			return isset($ret)==true ? $ret : $err;
		}

		$token = 'YOUR TOKEN HERE';
		$key = 'YOUR KEY HERE';
		$url = 'https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica';
		$user = 'YOUR USER HERE';
		$passwd = 'YOUR PASS HERE';
		$xml =  '
					<EnviarInstrucao>
					<InstrucaoUnica> 
						<Razao>Pagamento de exemplo</Razao>
						<Valores>
							 <Valor moeda="BRL">150.25</Valor>
						</Valores>
						<IdProprio>'. $_GET['key'] .'</IdProprio>
						<DataVencimento>2010-10-25T18:01:48.703-02:00</DataVencimento>
					</InstrucaoUnica>
					</EnviarInstrucao>
				';
		$response = moip_request($url, $xml, $token, $key, $user, $passwd);

		echo $response; //you should go to the payment page with the generated token and effecting it 
						//e.g.: https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token=TRANSACTION_TOKEN
						//after this, you can manage your NASP normally
	}
