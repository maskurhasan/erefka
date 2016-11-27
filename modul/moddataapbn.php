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
          echo "<label>&nbsp</label><a href='?module=dataapbn&act=add' class='button'>
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
                $sql = mysql_query("SELECT * FROM dataapbn a,bidangapbn b, ppk c 
                                      WHERE a.id_BidangApbn = b.id_BidangApbn AND a.id_Ppk = c.id_Ppk 
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'");
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>".$no++."</td>
                          
                          <td>$dt[nm_BidangApbn]</td>
                          <td>$dt[nm_Ppk]</td>
                          <td class=align-center><a href='?module=dataapbn&act=edit&id=$dt[id_DataApbn]'><i class='fa fa-edit fa-lg'></i></a>
                              <a href='#'><i class='fa fa-trash fa-lg'></i></a>
                              <a href='?module=dataapbn&act=subapbn&id=$dt[id_DataApbn]'><i class='fa fa-plus'></i> Sub Dak</a></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "add":
          echo "<div class='grid_7'>";
          echo "<form method=post action='modul/act_moddataapbn.php?module=dataapbn&act=add'>
                <label>Kementerian </label><select class='input-short'  name=id_BidangApbn placeholder=pilih Kementerian>
                <option selected>Pilih Kementerian</option>";
                $q=mysql_query("SELECT * FROM bidangapbn");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_BidangApbn]>$r[id_BidangApbn] $r[nm_BidangApbn]</option>";
                }         
                echo "</select>
                <label>Keterangan : </label><textarea rows='7' cols='90'class='input-short' name='Keterangan' id=''></textarea>
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
          $sql = mysql_query("SELECT * FROM dataapbn WHERE id_DataApbn = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          
          echo "<div class='grid_7'>";
         echo "<form method=post action='modul/act_moddataapbn.php?module=dataapbn&act=edit'>
                <label>Kementerian </label><select class='input-short'  name=id_BidangApbn placeholder=pilih Kementerian>
                <option selected>Pilih Kementerian</option>";
                $qx=mysql_query("SELECT * FROM bidangapbn");
                while ($rx=mysql_fetch_array($qx)) {
                  if($rx[id_BidangApbn]==$r[id_BidangApbn]) {
                    echo "<option value=$rx[id_BidangApbn] selected>$rx[id_BidangApbn] $rx[nm_BidangApbn]</option>";
                  } else {
                    echo "<option value=$rx[id_BidangApbn]>$rx[id_BidangApbn] $rx[nm_BidangApbn]</option>";
                  }
                }         
                echo "</select>
                <label>Keterangan : </label><textarea rows='7' cols='90'class='input-short' name='Keterangan' id=''>$r[Keterangan]</textarea>
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
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=id_DataApbn value=$_GET[id] />
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
    case "subapbn":
          $sql = mysql_query("SELECT * FROM dataapbn WHERE id_DataApbn = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          
          echo "<div class='grid_6'>
                <button type='button' name='tambahsubdak' id='tomboltambahsubdak'><i class='fa fa-plus'></i> Tambah</button>
                <div class='module'>
                        <h2><span>Data Rincian Kegiatan</span></h2>
                        <div class=module-table-body>
                        <form action=''>
                        <table id=myTable class=tablesorter>
                        <thead><tr><th style=width:5%>#</th>
                        <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>DAK</th><th style=width:10%>Pendamping</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM dataapbn a,subapbn b, jnsapbn c 
                                      WHERE a.id_DataApbn = b.id_DataApbn AND c.id_JnsApbn = b.id_JnsApbn 
                                      AND a.id_DataApbn = '$_GET[id]'");
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[nm_JnsApbn]</td>
                          <td>$dt[nm_SubApbn]</td>
                          <td>$dt[anggApbn]</td>
                          <td>$dt[anggApbn]</td>
                          <td class=align-center><button type=button id=id_SubApbn value='$dt[id_SubApbn]' onClick='ax_form_subapbn(this.value)'><i class='fa fa-plus'></i> Edit</button></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>
                <div style='clear:both;'></div>
            </div>";
          
          echo "<div class='grid_6' id='subdak'>";
          echo "<form method=post action='modul/act_moddataapbn.php?module=dataapbn&act=addsubapbn' id='form_tambah'>
                <label>Nama Kegiatan : </label><input type=text class='input-medium' name='nm_SubApbn' placeholder='Nama Kegiatan'>
                <label>Jenis APBN: </label><select name='id_JnsApbn' class='input-short'><option>Jenis</option>";
                $qx = mysql_query("SELECT * FROM jnsapbn");
                while ($rx=mysql_fetch_array($qx)) {
                  echo "<option value=$rx[id_JnsApbn]>$rx[nm_JnsApbn] - $rx[KetJnsApbn]</option>";
                }
          echo "</select><label>Anggaran APBN : </label><input type=text class='input-short' name='anggApbn' placeholder='Anggaran APBN'>
                <label>Anggaran PHLN : </label><input type=text class='input-short' name='anggPhln' placeholder='Anggaran PHLN'>
                <label>Total (APBN+PHLN) : </label><input type=text class='input-short' name='Total' placeholder='total'>
                <label>Swakelola : </label><input type=text class='input-short' name='pl_Swakelola' placeholder='Swakelola'>
                <label>Kontrak : </label><input type=text class='input-short' name='pl_Kontrak' placeholder='Kontrak'>
                   
                <fieldset>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input type=hidden name='id_Session' value=$_SESSION[Sessid] />
                <input type=hidden name=id_DataApbn value=$_GET[id] />
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


function ax_form_subapbn(id_SubApbn)
{
  $.ajax({
    url: '../library/ax_subapbn.php',
    data: 'id_SubApbn='+id_SubApbn,
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
