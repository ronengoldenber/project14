#!/usr/bin/expect
spawn bt-device -c DC:37:14:0B:35:96
expect "*yes\/no*"
send "yes\r\n"
interact
