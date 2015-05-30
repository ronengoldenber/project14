#!/bin/bash
BASE_DIR="/home/pi/1414/"
ENV_FILE="${BASE_DIR}env.txt"
BT_DIR="${BASE_DIR}bt/"
BIN_DIR="${BASE_DIR}bin/"
function log1414() {
	msg=${1}
#	echo "${msg}"
#	logger "${1}"
	return 0
}
function get_env() {
	LOCAL="`cat \"${ENV_FILE}\" | grep \"LOCAL=\" | awk -F '=' '{print $2}'`"
	BACKEND="`cat \"${ENV_FILE}\" | grep \"BACKEND=\" | awk -F '=' '{print $2}'`"
	USERNAME="`cat \"${ENV_FILE}\" | grep \"USERNAME=\" | awk -F '=' '{print $2}'`"
	PASSWORD="`cat \"${ENV_FILE}\" | grep \"PASSWORD=\" | awk -F '=' '{print $2}'`"
	DOMAIN="`cat \"${ENV_FILE}\" | grep \"DOMAIN=\" | awk -F '=' '{print $2}'`"
	BT="`cat \"${ENV_FILE}\" | grep \"BT=\" | awk -F '=' '{print $2}'`"
	APIKEY="`cat \"${ENV_FILE}\" | grep \"APIKEY=\" | awk -F '=' '{print $2}'`"
	return 0
}
get_env
prevstatus=""
for i in `seq 1 14`; do
	voip="`/home/pi/1414/calls/voip_call_list.sh | head -n 6 | tail -n 1`"
	cd /home/pi/1414/phone/
	calls="`sudo ./list-calls`"
	echo "${calls}" | sed ':a;N;$!ba;s/\n/~/g' > /home/pi/1414/status.txt
	status="`cat /home/pi/1414/status.txt | python -c 'import json,sys; print json.dumps(sys.stdin.read())' | sed 's/\"//g'`"
	if [ "${status}" != "${prevstatus}" ] ; then
		log1414 "curl -X POST --data \"${status}\" \"http://${BACKEND}/backend/voiceapi.php?api=set_device_status&username=${USERNAME}&apikey=${APIKEY}\""
		curl -X POST --data "${status}" "http://${BACKEND}/backend/voiceapi.php?api=set_device_status&username=${USERNAME}&apikey=${APIKEY}"
		prevstatus="${status}"
	fi
	log1414 "voip = [${voip}]"
	log1414 "calls = [${calls}]"
	is_calls="`echo \"${calls}\" | wc | awk '{print $1}'`"
	is_voip="`echo \"${voip}\" | grep \"You have 0 active call\" | wc | awk '{print $1}'`"
	if [ "${is_calls}" == "1" ] && [ "${is_voip}" == "0" ] ; then
		log1414 "need to hangup"
		/home/pi/1414/calls/voip_hangup_all.sh
	fi
	if [ "${is_calls}" == "0" ] && [ "${is_voip}" == "1" ] ; then
		cd /home/pi/1414/phone/
		sudo ./hangup-all
	fi
	sleep 1
done
