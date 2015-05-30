#!/bin/bash
function log1414() {
	msg=${1}
#	echo "${msg}"
	logger "${1}"
	return 0
}
devices="`bt-device -l | grep \"(\" | awk -F '\(' '{print $2}' | awk -F '\)' '{print $1}'`"
if [ "${devices}" != "" ] ; then
	for device in ${devices} ; do
		if [ "${device}" != "" ] ; then
			log1414 "bt-device -r ${device}"
			bt-device -r ${device}
		fi
	done
fi
sudo hciconfig hci0 piscan
