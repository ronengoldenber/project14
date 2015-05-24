#!/bin/bash
function log1414() {
	msg=${1}
#	echo "${msg}"
	logger "${1}"
	return 0
}
data="${1}"
call_id="${2}"
if [ "${data}" == "" ] ; then
	log1414 "Cannot dial number is empty "
	exit 1
fi
log1414 "Dialing to [${data}] call id ["${call_id}"] /home/pi/make_call.sh ${data} "
response="`/home/pi/make_call.sh \"${data}\"`"
if [ "${response}" == "1414: Call Answered" ] ; then
	log1414 "Call is answered"
	exit 0
fi
log1414 "Call is not answered [${response}]"
exit 1
