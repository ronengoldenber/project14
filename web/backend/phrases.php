<?php   
include_once 'global.php';
function main_phrase() {
	print_request();
	$link = db_connect();
	handle_request($link);
	if($link) {
		mysqli_close($link);
	}
}
function phrases_header() {
	header('Content-Type: text/xml');
	logmsg_echo("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>");
	logmsg_echo("<document type=\"freeswitch/xml\">");
	logmsg_echo("<section name=\"phrases\" description=\"phrases\">");
	logmsg_echo('		<macros>');
	logmsg_echo('<language name="en" say-module="en" sound-prefix="/usr/local/freeswitch/sounds/en/us/callie" tts-engine="cepstral" tts-voice="callie">');
}
function phrases_footer(){
	 logmsg_echo('   </language>');
	logmsg_echo('		</macros>');
	logmsg_echo('</section>');
	return logmsg_echo('</document>');
}
function phrases_username($phrases_info)
{
	phrases_header();
	logmsg_echo('<macro name="saydigits">');
	logmsg_echo('	<input pattern="(.*)">');
	logmsg_echo('		<match>');
	logmsg_echo('	<action function="execute" data="sleep(100)"/>');
	logmsg_echo('	<action function="play-file" data="/usr/local/freeswitch/sounds/he/wrongnumber.wav"/>');
	logmsg_echo('   <action function="execute" data="sleep(400)"/>');
	logmsg_echo('			 <action function="say" data="$1" method="iterated" type="number"/>');
	logmsg_echo('		</match>');
	logmsg_echo('	</input>');
	logmsg_echo('</macro>');
	phrases_footer();
}
function phrase($phrases_info) {
	return phrases_username($phrases_info);
}
function handle_request($link) {
	$phrases_info='';
	phrase($phrases_info);
	return;
}
if ((isset($_POST['section'])) && (($_POST['section'] == 'languages') || ($_POST['section'] == 'phrases')))
{
	main_phrase();
}
