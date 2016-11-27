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
include "../config/pagination.php";

  
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
            </div>
            </div>';


          echo '<div class="row">
            <div class="col-md-7" id="subkegiatan">';

          echo "</div>
          </div>"; 

  
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

function ax_form_statusfinal(id_SubKegiatan)
{
  $.ajax({
    url: 'modul/modstatusfinal.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}

function ax_form_realisasi2(id_DataKegiatan)
{
  $.ajax({
    url: '../library/ax_realisasi2.php',
    data: 'id_DataKegiatan='+id_DataKegiatan,
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
