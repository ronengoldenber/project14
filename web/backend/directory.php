<?php   
include_once 'global.php';
function main_directory() {
	print_request();
	$link = db_connect();
	handle_request($link);
	if($link) {
		mysqli_close($link);
	}
}
function get_username($link, $user) {
	$query = 'SELECT f.domain, t.tenant_id, d.ha1 FROM `config_farm` f JOIN `config_tenant` t ON f.farm_id = t.farm_id JOIN `config_user` s ON t.tenant_id = s.tenant_id ';
	$query .= 'JOIN `config_device` d ON s.user_id = d.user_id  WHERE d.username = ? ';
	if (!($stmt = sql_query($link, $query, 'd', array($user)))) {
		return NULL;
	}
	mysqli_stmt_bind_result($stmt, $row['domain'], $row['tenant_id'], $row['ha1']);
	if (mysqli_stmt_num_rows($stmt) == 0) {
		exit_stmt($stmt);
		return NULL;
	}
	$row['type'] = 'username';
	$row['user'] = $user;
	$row['count'] = mysqli_stmt_num_rows($stmt);
	exit_stmt($stmt);
	logmsg(LOG_DEBUG, 'Parameters found row [' . print_r($row, true) . '] ');
	return $row;
}
function directory_header() {
	header('Content-Type: text/xml');
	logmsg_echo("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>");
	logmsg_echo("<document type=\"freeswitch/xml\">");
	return logmsg_echo("<section name=\"directory\" description=\"directory\">");
}
function directory_footer(){
	logmsg_echo("</section>");
	return logmsg_echo("</document>");
}
function get_user() {
	if (!isset($_POST["user"])) {
		logmsg(LOG_DEBUG, 'There was no user found in the request ');
		return NULL;
	}
	$user = $_POST["user"];
	return $user;
}
function get_directory($link, $user) {
	return get_username($link, $user);
}
function directory_username($directory_info)
{
	directory_header();
	logmsg_echo("<domain name=\"" . $directory_info['domain'] . "\">");
	logmsg_echo("	<groups>");
	logmsg_echo("		<group name=\"default\">");
	logmsg_echo("		<users>");
	logmsg_echo("			<user id=\"" . $directory_info['user'] . "\">");
	logmsg_echo("				<variables>");
	logmsg_echo("					<variable name=\"user_context\" value=\"context_" . $directory_info['tenant_id'] . "\"/>");
	logmsg_echo("					<variable name=\"force_transfer_context\" value=\"context_" . $directory_info['tenant_id'] . "\"/>");
	logmsg_echo("					<variable name=\"user_originated\" value=\"true\"/>");
	logmsg_echo("					<variable name=\"default_language\" value=\"en\"/>");
	logmsg_echo("				</variables>");
	logmsg_echo("				<params>");
	logmsg_echo("					<param name=\"a1-hash\" value=\"" . $directory_info['ha1'] . "\"/>");
	logmsg_echo("					<param name=\"mwi-account\" value=\"" . $directory_info['user'] . "@" . $directory_info['domain'] . "\"/>");
	for($i = 0; $i < $directory_info['count'] && $i < MULTI_REGISTRATION_MAX_SIZE; $i++)
	{
		logmsg_echo("					<param name=\"backend_contact" . $i . "\" value=\"" . $directory_info['contacts'][$i] . "\"/>");
		logmsg_echo("					<param name=\"backend_expires" . $i . "\" value=\"" . $directory_info['expires_arr'][$i] . "\"/>");
	}
	logmsg_echo("				</params>");
	logmsg_echo("			</user>");
	logmsg_echo("		</users>");
	logmsg_echo("		</group>");
	logmsg_echo("	</groups>");
	logmsg_echo("</domain>");
	directory_footer();
}
function directory($directory_info) {
	return directory_username($directory_info);
}
function handle_request($link) {
	$user = get_user();
	logmsg(LOG_DEBUG, 'The user found is [' . $user . '] ');
	$directory_info = get_directory($link, $user);
	directory($directory_info);
	return;
}
if ((isset($_POST['section'])) && ($_POST['section'] == 'directory'))
{
	main_directory();
}
