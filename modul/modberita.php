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
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=berita&act=add'\"><i class='fa fa-plus-circle'></i> Tambah Berita</button>";
                        echo '</div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="tabledata" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th></th><th>Tgl Berita</th><th>Kategori</th>
                        <th>Judul</th><th>Status</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';
                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM berita a, skpd b
                                            WHERE a.id_Skpd = b.id_Skpd");
                      } else {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM berita a, skpd b
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_kategori = array(1=>'Pemberitahuan',2=>'Running teks',3=>'Sample');
                        $jns = $dt['Kategori'];

                        $jns_status = array(0=>'Draf',1=>'Publish');
                        $jx = $dt['Statusberita'];

                        echo "<tr>
                                <td>".$no++."</td>
                                <td>".tgl_indo($dt[tgl_Berita])."</td>
                                <td>$jns_kategori[$jns]</td>
                                <td>$dt[Judul]</td>
                                <td>$jns_status[$jx]</td>
                                <td class=align-center><a class='btn btn-minier btn-primary' href='?module=berita&act=edit&id=$dt[id_Berita]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                                          <button role='button' href='#modal-form-edit' value='$dt[id_Berita]_x' id='id_Spm' onClick='md_verkeg(this.value)' class='btn btn-success btn-minier' data-toggle='modal'><i class='fa fa-refresh fa-lg'></i> Status </button> ";
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
		    echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modberita.php?module=berita&act=add" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kategori </label>
                    <div class="col-sm-10">';
                    $jns_kategori = array(1=>'Pemberitahuan',2=>'Running teks',3=>'Sample');
                    echo "<select name='Kategori' id='form-field-1' required>
                            <option value=''>-Pilih Kategori-</option>";
                          foreach ($jns_kategori as $key => $value) {
                            echo "<option value=$key>$value</option>";
                          }
                    echo "</select>";
                    echo '</div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tgl. Berita </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" name="tgl_Berita" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                    </div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Judul </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" name="Judul" class="col-xs-10 col-sm-5" required/>
                    </div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Ringkasan </label>
										<div class="col-sm-10">
                      <textarea name="Ringkasan" class="col-xs-10 col-sm-8" required></textarea>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Isi Berita </label>
										<div class="col-sm-10">
                      <textarea name="Isiberita" class="col-xs-10 col-sm-8" required></textarea>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload Gambar </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Berita" class="col-xs-10 col-sm-5">
										</div>
									</div>';
                  if($_SESSION['UserLevel']==1) {
                    echo '<div class="form-group">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Status </label>
                      <div class="col-sm-10">';
                        $jns_status = array(0=>'Draf',1=>'Publish');
                        echo "<select name='Statusberita' class='col-xs-10 col-sm-5' id='form-field-1'>
                                <option value=''>-Pilih Kategori-</option>";
                              foreach ($jns_status as $key => $value) {
                                if($key == $r[Statusberita]) {
                                  echo "<option value=$key selected>$value</option>";
                                } else {
                                  echo "<option value=$key>$value</option>";
                                }
                              }
                        echo "</select>";
                        echo '</div>
                      </div>';
                    } else {
                      echo "";
                    }

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

									<div class="hr hr-24"></div>
                  </form>';

                  //modal penerima
                  echo '<div id="modal-form-edit" class="modal" tabindex="-1">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="smaller lighter blue no-margin">Tambah Penerima</h4>
                                </div>

                                <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                    <form method=post action="modul/act_modkegiatan.php?module=agenda&act=editlistkegiatan">
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
                                                  <td><input type='checkbox'></td>
                                                </tr>";
                                          }
                                          echo '</table>
                                        </div>
                                      </div>
                                      </div>

                                      <div class="modal-footer">
                                      <button class="btn btn-sm" data-dismiss="modal">
                                        <i class="ace-icon fa fa-times"></i>
                                        Cancel
                                      </button>

                                      <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                                        <i class="ace-icon fa fa-check"></i>
                                        Proses
                                      </button>
                                      </div></form>

                              </div>
                            </div>
                          </div>';



	break;
  case 'edit':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM kegiatan
                              WHERE id_Kegiatan = '$_GET[id]'");
      } else {
        $sql = mysql_query("SELECT * FROM berita WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Berita= '$_GET[id]'");
      }
      $r = mysql_fetch_array($sql);


      echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modberita.php?module=berita&act=edit" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kategori </label>
                  <div class="col-sm-10">';
                  $jns_kategori = array(1=>'Pemberitahuan',2=>'Running teks',3=>'Sample');
                  echo "<select name='Kategori' class='col-xs-10 col-sm-5' id='form-field-1' required>
                          <option value=''>-Pilih Kategori-</option>";
                        foreach ($jns_kategori as $key => $value) {
                          if($key == $r[Kategori]) {
                            echo "<option value=$key selected>$value</option>";
                          } else {
                            echo "<option value=$key>$value</option>";
                          }
                        }
                  echo "</select>";
                  echo '</div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tgl. Berita </label>
                  <div class="col-sm-10">
                    <input type="text" id="form-field-1" name="tgl_Berita" value="'.$r['tgl_Berita'].'" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Judul </label>
                  <div class="col-sm-10">
                    <input type="text" id="form-field-1" name="Judul" value="'.$r[Judul].'" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Ringkasan </label>
                  <div class="col-sm-10">
                    <textarea placeholder="Ringkasan" name="Ringkasan" class="col-xs-10 col-sm-8" required>'.$r[Ringkasan].'</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Isi Berita </label>
                  <div class="col-sm-10">
                    <textarea placeholder="" name="Isiberita" class="col-xs-10 col-sm-8" required>'.$r[Isiberita].'</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload Gambar </label>
                  <div class="col-sm-10">
                    <input type="hidden" name="fl_BeritaHidd" value="'.$r[fl_Berita].'" class="col-xs-10 col-sm-5">
                    <input type="file" accept="image/*" name="fl_Berita" class="col-xs-10 col-sm-5">
                    <a class="btn btn-warning btn-xs" target="_blank" href="media/berita/'.$_SESSION[thn_Login].'/'.$r[fl_berita].'"><i class="fa fa-image"> </i>Tampilkan</a>
                  </div>
                </div>';
                if($_SESSION['UserLevel']==1) {
                  echo '<div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Status </label>
                    <div class="col-sm-10">';
                      $jns_status = array(0=>'Draf',1=>'Publish');
                      echo "<select name='Statusberita' class='col-xs-10 col-sm-5' id='form-field-1'>
                              <option value=''>-Pilih Kategori-</option>";
                            foreach ($jns_status as $key => $value) {
                              if($key == $r[Statusberita]) {
                                echo "<option value=$key selected>$value</option>";
                              } else {
                                echo "<option value=$key>$value</option>";
                              }
                            }
                      echo "</select>";
                      echo '</div>
                    </div>';
                  } else {
                    echo "";
                  }

                echo "<input type='hidden' name='id_Berita' value='$r[id_Berita]'>";
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

                <div class="hr hr-24"></div>
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
