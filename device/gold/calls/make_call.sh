#!/bin/bash
function log1414() {
	msg=${1}
#	echo "${msg}"
	logger "${1}"
	return 0
}
function enable_modem() {
	cd /home/pi/1414/phone/
	enable_modem="`sudo ./enable-modem`"
	sleep 2
	return true;
}
number="${1}"
if [ "${number}" == "" ] ; then
	log1414 "No number"
	echo "No Number"
	exit 1
fi
data="${number}"
log1414 "1414: Calling ${data}..."
cd /home/pi/1414/phone/
enable_modem
is_busy="`sudo ./list-calls | grep LineIdentification`"
if [ "${is_busy}" != "" ] ; then
	log1414 "1414: Cannot call phone is already in a call "
	exit 0
fi
sudo ./dial-number ${data} > /dev/null 2>&1
for i in `seq 1 1`; do
	calls="`sudo ./list-calls | grep StartTime `"
	log1414 "Check if the call is answered "
	if [ "${calls}" != "" ] ; then
		break
	fi
done
log1414 "1414: Call Answered"
echo "1414: Call Answered"
