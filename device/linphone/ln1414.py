#!/usr/bin/env python
 
import linphone
import logging
import signal
import time
 
class SecurityCamera:
  def __init__(self, username='', password='', whitelist=[], camera='', snd_capture='', snd_playback=''):
    self.quit = False
    self.whitelist = whitelist
    callbacks = {
      'call_state_changed': self.call_state_changed,
    }
 
    # Configure the linphone core
    logging.basicConfig(level=logging.INFO)
    signal.signal(signal.SIGINT, self.signal_handler)
    linphone.set_log_handler(self.log_handler)
    self.core = linphone.Core.new(callbacks, None, None)
    self.core.max_calls = 1
    self.core.echo_cancellation_enabled = False
    self.core.video_capture_enabled = True
    self.core.video_display_enabled = False
    self.core.stun_server = 'stun.linphone.org'
    self.core.firewall_policy = linphone.FirewallPolicy.PolicyUseIce
    if len(camera):
      self.core.video_device = camera
    if len(snd_capture):
      self.core.capture_device = snd_capture
    if len(snd_playback):
      self.core.playback_device = snd_playback
 
    # Only enable PCMU and PCMA audio codecs
    for codec in self.core.audio_codecs:
      print codec.mime_type
      if codec.mime_type == "PCMA" or codec.mime_type == "PCMU":
        self.core.enable_payload_type(codec, True)
      else:
        self.core.enable_payload_type(codec, False)
 
    # Only enable VP8 video codec
    for codec in self.core.video_codecs:
      if codec.mime_type == "VP8":
        self.core.enable_payload_type(codec, True)
      else:
        self.core.enable_payload_type(codec, False)
 
    self.configure_sip_account(username, password)
 
  def signal_handler(self, signal, frame):
    self.core.terminate_all_calls()
    self.quit = True
 
  def log_handler(self, level, msg):
    method = getattr(logging, level)
    method(msg)
 
  def call_state_changed(self, core, call, state, message):
    if state == linphone.CallState.IncomingReceived:
      if call.remote_address.as_string_uri_only() in self.whitelist:
        params = core.create_call_params(call)
        core.accept_call_with_params(call, params)
      else:
        core.decline_call(call, linphone.Reason.Declined)
        chat_room = core.get_chat_room_from_uri(self.whitelist[0])
        msg = chat_room.create_message(call.remote_address_as_string + ' tried to call')
        chat_room.send_chat_message(msg)
 
  def configure_sip_account(self, username, password):
    # Configure the SIP account
    proxy_cfg = self.core.create_proxy_config()
    proxy_cfg.identity = 'sip:{username}@sip.linphone.org'.format(username=username)
    proxy_cfg.server_addr = 'sip:sip.linphone.org;transport=tls'
    proxy_cfg.register_enabled = True
    self.core.add_proxy_config(proxy_cfg)
    auth_info = self.core.create_auth_info(username, None, password, None, None, 'sip.linphone.org')
    self.core.add_auth_info(auth_info)
 
  def run(self):
    while not self.quit:
      self.core.iterate()
      time.sleep(0.03)
 
def main():
  cam = SecurityCamera(username='raspberry', password='pi', whitelist=['sip:trusteduser@sip.linphone.org'], camera='V4L2: /dev/video0', snd_capture='ALSA: USB Device 0x46d:0x825')
  cam.run()
 
main()
