#!/usr/bin/expect
spawn bt-device -c 4C:7C:5F:AD:6E:68
expect "*yes\/no*"
send "yes\r\n"
expect eof
exit
