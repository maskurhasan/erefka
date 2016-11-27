<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {
//----------------------------------
include "config/koneksi.php";
//include "config/fungsi.php";
include "config/pagination.php";

  switch ($_GET[act]) {
    default:

           echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <form class="" method=get action="'.$_SERVER['PHPSELF'].'">
                          <div class="input-group pull-right" style="width: 250px;">
                            <input name="module" type="hidden" value="subkegiatan">
                            <input name="t" type="hidden" value="nm">
                            <input type="text" name="q" class="form-control input-sm pull-right" placeholder="Cari" size="10">
                            <div class="input-group-btn">
                              <button class="btn btn-sm btn-default btn-fill"><i class="fa fa-search"></i> Cari</button></form>';
                           echo '</div>
                          </div>
                    </div>
                    </div>
                </div>
                <div class="content table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered table-hover">
                          <thead>
                          <tr>
                          <th>#</th>
                          <th>Kode</th><th style=width:30%>Nama Kegiatan</th><th>Nama PPK</th><th>Target/Realisasi</th>
                          <th>Aksi</th>
                          </tr>
                          </thead>
                          <tbody>';

                          //cari nilai realisasi perkegiatan

                          function maxkeu($id_DataKegiatan){
                              $q = mysql_query("SELECT MAX(a.rls_Keu2) AS nilai
                                                  FROM realisasi a,subkegiatan b
                                                  WHERE a.id_Subkegiatan = b.id_Subkegiatan
                                                  AND b.id_DataKegiatan = '$id_DataKegiatan'");
                              $r = mysql_fetch_array($q);
                              //$bln_lalu = $id_Bulan - 1;
                              return $r['nilai'];
                          }

                          $page = 1;
                          if (isset($_GET['page']) && !empty($_GET['page']))
                              $page = (int)$_GET['page'];
                          $q = $_GET['q'];
                          $t = $_GET['t'];
                          if($_GET['t'] == 'nm') {
                            $nmkeg = "AND b.nm_Kegiatan LIKE '%$q%' ";
                          } elseif($_GET['t']=='kode') {
                            $kode = "AND a.id_Kegiatan = '$q' ";
                          }
                          if($_SESSION['UserLevel']==3) {
                            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg,d.nm_Lengkap
                                    FROM datakegiatan a,kegiatan b,subkegiatan c,user d
                                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                    AND a.id_Kegiatan = b.id_Kegiatan
                                    AND a.id_DataKegiatan = c.id_DataKegiatan
                                    AND a.id_Ppk = d.id_User
                                    AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                                    AND a.id_Ppk = '$_SESSION[id_User]'
                                    $nmkeg $kode
                                    GROUP BY a.id_DataKegiatan";
                          } else {
                            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg,d.nm_Lengkap
                                    FROM datakegiatan a,kegiatan b,subkegiatan c,user d
                                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                    AND a.id_Kegiatan = b.id_Kegiatan
                                    AND a.id_DataKegiatan = c.id_DataKegiatan
                                    AND a.id_Ppk = d.id_User
                                    AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                                    $nmkeg $kode
                                    GROUP BY a.id_DataKegiatan";
                          }
                          $dataTable = getTableData($sql,$page);
                          //$no=1;
                          foreach ($dataTable as $i => $dt)
                          {
                          $no = ($i + 1) + (($page - 1) * 10);
                          $no % 2 === 0 ? $alt="alt" : $alt="";
                            echo "<tr class=$alt><td>".$no++."</td>
                                    <td>$dt[id_DataKegiatan]</td>
                                    <td>$dt[nm_Kegiatan]</td>
                                    <td>$dt[nm_Lengkap]</td>
                                    <td>".number_format($dt['AnggKeg'])." / ".number_format(maxkeu($dt['id_DataKegiatan']))."</td>
                                    <td><a class='btn btn-sm btn-success btn-fill' href='?module=realisasi&act=add&id=$dt[id_DataKegiatan]'><i class='fa fa-plus fa-lg'></i> Input Realisasi</a></td>
                                    </tr>";
                          }
                      echo '</tbody></table>
                   <div class="">';
                  showPagination2($sql);
                echo '</div>
            </div>
            </div>
            </div>';



    break;
    case "add":
          $sql = mysql_query("SELECT c.nm_Program, b.nm_Kegiatan,a.AnggKeg,d.nm_Lengkap,SUM(e.NilaiBelanja) AS NilaiRealisasi
                              FROM kegiatan b, program c,datakegiatan a
                              LEFT JOIN user d
                              ON a.id_Ppk = d.id_User
                              LEFT JOIN realisasi2 e
                              ON a.id_Kegiatan = e.id_Kegiatan
                              WHERE a.id_DataKegiatan = '$_GET[id]'
                              AND a.id_Kegiatan = b.id_Kegiatan
                              AND b.id_Program = c.id_Program ");

          $r=mysql_fetch_array($sql);

          echo '<div class="col-md-12">
                <div class="profile-user-info profile-user-info-striped">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Program </div>
                    <div class="profile-info-value">
                      '.$r[nm_Program].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Kegiatan</div>
                    <div class="profile-info-value">
                      '.$r[nm_Kegiatan].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> PPK </div>
                    <div class="profile-info-value">
                      '.$r[nm_Lengkap].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Anggaran </div>
                    <div class="profile-info-value"> Rp.
                      '.number_format($r[AnggKeg]).'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Realisasi SIMDA </div>
                    <div class="profile-info-value"> Rp.

                    </div>
                  </div>
                </div>
                </div>';

                echo '<p>&nbsp;</p>';


          echo '<div class="col-md-4
          ">
              <div class="card">
              <div class="content">';
          echo "</div>";
         echo '<table class="table table-hover table-bordered table-condensed">
                  <thead><tr><th></th><th>Kegiatan / Subkegiatan</th></tr></thead><tbody>';

                $sql = mysql_query("SELECT b.nl_Pagu,b.nm_SubKegiatan,b.id_SubKegiatan
                                    FROM subkegiatan b, datakegiatan a
                                    WHERE a.id_DataKegiatan = b.id_DataKegiatan
                                    AND a.id_Skpd = '$_SESSION[id_Skpd]'
                                    AND a.id_DataKegiatan = '$_GET[id]'");
                $no = 1;
                while($dt = mysql_fetch_array($sql)) {
                $no % 2 === 0 ? $alt="" : $alt="";
                  echo "<tr>
                          <td><input type=checkbox name=pilih></td>
                          <td>$dt[nm_SubKegiatan]<br>     
                              <button class='btn btn-xs btn-primary btn-fill' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_realisasi(this.value)'><i class='fa fa-plus'></i> Realisasi</button>
                            <button class='btn btn-xs btn-success btn-fill' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_lampiran(this.value)'><i class='fa fa-upload'></i> upload</button>
                            <button class='btn btn-xs btn-warning btn-fill' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_permasalahan(this.value)'><i class='fa fa-plus'></i> Masalah</button>
                            </td>
                          </tr>";
                }
                echo "</tbody></table></form>";
                echo '
            </div>
            </div>';
 
 //include "../library/chartexample.html";
          echo '<div class="col-md-8" id="subkegiatan">';

          echo "</div>
          </div>";


                      //akhir isi                     

                   echo '</div>
                  </div>
                </div>';

    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">



function pilih_kecamatan(id_Kecamatan)
{
  $.ajax({
    url: '../library/desa.php',
    data : 'id_Kecamatan='+id_Kecamatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Desa').html(response);
        }
    });
}

function pilih_Urusan(id_Urusan)
{
  $.ajax({
        url: '../library/bidangurusan.php',
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

function ax_form_realisasi(id_SubKegiatan)
{
  $.ajax({
    url: 'library/ax_realisasi.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}
function ax_form_target(id_SubKegiatan)
{
  $.ajax({
    url: 'library/ax_target.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}

function ax_form_realisasi2(id_DataKegiatan)
{
  $.ajax({
    url: 'library/ax_realisasi2.php',
    data: 'id_DataKegiatan='+id_DataKegiatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}
function ax_form_lampiran(id_SubKegiatan)
{
  $.ajax({
    url: 'library/ax_lampiran.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}
function ax_form_permasalahan(id_SubKegiatan)
{
  $.ajax({
    url: 'library/ax_permasalahan.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}



  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {5: {sorter: true}}
})
$("#myTable2").tablesorter({widgets: ['zebra'],
  headers: {5: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});
</script>
