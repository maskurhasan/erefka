<?php
//session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {

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
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=notulen&act=listkegiatan'\"><i class='fa fa-plus'></i> Tambah Notulen</button>";
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
                        <th>Prioritas</th><th>Perihal</th><th>Tgl. Notulen</th><th width="20%"></th>
                      </tr>
                      </thead>
                      <tbody>';

                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b,agenda c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Kegiatan = c.id_Kegiatan");
                      } else {
                        //jangan tampilkan kegiatan SKPD sendiri
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.tgl_Notulen FROM kegiatan a, skpd b,notulen c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Kegiatan = c.id_Kegiatan
                                            AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                      }

                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
                        $jns = $dt['Prioritas'];
                        $jns_tl = array(1=>'Hadir',2=>'Tidak Hadir',3=>'Tunda');
                        $tl = $dt['Tindaklanjut'];

                        echo "<tr>
                                <td>".$no++."</td>
                                <td>$dt[NomorSurat]</td>
                                <td>".tgl_indo($dt[tgl_Surat])."</td>
                                <td>$jns_prioritas[$jns]</td>
                                <td>$dt[Perihal]</td>
                                <td>$dt[tgl_Notulen]</td>
                                <td class=align-center>
                                          <a class='btn btn-minier btn-primary' href='?module=notulen&act=add&id=$dt[id_Kegiatan]'><i class='fa fa-edit fa-lg'></i> Edit</a>";
                                    echo " <a class='btn btn-minier btn-danger' href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";
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

              echo '<div id="modal-form-edit" class="modal" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="smaller lighter blue no-margin">Tambahkan Kegiatan  edit</h4>
                            </div>

                            <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                <form method=post action="modul/act_modkegiatan.php?module=agenda&act=editlistkegiatan">
                                    <div id="id_ProsesSpm"></div>

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
  case 'listkegiatan':
  echo '<div class="col-md-12">
          <div class="card">
            <div class="header">
              <div class="row">
                <div class="col-md-6">Daftar Kegiatan yang Dilaksanakan</div>
                <div class="col-md-6">
                <div class="input-group pull-right" style="width: 350px;">
                  <input type="text" name="table_search" class="form-control" placeholder="Search">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                    echo "<!--<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=spm&act=add'\"><i class='fa fa-plus'></i> Tambah SPM</button>-->";
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
                  <th>Prioritas</th><th>Perihal</th><th>Tgl Pelaksanaan</th><th width="15%"></th>
                </tr>
                </thead>
                <tbody>';
                //data yang ditampilkan pada halaman user sesuai dengan role
                if($_SESSION['UserLevel']==1) {
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                      WHERE a.id_Skpd = b.id_Skpd");
                } else {
                  //jangan tampilkan kegiatan SKPD sendiri
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'
                                      AND a.StatusKegiatan = 0");
                }
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
                  $jns = $dt['Prioritas'];

                  echo "<tr>
                          <td>".$no++."</td>
                          <td>$dt[NomorSurat]</td>
                          <td>".tgl_indo($dt[tgl_Surat])."</td>
                          <td>$jns_prioritas[$jns]</td>
                          <td>$dt[Perihal]</td>
                          <td>$dt[tgl_Mulai] s.d $dt[tgl_Selesai]</td>
                          <td class=align-center>
                                <!--<a class='btn btn-minier btn-primary' href='?module=notulen&act=add&id=$dt[id_Kegiatan]'><i class='fa fa-display fa-lg'></i> Tambahkan</a>-->
                                <button role='button' href='#modal-form' value='$dt[id_Kegiatan]' id='id_Kegiatan' onClick='md_addnot(this.value)' class='btn btn-primary btn-minier' data-toggle='modal'><i class='fa fa-plus-circle'></i> Tambahkan </button> ";
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

        //modal dari data spm yg diambil
        echo '<div id="modal-form" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="smaller lighter blue no-margin">Tambahkan Kegiatan</h4>
											</div>

											<div class="modal-body">
                      <div class="row">
                          <div class="col-xs-12 col-sm-12">
                          <form method=post action="modul/act_modnotulen.php?module=notulen&act=add">
                              <div id="id_ProsesSpm"></div>

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
	case "add" :
  if($_SESSION['UserLevel']==1) {
    $sql = mysql_query("SELECT * FROM kegiatan
                          WHERE id_Kegiatan = '$_GET[id]'");
  } else {
    $sql = mysql_query("SELECT a.*,b.nm_Skpd,c.* FROM kegiatan a,skpd b,notulen c
                                  WHERE a.id_Skpd = b.id_Skpd
                                  AND a.id_Kegiatan = c.id_Kegiatan
                                  AND a.id_Skpd = '$_SESSION[id_Skpd]'
                                  AND a.id_Kegiatan= '$_GET[id]'");
  }
  $dt = mysql_fetch_array($sql);
  $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
  $jns = $dt['Prioritas'];


  	echo '<div class="col-md-6">
          <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
              <div class="profile-info-name"> Prioritas </div>
              <div class="profile-info-value">
                '.$jns_prioritas[$jns].'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> Nomor</div>
              <div class="profile-info-value">
                '.$dt['NomorSurat'].'  Tanggal '.$dt['tgl_Surat'].'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> Waktu </div>
              <div class="profile-info-value">
                '.$dt['Pukul'].' / Tanggal '.tgl_indo($dt['tgl_Mulai']).' s.d '.tgl_indo($dt['tgl_Selesai']).'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> Tempat </div>
              <div class="profile-info-value">
                '.$dt['Tempat'].'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> Perihal </div>
              <div class="profile-info-value">
                '.$dt['Perihal'].'
              </div>
            </div>

          </div>
          </div>';

          echo '<div class="col-md-6">
                <div class="profile-user-info profile-user-info-striped">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> SKPD </div>
                    <div class="profile-info-value">
                      '.$dt['nm_Skpd'].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Deskripsi </div>
                    <div class="profile-info-value">
                      '.$dt['Deskripsi'].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> File Surat </div>
                    <div class="profile-info-value">
                      <a class="btn btn-warning btn-xs" target="_blank" href="media/surat/'.$_SESSION[thn_Login].'/'.$dt[fl_Surat].'"><i class="fa fa-image"> </i>Tampilkan</a>
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> File Lampiran </div>
                    <div class="profile-info-value">
                      <a class="btn btn-warning btn-xs" target="_blank" href="media/lampiran/'.$_SESSION[thn_Login].'/'.$dt[fl_Lampiran].'"><i class="fa fa-image"> </i>Tampilkan</a>
                    </div>
                  </div>
                </div>
                </div>';

//mulai tab

echo '<p>&nbsp;</p>';

//mulai tab
echo '<div class="col-sm-12 widget-container-col">
            <div class="widget-box transparent">
              <div class="widget-header">
                <h4 class="widget-title lighter">Transparent Box</h4>

                <div class="widget-toolbar no-border">
                  <a href="#" data-action="settings">
                    <i class="ace-icon fa fa-cog"></i>
                  </a>

                  <a href="#" data-action="reload">
                    <i class="ace-icon fa fa-refresh"></i>
                  </a>

                  <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                  </a>

                  <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                  </a>
                </div>
              </div>

              <div class="widget-body">';
              //start tab
              echo '<!--<div class="col-sm-12">-->
                      <div class="tabbable">
                        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                          <li class="active">
                            <a data-toggle="tab" href="#home4"><i class="ace-icon fa fa-list"></i> Isi Notulen</a>
                          </li>

                          <li>
                            <a data-toggle="tab" href="#profile4"><i class="ace-icon fa fa-folder"></i> Dokumentasi</a>
                          </li>

                          <li>
                            <a data-toggle="tab" href="#dropdown14"><i class="ace-icon fa fa-check"></i> Kehadiran </a>
                          </li>

                          <li>
                            <a data-toggle="tab" href="#status"><i class="ace-icon fa fa-refresh"></i> Ubah Status</a>
                          </li>
                        </ul>

                        <div class="tab-content">
                          <div id="home4" class="tab-pane in active">';
                            //input data notulen
                        echo '<form role="form" method="post" action="modul/act_modnotulen.php?module=notulen&act=edit1" enctype="multipart/form-data">
                            <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                              <div class="profile-info-name"> Tujuan Rapat </div>
                              <div class="profile-info-value">
                              <input type="hidden" name="id_Notulen" value="'.$dt[id_Notulen].'">
                              <input type="hidden" name="id_Kegiatan" value="'.$dt[id_Kegiatan].'">
                              <input type="hidden" name="id_Skpd" value="'.$dt[id_Skpd].'">
                                <input type="text" name="Tujuanrapat" class="col-xs-10 col-sm-5" value="'.$dt[Tujuanrapat].'">
                              </div>
                            </div>
                            <div class="profile-info-row">
                              <div class="profile-info-name"> Permasalahan </div>
                              <div class="profile-info-value">
                                <input type="text" name="Permasalahan" class="col-xs-10 col-sm-5" value="'.$dt[Permasalahan].'">
                              </div>
                            </div>
                            <div class="profile-info-row">
                              <div class="profile-info-name"> Saran </div>
                              <div class="profile-info-value">
                                <textarea name="Saran" class="col-xs-10 col-sm-5">'.$dt[Saran].'</textarea>
                              </div>
                            </div>
                            <div class="profile-info-row">
                              <div class="profile-info-name"> Keputusan </div>
                              <div class="profile-info-value">
                                <textarea name="Keputusan" class="col-xs-10 col-sm-5">'.$dt[Keputusan].'</textarea>
                              </div>
                            </div>
                            <div class="profile-info-row">
                              <div class="profile-info-name"> Lampiran </div>
                              <div class="profile-info-value">
                                <input type="hidden" name="LampHid" value="'.$dt[LampiranNotulen].'">
                                <input type="file" name="LampiranNotulen" class="col-xs-10 col-sm-5">
                              </div>
                            </div>
                            <div class="profile-info-row">
                              <div class="profile-info-name"> Tgl Notulen </div>
                              <div class="profile-info-value">
                                <input type="text" id="form-field-1" name="tgl_Notulen" value="'.$dt[tgl_Notulen].'" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="col-sm-5 col-md-offset-2">
                              <button class="btn btn-success btn-sm" type="submit" name="simpan"><i class="fa fa-check"></i> Simpan</button>
                              <button class="btn btn-warning btn-sm" type="reset" name=""><i class="fa fa-refresh"></i> Reset</button>
                          </div>
                          </form>
                          <br><br>';

                          echo '</div>

                          <div id="profile4" class="tab-pane">
                            <p>
                            <form role="form" method="post" action="modul/act_modnotulen.php?module=notulen&act=edit2" enctype="multipart/form-data">
                            <div class="profile-user-info profile-user-info-striped">
                              <div class="profile-info-row">
                                <div class="profile-info-name"> Upload File </div>
                                <div class="profile-info-value">
                                <input type="hidden" name="id_Notulen" value="'.$dt[id_Notulen].'">
                                <input type="hidden" name="id_Kegiatan" value="'.$dt[id_Kegiatan].'">
                                <input type="hidden" name="id_Skpd" value="'.$dt[id_Skpd].'">
                                  <input type="file" name="Tujuan" class="col-xs-10 col-sm-5">  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                </div>
                              </div>
                              <div class="profile-info-row">
                                <div class="profile-info-name"> Upload File </div>
                                <div class="profile-info-value">
                                  <input type="file" name="Tujuan" class="col-xs-10 col-sm-5">  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                </div>
                              </div>
                              <div class="profile-info-row">
                                <div class="profile-info-name"> Upload File </div>
                                <div class="profile-info-value">
                                  <input type="file" name="Tujuan" class="col-xs-10 col-sm-5">  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                </div>
                              </div>
                              <div class="profile-info-row">
                                <div class="profile-info-name"> Upload File </div>
                                <div class="profile-info-value">
                                  <input type="file" name="Tujuan" class="col-xs-10 col-sm-5">  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                </div>
                              </div>
                              <div class="profile-info-row">
                                <div class="profile-info-name"> Upload File </div>
                                <div class="profile-info-value">
                                  <input type="file" name="Tujuan" class="col-xs-10 col-sm-5">  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                </div>
                              </div>

                            </div>
                              <br>
                            </p><hr>';


                          echo '</div>

                          <div id="dropdown14" class="tab-pane">
                          <form action="modul/act_modverifikasi.php?module=verifikasi&act=ubahstatus" method="post">
                            <p>Daftar Hadir </p>';
                            //untuk daftar check list
                            $q = mysql_query("SELECT a.nm_Skpd FROM skpd a, penerima b
                                                      WHERE a.id_Skpd = b.id_SkpdUd
                                                      AND b.Token = '$dt[Token]'");
                            $no=1;
                            echo '<table class="table table-condensed">';
                                  while($r=mysql_fetch_array($q)) {
                                    echo '<tr>
                                      <td>'.$no++.'</td><td><td>'.$r[nm_Skpd].'</td><td>Hadir</td>
                                    </tr>';
                                  }
                            echo '</table>
                          </div>

                          <div id="status" class="tab-pane">';
                            //ini untuk mengubah status dari spm yg diajukan
                            echo '<form action="modul/act_modverifikasi.php?module=verifikasi&act=ubahstatus" method="post">';
                                  $qq = mysql_query("SELECT * FROM verifikasi WHERE id_Ver = '$_GET[id]'");
                                  $rq = mysql_fetch_array($qq);
                            echo '<div class="form-horizontal">
                                    <div class="form-group">
                                      <label class="col-sm-2 control-label" for="form-field-1"> Tgl Notulen </label>
                                      <div class="col-sm-10">
                                        <input type="text" id="form-field-1" name="tgl_Ver" value="'.$rq[tgl_Ver].'" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="inputPassword3" class="col-sm-2 control-label">Status Verifikasi</label>
                                      <div class="col-sm-10">
                                        <input type="hidden" name="id_Ver" value="'.$rq[id_Ver].'">
                                        <select class="col-xs-10 col-sm-5" name="StatusVer" onchange="" required>';
                                            $status = array(0 => 'Draf',1=>'Final',2=>'Ditolak' );
                                            foreach ($status as $key => $value) {
                                              if($key == $rq[StatusVer]) {
                                                echo "<option value='$key' selected>$value</option>";
                                              } else {
                                                echo "<option value='$key'>$value</option>";
                                              }
                                            }

                                        echo '</select>
                                      </div>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="col-sm-5 col-md-offset-2">
                                      <button class="btn btn-success btn-sm" type="submit" name="simpan"><i class="fa fa-check"></i> Simpan</button>
                                      <button class="btn btn-warning btn-sm" type="reset" name=""><i class="fa fa-refresh"></i> Reset</button>
                                  </div>
                                  </form>
                                  <br><br>';

                          echo '</div>
                      </div>
                    </div>';
                    /*
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
                    </form>';
                    */



              echo '</div>
            </div>
          </div>';





	break;
  case 'edit':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM ttdbukti
                              WHERE id_Spm = '$_GET[id]'");
      } else {
        $sql = mysql_query("SELECT * FROM spm WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Spm= '$_GET[id]'");
      }
      $r = mysql_fetch_array($sql);



  break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session
?>
<script type="text/javascript">

function md_addnot(id_Kegiatan)
{
  $.ajax({
        url: 'library/ax_addnot.php',
        data : 'id_Kegiatan='+id_Kegiatan,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_ProsesSpm').html(response);
        }
    });
}

function pilih_Urusan(id_Urusan)
{
  $.ajax({
        url: 'library/bidangurusan.php',
        data : 'id_Urusan='+id_Urusan,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_BidUrusan').html(response);
        }
    });
}

function pilih_BidUrusan(id_BidUrusan)
{
  $.ajax({
        url: '../library/program.php',
        data : 'id_BidUrusan='+id_BidUrusan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Program').html(response);
        }
    });
}

function pilih_Program(id_Program)
{
  $.ajax({
        url: '../library/kegiatan.php',
        data : 'id_Program='+id_Program,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Kegiatan').html(response);
        }
    });
}



function pilih_Kegiatan(id_Kegiatan)
{
  $.ajax({
        url: '../library/nm_kegiatan.php',
        data : 'id_Kegiatan='+id_Kegiatan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#nm_Kegiatan').html(response);
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
