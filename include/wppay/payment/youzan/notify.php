<?php
require_once('../../../../../../../wp-config.php');
if(version_compare(phpversion(), '7.0.0') >= 0){
	$json = file_get_contents('php://input');
}else{
	$json = $GLOBALS['HTTP_RAW_POST_DATA'];
}
$jsondata = json_decode($json, true);  

if($jsondata['test'] != "true"){
	$client_id = wppay_get_setting('youzan-client-id');
	$client_secret = wppay_get_setting('youzan-client-secret');
	$sign = md5($client_id."".$jsondata['msg']."".$client_secret);
	
	if($jsondata['mode'] == "1" and $sign == $jsondata['sign'] and $jsondata['type'] == "trade_TradePaid"){
		$imsg = json_decode(urldecode($jsondata['msg']),true);
		$amount = $wpdb->escape($imsg['full_order_info']['orders']['0']['payment']);
		$title = $wpdb->escape($imsg['full_order_info']['orders']['0']['title']);
		$id = $wpdb->escape($jsondata['id']);
		global $wpdb, $wppay_table_name;
		$order=$wpdb->get_row("select * from $wppay_table_name where order_num='".$title."'");
		if($order){
			if(!$order->order_status){
				$wpdb->query("UPDATE $wppay_table_name SET order_pay_num = '".$id."',order_status=1 WHERE order_num = '".$title."'");
				echo '{"code":0,"msg":"success"}';
			}
		}
	}
}else{
	echo '{"code":0,"msg":"success"}';
}