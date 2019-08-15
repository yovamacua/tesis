<!-- Begin: Page Footer -->
<!-- Theme Javascript -->
<script src="../../assets/js/utility/utility.js"></script>
<script src="../../assets/js/demo/demo.js"></script>
<script src="../../assets/js/main.js"></script>
<footer id="content-footer" class="affix">
  <div class="row">
    <div class="col-md-6">
      <span class="footer-legal">© 2019 AdminDesigns</span>
    </div>
    <div class="col-md-6 text-right">
      <span class="footer-meta"><b>Usonsonate</b></span>
      <a href="#content" class="footer-return-top">
        <span class="fa fa-arrow-up"></span>
      </a>
    </div>
  </div>
</footer>
<!-- End: Page Footer -->
</body>
</html>
<!-- BEGIN: PAGE SCRIPTS -->
<script type="text/javascript">
jQuery(document).ready(function() {

  "use strict";
  // Init Demo JS
  Demo.init();
  // Init Theme Core
  Core.init();
  $('.admin-panels').adminpanel({
    grid: '.admin-grid',
    draggable: true,
    preserveGrid: true,
    // mobile: true,
    onStart: function() {
      // Do something before AdminPanels runs
    },
    onFinish: function() {
      $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');

      // Init the rest of the plugins now that the panels
      // have had a chance to be moved and organized.
      // It's less taxing to organize empty panels
    },
    onSave: function() {
      $(window).trigger('resize');
    }
  });
});
</script>
<!-- END: PAGE SCRIPTS -->
