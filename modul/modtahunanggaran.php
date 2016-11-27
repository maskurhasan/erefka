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
                echo "<div class=module>
                        <h2><span>Tahun Anggaran</span></h2>
                        <div class=module-table-body>
                        <form action=''>
                        <table class=tabel width=300px>
                        <thead><tr><th>Tahun Anggaran</th>
                        <th>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM tahunanggaran");
				$no=1;
                while($dt = mysql_fetch_array($sql)) {
					$no % 2 === 0 ? $alt="alt" : $alt="";
					$no++;
                  echo "<tr class=$alt><td>$dt[nm_Tahun]</td>
                          <td class=align-center><a href='#'><i class='fa fa-edit fa-lg'></i> Edit</a>
                              <a href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>
                          </tr>";
                } 
                echo "</tbody></table>";
    break;
    case "add":
          echo "<div class='grid_7'>";
          echo "<form method=post action='modul/act_modmodul.php?module=modul&act=add'>
                <label>Nama Modul : </label><input class='input-short' type='text' name='nm_Modul'>
                <label>Link Modul : </label><input class='input-short' type='text' name='LinkModul'>
                <label>Level : </label><select class='input-short' name=UserLevel  placeholder='pilih Level' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Level</option>
                <option value=1>1 Administrator</option>
                <option value=2>2 Operator</option></select>
                <fieldset>
                <legend>Aktiv : </legend>
                <label><input type=radio name=AktivModul value=Y checked=checked /> Y</label>
                <label><input type=radio name=AktivModul value=N /> N</label>
                
                </fieldset>
                <fieldset>
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
          $sql = mysql_query("SELECT * FROM modul WHERE id_Modul = '$_GET[id]'");
          $r = mysql_fetch_array($sql);

          echo "<div class='grid_7'>";
          echo "<form method=post action='modul/act_modmodul.php?module=modul&act=edit'>
                <label>Nama Modul : </label><input class='input-short' type='text' name='nm_Modul' value=$r[nm_Modul]>
                <label>Link Modul : </label><input class='input-short' type='text' name='LinkModul' value=$r[LinkModul]>
                <label>Level : </label><select class='input-short' name=UserLevel  placeholder='pilih Level' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Level</option>";
                $r[UserLevel] == 1 ? $selected1="selected" : $selected2="selected";
                echo "<option value=1 $selected1>1 Administrator</option>
                <option value=2 $selected2>2 Operator</option></select>
                <fieldset>
                <legend>Aktiv : </legend>";
                $r[AktivModul] == "Y" ? $checked1="checked" : $checked2="checked";
                echo "<label><input type=radio name=AktivModul value=Y $checked1 /> Y</label>
                <label><input type=radio name=AktivModul value=N $checked2 /> N</label>
                </fieldset>
                <fieldset>
                <input type='hidden' name='id_Modul' value=$r[id_Modul] />
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
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});   
</script>
