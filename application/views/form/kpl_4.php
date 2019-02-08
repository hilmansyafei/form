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
        <small>KPL 4</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Dashboard </a></li>
        <li class="active">KPL 4</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary box-solid">
            <div class="box-header">
              <h3 class="box-title">KPL 4</h3>

              <a href="<?php base_url()?>kpl4/viewNew" class="btn btn-success" style="margin-left:10px"> <i class="fa fa-plus"></i> Add New Item</a>
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
                  <th>ID_KPI_L3</th>
                  <th>KD_PAT</th>
                  <th>KD_GAS</th>
                  <th>KD_JBT</th>
                  <th>PROG_KERJA</th>
                  <th>FORMULA</th>
                  <th>SATUAN</th>
                  <th>BOBOT_ASLI</th>
                  <th>BOBOT_KONVERSI</th>
                  <th>BOBOT_FINAL</th>
                  <th>TARGET_JML</th>
                  <th>TARGET_MIN_MAX</th>
                  <th>RI_JML_SEM1</th>
                  <th>RI_VS_TARGET_SEM1</th>
                  <th>RI_JML</th>
                  <th>RI_VS_TARGET</th>
                  <th>RI_NILAI</th>
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
                  echo "<td>".$value->ID_KPI_L3."</td>";
                  echo "<td>".$value->PAT."</td>";
                  echo "<td>".$value->GAS."</td>";
                  echo "<td>".$value->JBT."</td>";
                  echo "<td>".$value->PROG_KERJA."</td>";
                  echo "<td>".$value->FORMULA."</td>";
                  echo "<td>".$value->SATUAN."</td>";
                  echo "<td>".$value->BOBOT_ASLI."</td>";
                  echo "<td>".$value->BOBOT_KONVERSI."</td>";
                  echo "<td>".$value->BOBOT_FINAL."</td>";
                  echo "<td>".$value->TARGET_JML."</td>";
                  echo "<td>".$value->TARGET_MIN_MAX."</td>";
                  echo "<td>".$value->RI_JML_SEM1."</td>";
                  echo "<td>".$value->RI_VS_TARGET_SEM1."</td>";
                  echo "<td>".$value->RI_JML."</td>";
                  echo "<td>".$value->RI_VS_TARGET."</td>";
                  echo "<td>".$value->RI_NILAI."</td>";
                  echo "<td>".$value->CREATED_BY."</td>";
                  echo "<td><a href='".base_url()."welcome/kpl4/viewEdit/".$value->ID_KPI_L4."' class='btn btn-success'> <i class='fa fa-edit'></i></a>
                            <a href='".base_url()."welcome/kpl4/delete/".$value->ID_KPI_L4."' class='btn btn-danger' onclick=\"return confirm('Apakah anda yakin akan menghapus data ini ?');\"> <i class='fa fa-trash'></i></a> 
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