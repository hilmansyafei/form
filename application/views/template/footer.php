

   <div id="line-example"></div>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> <?php echo $version; ?>
      </div>
      <strong>Copyright &copy; <?php echo $year; ?> <a href="http://almsaeedstudio.com"><?php echo $title; ?></a>.</strong> All rights
      reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

 
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(document).ready(
      function () {
        /* DinamicMenu() * dinamic activate menu */ 
        var path = $(location).attr('href');
        // Will only work if string in href matches with location 
        $('.treeview-menu li a[href="'+path+'"]').parents().addClass('active');
        $('li a[href="'+path+'"]').parents().addClass('active');
      }
    );    
  </script>
  <!-- Morris.js charts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url() ?>assets/plugins/knob/jquery.knob.js"></script>
  <!-- daterangepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="<?php echo base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>assets/dist/js/app.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url() ?>assets/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() ?>assets/dist/js/demo.js"></script>
</body>
</html>
