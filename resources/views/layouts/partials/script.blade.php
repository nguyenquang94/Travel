
<!-- END SHORTCUT AREA -->

<!--================================================== -->

<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('/sa/js/plugin/pace/pace.min.js') }}"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    if (!window.jQuery) {
        document.write('<script src="{{ asset('/sa/js/libs/jquery-2.1.1.min.js') }}"><\/script>');
    }
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    if (!window.jQuery.ui) {
        document.write('<script src="{{ asset('/sa/js/libs/jquery-ui-1.10.3.min.js') }}"><\/script>');
    }
</script>

<script src="{{ asset('/sa/js/app.config.js') }}"></script>
<script src="{{ asset('/sa/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> 
<script src="{{ asset('/sa/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('/sa/js/notification/SmartNotification.min.js') }}"></script>

<!-- JARVIS WIDGETS -->
<script src="{{ asset('/sa/js/smartwidgets/jarvis.widget.min.js') }}"></script>

<!-- EASY PIE CHARTS -->
<script src="{{ asset('/sa/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

<!-- SPARKLINES -->
<script src="{{ asset('/sa/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

<!-- JQUERY VALIDATE -->
<script src="{{ asset('/sa/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

<!-- JQUERY MASKED INPUT -->
<script src="{{ asset('/sa/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

<!-- JQUERY SELECT2 INPUT -->
<script src="{{ asset('/sa/js/plugin/select2/select2.min.js') }}"></script>

<!-- JQUERY UI + Bootstrap Slider -->
<script src="{{ asset('/sa/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

<!-- browser msie issue fix -->
<script src="{{ asset('/sa/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

<!-- FastClick: For mobile devices -->
<script src="{{ asset('/sa/js/plugin/fastclick/fastclick.min.js') }}"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- Demo purpose only -->
<script src="{{ asset('/sa/js/demo.min.js') }}"></script>

<!-- MAIN APP JS FILE -->
<script src="{{ asset('/sa/js/app.min.js') }}"></script>

<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
<!-- Voice command : plugin -->
<script src="{{ asset('/sa/js/speech/voicecommand.min.js') }}"></script>

<!-- SmartChat UI : plugin -->
<script src="{{ asset('/sa/js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
<script src="{{ asset('/sa/js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>

<script src="{{ asset('/sa/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/sa/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('/sa/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('/sa/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/sa/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('/sa/js/plugin/ckeditor/ckeditor.js') }}"></script>

<script src="{{ asset('/bower_components/ace-builds/src-min/ace.js') }}"></script>
<script src="{{ asset('/bower_components/bootstrap-markdown-editor/dist/js/bootstrap-markdown-editor.js') }}"></script>


<!-- PAGE RELATED PLUGIN(S) -->

@stack("js")


<script type="text/javascript">
// DO NOT REMOVE : GLOBAL FUNCTIONS!
$(document).ready(function() {
    pageSetUp();

})

</script>

<!-- Your GOOGLE ANALYTICS CODE Below -->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();

</script>
@stack('script')
@yield('dp_script')