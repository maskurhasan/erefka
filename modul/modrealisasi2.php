<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {  
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/pagination.php";
require "../config/excel_reader.php";

  switch ($_GET[act]) {
    default:


          echo '<div class="col-md-8">
            <div class="card">
              <div class="header">
                <h4 class="box-title">Statu Anggaran SKPD</h4>
              </div>
              <div class="content">';

          echo "<table class='table'>
                <tr>
                <td>Import SPJ  </td><td><form name='myForm' id='myForm' onSubmit='return validateForm()' action='' method='post' enctype='multipart/form-data'>
                      <input class='form-control' type='file' id='fileimport' name='fileimport' />
                      <input class='btn btn-sm btn-fill btn-primary' type='submit' name='submit' value='Import' /><br/>
                      <!--<label><input type='checkbox' name='drop' value='1' /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>-->
                      </form></td>
                </tr>
                </table>
                <div id=vw_skpd></div>";
                if (isset($_POST['submit'])) {
                          echo '<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
                              <div id="info"></div>';
                }
          //akhir grid 7
          echo "</div>";

          echo '</div>
              </div>
            </div>';      

            if(isset($_POST['submit'])){

                      $target = basename($_FILES['fileimport']['name']) ;
                      move_uploaded_file($_FILES['fileimport']['tmp_name'], $target);
                      
                      $data = new Spreadsheet_Excel_Reader($_FILES['fileimport']['name'],false);
                      
                  //    menghitung jumlah baris file xls
                      $baris = $data->rowcount($sheet_index=0);
                      
                  //    jika kosongkan data dicentang jalankan kode berikut
                      if($_POST['drop']==1){
                  //             kosongkan tabel pegawai
                               $truncate ="TRUNCATE TABLE realisasi2";
                               mysql_query($truncate);
                      };
                      
                  //    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
                      for ($i=2; $i<=$baris; $i++)
                      {
                  //        menghitung jumlah real data. Karena kita mulai pada baris ke-2, maka jumlah baris yang sebenarnya adalah 
                  //        jumlah baris data dikurangi 1. Demikian juga untuk awal dari pengulangan yaitu i juga dikurangi 1
                          $barisreal = $baris-1;
                          $k = $i-1;
                          
                  // menghitung persentase progress
                          $percent = intval($k/$barisreal * 100)."%";

                  // mengupdate progress
                          echo '<script language="javascript">
                          document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:lightblue\">&nbsp;</div>";
                          document.getElementById("info").innerHTML="'.$k.' data berhasil diinsert ('.$percent.' selesai).";
                          </script>';

                  //       membaca data (kolom ke-1 sd terakhir)
                        $no = $data->val($i,1);
                        $norek = $data->val($i,2);
                        $pecah = substr($norek,7,5);
                        $rek = str_replace('.', '', $pecah);
                        $unit = str_replace('.','',substr($norek,0,4));
                        $id_Kegiatan = $unit.$rek;
                        $nobukti = $data->val($i,3);
                        $tanggal = $data->val($i,4);
                        //konversi tanggal ke format mysql
                        $tgl = date('Y-m-d',strtotime($tanggal));
                        $tglhasil = $tgl[2]."-".$tgl[1]."-".$tgl[0];
                        $namarek = $data->val($i,5); 
                        $nilai = $data->val($i,6);
                        $belanja = str_replace(',','', substr($nilai,0,-3));
                        $id_Skpd = $_SESSION['id_Skpd'];
                        $TahunAnggaran = $_SESSION['thn_Login'];
                      //setelah data dibaca, masukkan ke tabel pegawai sql
                        //$query1 = "INSERT into pegawai (nama,tempat_lahir,tanggal_lahir)values('$nama','$tempat_lahir','$tanggal_lahir')";
                        $query = "INSERT into realisasi2 (id_Kegiatan,NomorBukti,Tanggal,UraianBelanja,NilaiBelanja,id_Skpd,TahunAnggaran,tgl_Input) values ('$id_Kegiatan','$nobukti','$tgl','$namarek','$belanja','$id_Skpd','$TahunAnggaran',now())";
                        
                        $hasil = mysql_query($query);

                        flush();
                  //      kita tambahkan sleep agar ada penundaan, sehingga progress terbaca bila file yg diimport sedikit
                  //      pada prakteknya sleep dihapus aja karena bikin lama hehe
                        //sleep(1);
                      }  
                  //    hapus file xls yang udah dibaca
                    //unlink($_FILES['filepegawaiall']['name']);
                  }

          
        echo '<div class="row">
              <div class="col-md-12">
              <div class="card">
                <div class="header">
                  <h4 class="title">Daftar Rencana Kegiatan</h4>
                  <p class="category">Rencana Kegiatan SKPD</p>
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <form class="" method=get action="'.$_SERVER['PHPSELF'].'">
                          <div class="input-group pull-right" style="width: 250px;">

                             <input name="module" type=hidden value=realisasi2>
                            <input name="t" type="hidden" value="nm">
                            <input type="text" name="q" class="form-control input-sm pull-right" placeholder="Cari" size="10">
                            <div class="input-group-btn">
                              <button class="btn btn-sm btn-default btn-fill"><i class="fa fa-search"></i> Cari</button></form>';
                            echo '</div>
                          </div>
                    </div>
                    </div>
                </div>
                <div class="content table-responsive">
                <table class="table">
                  <thead><tr><th style=width:5%>#</th>
                  <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>Anggaran</th>
                  <th style=width:10%>Realisasi</th><th style=width:10%>Persen</th></tr></thead><tbody>';
                $page = 1;
                if (isset($_GET['page']) && !empty($_GET['page']))
                    $page = (int)$_GET['page'];
                $q = $_GET['q'];
                $t = $_GET['t'];
                if($_GET['t'] == 'nm') {
                  $nmkeg = "AND b.nm_Kegiatan LIKE '%$q%' ";
                } elseif($_GET['t']=='kode') {
                  $kode = "AND a.id_Kegiatan = '$q' ";
                } 
                $sql = "SELECT a.AnggKeg,b.nm_Kegiatan,b.id_Kegiatan,SUM(c.NilaiBelanja) AS NilaiRealisasi
                        FROM kegiatan b,datakegiatan a 
                        LEFT JOIN realisasi2 c 
                        ON a.id_Kegiatan = c.id_Kegiatan
                        WHERE a.id_Skpd = '$_SESSION[id_Skpd]' 
                        AND a.id_Kegiatan = b.id_Kegiatan
                        AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                        GROUP BY a.id_Kegiatan";
                $dataTable = getTableData($sql,$page);
                //$no=1;
                foreach ($dataTable as $i => $dt)
                {
                $no = ($i + 1) + (($page - 1) * 10);
                $no % 2 === 0 ? $alt="alt" : $alt="";
                  $persentase = ($dt['NilaiRealisasi'] / $dt['AnggKeg']) * 100;
                  echo "<tr class=$alt><td>".$no++."</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td>".number_format($dt[AnggKeg])."</td>
                          <td>".number_format($dt[NilaiRealisasi])."</td>
                          <td>".round($persentase,2)."</td>
                          </tr>";
                } 
                echo "</tbody></table>";                
        
        echo '<div class="footer">';
                  showPagination2($sql);
                echo '</div>
                </div>
            </div>
            </div>';

/*
          echo "<div class='grid_7'>";
          echo "<div class=module>
                  <h2><span>Data Realisasi</span></h2>
                  <div class=module-table-body>
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
                      <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                      <option value=#>Pilih Bid.Urusan</option></select></td>
                  </tr>
                  <tr>
                      <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='vw_tbl(this.value);'>
                      <option value=#>Pilih Program</option></select></td>
                  </tr>
                  <tr>
                      <td>Import SPJ :</td><td><form name='myForm' id='myForm' onSubmit='return validateForm()' action='' method='post' enctype='multipart/form-data'>
                      <input type='file' id='fileimport' name='fileimport' />
                      <input type='submit' name='submit' value='Import' /><br/>
                      <!--<label><input type='checkbox' name='drop' value='1' /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label>-->
                      </form>";
                      if (isset($_POST['submit'])) {
                          echo '<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
                              <div id="info"></div>';
                      }
                      echo "</td>
                  </tr>
                  </table>";
                  if(isset($_POST['submit'])){

                      $target = basename($_FILES['fileimport']['name']) ;
                      move_uploaded_file($_FILES['fileimport']['tmp_name'], $target);
                      
                      $data = new Spreadsheet_Excel_Reader($_FILES['fileimport']['name'],false);
                      
                  //    menghitung jumlah baris file xls
                      $baris = $data->rowcount($sheet_index=0);
                      
                  //    jika kosongkan data dicentang jalankan kode berikut
                      if($_POST['drop']==1){
                  //             kosongkan tabel pegawai
                               $truncate ="TRUNCATE TABLE realisasi2";
                               mysql_query($truncate);
                      };
                      
                  //    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
                      for ($i=2; $i<=$baris; $i++)
                      {
                  //        menghitung jumlah real data. Karena kita mulai pada baris ke-2, maka jumlah baris yang sebenarnya adalah 
                  //        jumlah baris data dikurangi 1. Demikian juga untuk awal dari pengulangan yaitu i juga dikurangi 1
                          $barisreal = $baris-1;
                          $k = $i-1;
                          
                  // menghitung persentase progress
                          $percent = intval($k/$barisreal * 100)."%";

                  // mengupdate progress
                          echo '<script language="javascript">
                          document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:lightblue\">&nbsp;</div>";
                          document.getElementById("info").innerHTML="'.$k.' data berhasil diinsert ('.$percent.' selesai).";
                          </script>';

                  //       membaca data (kolom ke-1 sd terakhir)
                        $no = $data->val($i,1);
                        $norek = $data->val($i,2);
                        $pecah = substr($norek,7,5);
                        $rek = str_replace('.', '', $pecah);
                        $unit = str_replace('.','',substr($norek,0,4));
                        $id_Kegiatan = $unit.$rek;
                        $nobukti = $data->val($i,3);
                        $tanggal = $data->val($i,4);
                        //konversi tanggal ke format mysql
                        $tgl = date('Y-m-d',strtotime($tanggal));
                        $tglhasil = $tgl[2]."-".$tgl[1]."-".$tgl[0];
                        $namarek = $data->val($i,5); 
                        $nilai = $data->val($i,6);
                        $belanja = str_replace(',','', substr($nilai,0,-3));
                        $id_Skpd = $_SESSION['id_Skpd'];
                        $TahunAnggaran = $_SESSION['thn_Login'];
                      //setelah data dibaca, masukkan ke tabel pegawai sql
                        //$query1 = "INSERT into pegawai (nama,tempat_lahir,tanggal_lahir)values('$nama','$tempat_lahir','$tanggal_lahir')";
                        $query = "INSERT into realisasi2 (id_Kegiatan,NomorBukti,Tanggal,UraianBelanja,NilaiBelanja,id_Skpd,TahunAnggaran,tgl_Input) values ('$id_Kegiatan','$nobukti','$tgl','$namarek','$belanja','$id_Skpd','$TahunAnggaran',now())";
                        
                        $hasil = mysql_query($query);

                        flush();
                  //      kita tambahkan sleep agar ada penundaan, sehingga progress terbaca bila file yg diimport sedikit
                  //      pada prakteknya sleep dihapus aja karena bikin lama hehe
                        //sleep(1);
                      }  
                  //    hapus file xls yang udah dibaca
                    //unlink($_FILES['filepegawaiall']['name']);
                  }

                  echo "<hr />
                  <table width='700px' cellspacing=0 cellpadding=0>
                  <tr><td><form>
                  <input name='module' type=hidden value=realisasi>
                  <input type=text name='q' size='10'>
                  <select name='t'>
                    <option value='nm'>Kegiatan</option>
                    <option value='kode'>Kode</option>
                  </select>
                  <button type='submit' value=''><i class='fa fa-search'></i> C a r i</button></form></td>
                  <td></td><td align='right'><!--<button name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=datakegiatan&act=add'\"><i class='fa fa-plus'></i> Tambah Program Kegiatan</button>--></td></tr>
                  </table>
                  <table class=tabel width='700px'>
                  <thead><tr><th style=width:5%>#</th>
                  <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>Anggaran</th>
                  <th style=width:10%>Realisasi</th><th style=width:10%>Persen</th></tr></thead><tbody>";

                //mulai tabel 
                $page = 1;
                if (isset($_GET['page']) && !empty($_GET['page']))
                    $page = (int)$_GET['page'];
                $q = $_GET['q'];
                $t = $_GET['t'];
                if($_GET['t'] == 'nm') {
                  $nmkeg = "AND b.nm_Kegiatan LIKE '%$q%' ";
                } elseif($_GET['t']=='kode') {
                  $kode = "AND a.id_Kegiatan = '$q' ";
                } 
                $sql = "SELECT a.AnggKeg,b.nm_Kegiatan,b.id_Kegiatan,SUM(c.NilaiBelanja) AS NilaiRealisasi
                        FROM kegiatan b,datakegiatan a 
                        LEFT JOIN realisasi2 c 
                        ON a.id_Kegiatan = c.id_Kegiatan
                        WHERE a.id_Skpd = '$_SESSION[id_Skpd]' 
                        AND a.id_Kegiatan = b.id_Kegiatan
                        AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                        GROUP BY a.id_Kegiatan";
                $dataTable = getTableData($sql,$page);
                //$no=1;
				        foreach ($dataTable as $i => $dt)
                {
                $no = ($i + 1) + (($page - 1) * 10);
				        $no % 2 === 0 ? $alt="alt" : $alt="";
                  $persentase = ($dt['NilaiRealisasi'] / $dt['AnggKeg']) * 100;
                  echo "<tr class=$alt><td>".$no++."</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td>".number_format($dt[AnggKeg])."</td>
                          <td>".number_format($dt[NilaiRealisasi])."</td>
                          <td>".round($persentase,2)."</td>
                          </tr>";
                } 
                echo "</tbody></table>";
                showPagination($sql);
                echo "</div></div>";
          //akhir grid 7
          echo "</div>";
    */
    break;
    case "add":
          $sql = mysql_query("SELECT c.nm_Program, b.nm_Kegiatan,a.AnggKeg,d.nm_Ppk 
                              FROM kegiatan b, program c,datakegiatan a 
                              LEFT JOIN ppk d
                              ON a.id_Ppk = d.id_Ppk 
                              WHERE a.id_DataKegiatan = '$_GET[id]' 
                              AND a.id_Kegiatan = b.id_Kegiatan 
                              AND b.id_Program = c.id_Program");

          $r=mysql_fetch_array($sql);
          echo "<div class='grid_12'>";
          echo "<table id='table_form'>
                <tr>
                <td width=30%>Program</td><td>:</td><td>$r[nm_Program]</td>
                </tr>
                <tr>
                <td>Kegiatan</td><td>:</td><td>$r[nm_Kegiatan]</td>
                </tr>
                <tr>
                <td>PPK</td><td>:</td><td>$r[nm_Ppk]</td>
                </tr>
                <tr>
                <td>Anggaran</td><td>:</td><td>Rp. ".number_format($r[AnggKeg])."</td>
                </tr>
                <tr>
                <td>&nbsp;</td><td></td>
                <td><button type=button class='batal'><i class='fa fa-edit'></i> Kembali</button></td>
                </tr>
                </table><hr />
                </div>";
          echo "<div class='grid_6'>
                <div class='module'>
                  <h2><span>Data Rincian Kegiatan</span></h2>
                  <div class=module-table-body>
                  <form action=''>
                  <table class=tabel width=700px>
                  <thead><tr><th style=width:5%>#</th>
                  <th style=width:5%>Kode</th><th style=width:25%>Nama Kegiatan</th><th style=width:10%>PAGU</th><th style=width:30%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM datakegiatan a,subkegiatan b 
                                      WHERE a.id_DataKegiatan = b.id_DataKegiatan AND a.id_Skpd = '$_SESSION[id_Skpd]' AND a.id_DataKegiatan = '$_GET[id]'");
                $no=1;
				while($dt = mysql_fetch_array($sql)) {
				$no % 2 === 0 ? $alt="alt" : $alt="";
                  echo "<tr class=$alt><td>".$no++."</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_SubKegiatan]</td>
                          <td>".number_format($dt[nl_Pagu])."</td>
                          <td class=align-center>
                            <button class='' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_realisasi(this.value)'><i class='fa fa-plus'></i> Realisasi</button>
                            <button class='' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_lampiran(this.value)'><i class='fa fa-plus'></i> upload</button>
                            <button class='' type=button id=id_SubKegiatan value='$dt[id_SubKegiatan]' onClick='ax_form_permasalahan(this.value)'><i class='fa fa-plus'></i> Masalah</button></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>
                <div style='clear:both;'></div>
            </div>";
          echo "<div class='grid_6' id=subkegiatan>";
         
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
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('fileimport', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>
