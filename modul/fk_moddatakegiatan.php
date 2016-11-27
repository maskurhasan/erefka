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

  switch ($_GET[act]) {
    default:
          //----------------------------------
          echo "<div class='grid_7'>";
          echo "<label>Urusan </label><select class=input-short  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select>
                <label>Bid. Urusan : </label><select class=input-short name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select>
                <label>&nbsp</label><a href='?module=kegiatanfk&act=add' class='button'>
                    <span><i class='fa fa-plus fa-lg'></i> Tambah Kegiatan</span>
                  </a>
                <div class=bottom-spacing>
                </div>";
                echo "<div class=module>
                        <h2><span>Sample table</span></h2>
                        <div class=module-table-body>
                        <form action=''>
                        <table id=example class=tablesorter>
                        <thead><tr><th style=width:5%>#</th>
                        <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>Nama PPK</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                /*
                $sql = mysql_query("SELECT * FROM datakegiatan a,kegiatan b, ppk c 
                                      WHERE a.id_Kegiatan = b.id_Kegiatan AND a.id_Ppk = c.id_Ppk 
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                */
                $sql = mysql_query("SELECT * FROM fk_kegiatan a
                                      LEFT JOIN ppk c 
                                      ON a.id_Ppk = c.id_Ppk  
                                      LEFT JOIN program b 
                                      ON a.id_Program = b.id_Program 
                                      WHERE a.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'");
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>$no</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td>$dt[nm_Ppk]</td>
                          <td class=align-center><a href='?module=kegiatanfk&act=edit&id=$dt[id_Kegiatan]'><i class='fa fa-edit fa-lg'></i></a>";
                              echo '<a href="modul/act_fk_moddatakegiatan.php?module=kegiatanfk&act=delete&id='.$dt[id_Kegiatan].'" onclick="return confirm(\'Yakin untuk menghapus data ini?\')"><i class="fa fa-trash fa-lg"></i></a>';
                              echo "</td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "add":
          echo "<div class='grid_7'>";
          echo "<form method=post action='modul/act_fk_moddatakegiatan.php?module=kegiatanfk&act=add'>
                <label>Belanja </label><select class='input-short'  name=id_Program placeholder=pilih Program id=id_Program onchange=''>
                <option selected>Pilih Belanja</option>";
                $q=mysql_query("SELECT * FROM fk_program");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Program]>$r[id_Program] $r[nm_Program]</option>";
                }         
                echo "</select>
                <label>Nama Kegiatan : </label><textarea rows='7' cols='90'class='input-short' name='nm_Kegiatan' id='nm_Kegiatan'></textarea>
                <label>Anggaran (Rp.) : </label><input class='input-short' type=text name=Anggaran>
                <label>PPK </label><select class='input-short'  name=id_Ppk placeholder=pilih PPK id=id_Urusan onchange=''>
                <option selected>Pilih</option>";
                $q=mysql_query("SELECT * FROM ppk WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                while ($rx=mysql_fetch_array($q)) {
                  echo "<option value=$rx[id_Ppk]>$rx[nm_Ppk]</option>";
                }         
                echo "</select>
                <fieldset>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM fk_kegiatan WHERE id_Kegiatan = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          echo "<div class='grid_7'>";
         echo "<form method=post action='modul/act_fk_moddatakegiatan.php?module=kegiatanfk&act=edit'>
                <label>Belanja </label><select class='input-short'  name=id_Program placeholder=pilih Program id=id_Program onchange=''>
                <option selected>Pilih Belanja</option>";
                $qx=mysql_query("SELECT * FROM fk_program");
                while ($rx=mysql_fetch_array($qx)) {
                  if($r[id_Program]==$rx[id_Program]) {
                    echo "<option value=$rx[id_Program] selected>$r[id_Program] $rx[nm_Program]</option>";
                  } else {
                  echo "<option value=$rx[id_Program]>$rx[id_Program] $rx[nm_Program]</option>";
                  }
                }         
                echo "</select>
                <label>Nama Kegiatan : </label><textarea rows='7' cols='90'class='input-short' name='nm_Kegiatan' id='nm_Kegiatan'>$r[nm_Kegiatan]</textarea>
                <label>Anggaran (Rp.) : </label><input class='input-short' type=text name=Anggaran value=$r[Anggaran]>
                <label>PPK </label><select class='input-short'  name=id_Ppk placeholder=pilih PPK id=id_Urusan onchange=''>
                <option selected>Pilih</option>";
                $qx=mysql_query("SELECT * FROM ppk WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                while ($rx=mysql_fetch_array($qx)) {
                  if($r[id_Ppk]==$rx[id_Ppk]) {
                    echo "<option value=$rx[id_Ppk] selected>$rx[nm_Ppk]</option>";
                  } else {
                    echo "<option value=$rx[id_Ppk]>$rx[nm_Ppk]</option>";
                  }
                }         
                echo "</select>
                <fieldset>
                <input type=hidden name=id_Skpd value=$r[id_Skpd] />
                <input type=hidden name=TahunAnggaran value=$r[TahunAnggaran] />
                <input type=hidden name=id_Kegiatan value=$r[id_Kegiatan] />
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
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
