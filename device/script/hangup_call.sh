#!/bin/bash
function log1414() {
	msg=${1}
#	echo "${msg}"
	logger "${1}"
	return 0
}
cd /home/pi/ofono/test/
sudo ./hangup-all
echo "hangup successfully"
