<?php
//session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {

//include "../config/koneksi.php";
include "config/fungsi_indotgl.php";



  switch ($_GET['act']) {
    default:
        echo '<div class="col-md-12">
                <div class="card">
                  <div class="header">
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                      <div class="input-group pull-right" style="width: 350px;">
                        <input type="text" name="table_search" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                          <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=kegiatan&act=add'\"><i class='fa fa-plus'></i> Tambah Kegiatan</button>";
                        echo '</div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="tabledata" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th></th><th>Nomor</th><th>Tanggal</th>
                        <th>Prioritas</th><th>Perihal</th><th>Status Kegiatan</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';
                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                            WHERE a.id_Skpd = b.id_Skpd");
                      } else {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
                        $jns = $dt['Prioritas'];

                        $status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                        $sttver = $status[$dt[StatusSpm]];

                        echo "<tr>
                                <td>".$no++."</td>
                                <td>$dt[NomorSurat]</td>
                                <td>".tgl_indo($dt[tgl_Surat])."</td>
                                <td>$jns_prioritas[$jns]</td>
                                <td>$dt[Perihal]</td>
                                <td>Terlaksana</td>
                                <td class=align-center><a class='btn btn-minier btn-primary' href='?module=kegiatan&act=edit&id=$dt[id_Kegiatan]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                                          <button role='button' href='#modal-form-edit' value='$dt[id_Agenda]_x' id='id_Spm' onClick='md_verkeg(this.value)' class='btn btn-success btn-minier' data-toggle='modal'><i class='fa fa-refresh fa-lg'></i> Status </button> ";
                                    echo "<a class='btn btn-minier btn-danger' href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";

                                echo '</td>
                              </tr>';
                      }
                    echo '<tbody></table>

                  <div class="footer">
                    <ul class="pagination pagination-sm no-margin pull-right">
                      <li><a href="#">&laquo;</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">&raquo;</a></li>
                    </ul>
                  </div>
                  </div>
                </div>
              </div>';

  break;

	case "add" :
		    echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modkegiatan.php?module=kegiatan&act=add" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Prioritas </label>
                    <div class="col-sm-10">';
                    $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
                    echo "<select name='Prioritas' class='col-xs-10 col-sm-5' id='form-field-1' required>
                            <option value=''>-Pilih Prioritas-</option>";
                          foreach ($jns_prioritas as $key => $value) {
                            echo "<option value=$key>$value</option>";
                          }
                    echo "</select>";
                    echo '</div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor Surat </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" name="NomorSurat" placeholder="Nomor Surat" class="col-xs-10 col-sm-5" required/>
                      <label class="col-sm-2 control-label" for="form-field-1"> Tanggal</label>
                      <input type="text" id="form-field-1" name="tgl_Surat" placeholder="Tanggal Surat" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                    </div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Perihal </label>
										<div class="col-sm-10">
                      <textarea placeholder="Perihal" name="Perihal" class="col-xs-10 col-sm-5" required></textarea>
                      <label class="col-sm-2 control-label" for="form-field-1"> Penerima</label>
                      <button role="button" type="button" href="#modal-form-penerima" value="" id="id_Spm" onClick="" class="btn btn-info btn-sm"  data-toggle="modal"> Pilih Penerima</button>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Waktu Pelaksanaan </label>
										<div class="col-sm-10">
                      <div class="input-daterange input-group">
                        <input type="text" class="input-sm form-control date-picker" name="tgl_Mulai"  placeholder="Tanggal Mulai" data-date-format="yyyy-mm-dd" value="'.$r[tgl_Mulai].'"/>
                        <span class="input-group-addon">
                          <i class="fa fa-exchange"></i>
                        </span>
                        <input type="text" class="input-sm form-control date-picker" name="tgl_Selesai"  placeholder="Tanggal Selesai" data-date-format="yyyy-mm-dd" value="'.$r[tgl_Selesai].'"/>
                      </div>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jam Acara </label>
										<div class="col-sm-10">
                      <div class="input-group bootstrap-timepicker col-xs-10 col-sm-5">
                        <input id="timepicker1" type="text" name="Pukul" class="form-control" required/>
                          <span class="input-group-addon">
                            <i class="fa fa-clock-o bigger-110"></i>
                          </span>
                      </div>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tempat </label>
										<div class="col-sm-10">
                      <input type="text" placeholder="Tempat" name="Tempat" class="col-xs-10 col-sm-5" required>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Deskripsi </label>
										<div class="col-sm-10">
											<textarea id="form-field-1" placeholder="Deskripsi" name="Deskripsi" class="col-xs-10 col-sm-5" ></textarea>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload Surat </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Surat" class="col-xs-10 col-sm-5" required>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload Lampiran </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Lampiran" class="col-xs-10 col-sm-5" required>
										</div>
									</div>';
                  echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
									echo '<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="simpan">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Simpan
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
											</button>
										</div>
									</div>

									<div class="hr hr-24"></div>';

                  //modal penerima
                  echo '<div id="modal-form-penerima" class="modal" tabindex="-1">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="smaller lighter blue no-margin">Tambah Penerima</h4>
                                </div>

                                <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div id="id_ProsesSpm"></div>

                                          <table class="table table-striped table-bordered">
                                            <tr>
                                              <th></th><th>Nama SKPD</th><th>Kepala SKPD</th><th></th>
                                            </tr>';
                                          $no=1;
                                          $q = mysql_query("SELECT * FROM skpd");
                                          while ($dt = mysql_fetch_array($q)) {
                                          echo "<tr>
                                                  <td>".$no++."</td>
                                                  <td>$dt[nm_Skpd]</td>
                                                  <td>$dt[nm_Kepala]</td>
                                                  <td><input type='checkbox' name='id_SkpdUd[]' value=$dt[id_Skpd]></td>
                                                </tr>";
                                          }
                                          echo '</table>
                                        </div>
                                      </div>
                                      </div>

                                      <div class="modal-footer">
                                      <button class="btn btn-sm btn-warning" data-dismiss="modal">
                                        <i class="ace-icon fa fa-times"></i>
                                        Tutup
                                      </button>
                                      </div></form>

                              </div>
                            </div>
                          </div>
                          </form>';




	break;
  case 'edit':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM kegiatan
                              WHERE id_Kegiatan = '$_GET[id]'");
      } else {
        $sql = mysql_query("SELECT * FROM kegiatan WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Kegiatan= '$_GET[id]'");
      }
      $r = mysql_fetch_array($sql);



      echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modkegiatan.php?module=kegiatan&act=edit" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Prioritas </label>
                  <div class="col-sm-10">';
                  $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
                  echo "<select name='Prioritas' class='col-xs-10 col-sm-5' id='form-field-1' required>
                          <option value=''>-Pilih Prioritas-</option>";
                        foreach ($jns_prioritas as $key => $value) {
                          if($key==$r[Prioritas]) {
                            echo "<option value=$key selected>$value</option>";
                          } else {
                            echo "<option value=$key>$value</option>";
                          }
                        }
                  echo "</select>";
                  echo '</div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor Surat </label>
                  <div class="col-sm-10">
                    <input type="text" id="form-field-1" name="NomorSurat" placeholder="Nomor Surat" class="col-xs-10 col-sm-5" value="'.$r[NomorSurat].'"  required/>
                    <label class="col-sm-2 control-label" for="form-field-1"> Tanggal</label>
                    <input type="text" id="form-field-1" name="tgl_Surat" placeholder="Tanggal Surat" class="date-picker" data-date-format="yyyy-mm-dd" value="'.$r[tgl_Surat].'" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Perihal </label>
                  <div class="col-sm-10">
                    <textarea placeholder="Perihal" name="Perihal" class="col-xs-10 col-sm-5" required> '.$r['Perihal'].'</textarea>
                    <label class="col-sm-2 control-label" for="form-field-1"> Penerima</label>
                    <button role="button" type="button" href="#modal-form-penerima" value="" id="id_Spm" onClick="" class="btn btn-info btn-sm"  data-toggle="modal"> Pilih Penerima</button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Waktu Pelaksanaan </label>
                  <div class="col-sm-10">
                    <div class="input-daterange input-group">
                      <input type="text" class="input-sm form-control date-picker" name="tgl_Mulai"  placeholder="Tanggal Mulai" data-date-format="yyyy-mm-dd" value="'.$r[tgl_Mulai].'"/>
                      <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                      </span>
                      <input type="text" class="input-sm form-control date-picker" name="tgl_Selesai"  placeholder="Tanggal Selesai" data-date-format="yyyy-mm-dd" value="'.$r[tgl_Selesai].'"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jam Acara </label>
                  <div class="col-sm-10">
                    <div class="input-group bootstrap-timepicker col-xs-10 col-sm-5">
                      <input id="timepicker1" type="text" name="Pukul" class="form-control" value="'.$r[Pukul].'" required/>
                        <span class="input-group-addon">
                          <i class="fa fa-clock-o bigger-110"></i>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tempat </label>
                  <div class="col-sm-10">
                    <input type="text" placeholder="Tempat" name="Tempat" class="col-xs-10 col-sm-5" value="'.$r[Tempat].'"  required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Deskripsi </label>
                  <div class="col-sm-10">
                    <textarea id="form-field-1" placeholder="Deskripsi" name="Deskripsi" class="col-xs-10 col-sm-5" >'.$r[Deskripsi].'</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload Surat </label>
                  <div class="col-sm-10">
                    <input type="file" accept="image/*" name="fl_Surat" class="col-xs-10 col-sm-5">
                    <a class="btn btn-warning btn-xs" target="_blank" href="media/surat/'.$_SESSION[thn_Login].'/'.$r[fl_Surat].'"><i class="fa fa-image"> </i>Tampilkan</a>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload Lampiran </label>
                  <div class="col-sm-10">
                    <input type="file" accept="image/*" name="fl_Lampiran" class="col-xs-10 col-sm-5">
                    <a class="btn btn-warning btn-xs" target="_blank" href="media/lampiran/'.$_SESSION[thn_Login].'/'.$r[fl_Lampiran].'"><i class="fa fa-image"> </i>Tampilkan</a>
                  </div>
                </div>';
                echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                echo "<input type='hidden' name='id_Kegiatan' value='$r[id_Kegiatan]'>";
                echo "<input type='hidden' name='token' value='$r[Token]'>";
                echo '<div class="clearfix form-actions">
                  <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit" name="simpan">
                      <i class="ace-icon fa fa-check bigger-110"></i>
                      Simpan
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                      <i class="ace-icon fa fa-undo bigger-110"></i>
                      Reset
                    </button>
                  </div>
                </div>

                <div class="hr hr-24"></div>';

                //modal penerima
                echo '<div id="modal-form-penerima" class="modal" tabindex="-1">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button class="close" data-dismiss="modal">&times;</button>
                                <h4 class="smaller lighter blue no-margin">Tambah Penerima</h4>
                              </div>

                              <div class="modal-body">
                              <div class="row">
                                  <div class="col-xs-12 col-sm-12">
                                      <div id="id_ProsesSpm"></div>

                                        <table class="table table-striped table-bordered">
                                          <tr>
                                            <th></th><th>Nama SKPD</th><th>Kepala SKPD</th><th><input type="checkbox"</th>
                                          </tr>';
                                        function ckbx($id_Skpd,$token) {
                                          $q = mysql_query("SELECT id_SkpdUd FROM penerima WHERE Token = '$token' AND id_SkpdUd = '$id_Skpd'"); //jadi array ini
                                          $r = mysql_fetch_array($q);
                                          if($id_Skpd == $r[id_SkpdUd]) {
                                            $ck = "checked";
                                          } else {
                                            $ck = "";
                                          }
                                          return $ck;
                                        }

                                        $no=1;
                                        $q = mysql_query("SELECT * FROM skpd");
                                        while ($dt = mysql_fetch_array($q)) {
                                        echo "<tr>
                                                <td>".$no++."</td>
                                                <td>$dt[nm_Skpd]</td>
                                                <td>$dt[nm_Kepala]</td>
                                                <td><input type='checkbox' ".ckbx($dt[id_Skpd],$r[Token])." name='id_SkpdUd[]' value=$dt[id_Skpd]></td>
                                              </tr>";
                                        }
                                        echo '</table>
                                      </div>
                                    </div>
                                    </div>

                                    <div class="modal-footer">
                                    <button class="btn btn-sm btn-warning" data-dismiss="modal">
                                      <i class="ace-icon fa fa-times"></i>
                                      Tutup
                                    </button>
                                    </div></form>

                            </div>
                          </div>
                        </div>
                        </form>';
  break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session
?>
<script type="text/javascript">
        //in ajax mode, remove remaining elements before leaving page
				$(document).one('ajaxloadstart.page', function(e) {
					$('[class*=select2]').remove();
					$('select[name="duallistbox_demo1[]"]').bootstrapDualListbox('destroy');
					$('.rating').raty('destroy');
					$('.multiselect').multiselect('destroy');
				});

function md_pengbud(id_Spm)
{
  $.ajax({
        url: 'library/ax_kegiatanspm.php',
        data : 'id_Spm='+id_Spm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_ProsesSpm').html(response);
        }
    });
}

function md_editpengbud(id_Rincspm)
{
  $.ajax({
        url: 'library/rinc_kegiatanspmedit.php',
        data : 'id_Rincspm='+id_Rincspm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_EditProsesSpm').html(response);
        }
    });
}



function vw_tbl(id_BidUrusan)
{
  $.ajax({
    url: 'library/vw_skpd.php',
    data: 'id_BidUrusan='+id_BidUrusan,
    type: "post",
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#vw_skpd').html(response);
    }
    });
}



  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
