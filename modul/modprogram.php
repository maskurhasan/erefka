<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else { 
$cek=user_akses($_GET[module],$_SESSION[Sessid]);
if($cek==1 OR $_SESSION[UserLevel]=='1') { 
//----------------------------------
include "../config/koneksi.php";
include "../config/errormode.php";

  switch ($_GET[act]) {
    default:
          //----------------------------------
        echo "<h2><span>Data Program</span></h2>";
        echo "<table>
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
                <td>Bid. Urusan : </td><td><select class=input-short name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
				</tr>
				<tr>
                <td>&nbsp</td><td><button type='button' name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=program&act=add'\"><i class='fa fa-plus'></i> Tambah Program</button>
                  </td>
				</tr>
				</table>
                <div class=bottom-spacing>
                </div>
                <div id=vw_program></div>";
    break;
    case "add":
          echo "<h2><span>Tambah Program</span></h2>";
          echo "<form method=post action='act_modprogram.php?module=program&act=add'>
				<table>
				<tr>
                <td>Urusan :</td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
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
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange=''>
                <option value=#>Pilih Program</option></select></td>
				</tr>
				<tr>
                <td>Kode Program : </td><td><input class='input-short' type='text' name='kd_Program'></td>
				</tr>
				<tr>
                <td>Program : </td><td><textarea rows='7' cols='90'class='input-short' name='nm_Program'></textarea></td>
                </tr>
				<tr>
				<td></td>
				<td>
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
				<button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button></td>
                </tr>
				</table>
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM program WHERE id_Program = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Program], 0,1);
          $id_BidUrusan = substr($r[id_Program], 0,3);
          echo "<h2><span>Edit Program</span></h2>";
          echo "<form method=post action='act_modprogram.php?module=program&act=edit'>
                <table>
				<tr>
				<td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_Urusan] == $id_Urusan) {
                    echo "<option value=$rx[id_Urusan] selected>$rx[id_Urusan] $rx[nm_Urusan]</option>";
                  } else {
                    echo "<option value=$rx[id_Urusan]>$rx[id_Urusan] $rx[nm_Urusan]</option>";
                  }
                }         
                echo "</select></td>
				</tr>
				<tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Bid.Urusan</option>";
                $q=mysql_query("SELECT * FROM bidurusan WHERE id_Urusan = '$id_Urusan'");
                while ($rx=mysql_fetch_array($q)) {
                  $id_BidUrusan1 = substr($rx[id_BidUrusan],-2);
                  if($rx[id_BidUrusan] == $id_BidUrusan) {
                    echo "<option value=$rx[id_BidUrusan] selected>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                  } else {
                    echo "<option value=$rx[id_BidUrusan]>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                  }
                }
                echo "</select></td>";
                $kd_Program = substr($r[id_Program],-2,2);
                echo "</tr>
				<tr>
				<td>Kode Program : </td><td><input class='input-short' type='text' name='kd_Program' value=$kd_Program></td>
				</tr>
				<tr>
                <td>Program : </td><td><textarea rows='7' cols='90'class='input-short' name='nm_Program'>$r[nm_Program]</textarea></td>
				</tr>
				<tr>
				<td></td>
				<td>
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button></td>
				</tr>
				</table>
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
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

function vw_tbl(id_BidUrusan)
{
  $.ajax({
    url: '../library/vw_program.php',
    data: 'id_BidUrusan='+id_BidUrusan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#vw_program').html(response);
        }
    });
}



  //kembali 
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
