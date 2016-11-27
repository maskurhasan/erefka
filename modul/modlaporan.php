<?php
session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {  
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

switch ($_GET['act']) {
    default:

echo '<div class="col-md-7">
               <div class="card">
                <div class="header">
                  <h4 class="title">Realisasi Kegiatan</h4>
                  <p class="category">Data Realisasi Subkegiatan SKPD</p>
                </div>
              <div class="content"  id="">';

         echo "<h2>Laporan</h2>

              <table>
              <tr>
              <td>
                <form method=POST action='?module=report&act=rfk'>
                <input type=submit value='(j) Form RFK' accesskey='j'>
                </form>
              </td>

              <td>
                <form method=POST action='?module=report&act=perkeg'>
                <input type=submit value='(b) Perkembangan Kegiatan' accesskey='b'>
                </form>
              </td>

              <td>
                <form method=POST action='?module=report&act=ckbulan'>
                <input type=submit value='(t) Cek Bulanan' accesskey='t'>
                </form>
              </td>
              </tr>
              <tr>

                <td>
                <form method=POST action='?module=report&act=rfkviarealisasi2'>
                <input type=submit value='(r) Form RFK model 2' accesskey='r'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=alokasiangg'>
                <input type=submit value='(a) Alokasi Anggaran SKPD' accesskey='a'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=capaiankegbulan'>
                <input type=submit value='(a) Capaian Bulanan' accesskey='a'>
                </form>
                </td>
                </tr>
                <tr>

                <td>
                <form method=POST action='?module=report&act=cppersub'>
                <input type=submit value=' Capaian per Sub Kegiatan' accesskey='r'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=alokasiangg'>
                <input type=submit value='(a) Form RFK - Kegiatan' accesskey='a'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=capaiankegbulan'>
                <input type=submit value='(a) Capaian Bulanan' accesskey='a'>
                </form>
                </td>
                </tr>
                <tr>

                <td>
                <form method=POST action='?module=report&act=rekapskpd'>
                <input type=submit value='(r) Rekap SKPD' accesskey='r'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=alokasiangg'>
                <input type=submit value='(a) Alokasi Anggaran SKPD' accesskey='a'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=capaiankegbulan'>
                <input type=submit value='(a) Capaian Bulanan' accesskey='a'>
                </form>
                </td>
                </tr>
                <tr>

                <td>
                <form method=POST action='?module=report&act=cppersub'>
                <input type=submit value=' Capaian per Sub Kegiatan' accesskey='r'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=alokasiangg'>
                <input type=submit value='(a) Alokasi Anggaran SKPD' accesskey='a'>
                </form>
                </td>

                <td>
                <form method=POST action='?module=report&act=capaiankegbulan'>
                <input type=submit value='(a) Capaian Bulanan' accesskey='a'>
                </form>
                </td>
                </tr>
                </table>";
                
                echo "</div>
                </div>
            </div>"; 
    break;
    case "rfk":
          echo "<form method=get action='report/rfkmodel1.php' target='_blank'>
                <table>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <tr>
                <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
                </tr>
                <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";
    break;
    case "rfkviarealisasi2":
          echo "<form method=get action='report/rfkviarealisasi2.php' target='_blank'>
                <table>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <tr>
                <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
                </tr>
                <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";
    break;
    case "perkeg":
          echo "<form method=get action='report/rpt_perkeg.php' target='_blank'>
                <table>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <tr>
                <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
                </tr>
                <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";
    break;
    case "capaiankegbulan":
          echo "<form method=get action='report/rpt_perkeg_capaian.php' target='_blank'>
                <table>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <tr>
                <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
                </tr>
                <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";
    break;
    case "cppersub":
          echo "<form method=get action='report/rpt_cppersub.php' target='_blank'>
                <table>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <tr>
                <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
                </tr>
                <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";
    break;
    case "rekapskpd" : 
            echo "<form method=get action='report/rpt_rekapskpd.php' target='_blank'>
                <table>
                <tr>
                <td>Urusan </td><td><select class=input-short  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }           
          echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class=input-short name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_Skpd(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>SKPD : </td><td><select class=input-short name=id_Skpd  placeholder=pilih Skpd id=id_Skpd onchange=''>
                <option value=#>Pilih SKPD</option></select>
                </td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";

    break;
    case "ckbulan" : 
            echo "<form method=get action='report/rpt_ckbulan.php' target='_blank'>
                <table>
                <tr>
                <td>Urusan </td><td><select class=input-short  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }           
          echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class=input-short name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_Skpd(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>SKPD : </td><td><select class=input-short name=id_Skpd  placeholder=pilih Skpd id=id_Skpd onchange=''>
                <option value=#>Pilih SKPD</option></select>
                </td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";

    break;
    case "alokasiangg" : 
            echo "<form method=get action='report/rpt_alokasiangg.php' target='_blank'>
                <table>
                <tr>
                <td>Urusan </td><td><select class=input-short  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }           
          echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class=input-short name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_Skpd(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                <tr>
                <td>SKPD : </td><td><select class=input-short name=id_Skpd  placeholder=pilih Skpd id=id_Skpd onchange=''>
                <option value=#>Pilih SKPD</option></select>
                </td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>";

    break;
  }//end switch

} //end tanpa hak akses
} //end tanpa session
?>
<script type="text/javascript">

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

function vw_tbl(id_Program)
{
  $.ajax({
    url: '../library/vw_kegiatan.php',
    data: 'id_Program='+id_Program,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#vw_kegiatan').html(response);
        }
    });
}

function pilih_Skpd(id_BidUrusan)
{
  $.ajax({
        url: '../library/skpd.php',
        data : 'id_BidUrusan='+id_BidUrusan,
    type: "post", 
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Skpd').html(response);
        }
    });
}

  //kembali 
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
