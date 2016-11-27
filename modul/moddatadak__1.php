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
          echo "<label>&nbsp</label><a href='?module=datadak&act=add' class='button'>
                    <span><i class='fa fa-plus fa-lg'></i> Tambah DAK</span>
                  </a>
                <div class=bottom-spacing>
                </div>";
                echo "<div class=module>
                        <h2><span>Sample table</span></h2>
                        <div class=module-table-body>
                        <form action=''>
                        <table id=myTable class=tablesorter>
                        <thead><tr><th style=width:5%>#</th>
                        <th style=width:25%>Nama Kegiatan</th><th style=width:10%>Nama PPK</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM datadak a,bidangdak b, ppk c 
                                      WHERE a.id_BidangDak = b.id_BidangDak AND a.id_Ppk = c.id_Ppk 
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'");
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>".$no++."</td>
                          
                          <td>$dt[nm_BidangDak]</td>
                          <td>$dt[nm_Ppk]</td>
                          <td class=align-center><a href='?module=datadak&act=edit&id=$dt[id_DataDak]'><i class='fa fa-edit fa-lg'></i></a>
                              <a href='#'><i class='fa fa-trash fa-lg'></i></a>
                              <a href='?module=datadak&act=subdak&id=$dt[id_DataDak]'><i class='fa fa-plus'></i> Sub Dak</a></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "add":
          echo "<div class='grid_7'>";
          echo "<form method=post action='modul/act_moddatadak.php?module=datadak&act=add'>
                <label>Bidang DAK </label><select class='input-short'  name=id_BidangDak placeholder=pilih Bidang>
                <option selected>Pilih Bidang</option>";
                $q=mysql_query("SELECT * FROM bidangdak");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_BidangDak]>$r[id_BidangDak] $r[nm_BidangDak]</option>";
                }         
                echo "</select>
                <label>Nama Kegiatan : </label><textarea rows='7' cols='90'class='input-short' name='nm_Kegiatan' id='nm_Kegiatan'></textarea>
                <label>Penanggung Jawab </label><select class='input-short'  name=id_Ppk placeholder=pilih PPK id=id_Urusan onchange=''>
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
          $sql = mysql_query("SELECT * FROM datadak WHERE id_DataDak = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          
          echo "<div class='grid_7'>";
         echo "<form method=post action='modul/act_moddatadak.php?module=datadak&act=edit'>
                <label>Bidang DAK </label><select class='input-short'  name=id_BidangDak placeholder=pilih Bidang>
                <option selected>Pilih Bidang</option>";
                $q=mysql_query("SELECT * FROM bidangdak");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_BidangDak]==$r[id_BidangDak]) {
                    echo "<option value=$rx[id_BidangDak] selected>$rx[id_BidangDak] $rx[nm_BidangDak]</option>";
                  } else {
                    echo "<option value=$rx[id_BidangDak]>$rx[id_BidangDak] $rx[nm_BidangDak]</option>";
                  }
                }         
                echo "</select>
                <label>Nama Bidang : </label><textarea rows='7' cols='90'class='input-short' name='' id='nm_Kegiatan'>$r[nm_BidangDak]</textarea>
                <label>Penanggung Jawab </label><select class='input-short'  name=id_Ppk placeholder=pilih PPK id=id_Urusan onchange=''>
                <option selected>Pilih</option>";
                $q=mysql_query("SELECT * FROM ppk WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_Ppk]==$r[id_Ppk]) {
                    echo "<option value=$rx[id_Ppk] selected>$rx[nm_Ppk]</option>";
                  } else {
                    echo "<option value=$rx[id_Ppk]>$rx[nm_Ppk]</option>";

                  }
                }         
                echo "</select>
                <fieldset>
                <input type=hidden name=id_DataDak value=$r[id_DataDak] />
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
    case "subdak":
          $sql = mysql_query("SELECT * FROM datadak WHERE id_DataDak = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          
          echo "<div class='grid_6'>
                <button type='button' name='tambahsubdak' id='tomboltambahsubdak' onClick=''><i class='fa fa-plus'></i> Tambah</button>";
          echo "<div class='module'>
                        <h2><span>Data Rincian Kegiatan</span></h2>
                        <div class=module-table-body>
                        <form action=''>
                        <table id=myTable class=tablesorter>
                        <thead><tr><th style=width:5%>#</th>
                        <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>DAK</th><th style=width:10%>Pendamping</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM datadak a,subdak b 
                                      WHERE a.id_DataDak = b.id_DataDak AND a.id_DataDak = '$_GET[id]'");
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[id_DataDak]</td>
                          <td>$dt[nm_SubDak]</td>
                          <td>$dt[anggDak]</td>
                          <td>$dt[anggPendamping]</td>
                          <td class=align-center><button type=button id=id_SubDak value='$dt[id_SubDak]' onClick='ax_form_subdak(this.value)'><i class='fa fa-plus'></i> Edit</button></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>
                <div style='clear:both;'></div>
            </div>";
          
          echo "<div class='grid_6' id='subdak'>";
          echo "<form method=post action='modul/act_moddatadak.php?module=datadak&act=addsubdak' id='form_tambah'>
                <label>Nama Kegiatan : </label><input type=text class='input-medium' name='nm_SubDak' placeholder='Nama Kegiatan'>&nbsp;<input type='checkbox' name='d' id='group1'> Fisik
                <label>Volume : </label><input type=text class='input-short' name='Volume' placeholder='Volume'>
                <label>Satuan : </label><input type=text class='input-short' name='Paket' placeholder='Paket'>
                <label>Jumlah Penerima Manfaat : </label><input type=text class='input-medium' name='JpManfaat' placeholder='Penerima Manfaat'>
                <label>Anggaran DAK : </label><input type=text class='input-short' name='anggDak' placeholder='Anggaran DAK'>
                <label>Anggaran Pendamping : </label><input type=text class='input-short' name='anggPendamping' placeholder='Anggaran Pendamping'>
                <label>Total (DAK+Pendamping) : </label><input type=text class='input-short' name='Total' placeholder='total'>
                <label>Swakelola : </label><input type=text class='input-short' name='pl_Swakelola' placeholder='Swakelola'>
                <label>Kontrak : </label><input type=text class='input-short' name='pl_Kontrak' placeholder='Kontrak'>
                   
                <fieldset>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input type=hidden name='id_Session' value=$_SESSION[Sessid] />
                <input type=hidden name=id_DataDak value=$_GET[id] />
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
                </form>
                <div class=bottom-spacing>
                </div>";
          echo "</div>"; //akhir grid 7
    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">


function ax_form_subdak(id_SubDak)
{
  $.ajax({
    url: '../library/ax_subdak.php',
    data: 'id_SubDak='+id_SubDak,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subdak').html(response);
        }
    });
}

$("#form_tambah").hide();
$("#tomboltambahsubdak").click(function(){ 
  $("#form_tambah").show();
});



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
