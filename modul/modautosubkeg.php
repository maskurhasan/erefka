<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else { 
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION[UserLevel]=='1') {  
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

   echo '<div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="header">
                  <h4 class="title">Setting Aplikasi</h4>
                  <p class="category"></p>
                </div>
              <div class="content">';
          echo '<button class="btn btn-info btn-fill" type="submit" onClick=\'location.href="?module=statusfinal"\'><i class="pe-7s-user"></i> STATUS FINAL</button>
            <button class="btn btn-info btn-fill" type="submit" onClick=\'location.href="?module=posting"\'><i class="pe-7s-user"></i> POSTING</button>
            <button class="btn btn-info btn-fill" type="submit" onClick=\'location.href="?module=autosubkeg"\'><i class="fa fa-user"></i> AUTOPOST SUBKEGIATAN</button>';
          
          echo '</div>
              <div class="footer">
              </div>
            </div>
            </div>';

  switch ($_GET[act]) {
    default:
          
          echo '
              <div class="col-md-8">
              <div class="card">
                <div class="header">
                  <h3 class="title">Pilih SKPD</h3>
                </div>
              <div class="content">';

          echo "<table class=''>
                <tr>
                <td>Urusan </td><td><select class='form-control'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
                </tr>
                <tr>
                <td>Bid. Urusan : </td><td><select class='form-control'  name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
                </tr>
                </table>
                <div id=vw_skpd></div>";
          //akhir grid 7
          echo "</div>
          </div>
          </div></div>";
    break;
    case "add":
          echo '<div class="col-md-8">
                <div class="card">
                <div class="header">
                  <h4 class="title">Subkegiatan Auto</h4>
                  <p class="category">Autosubkegiatan</p>
              </div>
              <div class="content">';
          echo "<form method=post action='modul/act_modautosubkeg.php?module=autosubkeg&act=add'>
                  <table class='table'>
                  <thead><tr><th></th><th><input type=checkbox id=selecctall></th><th>Nama Kegiatan</th><th style=width:10%>Anggaran</th><th style=width:20%>Aksi</th></tr></thead><tbody>";
                function ck_subkeg($id_DataKegiatan) {
                    $qrr = mysql_query("SELECT id_DataKegiatan FROM subkegiatan WHERE id_DataKegiatan = '$id_DataKegiatan'");
                    $rqrr = mysql_fetch_array($qrr);
                    $hit = mysql_num_rows($qrr);
                    $checked = $hit >= 1 ? "checked='checked'" : '';
                    //$ck = '<input type="checkbox" '.$type.' name="id_Modul[]" value="'.$id_Modul.'" '.$checked.'>';
                    $ck = "<input type='checkbox' name='id_DataKegiatan[]' value='$id_DataKegiatan' $checked class='checkbox1'>";
                    return $ck;
                }
                $sql = mysql_query("SELECT a.*,b.nm_Kegiatan  
                                      FROM datakegiatan a, kegiatan b
                                      WHERE TahunAnggaran = '$_SESSION[thn_Login]' 
                                      AND a.id_Kegiatan = b.id_Kegiatan
                                      AND a.id_Skpd = '$_GET[id]'");
                $no = 1;
                while($dt = mysql_fetch_array($sql)) {
                $no % 2 === 0 ? $alt="alt" : $alt="";
      
                  echo "<input type='hidden' name='id_Desa[]' value='0'>
                        <input type='hidden' name='AlamatLokasi[]' value=''>
                        <input type='hidden' name='nm_SubKegiatan[]' value='$dt[nm_Kegiatan]'>
                        <input type='hidden' name='nl_Pagu[]' value='$dt[AnggKeg]'>
                        <input type='hidden' name='nl_Fisik[]' value='0'>
                        <input type='hidden' name='nl_Kontrak[]' value='0'>
                        <input type='hidden' name='jml_Volume[]' value=''>
                        <input type='hidden' name='id_SbDana[]' value=''>
                        <input type='hidden' name='JnsSubKeg[]' value=''>
                        <input type='hidden' name='Pelaksana[]' value='Swakelola'>
                        <input type='hidden' name='konsPerencana[]' value='-'>
                        <input type='hidden' name='konsPengawas[]' value='-'>
                        <input type='hidden' name='tgl_Mulai[]' value='$_SESSION[thn_Login]-01-01'>
                        <input type='hidden' name='tgl_Selesai[]' value='$_SESSION[thn_Login]-12-31'>
                        <input type='hidden' name='trg_Fisik[]' value='100%'>
                        <input type='hidden' name='trg_Keu1[]' value='$dt[tr_Satu]'>
                        <input type='hidden' name='trg_Keu2[]' value='$dt[tr_Dua]'>
                        <input type='hidden' name='trg_Keu3[]' value='$dt[tr_Tiga]'>
                        <input type='hidden' name='trg_Keu4[]' value='$dt[tr_Empat]'>";
                  echo "<tr>
                          <td>".$no++."</td>
                          <td><!--<input type=checkbox name='id_DataKegiatan[]' value='$dt[id_DataKegiatan]' class='checkbox1'>-->".ck_subkeg($dt['id_DataKegiatan'])."</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td align=right>".number_format($dt['AnggKeg'])."</td>
                          <td class=align-center>&nbsp;</td>
                          </tr>";
                } 
                echo "</tbody></table>
                
                <div class='footer'>
                  <input type=checkbox id=selecctall1> Pilih Semua Kegiatan<br />
                  <input type=hidden name=id_User value=$_GET[id]>
                  <input class='btn btn-sm btn-fill btn-info pull-right' type='submit' name='Simpan' value=Simpan /> 
                  <input class='btn btn-sm btn-fill btn-info' type='reset' value=Reset />
                  <button class='btn btn-sm btn-fill btn-info' type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                </div>
                </form>
          </div>
          </div>
          </div>
          </div>";


    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Program], 0,1);
          $id_BidUrusan = substr($r[id_Program], 0,3);
          echo "<div class='grid_7'>";
          /*
          echo "<form method=post action='act_modstatusfinal.php?module=skpd&act=edit'>
                <label>Nama SKPD : </label><input class='input-medium' type='text' name='nm_Skpd' value='$r[nm_Skpd]'>
                <label>Data Anggaran : </label><select class='input-short' name=DataAnggaran  placeholder='pilih Status' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Status</option>
                <option value='final'>Final</option>
                <option value='draft'>Draft</option></select>
                <label>Sub Kegiatan : </label><select class='input-short' name=DataAnggaran  placeholder='pilih Status' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Status</option>
                <option value='final'>Final</option>
                <option value='draft'>Draft</option></select>
                <label>Realisasi : </label><select class='input-short' name=DataAnggaran  placeholder='pilih Status' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Status</option>
                <option value='final'>Final</option>
                <option value='draft'>Draft</option></select>
                <fieldset>
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
                </form>";
          */
          //akhir grid 7
          echo "</div>";
    break;
    case "notif" :
          echo "nilai anggaran Lebih atau kurang dari PAGU";
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
    url: '../library/vw_autosubkeg.php',
    data: 'id_BidUrusan='+id_BidUrusan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#vw_skpd').html(response);
    }
    });
}

function ax_statusfinal(id_Status)
{
  $.ajax({
    url: '../library/ax_statusfinal.php',
    data: 'id_Status='+id_Status,
    type: "post", 
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#ax_statusfinal').html(response);
    }
    });
}



  //kembali 
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
