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
                <h2><span>Data Realisasi Dak</span></h2>
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
                          <td class=align-center>
                              <a href='?module=realisasidak&act=add&id=$dt[id_DataDak]'><i class='fa fa-plus'></i> Sub Dak</a></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "add":
          
          echo "<div class='grid_5'>
                <div class='module'>
                        <h2><span>Data Rincian Kegiatan</span></h2>
                        <div class=module-table-body>
                        <form action=''>
                        <table id=myTable class=tablesorter>
                        <thead><tr><th style=width:5%>#</th>
                        <th style=width:25%>Nama Kegiatan</th><th style=width:10%>DAK</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM datadak a,subdak b 
                                      WHERE a.id_DataDak = b.id_DataDak AND a.id_DataDak = '$_GET[id]'");
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[nm_SubDak]</td>
                          <td>$dt[anggDak]</td>
                          <td class=align-center>
                          <button class='' type=button id=id_SubDak value='$dt[id_SubDak]' onClick='ax_form_realisasidak(this.value)'><i class='fa fa-plus'></i> Realisasi</button>
                            <button class='' type=button id=id_SubDak value='$dt[id_SubDak]' onClick='ax_form_lampirandak(this.value)'><i class='fa fa-upload'></i> upload</button>
                            <button class='' type=button id=id_SubDak value='$dt[id_SubDak]' onClick='ax_form_permasalahandak(this.value)'><i class='fa fa-plus'></i> Masalah</button>
                          </td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>
                <div style='clear:both;'></div>
            </div>";
          echo "<div class='grid_7' id=subkegiatan>";
         
          echo "</div>"; //akhir grid 6

          
    break;
    case "upload":
          $sql = mysql_query("SELECT * FROM datakegiatan WHERE id_DataKegiatan = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Kegiatan], 0,1);
          $id_BidUrusan = substr($r[id_Kegiatan], 0,3);
          $id_Program = substr($r[id_Kegiatan], 0,5);
          echo "<div class='grid_7'>";
         
          //akhir grid 7
          echo "</div>";
    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">


function ax_form_realisasidak(id_SubDak)
{
  $.ajax({
    url: '../library/ax_realisasidak.php',
    data: 'id_SubDak='+id_SubDak,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}
function ax_form_lampirandak(id_SubDak)
{
  $.ajax({
    url: '../library/ax_lampirandak.php',
    data: 'id_SubDak='+id_SubDak,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}
function ax_form_permasalahandak(id_SubDak)
{
  $.ajax({
    url: '../library/ax_permasalahandak.php',
    data: 'id_SubDak='+id_SubDak,
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
