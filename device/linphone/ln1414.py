#!/usr/bin/env python
import linphone
import logging
import os
import signal
import time
class Phone1414:
	def __init__(self):
		self.quit = False
		callbacks = {
			'call_state_changed': self.call_state_changed,
		}
		# Configure the linphone core
		logging.basicConfig(level=logging.INFO)
		signal.signal(signal.SIGINT, self.signal_handler)
		linphone.set_log_handler(self.log_handler)
		self.core = linphone.Core.new(callbacks, None, None)
		self.core.max_calls = 1
		self.core.start_dtmf_stream()
		self.core.echo_cancellation_enabled = False
		self.core.use_info_for_dtmf = False
		self.core.use_rfc2833_for_dtmf = True
		# Only enable PCMU and PCMA audio codecs
		for codec in self.core.audio_codecs:
			print codec.mime_type
		self.configure_sip_account()
 
	def signal_handler(self, signal, frame):
		self.core.terminate_all_calls()
		self.quit = True
 
	def log_handler(self, level, msg):
		method = getattr(logging, level)
		method(msg)
 
	def call_state_changed(self, core, call, state, message):
		if state == linphone.CallState.IncomingReceived:
			params = core.create_call_params(call)
			core.accept_call_with_params(call, params)
			os.system("/home/pi/1414/calls/on_incoming_call.sh {0}".format(call.remote_params.get_custom_header('X-call-number')))
 
		if state == linphone.CallState.CallEnd:
			print "Call ended"
			os.system("/home/pi/1414/calls/on_call_hangup.sh")

	def configure_sip_account(self):
		# Configure the SIP account
		proxy_cfg = self.core.create_proxy_config()
		proxy_cfg.identity = 'sip:16503383032@tmusqa.com'
		proxy_cfg.server_addr = '192.168.1.110'
		proxy_cfg.register_enabled = True
		proxy_cfg.expires = 3600
		self.core.add_proxy_config(proxy_cfg)
		auth_info = self.core.create_auth_info('16503383032', None, 'choochee1', None, None, 'tmusqa.com')
		self.core.add_auth_info(auth_info)
 
	def run(self):
		while not self.quit:
			self.core.iterate()
			time.sleep(0.03)
 
def main():
  phoneObj1414 = Phone1414()
  phoneObj1414.run()
 
main()
