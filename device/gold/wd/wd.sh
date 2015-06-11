#!/bin/bash
BASE_DIR="/home/pi/1414/"
ENV_FILE="${BASE_DIR}env.txt"
BT_DIR="${BASE_DIR}bt/"
BIN_DIR="${BASE_DIR}bin/"
function log1414() {
	msg=${1}
	echo "${msg}"
	logger "${1}"
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
function set_env() {
	[ "${LOCAL}" == "" ] && return 0
	[ "${BACKEND}" == "" ] && return 0
	[ "${USERNAME}" == "" ] && return 0
	[ "${PASSWORD}" == "" ] && return 0
	[ "${DOMAIN}" == "" ] && return 0
	[ "${BT}" == "" ] && return 0
	[ "${APIKEY}" == "" ] && return 0
	echo "LOCAL=${LOCAL}" > "${ENV_FILE}.tmp"
	echo "BACKEND=${BACKEND}" >> "${ENV_FILE}.tmp"
	echo "USERNAME=${USERNAME}" >> "${ENV_FILE}.tmp"
	echo "PASSWORD=${PASSWORD}" >> "${ENV_FILE}.tmp"
	echo "DOMAIN=${DOMAIN}" >> "${ENV_FILE}.tmp"
	echo "BT=${BT}" >> "${ENV_FILE}.tmp"
	echo "APIKEY=${APIKEY}" >> "${ENV_FILE}.tmp"
	mv "${ENV_FILE}.tmp" "${ENV_FILE}"
	return 0
}
function remote_commands() {
	log1414 "curl \"http://${BACKEND}/backend/voiceapi.php?api=set_cmd&apikey=${APIKEY}&username=${USERNAME}\""
	cmd="`curl \"http://${BACKEND}/backend/voiceapi.php?api=set_cmd&apikey=${APIKEY}&username=${USERNAME}\"`"
	log1414 "Command [${cmd}] " 
	if [ "${cmd:0:5}" == "btadd" ] ; then
		btcurl="`echo \"${cmd}\" | awk '{print $2}'`"
		[ "${btcurl}" == "" ] && return 0
		BT="${btcurl}"
		set_env
		log1414 "${BT_DIR}btrm.sh"
		${BT_DIR}btrm.sh
		log1414 "${BT_DIR}btadd.sh \"${BT}\" > ${BT_DIR}bt.sh"
		${BT_DIR}btadd.sh "${BT}" > ${BT_DIR}bt.sh
		log1414 "chmod 755 ${BT_DIR}bt.sh"
		chmod 755 ${BT_DIR}bt.sh
		log1414 "${BT_DIR}bt.sh"
		${BT_DIR}bt.sh
	fi
}
function pjsip_keepalive() {
	filename=""
	[ "${LOCAL}" == "US" ] && filename="pj1414us" 
	[ "${LOCAL}" == "IL" ] && filename="pj1414il"
	if [ "${filename}" == "" ] ; then
		log1414 "Cannot find filename local [${LOCAL}] "
	fi
	pid="`pidof \"${filename}\"`"
	if [ "${pid}" == "" ] ; then
		log1414 "PID of ${filename} does not exist restarting "
		log1414 "${BIN_DIR}${filename} --registrar=sip:${USERNAME}@${DOMAIN} --id=sip:${USERNAME}@${DOMAIN} --outbound=sip:${BACKEND} --username=${USERNAME} --password=${PASSWORD} --realm=${DOMAIN} --quality=10 --ec-tail=0 --no-vad --auto-answer=200 --clock-rate=8000 --use-cli --cli-telnet-port=1414 --dis-codec=G722 &"
		${BIN_DIR}${filename} --registrar=sip:${USERNAME}@${DOMAIN} --id=sip:${USERNAME}@${DOMAIN} --outbound=sip:${BACKEND} --username=${USERNAME} --password=${PASSWORD} --realm=${DOMAIN} --quality=10 --ec-tail=0 --no-vad --auto-answer=200 --clock-rate=8000 --use-cli --cli-telnet-port=1414 --dis-codec=G722 &
	fi
}
function get_apikey() {
	log1414 "curl \"http://${BACKEND}/backend/voiceapi.php?api=get_device_nonce&username=${USERNAME}\""
	nonce="`curl \"http://${BACKEND}/backend/voiceapi.php?api=get_device_nonce&username=${USERNAME}\"`"
	log1414 "echo -n ${USERNAME}:${DOMAIN}:${PASSWORD} | md5sum | awk '{print \$1}'"
	ha1="`echo -n ${USERNAME}:${DOMAIN}:${PASSWORD} | md5sum | awk '{print $1}'`"
	log1414 "echo -n ${ha1}:${nonce} | md5sum | awk '{print \$1}'"
	device_ha1="`echo -n ${ha1}:${nonce} | md5sum | awk '{print $1}'`"
	log1414 "curl \"http://${BACKEND}/backend/voiceapi.php?api=get_device_apikey&username=${USERNAME}&device_ha1=${device_ha1}\""
	apikey="`curl \"http://${BACKEND}/backend/voiceapi.php?api=get_device_apikey&username=${USERNAME}&device_ha1=${device_ha1}\"`"
	log1414 "apikey is [${apikey}]"
	APIKEY="${apikey}"
	set_env
}
get_env
get_apikey
remote_commands
pjsip_keepalive
