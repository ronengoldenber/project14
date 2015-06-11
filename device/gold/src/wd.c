#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdarg.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <errno.h>
#include <syslog.h>
struct stat sts;
extern int errno;
#define PULSE_AUDIO "pulseaudio"
#define LOG_SEVERITY LOG_DEBUG
#define WD "/home/pi/1414/wd/wd.sh"
#define CC "/home/pi/1414/calls/clean_calls.sh"
#define LOCAL "/home/pi/1414/country.txt"
int log1414(int severity, const char* fmt, ...) {
	if(severity>LOG_SEVERITY) {
		return 0;
	}
	char buf[256];
	char msg[256];
	va_list args;
	va_start(args, fmt);
	vsprintf(buf, fmt, args);
	va_end(args);
	snprintf(msg, 256, "%d:%s\n", severity, buf);
	openlog ("wd1414", LOG_CONS | LOG_PID | LOG_NDELAY, LOG_LOCAL0);
//	printf(msg);
	syslog(severity, msg); 
	closelog();
	return 0;
}
int get_pid(const char* pname) {
	char line[256];
	char cmdline[256];
	int i = 0;
	snprintf(cmdline, 256, "/bin/pidof %s ", pname);
	log1414(LOG_DEBUG, cmdline);
	FILE *cmd = popen(cmdline, "r");
	fgets(line, 256, cmd);
	i = atoi(line);
	pclose(cmd);
	return i;
}
int read_from_file(const char* filename, int index) {
	char ch = 0;
	FILE *fp = NULL;
	char number[32];
	int i = 0, j = 0, k = 0;
	memset(number, 0, 32);
	log1414(LOG_DEBUG, "Read from file [%s], index [%d]", filename, index);
	if(!filename) {
		log1414(LOG_WARNING, "There is no file to read from ");
		return 0;
	}
	fp = fopen(filename,"r");
	if(fp == NULL) {
		log1414(LOG_WARNING, "Cannot open the file [%s]", filename);
		return 0;
	}
	while((ch = fgetc(fp)) != EOF) {
		if(k++ > 256) {
			break;
		}
		if(ch == ' ') {
			i++;
			if(i >= index) {
				break;
			}
			continue;
		}
		if(i==(index - 1)) {
			number[j++] = ch;
		}
	}
	fclose(fp);
	log1414(LOG_DEBUG, "param [%d] number [%s]", index, number);
	return atoi(number);
}
int read_digits_from_file(const char* filename) {
	char ch = 0;
	FILE *fp = NULL;
	char number[32];
	int i = 0, j = 0;
	memset(number, 0, 32);
	log1414(LOG_DEBUG, "Read digits from file [%s]", filename);
	if(!filename) {
		log1414(LOG_WARNING, "There is no file to read digits from ");
		return 0;
	}
	fp = fopen(filename,"r");
	if(fp == NULL) {
		log1414(LOG_WARNING, "Cannot open the digits file [%s]", filename);
		return 0;
	}
	while((ch = fgetc(fp)) != EOF) {
		if(j++ > 256) {
			break;
		}
		if(ch >= '0' && ch <= '9') {
			number[i++] = ch;
		}
        }
        fclose(fp);
        log1414(LOG_DEBUG, "param from file [%s] number [%s]", filename, number);
        return atoi(number);
}
int get_utime(int pid) {
	char cmdline[256];
	char line[256];
	memset(line, 0, 256);
	if(pid <= 0) {
		log1414(LOG_WARNING, "No pid to get cpu usage for ");
		return 0;
	}
	snprintf(cmdline, 256, "/proc/%d/stat", pid);
	int utime = read_from_file(cmdline, 14);
	return utime;
}
int is_cpu(int pid) {
	int utime_start = 0, utime_end = 0, diff = 0;
	if(pid == 0) {
		log1414(LOG_DEBUG, "There is no process to check cpu usage for ");
		return 0;
	}
	utime_start = get_utime(pid);
	utime_end = 0, diff = 0;
	log1414(LOG_DEBUG, "Sleeping for 5 seconds ");
	sleep(5);
	utime_end = get_utime(pid);
	diff = utime_end - utime_start;
	log1414(LOG_DEBUG, "The jiffies difference is [%d]", diff);
	if(diff > 30) {
		log1414(LOG_DEBUG, "The CPU is high for pid [%d] ", pid);
		return 1;
	}
	log1414(LOG_DEBUG, "The CPU is low for pid [%d] ", pid);
	return 0;
}
int usage(int argc, char *argv[]) {
	if (argc < 2) {
		log1414(LOG_WARNING, "Usage: wd <process_to_monitor>");
		return 0;
	}
	return 1;
}
int isProcessExist(const char* pname, int restart){
	const char* wdcmd = "/home/pi/1414/wd/wd.sh";
	char cmd[256];
	int pid = get_pid(pname);
	if(pid <= 0) {
		log1414(LOG_DEBUG, "The pid [%d] is not up ");
		if(restart) {
			log1414(LOG_WARNING, "Cannot find pid 0 restarting ");
			system(wdcmd);
		}
		return 0;
	}
	log1414(LOG_DEBUG, "found pid [%d]", pid);
	return pid;
}
int get_local() {
	int local = read_digits_from_file(LOCAL); 
	log1414(LOG_DEBUG, "The local is [%d]", local); 
	return local;
}
const char* get_pjcountry(int local) {
	switch(local) {
		case 972 : return "pj1414il";
	}
	return "pj1414us";
}
int main(int argc, char *argv[]) {
	int local = get_local();
	int pjpid = isProcessExist(get_pjcountry(local), 1);
	int is_voip = is_cpu(pjpid);
	int pulse_audio_pid = isProcessExist(PULSE_AUDIO, 0);
	int is_bt = is_cpu(pulse_audio_pid);
	log1414(LOG_INFO, "status [voip=%d] [bt=%d]", is_voip, is_bt); 
	if(!is_voip || !is_bt) {
		log1414(LOG_DEBUG, "Calling WD [%s]", WD);
		system(WD);
		log1414(LOG_DEBUG, "Calling CC [%s]", CC);
		system(CC);
	}
	return 0;
}

