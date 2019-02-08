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
      //   url :'<?php echo base_url()."welcome/ajaxForm1"?>', // json datasource
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
        <small>KPL 1</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Dashboard </a></li>
        <li class="active">KPL 1</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary box-solid">
            <div class="box-header">
              <h3 class="box-title">KPL 1</h3>

              <a href="<?php base_url()?>kpl1/viewNew" class="btn btn-success" style="margin-left:10px"> <i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <!-- /.box-header -->
            
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
                  <th>Tahun</th>
                  <th>Kinerja</th>
                  <th>No Kunci</th>
                  <th>ID Kunci</th>
                  <th>Formula</th>
                  <th>Satuan</th>
                  <th>Bobot</th>
                  <th>Target</th>
                  <th>Create By</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($data as $key => $value) {
                  echo "<tr>";
                  echo "<td>".$no."</td>";
                  echo "<td>".$value->THN."</td>";
                  echo "<td>".$value->KINERJA."</td>";
                  echo "<td>".$value->INDI_KIN_KUNCI."</td>";
                  echo "<td>".$value->NO_INDI_KIN_KUNCI."</td>";
                  echo "<td>".$value->FORMULA."</td>";
                  echo "<td>".$value->SATUAN."</td>";
                  echo "<td>".$value->BOBOT."</td>";
                  echo "<td>".$value->TARGET."</td>";
                  echo "<td>".$value->CREATED_BY."</td>";
                  echo "<td><a href='".base_url()."welcome/kpl1/viewEdit/".$value->ID_KPI_L1."' class='btn btn-success'> <i class='fa fa-edit'></i></a>
                            <a href='".base_url()."welcome/kpl1/delete/".$value->ID_KPI_L1."' class='btn btn-danger' onclick=\"return confirm('Apakah anda yakin akan menghapus data ini ?');\"> <i class='fa fa-trash'></i></a> 
                        </td>";
                  echo "</tr>";
                  $no++;
                }
                ?>
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