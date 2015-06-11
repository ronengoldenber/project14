#!/bin/bash
function log1414() {
	msg=${1}
#	echo "${msg}"
	logger "${1}"
	return 0
}
function disable_modem() {
	cd /home/pi/1414/phone/
	disable_modem="`sudo ./disable-modem`"
	return 0
}
cd /home/pi/1414/phone/
sudo ./hangup-all
disable_modem
echo "hangup successfully"
