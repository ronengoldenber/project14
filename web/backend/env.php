<?php
define('OUTBOUND_PROXY', 		'192.168.1.110');
define('BACKEND_URL', 			'http://192.168.1.110/voiceapi.php?');
define('FREESWITCH_SOUND_DIRECTORY', 	'/opt/dthbs/freeswitch/sounds/');
define('DB_IP', 			'localhost');
define('DB_USER', 			'');
define('DB_PASS', 			'');
define('DB_NAME', 			'1414');
define('STATS_SERVER_IP',		'localhost');
define('STATS_SERVER_PORT',		'4046');
define('STATSD_SERVER_IP',		'localhost'); 
define('STATSD_SERVER_PORT',		'8125'); 
define('STATSD_PERF_COLLECT',		1);
define('FILESYSTEM_MOUNT', 		'/tmp/');
define('FILESYSTEM_VM',			'vm/');
define('FILE_SERVER_URL',		'http://(ext=mp3)192.168.1.110/storage/');
define('MOH', 				FREESWITCH_SOUND_DIRECTORY . 'en/us/callie/conference/conf-music.wav');
define('CONF_MOH', 			FREESWITCH_SOUND_DIRECTORY . 'en/us/callie/conference/conf-music.wav');
define('CURRENT_DIALPLAN_VERSION', 	'1');
define('CURRENT_DIRECTORY_VERSION', 	'1');
define('CURRENT_CONFIGURATION_VERSION', '1');
define('CURRENT_VM_VERSION', 		'1');
define('CURRENT_VOICEAPI_VERSION', 	'1');
define('CURRENT_PHRASES_VERSION', 	'1');
define('FFMPEG_APP', '/usr/bin/ffmpeg -i ');
define('LAME_APP', '/usr/bin/lame -h ');
define('DIRECTORY_LOG_LEVEL',		LOG_DEBUG);
define('DIALPLAN_LOG_LEVEL',		LOG_DEBUG);
define('CONFIGURATION_LOG_LEVEL',	LOG_DEBUG);
define('VM_LOG_LEVEL',			LOG_DEBUG);
define('VOICEAPI_LOG_LEVEL',		LOG_DEBUG);
define('PHRASES_LOG_LEVEL',		LOG_DEBUG);
?>