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
          echo "<div class=module>
                  <h2><span>Data Realisasi</span></h2>
                  <div class=module-table-body>
                  <form action=''>
                  <table id=myTable class=tablesorter>
                  <thead><tr><th style=width:5%>#</th>
                  <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>Nama PPK</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM fk_kegiatan a,fk_program b, ppk c 
                                      WHERE a.id_Program = b.id_Program AND a.id_Ppk = c.id_Ppk 
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>$no</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td>$dt[nm_Ppk]</td>
                          <td class=align-center><a href='?module=realisasifk&act=belanja&id=$dt[id_Kegiatan]'><i class='fa fa-plus fa-lg'></i> Sub Kegiatan</a></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "belanja":
          echo "<div class='grid_6'>
                <label>&nbsp</label><a href='?module=realisasifk&act=add&id=$_GET[id]' class='button'>
                    <span><i class='fa fa-plus fa-lg'></i> Tambah Belanja</span>
                  </a>
                <div class=bottom-spacing></div>
                <div class='module'>
                  <h2><span>Data Rincian Kegiatan</span></h2>
                  <div class=module-table-body>
                  <form action=''>
                  <table id=myTable class=tablesorter>
                  <thead><tr><th style=width:5%>#</th>
                  <th style=width:5%>Tanggal</th><th style=width:25%>Nama Belanja</th><th style=width:10%>Jumlah(Rp.)</th><th style=width:30%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT a.* FROM fk_realisasi a, fk_kegiatan b
                                      WHERE a.id_Kegiatan = '$_GET[id]' 
                                      AND a.id_Kegiatan = b.id_Kegiatan 
                                      AND b.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND b.TahunAnggaran = '$_SESSION[thn_Login]'");
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[tgl_Belanja]</td>
                          <td>$dt[nm_Belanja]</td>
                          <td>$dt[rls_Anggaran]</td>
                          <td class=align-center>
                            <a href='?module=realisasifk&act=edit&id=$dt[id_Realisasi]'><i class='fa fa-plus'></i> Edit</a>
                            <a href='?module=realisasifk&act=edit&id=$dt[id_Realisasi]'><i class='fa fa-trash'></i> Hapus</a>
                          <!--<button class='' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_realisasi(this.value)'><i class='fa fa-plus'></i> Realisasi</button>
                            <button class='' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_lampiran(this.value)'><i class='fa fa-plus'></i> upload</button>
                            <button class='' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_permasalahan(this.value)'><i class='fa fa-plus'></i> Masalah</button>-->
                            </td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>
                <div style='clear:both;'></div>
            </div>";
          echo "<div class='grid_6' id=>";
          echo "</div>"; //akhir grid 6

          
    break;
    case "add":
          //$r=mysql_query("SELECT * FROM id_Re")
          
          echo "<div class=grid_7>"
          echo "<form method=post action='modul/act_fk_modrealisasi.php?module=realisasifk&act=add'>
                <label>Nama Belanja : </label><input class='input-short' type=text name=nm_Belanja>
                <label>Belanja (Rp.) : </label><input class='input-short' type=text name=rls_Anggaran>
                <label>Tanggal Belanja : </label><input class='input-short' type=text name=tgl_Belanja>
                <label>Keterangan : </label><textarea rows='7' cols='90'class='input-short' name='Keterangan' id='nm_Kegiatan'></textarea>
                <fieldset>
                <input type=hidden name=id_Kegiatan value=$_GET[id] />
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
                </form>";
          //akhir grid 7
          echo "</div>";
    break;
    case "edit":
          $q=mysql_query("SELECT * FROM fk_realisasi WHERE id_Realisasi = $_GET[id]");
          $r=mysql_fetch_array($q);
          echo "<div class='grid_7'>";
          echo "<form method=post action='modul/act_fk_modrealisasi.php?module=realisasifk&act=edit'>
                <label>Nama Belanja : </label><input class='input-short' type=text name=nm_Belanja value='$r[nm_Belanja]'>
                <label>Belanja (Rp.) : </label><input class='input-short' type=text name=rls_Anggaran value='$r[rls_Anggaran]'>
                <label>Tanggal Belanja : </label><input class='input-short' type=text name=tgl_Belanja value='$r[tgl_Belanja]'>
                <label>Keterangan : </label><textarea rows='7' cols='90'class='input-short' name='Keterangan' id='nm_Kegiatan'>$r[Keterangan]</textarea>
                <fieldset>
                <input type=hidden name=id_Realisasi value=$_GET[id] />
                <input type=hidden name=id_Kegiatan value=$r[id_Kegiatan] />
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
                </form>";
          //akhir grid 7
          echo "</div>";
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
    url: '../library/ax_realisasi.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
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
    url: '../library/ax_lampiran.php',
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
    url: '../library/ax_permasalahan.php',
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
