<?php
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

//mengambil data desa
$postur = $_POST['id_SubKegiatan'];
$q = mysql_query('SELECT *,(trg_Keu1+trg_Keu2+trg_Keu3+trg_Keu4) AS target
                  FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
$r = mysql_fetch_array($q);


                  echo '<div class="widget-box">
                          <div class="widget-header">
                            <h5 class="widget-title">Realisasi Anggaran</h5>

                            <div class="widget-toolbar">
                              <div class="widget-menu">
                                <a href="#" data-action="settings" data-toggle="dropdown">
                                  <i class="ace-icon fa fa-bars"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right dropdown-light-blue dropdown-caret dropdown-closer">
                                  <li>
                                    <a data-toggle="tab" href="#dropdown1">Option#1</a>
                                  </li>

                                  <li>
                                    <a data-toggle="tab" href="#dropdown2">Option#2</a>
                                  </li>
                                </ul>
                              </div>

                              <a href="#" data-action="fullscreen" class="orange2">
                                <i class="ace-icon fa fa-expand"></i>
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

                          <div class="widget-body">
                            <div class="widget-main">';
                            //isi mulai

                           echo "<div class='table-responsive'>
                              <form method=post action='modul/act_modrealisasi.php?module=realisasi&act=add'>";
                              $qc = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$postur'");
                              $rc = mysql_fetch_array($qc);                              

                              echo "<table class='table table-bordered table-condensed  table-highlight'>
                                <tr align=center>
                                  <th>Realisasi</th>";
                                  for ($i=1; $i <= 12 ; $i++) {
                                    echo "<th>".$arrbln[$i]."</th>";
                                  }
                                echo "</tr>
                                <tr>
                                  <td>Fisik</td>";
                                  for ($i=1; $i <= 12 ; $i++) { 
                                    echo "<td>".'<input type="text" class="" name="b'.$i.'" placeholder="Realisasi Fisik '.$i.'" value="'.$rc['b'.$i].'">'."</td>";
                                  }
                                echo "</tr>
                                <tr>
                                  <td>Keuangan</td>";
                                  for ($i=1; $i <= 12 ; $i++) { 
                                    echo "<td>".'<input type="number" class="form-control" name="t'.$i.'" placeholder="Realisasi Keuangan" value="'.$rc['t'.$i].'">
                                                <input type="hidden" name="bulan[]" value="'.$i.'">
                                                <input type=hidden name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                                                <input type=hidden name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                                                <input type=hidden name="id_Realisasi[]" value="'.$r['id_Realisasi'].'">'."
                                          </td>";
                                  }
                                echo "</tr>
                              </table>";
                              $qz = mysql_query("SELECT id_SubKegiatan FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
                              $hit = mysql_num_rows($qz);
                              if($hit == 0) {}
                              $hit == 0 ? $tmb_simpan = "simpanx" : $tmb_simpan = "editx";
                              echo '<div class="well">
                                      <input class="btn btn-primary btn-fill pull-right" type="submit" name="'.$tmb_simpan.'" value=Simpan />
                                      <input class="btn btn-info" type="reset" value=Reset />
                                      <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                                    </div>';
                            echo "</form>
                            </div>";

/*

        echo '<div class="card">
                
              <div class="content">';
              echo '<div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <p class="text-primary">BULAN</p>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <p class="text-primary">FISIK</p>
                    </div>
                    
                    <div class="col-sm-2">
                      <p class="text-primary">KEUANGAN</p>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div><hr>';
              echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=add'>";

              $qc = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$postur'");
              $rc = mysql_fetch_array($qc);
                for ($i=1; $i <=12 ; $i++) {
                  echo '<div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        '.$arrbln[$i].'
                      </div>
                    </div>
                    
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="text" class="form-control" name="b'.$i.'" placeholder="Realisasi Fisik '.$i.'" value="'.$rc['b'.$i].'">
                      </div>
                    </div>
                    
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="number" class="form-control" name="t'.$i.'" placeholder="Realisasi Keuangan" value="'.$rc['t'.$i].'">
                        <input type="hidden" name="bulan[]" value="'.$i.'">
                        <input type=hidden name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                        <input type=hidden name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                        <input type=hidden name="id_Realisasi[]" value="'.$r['id_Realisasi'].'">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <!--<input class="btn btn-primary btn-fill pull-right" type="submit" name="simpanx" value=Simpan />-->
                      </div>
                    </div>
                  </div>';
                }
                $qz = mysql_query("SELECT id_SubKegiatan FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
                $hit = mysql_num_rows($qz);
                if($hit == 0) {}
                $hit == 0 ? $tmb_simpan = "simpanx" : $tmb_simpan = "editx";
                echo '<hr>
                <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="'.$tmb_simpan.'" value=Simpan />
                  <input class="btn btn-info" type="reset" value=Reset />
                  <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                </div>
              </form>
              </div>
              </div>';
*/

                            //isi akhir
                            echo '</div>
                          </div>
                        </div>';



/*
 echo '<div class="card">
                <div class="header">
                  <h4 class="title">Realisasi Kegiatan</h4>
                </div>
              <div class="content">';
              echo '<div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <p class="text-primary">BULAN</p>
                      </div>
                    </div>
                    <!--
                    <div class="col-sm-2">
                      <p class="text-primary">TARGET FISIK</p>
                    </div>
                    -->
                    <div class="col-sm-2">
                      <p class="text-primary">FISIK</p>
                    </div>
                    <!--
                    <div class="col-sm-2">
                     <p class="text-primary">KEUANGAN</p>
                    </div>
                    -->
                    <div class="col-sm-2">
                      <p class="text-primary">KEUANGAN</p>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div><hr>';
              echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=add'>";
              $qc = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$postur'");
              $rc = mysql_fetch_array($qc);

                for ($i=1; $i <=12 ; $i++) {
                  echo '<div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        '.$arrbln[$i].'
                      </div>
                    </div>
                    <!--
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="text" class="form-control" name="trg_Fisik[]" placeholder="Target Fisik '.$i.'">
                      </div>
                    </div>
                    -->
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="text" class="form-control" name="b'.$i.'" placeholder="Realisasi Fisik '.$i.'" value="'.$rc['b'.$i].'">
                      </div>
                    </div>
                    <!--
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="number" class="form-control" name="trg_Keu[]" placeholder="Target Keuangan" value="'.$rc['trg_Keu'].'">
                      </div>
                    </div>
                    -->
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="number" class="form-control" name="t'.$i.'" placeholder="Realisasi Keuangan" value="'.$rc['t'.$i].'">
                        <input type="hidden" name="bulan[]" value="'.$i.'">
                        <input type=hidden name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                        <input type=hidden name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                        <input type=hidden name="id_Realisasi[]" value="'.$r['id_Realisasi'].'">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <!--<input class="btn btn-primary btn-fill pull-right" type="submit" name="simpanx" value=Simpan />-->
                      </div>
                    </div>
                  </div>';
                }
                $qz = mysql_query("SELECT id_SubKegiatan FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
                $hit = mysql_num_rows($qz);
                if($hit == 0) {}
                $hit == 0 ? $tmb_simpan = "simpanx" : $tmb_simpan = "editx";
                echo '<hr>
                <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="'.$tmb_simpan.'" value=Simpan />
                  <input class="btn btn-info" type="reset" value=Reset />
                  <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                </div>
              </form>
              </div>
              </div>';

*/

?>
