#!/bin/bash
function log1414() {
	msg=${1}
	echo "${msg}"
	logger "${1}"
	return 0
}
BACKEND_IP="192.168.1.110"
USERNAME="16503983002"
PASSWORD="choochee1"
DOMAIN="tmusqa.com"
log1414 "curl \"http://${BACKEND_IP}/backend/voiceapi.php?api=get_device_nonce&username=${USERNAME}\""
nonce="`curl \"http://${BACKEND_IP}/backend/voiceapi.php?api=get_device_nonce&username=${USERNAME}\"`"
log1414 "echo -n ${USERNAME}:${DOMAIN}:${PASSWORD} | md5sum | awk '{print \$1}'"
ha1="`echo -n ${USERNAME}:${DOMAIN}:${PASSWORD} | md5sum | awk '{print $1}'`"
log1414 "echo -n ${ha1}:${nonce} | md5sum | awk '{print \$1}'"
device_ha1="`echo -n ${ha1}:${nonce} | md5sum | awk '{print $1}'`"
log1414 "curl \"http://${BACKEND_IP}/backend/voiceapi.php?api=get_device_apikey&username=${USERNAME}&device_ha1=${device_ha1}\"" 
apikey="`curl \"http://${BACKEND_IP}/backend/voiceapi.php?api=get_device_apikey&username=${USERNAME}&device_ha1=${device_ha1}\"`"
log1414 "apikey is [${apikey}]"
for i in `seq 1 14`; do
	voip="`/home/pi/voip_call_list.sh | head -n 6 | tail -n 1`"
	cd /home/pi/ofono/test/
	calls="`sudo ./list-calls`"
	echo "${calls}" | sed ':a;N;$!ba;s/\n/~/g' > /home/pi/status.txt
	status="`cat /home/pi/status.txt | python -c 'import json,sys; print json.dumps(sys.stdin.read())' | sed 's/\"//g'`"
	log1414 "curl -X POST --data \"${status}\" \"http://${BACKEND_IP}/backend/voiceapi.php?api=set_device_status&username=${USERNAME}&apikey=${apikey}\""
	curl -X POST --data "${status}" "http://${BACKEND_IP}/backend/voiceapi.php?api=set_device_status&username=${USERNAME}&apikey=${apikey}"
	log1414 "voip = [${voip}]"
	log1414 "calls = [${calls}]"
	is_calls="`echo \"${calls}\" | wc | awk '{print $1}'`"
	is_voip="`echo \"${voip}\" | grep \"You have 0 active call\" | wc | awk '{print $1}'`"
	if [ "${is_calls}" == "1" ] && [ "${is_voip}" == "0" ] ; then
		log1414 "need to hangup"
		/home/pi/voip_hangup_all.sh
	fi
	if [ "${is_calls}" == "0" ] && [ "${is_voip}" == "1" ] ; then
		cd /home/pi/ofono/test/
		sudo ./hangup-all
	fi
	sleep 1
done
