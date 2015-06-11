#!/bin/bash
function log1414() {
	msg=${1}
#	echo "${msg}"
	logger "${1}"
	return 0
}
data="${1}"
log1414 "Hangup call [${data}] /home/pi/1414/calls/hangup_call.sh "
response="`/home/pi/1414/calls/hangup_call.sh`"
log1414 "Removing the on incoming call rm -f /home/pi/1414/calls/on_incoming_call.txt"
rm -f /home/pi/1414/calls/on_incoming_call.txt
[ "${response}" == "hangup successfully" ] && exit 0
exit 1
