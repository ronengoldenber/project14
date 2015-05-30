#!/bin/bash
echo "#!/usr/bin/expect"
echo "spawn bt-device -c ${1}"
echo "expect \"*yes\\/no*\""
echo "send \"yes\\r\\n\""
#echo "interact"
echo "expect eof"
echo "exit"
