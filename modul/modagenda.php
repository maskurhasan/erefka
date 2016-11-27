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
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=agenda&act=listkegiatan'\"><i class='fa fa-plus'></i> Tambah Agenda</button>";
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
                        <th>Prioritas</th><th>Perihal</th><th>SKPD</th><th>TL</th><th width="20%"></th>
                      </tr>
                      </thead>
                      <tbody>';

                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b,agenda c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Kegiatan = c.id_Kegiatan");
                      } else {
                        //jangan tampilkan kegiatan SKPD sendiri
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.Tindaklanjut,c.id_Agenda FROM kegiatan a, skpd b,agenda c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Kegiatan = c.id_Kegiatan
                                            AND c.id_Skpd = '$_SESSION[id_Skpd]'");
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
                                <td>$dt[nm_Skpd]</td>
                                <td>$jns_tl[$tl]</td>
                                <td class=align-center>
                                          <a class='btn btn-minier btn-primary' href='?module=agenda&act=view&id=$dt[id_Kegiatan]'><i class='fa fa-display fa-lg'></i> View</a>
                                          <button role='button' href='#modal-form-edit' value='$dt[id_Agenda]_x' id='id_Spm' onClick='md_verkeg(this.value)' class='btn btn-success btn-minier' data-toggle='modal'><i class='fa fa-edit fa-lg'></i> Edit </button> ";
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
                <div class="col-md-6">Daftar Kegiatan</div>
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
                  <th>Prioritas</th><th>Perihal</th><th>SKPD</th><th width="15%"></th>
                </tr>
                </thead>
                <tbody>';
                //data yang ditampilkan pada halaman user sesuai dengan role
                if($_SESSION['UserLevel']==1) {
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                                      WHERE a.id_Skpd = b.id_Skpd");
                } else {
                  //jangan tampilkan kegiatan SKPD sendiri
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b, penerima c
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.Token = c.Token
                                      AND c.id_SkpdUd = '$_SESSION[id_Skpd]'
                                      AND a.id_Skpd <> '$_SESSION[id_Skpd]'
                                      AND a.id_Kegiatan NOT IN (SELECT id_Kegiatan FROM agenda WHERE id_Skpd = '$_SESSION[id_Skpd]')
                                      GROUP BY a.id_Kegiatan");
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
                          <td>$dt[nm_Skpd]</td>
                          <td class=align-center>
                                  <button role='button' href='#modal-form' value='$dt[id_Kegiatan]' id='id_Kegiatan' onClick='md_verkeg(this.value)' class='btn btn-primary btn-minier' data-toggle='modal'>
                                    <i class='fa fa-plus-circle'></i> Konfirmasi </button>";
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
                          <form method=post action="modul/act_modkegiatan.php?module=agenda&act=listkegiatan">
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
	case "view" :
  if($_SESSION['UserLevel']==1) {
    $sql = mysql_query("SELECT * FROM kegiatan
                          WHERE id_Kegiatan = '$_GET[id]'");
  } else {
    $sql = mysql_query("SELECT a.*,b.nm_Skpd FROM kegiatan a,skpd b,agenda c
                                  WHERE a.id_Skpd = b.id_Skpd
                                  AND a.id_Kegiatan = c.id_Kegiatan
                                  AND c.id_Skpd = '$_SESSION[id_Skpd]'
                                  AND a.id_Kegiatan= '$_GET[id]'");
  }
  $dt = mysql_fetch_array($sql);
  $jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
  $jns = $dt['Prioritas'];


  	echo '<div class="col-md-8">
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
/*
          echo '<div class="col-md-6">
          <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
              <div class="profile-info-name"> Jenis SPM </div>
              <div class="profile-info-value">
                '.$jns_spm[$jns].'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> Nomor</div>
              <div class="profile-info-value">
                '.$dt['Nomor'].'  Tanggal '.$dt['Tanggal'].'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> Anggaran </div>
              <div class="profile-info-value">
                '.angkrp($dt['Anggaran']).'
              </div>
            </div>
            <div class="profile-info-row">
              <div class="profile-info-name"> SKPD </div>
              <div class="profile-info-value">
                '.$dt['nm_Skpd'].'
              </div>
            </div>
          </div>
          </div>';
*/

                  echo '<p>&nbsp;</p>';
/*
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
                    													<a data-toggle="tab" href="#home4"><i class="ace-icon fa fa-list"></i> Data Program Kegiatan</a>
                    												</li>

                    												<li>
                    													<a data-toggle="tab" href="#profile4"><i class="ace-icon fa fa-folder"></i> Lampiran Bukti</a>
                    												</li>

                    												<li>
                    													<a data-toggle="tab" href="#dropdown14"><i class="ace-icon fa fa-check"></i> Check-list Kelengkapan</a>
                    												</li>

                                            <li>
                    													<a data-toggle="tab" href="#status"><i class="ace-icon fa fa-refresh"></i> Ubah Status</a>
                    												</li>
                    											</ul>

                    											<div class="tab-content">
                    												<div id="home4" class="tab-pane in active">
                    													';
                                              //rincian kegiatan spm
                                              echo '
                                              <table id="tabledata" class="table table-striped table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                  <th></th><th>Kegiatan</th>
                                                  <th>Anggaran</th><th>Nilai SPM</th>
                                                </tr>
                                                </thead>
                                                <tbody>';

                                                if($_SESSION['UserLevel']==1) {
                                                  $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                                                                      WHERE a.id_Skpd = b.id_Skpd");
                                                } else {
                                                  $sql= mysql_query("SELECT b.*,d.nm_Kegiatan,c.Nilai,c.id_Rincspm FROM spm a,datakegiatan b,rincspm c,kegiatan d
                                                                      WHERE a.id_Spm = c.id_Spm
                                                                      AND c.id_DataKegiatan = b.id_DataKegiatan
                                                                      AND b.id_Kegiatan = d.id_Kegiatan
                                                                      AND a.id_Spm = '$dt[id_Spm]'");

                                                }

                                                $no=1;
                                                while($dt = mysql_fetch_array($sql)) {
                                                  //$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                                                  //$jns = $dt['Jenis'];

                                                  //$status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                                                  //$sttver = $status[$dt[StatusSpm]];

                                                  echo "<tr>
                                                          <td>".$no++."</td>
                                                          <td>$dt[nm_Kegiatan]</td>
                                                          <td>".angkrp($dt[AnggKeg])."</td>
                                                          <td>".angkrp($dt[Nilai])."</td>
                                                        </tr>";
                                                }

                                              echo '<tbody>';
                                              echo '<tfoot>
                                                      <tr>
                                                        <td></td>
                                                        <td align="right"><strong>Jumlah Total...</strong></td>
                                                        <td></td>
                                                        <td></td>
                                                      </tr>
                                                    </tfoot>';
                                              echo '</table>';

                                            echo '</div>

                    												<div id="profile4" class="tab-pane">
                    													<p>Food truck fixie locavore, accusamus mcsweeney\'s marfa nulla single-origin coffee squid.</p>';
                                              echo '<ul class="ace-thumbnails clearfix">
                                  										<li>
                                  											<a href="assets/images/gallery/image-1.jpg" title="Photo Title" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-1.jpg" />
                                  											</a>

                                  											<div class="tags">
                                  												<span class="label-holder">
                                  													<span class="label label-info">breakfast</span>
                                  												</span>

                                  												<span class="label-holder">
                                  													<span class="label label-danger">fruits</span>
                                  												</span>

                                  												<span class="label-holder">
                                  													<span class="label label-success">toast</span>
                                  												</span>

                                  												<span class="label-holder">
                                  													<span class="label label-warning arrowed-in">diet</span>
                                  												</span>
                                  											</div>

                                  											<div class="tools">
                                  												<a href="#">
                                  													<i class="ace-icon fa fa-link"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-paperclip"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-pencil"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-times red"></i>
                                  												</a>
                                  											</div>
                                  										</li>

                                  										<li>
                                  											<a href="assets/images/gallery/image-2.jpg" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-2.jpg" />
                                  												<div class="text">
                                  													<div class="inner">Sample Caption on Hover</div>
                                  												</div>
                                  											</a>
                                  										</li>

                                  										<li>
                                  											<a href="assets/images/gallery/image-3.jpg" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-3.jpg" />
                                  												<div class="text">
                                  													<div class="inner">Sample Caption on Hover</div>
                                  												</div>
                                  											</a>

                                  											<div class="tools tools-bottom">
                                  												<a href="#">
                                  													<i class="ace-icon fa fa-link"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-paperclip"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-pencil"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-times red"></i>
                                  												</a>
                                  											</div>
                                  										</li>

                                  										<li>
                                  											<a href="assets/images/gallery/image-4.jpg" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-4.jpg" />
                                  												<div class="tags">
                                  													<span class="label-holder">
                                  														<span class="label label-info arrowed">fountain</span>
                                  													</span>

                                  													<span class="label-holder">
                                  														<span class="label label-danger">recreation</span>
                                  													</span>
                                  												</div>
                                  											</a>

                                  											<div class="tools tools-top">
                                  												<a href="#">
                                  													<i class="ace-icon fa fa-link"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-paperclip"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-pencil"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-times red"></i>
                                  												</a>
                                  											</div>
                                  										</li>

                                  										<li>
                                  											<div>
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-5.jpg" />
                                  												<div class="text">
                                  													<div class="inner">
                                  														<span>Some Title!</span>

                                  														<br />
                                  														<a href="assets/images/gallery/image-5.jpg" data-rel="colorbox">
                                  															<i class="ace-icon fa fa-search-plus"></i>
                                  														</a>

                                  														<a href="#">
                                  															<i class="ace-icon fa fa-user"></i>
                                  														</a>

                                  														<a href="#">
                                  															<i class="ace-icon fa fa-share"></i>
                                  														</a>
                                  													</div>
                                  												</div>
                                  											</div>
                                  										</li>

                                  										<li>
                                  											<a href="assets/images/gallery/image-6.jpg" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-6.jpg" />
                                  											</a>

                                  											<div class="tools tools-right">
                                  												<a href="#">
                                  													<i class="ace-icon fa fa-link"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-paperclip"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-pencil"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-times red"></i>
                                  												</a>
                                  											</div>
                                  										</li>

                                  										<li>
                                  											<a href="assets/images/gallery/image-1.jpg" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-1.jpg" />
                                  											</a>

                                  											<div class="tools">
                                  												<a href="#">
                                  													<i class="ace-icon fa fa-link"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-paperclip"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-pencil"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-times red"></i>
                                  												</a>
                                  											</div>
                                  										</li>

                                  										<li>
                                  											<a href="assets/images/gallery/image-2.jpg" data-rel="colorbox">
                                  												<img width="150" height="150" alt="150x150" src="assets/images/gallery/thumb-2.jpg" />
                                  											</a>

                                  											<div class="tools tools-top in">
                                  												<a href="#">
                                  													<i class="ace-icon fa fa-link"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-paperclip"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-pencil"></i>
                                  												</a>

                                  												<a href="#">
                                  													<i class="ace-icon fa fa-times red"></i>
                                  												</a>
                                  											</div>
                                  										</li>
                                  									</ul>';

                                            echo '</div>

                    												<div id="dropdown14" class="tab-pane">
                                            <form action="modul/act_modverifikasi.php?module=verifikasi&act=ubahstatus" method="post">
                                              <p>Check-list Kelengkapan Dokumen Pengajuan SPM </p>';
                    													//untuk daftar check list
                                              $q = mysql_query("SELECT * FROM cklist WHERE Aktiv = 1");
                                              $no=1;
                                              echo '<table class="table table-condensed">';
                                                    while($r=mysql_fetch_array($q)) {
                                                      echo '<tr>
                                                        <td>'.$no++.'</td><td><input type="checkbox" value="'.$r[id_Cklist].'"></td><td>'.$r[nm_List].'</td><td><input type="text" class=""></td>
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
                                                        <label class="col-sm-2 control-label" for="form-field-1"> Tgl Verifikasi </label>
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
                                                    </div>';
                                    */
                    												echo '</div>
                    										</div>
                    									</div>';

                                      echo '<div class="clearfix form-actions">
                    										<div class="col-md-offset-3 col-md-9">
                    											<button class="btn btn-info" type="button" onClick="window.location.href=\'?module=agenda\'" name="simpan">
                    												<i class="ace-icon fa fa-check bigger-110"></i>
                    												kembali
                    											</button>

                    											&nbsp; &nbsp; &nbsp;

                    										</div>
                    									</div>
                                      </form>';

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
      echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modspm.php?module=spm&act=edit">
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis SPM </label>
              <div class="col-sm-10">';
              $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
              echo "<select name='Jenis' class='col-xs-10 col-sm-5' id='form-field-1' required>
                      <option value=''>-Pilih Jenis SPM-</option>";
                    foreach ($jns_spm as $key => $value) {
                      if($key == $r[Jenis]) {
                        echo "<option value='$key' selected>$value</option>";
                      } else {
                        echo "<option value=$key>$value</option>";
                      }
                    }
              echo "</select>";
              echo '</div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor SPM </label>
              <div class="col-sm-10">
                <input type="text" id="form-field-1" name="Nomor" placeholder="Nomor SPM" class="col-xs-10 col-sm-5" value="'.$r[Nomor].'" required/>
                <label class="col-sm-2 control-label" for="form-field-1"> Tanggal</label>
                <input type="text" id="form-field-1" name="Tanggal" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd"  value="'.$r[Tanggal].'" required/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Anggaran </label>
              <div class="col-sm-10">
                <input type="text" id="form-field-1" placeholder="Anggaran SPM" name="Anggaran" class="col-xs-10 col-sm-5" value="'.$r[Anggaran].'"  required/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Kegiatan </label>
              <div class="col-sm-10">
                <input type="text" id="form-field-1" placeholder="Username" name="JnsKegiatan" class="col-xs-10 col-sm-5"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kepala SKPD </label>
              <div class="col-sm-10">';
              $qx = mysql_query("SELECT id,NamaTtd FROM ttdbukti WHERE Jabatan = 1 AND id_Skpd = '$_SESSION[id_Skpd]'");
              echo "<select name='KepalaSkpd' class='col-xs-10 col-sm-5' id='form-field-1' required>
                      <option value=''>[Pilih]</option>";
                    while ($rx = mysql_fetch_array($qx)){
                      if($rx[id] == $r[KepalaSkpd]) {
                        echo "<option value='$rx[id]' selected>$rx[NamaTtd]</option>";
                      } else {
                        echo "<option value=$rx[id]>$rx[NamaTtd]</option>";
                      }
                    }
              echo "</select>";
              echo '</div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Bendahara </label>
              <div class="col-sm-10">';
              $qx = mysql_query("SELECT id,NamaTtd FROM ttdbukti WHERE Jabatan = 3 AND id_Skpd = '$_SESSION[id_Skpd]'");
              echo "<select name='Bendahara' class='col-xs-10 col-sm-5' id='form-field-1' required>
                      <option value=''>[Pilih]</option>";
                      while ($rx = mysql_fetch_array($qx)){
                        if($rx[id] == $r[Bendahara]) {
                          echo "<option value='$rx[id]' selected>$rx[NamaTtd]</option>";
                        } else {
                          echo "<option value=$rx[id]>$rx[NamaTtd]</option>";
                        }
                      }
              echo "</select>";
              echo '</div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Keterangan </label>
              <div class="col-sm-10">
                <textarea id="form-field-1" placeholder="Keterangan" name="Keterangan" class="col-xs-10 col-sm-5" >'.$r[Keterangan].'</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPM </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spm" class="col-xs-4 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spm/'.$_SESSION[thn_Login].'/'.$r[fl_Spm].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPP 1 </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spp1" class="col-xs-10 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp1].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload  SPP 2 </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spp2" class="col-xs-10 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp2].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPP 3 </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spp3" class="col-xs-10 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp3].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>';
            echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
            echo "<input type='hidden' name='id_Spm' value='$r[id_Spm]'>";
            echo '<div class="clearfix form-actions">
              <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-info" type="submit">
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
            </form>

          ';
  break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session
?>
<script type="text/javascript">

function md_verkeg(id_Kegiatan)
{
  $.ajax({
        url: 'library/ax_verkeg.php',
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
