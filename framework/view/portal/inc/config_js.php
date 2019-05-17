<!--JQUERY-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/jquery.js"></script>
<!--BOOTSTRAP 4-->
<script type="text/javascript" src="<?= URL_PORTAL ?>bootstrap4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= URL_PORTAL ?>bootstrap4/js/bootstrap.bundle.min.js"></script>
<!--MMENU-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/mmenu/jquery.mmenu.all.js"></script>        
<!--SMART WIZAD-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/SmartWizard/dist/js/jquery.smartWizard.js"></script>
<!--OWL CAROUSEL-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/owlcarousel/owl.carousel.min.js"></script>
<!--MAIN-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/main.js"></script>


<!-- ### DEV IMPORTS BELOW ### -->
<!--DEV JS-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/dev.js"></script>
<!-- include Cycle2 -->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/cycle2/jquery.cycle2.js"></script>
<!-- include one or more optional Cycle2 plugins -->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/cycle2/jquery.cycle2.carousel.js"></script>
<!--OPUS-RECORDER-->
<script type="text/javascript" src="<?= URL_PORTAL ?>js/opus_recorder/recorder.min.js"></script>
<!--WEBC-CAM JS-->  
<script type="text/javascript" src="<?= URL_PORTAL ?>js/webcam.min.js"></script>
<!--jquery form-->
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/smart/plugin/jquery-form/jquery-form.min.js"></script>
<!--MASK JQUERY--> 
<script type="text/javascript" src="<?= URL_PORTAL ?>js/jquery.mask.min.js"></script>

<?php if($oAluno = AlunoAction::recuperaObjetoAluno() !== false) { ?>
  <script type="text/javascript">
    var host = 'http://10.1.68.251:3000';

      (function(w, d, s, u) {

          w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;

          w.RocketChat(function() {
              var rc = this;
              this.onChatMaximized(function() {
                  rc.setGuestName("{{ user.username }}");
                  rc.setGuestEmail("{{ user.email }}");
              });
          });

          var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
          j.async = true; j.src = host + '/packages/rocketchat_livechat/assets/rocketchat-livechat.min.js';
          h.parentNode.insertBefore(j, h);
      })(window, document, 'script', host + '/livechat');
  </script>
<?php } ?>