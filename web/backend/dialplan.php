<?php   
include_once 'db.php';
function section_header() {
	header('Content-Type: text/xml');
	logmsg_echo('<?xml version="1.0" encoding="UTF-8" standalone="no"?>');
	logmsg_echo('<document type="freeswitch/xml">');
	logmsg_echo('<section name="dialplan" description="1414_dialplan">');
}
function section_footer() {
	logmsg_echo('</section>');
	logmsg_echo('</document>');
}
function exit_xml() {
	section_header();
	logmsg_echo('');
	section_footer();
	return true;
}
function dialplan_gvoiceout($dst) {
	$phonedst = $dst;
	if(substr($phonedst, 0, 1) == '+') {
		$phonedst = substr($phonedst, 1);
	}
	if(strlen($phonedst) == 10 && substr($phonedst, 0, 1) != '0') {
		$phonedst = '1' . $phonedst;
	}
#	if($phonedst == '16503389367') {
#		$phonedst = '18002220300';
#	}
	logmsg_echo('<extension name="gvoice_out">');
	logmsg_echo('	<condition>');
	logmsg_echo('		<action application="set" data="hangup_after_bridge=false"/>');
	logmsg_echo('		<action application="log" data="INFO calling to [' . $phonedst . ']"/>');
	logmsg_echo('		<action application="bridge" data="dingaling/gtalk/+' . $phonedst . '@voice.google.com"/>');
#	logmsg_echo('		<action application="bridge" data="sofia/gateway/sipus/' . $phonedst . '"/>');
	logmsg_echo('	</condition>');
	logmsg_echo('</extension>');
	logmsg_echo('</context>');
	section_footer();
	return 0;
}
function dialplan_gvoicein($dst) {
	logmsg_echo('<extension name="google_in" continue="true">');
	logmsg_echo('<condition field="caller_id_name" expression="^(Google Voice)$"/>');
	logmsg_echo('<condition field="caller_id_number" expression="^\+1?(\d{10})$">');
	logmsg_echo('<action application="log" data="Google Voice Call Incoming" />');
    logmsg_echo('<action application="sleep" data="500"/>');
	logmsg_echo('<action application="flush_dtmf"/>');
	logmsg_echo('<action application="set" data="execute_on_answer=send_dtmf 1"/>');
	logmsg_echo('<action application="export" data="nolocal:jitterbuffer_msec=80"/>');
	logmsg_echo('<action application="sched_hangup" data="+10800 alloted_timeout"/>');
	logmsg_echo('<action application="answer"/>');
#	logmsg_echo('<action application="sleep" data="100"/>');
	logmsg_echo('<action application="start_dtmf"/>');
#	logmsg_echo('<action application="echo" data=""/>');
	logmsg_echo('<action application="ivr" data="ivr_1414_' . $dst . '"/>');
	logmsg_echo('<action application="hangup"/>');
	logmsg_echo('</condition>');
	logmsg_echo('</extension>');
	logmsg_echo('</context>');
	section_footer();
	return 0;
}
function dialplan_ipkall($dst) {
	logmsg_echo('<extension name="ipkall_in" continue="true">');
	logmsg_echo('<condition>');
	logmsg_echo('<action application="export" data="nolocal:jitterbuffer_msec=80"/>');
	logmsg_echo('<action application="sched_hangup" data="+10800 alloted_timeout"/>');
	logmsg_echo('<action application="flush_dtmf"/>');
	logmsg_echo('<action application="answer"/>');
	logmsg_echo('<action application="ivr" data="ivr_1414_' . $dst . '"/>');
	logmsg_echo('<action application="hangup"/>');
	logmsg_echo('</condition>');
	logmsg_echo('</extension>');
	logmsg_echo('</context>');
	section_footer();
	return 0;
}
function dialplan_asr($src, $dst, $bridge, $device_type) {
	logmsg_echo('<extension name="directory">');
	logmsg_echo('	<condition field="destination_number" expression="^411$">');
	logmsg_echo('		<action application="lua" data="directory.lua"/>');
	logmsg_echo('	</condition>');
	logmsg_echo('</extension>');
	logmsg_echo('<extension name="pizza_demo">');
	logmsg_echo('	<condition field="destination_number" expression="^(pizza|74992)$"/>');
	logmsg_echo('	<condition field="${module_exists(mod_spidermonkey)}" expression="true"/>');
	logmsg_echo('	<condition field="${module_exists(mod_pocketsphinx)}" expression="true">');
	logmsg_echo('		<action application="javascript" data="ps_pizza.js"/>');
	logmsg_echo('	</condition>');
	logmsg_echo('</extension>');
	logmsg_echo('</context>');
	section_footer();
	return 0;
}
function dialplan_xml($src, $dst, $bridge, $device_type, $variable_sip_user_agent) {
	logmsg(LOG_DEBUG, 'Starting dialplan xml [src=' . $src .'][dst=' . $dst . ']');
	section_header();
	$context = 'context_default';
	logmsg_echo('<context name="' . $context . '">');
	if($dst=='16504298142' || $dst=='16503860217' || $dst=='16503537930') {
		dialplan_gvoicein($dst);
		return 0;
	}
	if($dst=='14082078869' || $dst == '14082078868') {
		dialplan_ipkall($dst);
		return 0;
	}
	$phonedst = $dst;
	if(substr($phonedst, 0, 4) == '1414') {
		dialplan_gvoiceout(substr($dst, 4));
		return 0;
	}
	logmsg_echo('	<extension continue="true" name="extension">');
	logmsg_echo('	<condition>');
	logmsg_echo('		<action application="set" data="hangup_after_bridge=true"/>');
	logmsg_echo('		<action application="set" data="ignore_display_updates=true"/>');
	logmsg_echo('		<action application="set" data="continue_on_fail=true"/>');
	logmsg_echo('		<action application="set"  data="ignore_display_updates=true"/>');
	logmsg_echo('		<action application="limit" data="hash ${sip_received_ip} ${destination_number} 5/10"/>');
	logmsg_echo('		<action application="set" data="timezone=America/Los_Angeles"/>');
	logmsg_echo('		<action application="set" data="default_language=en"/>');
	logmsg_echo('		<action application="set" data="hold_music=' . MOH . '"/>');
	logmsg_echo('		<action application="set" data="instant_ringback=true"/>');
	logmsg_echo('		<action application="ring_ready"/>');
	logmsg_echo('		<action application="export" data="ignore_early_media=true"/>');
	if(substr($phonedst, 0, 1) == '0') {
//		logmsg_echo('		<action application="export" data="nolocal:absolute_codec_string=G729"/>');/
		logmsg_echo('       <action application="export" data="nolocal:absolute_codec_string=PCMU"/>');
	}
	if(substr($phonedst, 0, 1) != '0') {
//		logmsg_echo('       <action application="export" data="nolocal:absolute_codec_string=G729"/>');
		logmsg_echo('       <action application="export" data="nolocal:absolute_codec_string=PCMU"/>');
	}
//	$bridge = 'sofia/sipinterface/16509433364%tmusqa.com';
	logmsg_echo('		<action application="set" data="ringback=%(2000,4000,440,480)"/>');
	logmsg_echo('		<action application="set" data="bridge_generate_comfort_noise=true"/>');
	$bypass='false';
	if($variable_sip_user_agent=='IPKall') {
		$bypass='true';
	}
	if(substr($phonedst, 0, 1) == '+') {
		$phonedst = substr($phonedst, 1);
	}
	if(strlen($phonedst) == 10 && substr($phonedst, 0, 1) != '0') {
		$phonedst = '1' . $phonedst;
	}
	if(strlen($phonedst) == 11 && substr($phonedst, 0, 1) != '0') {
		$bypass='false';
	}
	logmsg_echo('		<action application="set" data="bypass_media=' . $bypass .'"/>');
	logmsg_echo('		<action application="set" data="bypass_media_after_bridge=' . $bypass . '"/>');
#	logmsg_echo('		<action application="set" data="sdp_m_per_ptime=false"/>');
	logmsg_echo('		<action application="set" data="sip_jitter_buffer_during_bridge=false"/>');
	logmsg_echo('		<action application="export" data="call_timeout=120"/>');
	logmsg_echo('		<action application="set" data="sip_h_X-call-number=' . $phonedst . '"/>');
	logmsg_echo('		<action application="export" data="nolocal:jitterbuffer_msec=80"/>');
	logmsg_echo('       <action application="sched_hangup" data="+10800 alloted_timeout"/>');
	logmsg_echo('		<action application="answer"/>');
//	if($device_type == '1') {
#		logmsg_echo('		<action application="start_dtmf"/>');
#		logmsg_echo('		<action application="ivr" data="ivr_1414"/>');
//		logmsg_echo('       <action application="bridge" data="sofia/sipinterface/16509433364%tmusqa.com"/>');
//	}
//	if($device_type == '0') {
	
		logmsg_echo('		<action application="sched_hangup" data="+10800 alloted_timeout"/>');
		logmsg_echo('		<action application="limit_execute" data="hash outbound carrier1 5 bridge ' . $bridge . '"/>');
#		logmsg_echo('		<action application="bridge" data="' . $bridge . '"/>');
//	}
	logmsg_echo('		<action application="playback" data="/usr/local/freeswitch/sounds/he/allbusy.wav"/>');
	logmsg_echo('		<action application="hangup"/>');
	logmsg_echo('	</condition>');
	logmsg_echo('	</extension>');
	logmsg_echo('</context>');
	section_footer();
}
function match_bridge($link, $src) {
	logmsg(LOG_DEBUG, 'Matching bridge [' . $src . '] ');
	$dst_username =	get_match_username($link, $src);
	return $dst_username;
}
function handle_request($link) {
	$src = $_POST['Hunt-Caller-ID-Number'];
	$dst = $_POST['Caller-Destination-Number'];
	$variable_sip_user_agent = $_POST['variable_sip_user_agent'];
	$device_type=get_device_type_by_username($link, $src);
	$dst_device = match_bridge($link, $src);
//	$bridge	= 'sofia/sipinterface/16503383032%tmusqa.com';
	$bridge	= 'sofia/sipinterface/16503983002%tmusqa.com';
	if(substr($dst, 0, 1) == '0' || substr($dst, 0, 1) == '*') { 
		$bridge = 'sofia/sipinterface/' . $dst_device . '%tmusqa.com';
//		$bridge = 'sofia/sipinterface/16503383016%tmusqa.com';
		$bridge = 'sofia/sipinterface/16503383004%tmusqa.com';
	}
	logmsg(LOG_DEBUG, 'Routing to [' . $bridge . '] device type [' . $device_type . '] ');
	return dialplan_xml($src, $dst, $bridge, $device_type, $variable_sip_user_agent);
}
function main_dialplan() {
	$link = db_connect();
	handle_request($link);
	if ($link) {
		mysqli_close($link);
	}
}
if ((isset($_POST['section'])) && ($_POST['section'] == 'dialplan')) {
	main_dialplan();
}

