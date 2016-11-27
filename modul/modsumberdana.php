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
          
          echo '<div class="col-md-12">
                      <div class="card">
                        <div class="header">
                          <h4 class="title">Daftar Sumber Dana</h4>
                          <p class="category">Akses Sumber Dana Kegiatan</p>
                          <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                            </div>
                          </div>
                        </div>
                        <div class="content table-responsive">
                          <table class="table table-striped">
                            <thead><tr><th>#</th><th>Sumber Dana</th><th>Jmlh Kegiatan</th><th>Aksi</th></tr></thead><tbody>';
                            $sql = mysql_query("SELECT * 
                                    FROM sumberdana");
                            $no=1;
                            function hitsbdana($id_SbDana,$id_Skpd) {
                                $q = mysql_query("SELECT COUNT(id_SbDana) AS jumlah 
                                                  FROM datakegiatan 
                                                  WHERE id_SbDana = '$id_SbDana' 
                                                  AND id_Skpd = '$id_Skpd'");
                                $r = mysql_fetch_array($q);
                                return $r['jumlah'];
                            }
                            while($dt = mysql_fetch_array($sql)) {
                              $Aktiv = $dt[Aktiv]==1 ? "Y" : "N";
                              $no % 2 === 0 ? $alt="alt" : $alt="";
                              echo "<tr class=$alt><td>".$no++."</td>
                                      <td>$dt[nm_SbDana]</td>
                                      <td>".hitsbdana($dt['id_SbDana'],$_SESSION['id_Skpd'])." Jenis Kegiatan</td>
                                      <td class=align-center>
                                          <a href='?module=sumberdana&act=aksesdana&id=$dt[id_SbDana]'><i class='fa fa-tasks fa-lg'></i> Kegiatan</a>
                                          </td>
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
                                </ul>
                              </div>
                              </div>
                            </div>
                          </div>';

/*

            echo "<h2><span>Sumber Dana</span></h2>
                <table width='700px' cellspacing=0 cellpadding=0>
                <tr><td><input type=text size='20'><button type='submit' value=''><i class='fa fa-search'></i> C a r i</button></td>
                <td></td><td align='right'>
                <!--<button name='tambahsubdak' id='' onClick=\"window.location.href='?module=sumbrdana&act=add'\"><i class='fa fa-plus'></i> Tambah PPK</button>--></td></tr>
                </table>
                        <table class=tabel width=700px>
                        <thead><tr><th>#</th><th>Sumber Dana</th><th>Jmlh Kegiatan</th><th>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * 
                                    FROM sumberdana");
                $no=1;
                function hitsbdana($id_SbDana,$id_Skpd) {
                    $q = mysql_query("SELECT COUNT(id_SbDana) AS jumlah 
                                      FROM datakegiatan 
                                      WHERE id_SbDana = '$id_SbDana' 
                                      AND id_Skpd = '$id_Skpd'");
                    $r = mysql_fetch_array($q);
                    return $r['jumlah'];
                }
                while($dt = mysql_fetch_array($sql)) {
                  $Aktiv = $dt[Aktiv]==1 ? "Y" : "N";
                  $no % 2 === 0 ? $alt="alt" : $alt="";
                  echo "<tr class=$alt><td>".$no++."</td>
                          <td>$dt[nm_SbDana]</td>
                          <td>".hitsbdana($dt['id_SbDana'],$_SESSION['id_Skpd'])." Jenis Kegiatan</td>
                          <td class=align-center>
                              <a href='?module=sumberdana&act=aksesdana&id=$dt[id_SbDana]'><i class='fa fa-tasks fa-lg'></i> Kegiatan</a>
                              </td>
                          </tr>";
                } 
                echo "</tbody></table></form>";
   */      
    
    break;
    case "aksesdana" :
                $sql = mysql_query("SELECT * 
                                    FROM sumberdana
                                    WHERE id_SbDana = '$_GET[id]'");
                $r1 = mysql_fetch_array($sql);


          echo '<div class="col-md-12">
                      <div class="card">
                        <div class="header">
                          <h4 class="title">Akses Sumber Dana Kegiatan : '.$r1[nm_SbDana].'</h4>
                          <p class="category">Akses Sumber Dana Kegiatan</p>
                          <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                            </div>
                          </div>
                        </div>
                        <div class="content table-responsive">';
          
          echo "<form method=post action='modul/act_modsumberdana.php?module=sumberdana&act=aksesdana'>
                <table class='table table-striped'>
                <thead><tr><th></th><th><input type=checkbox id=selecctall></th><th>Nama Kegiatan</th><th style=width:20%>Sumber Dana</th></tr></thead><tbody>";
                function ck_sbdana($id_DataKegiatan,$id_SbDana) {
                    $qrr = mysql_query("SELECT a.id_DataKegiatan 
                                        FROM datakegiatan a
                                        WHERE a.id_DataKegiatan = '$id_DataKegiatan' 
                                        AND a.id_SbDana = '$id_SbDana'");
                    $rqrr = mysql_fetch_array($qrr);
                    $hit = mysql_num_rows($qrr);
                    $checked = $hit == 1 ? "checked='checked'" : '';
                    //$ck = '<input type="checkbox" '.$type.' name="id_Modul[]" value="'.$id_Modul.'" '.$checked.'>';
                    $ck = "<input type=checkbox name='id_DataKegiatan[]' value='$id_DataKegiatan' $checked class='checkbox1'>";
                    return $ck;
                }
                $sql = mysql_query("SELECT a.id_DataKegiatan,a.AnggKeg,b.nm_Kegiatan,c.nm_SbDana
                                      FROM kegiatan b,datakegiatan a
                                      LEFT JOIN sumberdana c 
                                      ON a.id_SbDana = c.id_SbDana 
                                      WHERE a.TahunAnggaran = '$_SESSION[thn_Login]' 
                                      AND a.id_Kegiatan = b.id_Kegiatan
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                $no = 1;
                while($dt = mysql_fetch_array($sql)) {
                  $no % 2 === 0 ? $alt="alt" : $alt="";
                  echo "<tr class=$alt>
                          <td>".$no++."</td>
                          <td>".ck_sbdana($dt['id_DataKegiatan'],$_GET['id'])."</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td>$dt[nm_SbDana]</td>
                          </tr>";
                } 
                echo "</tbody></table>
                <input type=checkbox id=selecctall1> Pilih Semua Kegiatan<br />
                <input type=hidden name=id_SbDana value=$_GET[id]>
                <input class='submit-green' type='submit' name='Simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                </form>";
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
             /*
                function ck_sbdana($id_DataKegiatan,$id_SbDana) {
                    $qrr = mysql_query("SELECT a.id_DataKegiatan 
                                        FROM datakegiatan a
                                        WHERE a.id_DataKegiatan = '$id_DataKegiatan' 
                                        AND a.id_SbDana = '$id_SbDana'");
                    $rqrr = mysql_fetch_array($qrr);
                    $hit = mysql_num_rows($qrr);
                    $checked = $hit == 1 ? "checked='checked'" : '';
                    //$ck = '<input type="checkbox" '.$type.' name="id_Modul[]" value="'.$id_Modul.'" '.$checked.'>';
                    $ck = "<input type=checkbox name='id_DataKegiatan[]' value='$id_DataKegiatan' $checked class='checkbox1'>";
                    return $ck;
                }
                $sql = mysql_query("SELECT a.id_DataKegiatan,a.AnggKeg,b.nm_Kegiatan,c.nm_SbDana
                                      FROM kegiatan b,datakegiatan a
                                      LEFT JOIN sumberdana c 
                                      ON a.id_SbDana = c.id_SbDana 
                                      WHERE a.TahunAnggaran = '$_SESSION[thn_Login]' 
                                      AND a.id_Kegiatan = b.id_Kegiatan
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                $no = 1;
                while($dt = mysql_fetch_array($sql)) {
                  $no % 2 === 0 ? $alt="alt" : $alt="";
                  echo "<tr class=$alt>
                          <td>".$no++."</td>
                          <td>".ck_sbdana($dt['id_DataKegiatan'],$_GET['id'])."</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td>$dt[nm_SbDana]</td>
                          </tr>";
                } 
                echo "</tbody></table>
                <input type=checkbox id=selecctall1> Pilih Semua Kegiatan<br />
                <input type=hidden name=id_SbDana value=$_GET[id]>
                <input class='submit-green' type='submit' name='Simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                </form>
          </div>";
          */
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
