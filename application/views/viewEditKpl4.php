<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>KPL 4</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i>Dashboard</a></li>
        <li class="active">KPL 4</li>
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
              <h3 class="box-title">KPL 4</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $formAction = "";
            if ($statEdit==true) {
              $formAction = base_url()."welcome/kpl4/save.edit";
            }else{
              $formAction = base_url()."welcome/kpl4/save.new";
            } ?>
            <form role="form" class="form-horizontal" action="<?php echo $formAction ?>" method="POST" enctype="multipart/form-data">
              <?php if ($statEdit==true) { ?>
                <input name='idParam' type="hidden" value="<?php echo $idParam; ?>">
              <?php } ?>
              <div class="box-body">

               <!--  <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Tahun</label>
                  <div class="col-sm-8">
                    <input type="text" name="THN" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->THN; } ?>" required>
                  </div>
                </div> -->

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">KPL 3</label>
                  <div class="col-sm-8">
                    <select name='ID_KPI_L3' class="form-control" required>
                    <option value=''>-- Silahkan Pilih --</option>
                    <?php
                    $selected = "";
                    foreach ($kpl3 as $key => $value) {
                      if ($statEdit) {
                        if ($dataEdit[0]->ID_KPI_L3 == $value->ID_KPI_L3) {
                          $selected = "selected";
                        }
                      }
                      echo "<option value='".$value->ID_KPI_L3."' $selected>".$value->ID_KPI_L3."</option>";
                      $selected = "";
                    }
                    ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">PAT</label>
                  <div class="col-sm-8">
                    <select name='KD_PAT' class="form-control">
                      <option value=''>-- Silahkan Pilih --</option>
                      <?php
                      $selected = "";
                      foreach ($pat as $key => $value) {
                        if ($statEdit) {
                          if ($dataEdit[0]->KD_PAT == $value->KD_PAT) {
                            $selected = "selected";
                          }
                        }
                        echo "<option value='".$value->KD_PAT."' $selected>".$value->KET."</option>";
                        $selected = "";
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">GAS</label>
                  <div class="col-sm-8">
                    <select name='KD_GAS' class="form-control">
                      <option value=''>-- Silahkan Pilih --</option>
                      <?php
                      $selected = "";
                      foreach ($gas as $key => $value) {
                        if ($statEdit) {
                          if ($dataEdit[0]->KD_GAS == $value->KD_GAS) {
                            $selected = "selected";
                          }
                        }
                        echo "<option value='".$value->KD_GAS."' $selected>".$value->KET."</option>";
                        $selected = "";
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">JBT</label>
                  <div class="col-sm-8">
                    <select name='KD_JBT' class="form-control">
                      <option value=''>-- Silahkan Pilih --</option>
                      <?php
                      $selected = "";
                      foreach ($jbt as $key => $value) {
                        if ($statEdit) {
                          if ($dataEdit[0]->KD_JBT == $value->KD_JBT) {
                            $selected = "selected";
                          }
                        }
                        echo "<option value='".$value->KD_JBT."' $selected>".$value->KET."</option>";
                        $selected = "";
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">PROG_KERJA</label>
                  <div class="col-sm-8">
                    <input type="text" name="PROG_KERJA" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->PROG_KERJA; } ?>" >
                  </div>
                </div>
                

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Formula</label>
                  <div class="col-sm-8">
                    <input type="file" name="FORMULA" class="form-control">
                    <?php 
                      if ($statEdit) {
                        if (file_exists($upload_path.$dataEdit[0]->FORMULA)) { ?>
                      <img src="<?php echo $view_path.$dataEdit[0]->FORMULA; ?>" width="200px">
                    <?php }
                      } ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Satuan</label>
                  <div class="col-sm-8">
                    <input type="text" name="SATUAN" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->SATUAN; } ?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Bobot Asli</label>
                  <div class="col-sm-8">
                    <input type="number" name="BOBOT_ASLI" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->BOBOT_ASLI; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Bobot Konversi</label>
                  <div class="col-sm-8">
                    <input type="number" name="BOBOT_KONVERSI" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->BOBOT_KONVERSI; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Bobot Final</label>
                  <div class="col-sm-8">
                    <input type="number" name="BOBOT_FINAL" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->BOBOT_FINAL; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Target Jml</label>
                  <div class="col-sm-8">
                    <input type="number" name="TARGET_JML" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->TARGET_JML; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">Target min max</label>
                  <div class="col-sm-8">
                    <input type="number" name="TARGET_MIN_MAX" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->TARGET_MIN_MAX; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">RI_JML_SEM1</label>
                  <div class="col-sm-8">
                    <input type="number" name="RI_JML_SEM1" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->RI_JML_SEM1; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">RI_VS_TARGET_SEM1</label>
                  <div class="col-sm-8">
                    <input type="number" name="RI_VS_TARGET_SEM1" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->RI_VS_TARGET_SEM1; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">RI_JML</label>
                  <div class="col-sm-8">
                    <input type="number" name="RI_JML" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->RI_JML; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">RI_VS_TARGET</label>
                  <div class="col-sm-8">
                    <input type="number" name="RI_VS_TARGET" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->RI_VS_TARGET; } ?>" step=".01">
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" class="col-sm-2 control-label">RI_NILAI</label>
                  <div class="col-sm-8">
                    <input type="number" name="RI_NILAI" class="form-control" 
                          value="<?php if ($statEdit==true) { echo $dataEdit[0]->RI_NILAI; } ?>" step=".01">
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