<script>
  $(function () {
    $('#example1').DataTable({
      "scrollX": true,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "processing": true,
      "serverSide": false,
      // "ajax":{
      //   url :'<?php echo base_url()."settings/groupmanagement/ajax/".$requestMenu?>', // json datasource
      //   type: "GET",  // method  , by default get
      // }
    });
    $('table th').addClass('bg-blue');
  });
</script>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small><?php echo $title; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Dashboard </a></li>
        <li class="active"><?php echo $title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary box-solid">
            <div class="box-header">
              <h3 class="box-title">List <?php echo $title; ?></h3>
            </div>
            <!-- /.box-header -->
            <a href="#" class="btn btn-primary" style="margin-left:10px">Add New Item</a>
            <div class="box-body">
              <?php if ($this->session->flashdata('success')) { ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $this->session->flashdata('success'); ?>
              </div>
              <?php } ?>

              <?php if ($this->session->flashdata('error')) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo $this->session->flashdata('error'); ?>
              </div>
              <?php } ?>

              <?php if ($this->session->flashdata('warning')) { ?>
              <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Warning!</h4>
                <?php echo $this->session->flashdata('warning'); ?>
              </div>
              <?php } ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Field 1</th>
                  <th>Field 2</th>
                  <th>Field 3</th>
                </tr>
                </thead>
                <tbody>
               
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->