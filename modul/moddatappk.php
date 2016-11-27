<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";

include "modmaster.php";

  switch ($_GET[act]) {
    default:

    echo '<div class="col-md-8">
              <div class="card">
                <div class="header">
                  <h4 class="title">Daftar PPK</h4>
                  <p class="category">Data Pejabat Pembuat Komitmen SKPD</p>
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                    <div class="input-group-btn">
                      <button class="btn btn-sm btn-default"><i class="fa fa-search"></i> Cari</button>';
                      //echo "<button class='btn btn-sm btn-primary btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=datappk&act=add'\"><i class='fa fa-plus'></i> Tambah PPK</button>";
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                  <table class="table table-hover">
                    <thead>
                    <tr>
                      <th>#</th><th>Nama Lengkap</th><th>NIP</th><th>Jabatan</th><th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>';
                  $sql = mysql_query("SELECT * FROM user a, pangkat b WHERE a.id_Pangkat = b.id_Pangkat
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND a.UserLevel != 1 
                                      AND a.statusppk = 1");
                  $no=1;
                  while($dt = mysql_fetch_array($sql)) {
                    $Aktiv = $dt[Aktiv]==1 ? "Y" : "N";
                    $no % 2 === 0 ? $alt="alt" : $alt="";
                    echo "<tr class=$alt><td>".$no++."</td>
                            <td>$dt[nm_Lengkap]</td>
                            <td>$dt[nip_Ppk]</td>
                            <td>PPK Kegiatan</td>
                            <td class=align-center><!--<a href='?module=datappk&act=edit&id=$dt[id_Ppk]'><i class='fa fa-edit fa-lg'></i> Edit</a>-->
                                <a href='?module=datappk&act=akseskegiatan&id=$dt[id_User]'><i class='fa fa-tasks fa-lg'></i> Kegiatan</a>
                                <!--<a href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a>--></td>
                            </tr>";
                  }
                  echo '<tbody></table>
                
                <div class="footer">
                  
                </div>
                </div>
              </div>
            </div>';
  
    break;
    case "add":
      echo '<div class="col-md-8">
            <div class="card">
              <div class="header">
                <h4 class="title">Data PPK</h4>
                  <p class="category">Tambah Pejabat Pembuat Komitmen SKPD</p>
              </div>
              <div class="content table-responsive">
                  <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Lengkap</th>
                      <th>NIP</th><th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>';

                    $sql = mysql_query("SELECT * FROM user a, skpd b 
                                          WHERE a.id_Skpd = b.id_Skpd 
                                          AND a.UserLevel = 3");
                    $no=1;
            while($dt = mysql_fetch_array($sql)) {
                      $Aktiv = $dt[Aktiv]==1 ? "Y" : "N";
                      $no % 2 === 0 ? $alt="alt" : $alt="";
                      if($dt['UserLevel']==1) {
                        $Level = "Super Admin";
                      } elseif($dt['UserLevel']==2) {
                        $Level = "Admin SKPD";
                      } else {
                        $Level = "Operator";
                      }
                      echo "<tr>
                              <td>".$no++."</td>
                              <td>$dt[nm_Lengkap]</td>
                              <td>$dt[nip_Ppk]</td>
                              <td class=align-center><button type='submit' class='btn btn-sm btn-primary btn-fill'>Tambahkan</button></td>
                            </tr>";
                    }
                  echo '<tbody></table>
                
                <div class="footer">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul></div>';
              
              echo '</div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- row-->';

    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM ppk WHERE id_Ppk = '$_GET[id]'");
          $r = mysql_fetch_array($sql);

 echo '<div class="col-md-8">
            <div class="card">
              <div class="header">
                <h4 class="title">Data PPK</h4>
                  <p class="category">Edit Pejabat Pembuat Komitmen SKPD</p>
              </div>
              <div class="content">';
              echo "<form class='form-horizontal' method=post action='modul/act_moddatappk.php?module=datappk&act=edit'>";
                      echo '<div class="box-body">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Nama Lengkap</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="nm_Ppk" value="'.$r['nm_Ppk'].'">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">NIP</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="nip_Ppk" value="'.$r['nip_Ppk'].'">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Pangkat</label>
                          <div class="col-sm-10">
                            <select class="form-control" name=id_Pangkat  placeholder="Pangkat" id=id_Pangkat onchange="">';
                              $q=mysql_query("SELECT * FROM pangkat");
                              while ($rx=mysql_fetch_array($q)) {
                                if($rx[id_Pangkat] == $r[id_Pangkat]) {
                                  echo "<option value='$rx[id_Pangkat]' selected>$rx[nm_Pangkat]</option>";
                                } else {
                                  echo "<option value='$rx[id_Pangkat]'>$rx[nm_Pangkat]</option>";
                                }
                              }
                            echo '</select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Jabatan</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="Jabatan" value="'.$r['Jabatan'].'">
                          </div>
                        </div>
                      </div>
                  <hr>
                <div class="footer">
                    <input type="hidden" name=id_Skpd value="'.$_SESSION['id_Skpd'].'" />
                    <input type="hidden" name="id_Ppk" value="'.$r[id_Ppk].'">
                    <input class="btn btn-primary btn-fill pull-right" type="submit" name="simpan" value=Simpan />
                    <input class="btn btn-info" type="reset" value=Reset />
                    <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                  <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
              </div>
              </form>
              </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- row-->';


    break;
    case "akseskegiatan" :
                $sql = mysql_query("SELECT *
                                    FROM user a
                                    LEFT JOIN pangkat b
                                    ON a.id_Pangkat = b.id_Pangkat
                                    WHERE id_User = '$_GET[id]'");
                $r1 = mysql_fetch_array($sql);

          echo '<div class="col-md-12">
              <div class="card">
              <div class="content  table-responsive">';
          echo "<table class=''>
                <tr>
                  <td width=30%>Nama</td><td>: </td><td><strong>$r1[nm_Lengkap]</strong></td>
                </tr>
                <tr>
                  <td>NIP/Pangkat</td><td>:</td><td>$r1[nip_Ppk] / $r1[nm_Pangkat]</td>
                </tr>
                <tr>
                  <td>Jabatan</td><td>:</td><td>PPK Kegiatan</td>
                </tr>
                <tr>
                  <td>&nbsp;</td><td></td>
                  <td><button class='btn btn-fill btn-sm btn-info' type='reset' onClick=\"window.location.href='?module=datappk'\"><i class='fa fa-arrow-left'></i> Kembali</button>
                    </td>
                </tr>
                </table>
                </div>
                </div>
                </div>";



      echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <h4 class="title">Akses Kegiatan PPK</h4>
                  <p class="category">Hak Kegiatan PPK</p>
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 350px;">
                      <input type="text" name="table_search" class="form-control" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                <form method=post action="modul/act_moddatappk.php?module=datappk&act=akseskegiatan">
                  <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                      <th></th><th><input type=checkbox id=selecctall></th><th>Nama Kegiatan</th><th style=width:20%>Nama PPK</th>
                    </tr>
                    </thead>
                    <tbody>';
                                function ck_ppk($id_DataKegiatan,$id_Ppk) {
                                  $qrr = mysql_query("SELECT a.id_DataKegiatan
                                                      FROM datakegiatan a
                                                      WHERE a.id_DataKegiatan = '$id_DataKegiatan'
                                                      AND a.id_Ppk = '$id_Ppk'");
                                  $rqrr = mysql_fetch_array($qrr);
                                  $hit = mysql_num_rows($qrr);
                                  $checked = $hit == 1 ? "checked='checked'" : '';
                                  //$ck = '<input type="checkbox" '.$type.' name="id_Modul[]" value="'.$id_Modul.'" '.$checked.'>';
                                  $ck = "<input type=checkbox name='id_DataKegiatan[]' value='$id_DataKegiatan' $checked class='checkbox1'>";
                                  return $ck;
                              }
                              $sql = mysql_query("SELECT a.id_DataKegiatan,a.AnggKeg,b.nm_Kegiatan,c.nm_Lengkap
                                                    FROM kegiatan b,datakegiatan a
                                                    LEFT JOIN user c
                                                    ON a.id_Ppk = c.id_User
                                                    WHERE a.TahunAnggaran = '$_SESSION[thn_Login]'
                                                    AND a.id_Kegiatan = b.id_Kegiatan
                                                    AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                              $no = 1;
                              while($dt = mysql_fetch_array($sql)) {
                                $no % 2 === 0 ? $alt="alt" : $alt="";
                                echo "<tr class=$alt>
                                        <td>".$no++."</td>
                                        <td>".ck_ppk($dt['id_DataKegiatan'],$_GET['id'])."</td>
                                        <td>$dt[nm_Kegiatan]</td>
                                        <td>$dt[nm_Lengkap]</td>
                                        </tr>";
                              }
                  echo '<tbody></table>
                
                <div class="footer">';
                 echo "<input type=checkbox id=selecctall1> Pilih Semua Kegiatan<br />
                          <input type=hidden name=id_Ppk value=$_GET[id]>
                          <input class='submit-green' type='submit' name='Simpan' value=Simpan />
                          <input class='submit-gray' type='reset' value=Reset />
                          <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                          </form>";
                echo '</div>
                </div>
              </div>
            </div>';

    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });
    $('#selecctall1').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

});

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

function vw_tbl(id_BidUrusan)
{
  $.ajax({
    url: '../library/vw_skpd.php',
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
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});
</script>
