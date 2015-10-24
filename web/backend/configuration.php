<?php   
include_once 'db.php';
define('WELCOME1414', '/usr/local/freeswitch/sounds/1414welcome.wav');
define('EXIT1414', '/usr/local/freeswitch/sounds/1414exit.wav');
function ivr_xml_header() {
	header('Content-Type: text/xml');
	logmsg_echo('<?xml version="1.0" encoding="UTF-8" standalone="no"?>');
	logmsg_echo('<document type="freeswitch/xml">');
	logmsg_echo('	<section name="configuration" description="1414_configuration">');
	logmsg_echo('		<configuration name="ivr.conf"  description="IVR menus">');
	logmsg_echo('		<menus>');
}
function ivr_xml_footer() {
	logmsg_echo('		</menus>');
	logmsg_echo('	</configuration>');
	logmsg_echo('	</section>');
	logmsg_echo('</document>');
}
function exit_xml() {
	section_header();
	logmsg_echo('');
	section_footer();
	return true;
}
function ivr_common() {
	logmsg_echo('	greet-long="' . WELCOME1414 . '"');
	logmsg_echo('	greet-short="' . EXIT1414 . '"');
	logmsg_echo('	invalid-sound="' . EXIT1414 . '"');
	logmsg_echo('	exit-sound="' . EXIT1414 . '"');
	logmsg_echo('	inter-digit-timeout="2000"');
	logmsg_echo('	timeout="16000"');
	logmsg_echo('	max-failures="2"');
	logmsg_echo('	max-timeouts="2"');
	logmsg_echo('	confirm-key="#">');
	return true;
}
function get_il_dialplan() {
	logmsg_echo('   <entry action="menu-exec-app" param="transfer *555 XML context_default" digits="/^[\*][5][5][5]$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer *997 XML context_default" digits="/^[\*][9][9][7]$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 1700$1 XML context_default" digits="/^[1][7][0][0](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 1800$1 XML context_default" digits="/^[1][8][0][0](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 1801$1 XML context_default" digits="/^[1][8][0][1](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 02$1 XML context_default" digits="/^[2](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 03$1 XML context_default" digits="/^[3](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 04$1 XML context_default" digits="/^[4](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 050$1 XML context_default" digits="/^[5][0](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 052$1 XML context_default" digits="/^[5][2](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 053$1 XML context_default" digits="/^[5][3](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 054$1 XML context_default" digits="/^[5][4](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 055$1 XML context_default" digits="/^[5][5](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 058$1 XML context_default" digits="/^[5][8](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 0722$1 XML context_default" digits="/^[7][2][2](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 0723$1 XML context_default" digits="/^[7][2][3](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 0732$1 XML context_default" digits="/^[7][3][2](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 0733$1 XML context_default" digits="/^[7][3][3](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 0747$1 XML context_default" digits="/^[7][4][7](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 0768$1 XML context_default" digits="/^[7][6][8](\d{6})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 077$1 XML context_default" digits="/^[7][6][8](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 08$1 XML context_default" digits="/^[8](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" param="transfer 09$1 XML context_default" digits="/^[9](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 02$1 XML context_default" digits="/^[0][2](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 03$1 XML context_default" digits="/^[0][3](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 04$1 XML context_default" digits="/^[0][4](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 050$1 XML context_default" digits="/^[0][5][0](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 052$1 XML context_default" digits="/^[0][5][2](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 053$1 XML context_default" digits="/^[0][5][3](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 054$1 XML context_default" digits="/^[0][5][4](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 055$1 XML context_default" digits="/^[0][5][5](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 058$1 XML context_default" digits="/^[0][5][8](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0722$1 XML context_default" digits="/^[0][7][2][2](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0723$1 XML context_default" digits="/^[0][7][2][3](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0732$1 XML context_default" digits="/^[0][7][3][2](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0733$1 XML context_default" digits="/^[0][7][3][3](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0747$1 XML context_default" digits="/^[0][7][4][7](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0768$1 XML context_default" digits="/^[0][7][6][8](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 077$1 XML context_default" digits="/^[0][7][6][8](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 08$1 XML context_default" digits="/^[0][8](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 09$1 XML context_default" digits="/^[0][9](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 02$1 XML context_default" digits="/^[0][0][2](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 03$1 XML context_default" digits="/^[0][0][3](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 04$1 XML context_default" digits="/^[0][0][4](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 050$1 XML context_default" digits="/^[0][0][5][0](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 052$1 XML context_default" digits="/^[0][0][5][2](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 053$1 XML context_default" digits="/^[0][0][5][3](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 054$1 XML context_default" digits="/^[0][0][5][4](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 055$1 XML context_default" digits="/^[0][0][5][5](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 058$1 XML context_default" digits="/^[0][0][5][8](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0722$1 XML context_default" digits="/^[0][0][7][2][2](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0723$1 XML context_default" digits="/^[0][0][7][2][3](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0732$1 XML context_default" digits="/^[0][0][7][3][2](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0733$1 XML context_default" digits="/^[0][0][7][3][3](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0747$1 XML context_default" digits="/^[0][0][7][4][7](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 0768$1 XML context_default" digits="/^[0][0][7][6][8](\d{6})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 077$1 XML context_default" digits="/^[0][0][7][6][8](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 08$1 XML context_default" digits="/^[0][0][8](\d{7})$/"/>');
	logmsg_echo('   <entry action="menu-exec-app" param="transfer 09$1 XML context_default" digits="/^[0][0][9](\d{7})$/"/>');
	logmsg_echo('	<entry action="menu-exec-app" digits="/^(\d+)$/" param="playback phrase:saydigits:$1"/>');
	return true;
}
function ivr_xml_16503860217($src, $dst) {
	ivr_xml_header();
	logmsg_echo('<menu');
	logmsg_echo('	name="ivr_1414_' . $dst . '"');
	logmsg_echo('	digit-len="11"');
	ivr_common();
	get_il_dialplan();
	logmsg_echo('</menu>');
	ivr_xml_footer();
	return true;
}
function ivr_xml_16503537930($src, $dst) {
	ivr_xml_header();
	logmsg_echo('<menu');
	logmsg_echo('   name="ivr_1414_' . $dst . '"');
	logmsg_echo('   digit-len="11"');
	ivr_common();
	get_il_dialplan();
	logmsg_echo('</menu>');
	ivr_xml_footer();
	return true;
}
function handle_request($link) {
	$src = $_POST['variable_sip_from_user_stripped'];
	$dst = $_POST['Caller-Destination-Number'];
	logmsg(LOG_DEBUG, 'call ivr [' . $src . '][' . $dst . '] ');
	print_request();
	if($dst == '16503537930' || $dst == '14082078868') {
		ivr_xml_16503537930($src, $dst);
		return;
	}
	return ivr_xml_16503860217($src, $dst, '16503860217');
}
function main_configuration() {
	$link = db_connect();
	handle_request($link);
	if ($link) {
		mysqli_close($link);
	}
}
if ((isset($_POST['section'])) && ($_POST['section'] == 'configuration')) {
	main_configuration();
}

