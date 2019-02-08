<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>KPL 1</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i>Dashboard</a></li>
        <li class="active">KPL 1</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <!-- left column -->
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">KPL 1</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formAction = "";
            if ($statEdit==true) {
              $formAction = base_url()."kpl1/save.edit";
            }else{
              $formAction = base_url()."kpl1/save.new";
             } ?>
            <form role="form" class="form-horizontal" action="" method="POST" enctype="multipart/form-data">

            <?php $readonly = ""; 
                  $disabled = "";
            if ($statEdit==true) { $readonly = "readonly"; $disabled="disabled"; ?>
              <input name='idParam' type="hidden" value="<?php echo $idParam; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">Tahun</label>
                  <div class="col-sm-8">
                          <input type="text" name="THN" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->THN; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">Kinerja</label>
                  <div class="col-sm-8">
                          <input type="text" name="ID_KINERJA_L1" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->ID_KINERJA_L1; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">ID Kinerja</label>
                  <div class="col-sm-8">
                          <input type="text" name="ID_INDI_KIN_KUNCI" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->ID_INDI_KIN_KUNCI; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">NO Kinerja</label>
                  <div class="col-sm-8">
                          <input type="text" name="NO_INDI_KIN_KUNCI" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->NO_INDI_KIN_KUNCI; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">Formula</label>
                  <div class="col-sm-8">
                          <input type="text" name="FORMULA" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->FORMULA; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">Satuan</label>
                  <div class="col-sm-8">
                          <input type="text" name="SATUAN" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->SATUAN; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">Bobot</label>
                  <div class="col-sm-8">
                          <input type="text" name="BOBOT" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->BOBOT; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-4 control-label">Target</label>
                  <div class="col-sm-8">
                          <input type="text" name="TARGET" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->TARGET; } ?>">
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a class="btn btn-danger" href="javascript: history.go(-1)">kembali</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->