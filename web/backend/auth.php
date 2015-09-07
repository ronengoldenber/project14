<?php
include_once 'db.php';
function set_nonce($link, $username) {
	$nonce = generate_nonce();
	$state_device_id = get_state_device_id_by_username($link, $username);
	$stmt = sql_query($link, 'UPDATE `state_device` SET nonce=?, apikey = NULL WHERE state_device_id = ?', 'ss', array($nonce, $state_device_id));
	exit_stmt($stmt);
	return $nonce;
}
function get_nonce($link, $username) {
	return get_nonce_by_username($link, $username);
}
function set_apikey($link, $username) {
	$apikey = guid();
	$state_device_id = get_state_device_id_by_username($link, $username);
	$stmt = sql_query($link, 'UPDATE `state_device` SET apikey=? WHERE state_device_id = ?', 'ss', array($apikey, $state_device_id));
	exit_stmt($stmt);
	return $apikey;
}
function get_apikey($link, $username) {
	return get_apikey_by_username($link, $username);
}

