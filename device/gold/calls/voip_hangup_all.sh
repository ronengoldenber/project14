#!/usr/bin/expect
spawn telnet 127.0.0.1 1414
expect "raspberrypi>"
send "call hangup_all\r"
expect "raspberrypi>"
send "exit\r"
interact
