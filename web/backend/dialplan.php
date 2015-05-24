<?php   
include_once 'global.php';
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
function dialplan_xml($src, $dst, $bridge)
{
	logmsg(LOG_DEBUG, 'Starting dialplan xml');
	section_header();
	$context = 'context_240000001';
	logmsg_echo('<context name="' . $context . '">');
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
	logmsg_echo('		<action application="set" data="ringback=%(2000,4000,440,480)"/>');
	logmsg_echo('		<action application="set" data="bypass_media=false"/>');
	logmsg_echo('		<action application="set" data="sdp_m_per_ptime=false"/>');
	logmsg_echo('		<action application="export" data="call_timeout=120"/>');
	$phonedst = $dst;
	if(substr($phonedst, 0, 1) == '+') {
		$phonedst = substr($phonedst, 1);
	}
	if(strlen($phonedst) == 10 && substr($phonedst, 0, 1) != '0') {
		$phonedst = '1' . $phonedst;
	}
	logmsg_echo('		<action application="set" data="sip_h_X-call-number=' . $phonedst . '"/>');
	logmsg_echo('		<action application="bridge" data="' . $bridge . '"/>');
	logmsg_echo('		<action application="hangup"/>');
	logmsg_echo('	</condition>');
	logmsg_echo('	</extension>');
	logmsg_echo('</context>');
	section_footer();
}
function handle_request($link) {
	logmsg(LOG_DEBUG, 'Handling request');
	$src = $_POST['Hunt-Caller-ID-Number'];
	$dst = $_POST['Caller-Destination-Number'];
	$bridge	= 'sofia/sipinterface/16503983002%tmusqa.com';
	logmsg(LOG_DEBUG, 'calling dialplan xml');
	return dialplan_xml($src, $dst, $bridge);
}
function main_dialplan() {
	$link = db_connect();
	logmsg(LOG_DEBUG, 'Starting main dialplan ');
	handle_request();
	if ($link) {
		mysqli_close($link);
	}
}
if ((isset($_POST['section'])) && ($_POST['section'] == 'dialplan')) {
	main_dialplan();
}

