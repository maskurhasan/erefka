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
          //----------------------------------

/*
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
                </table>";
*/

                $qc = mysql_query("SELECT a.apbd,a.apbn,a.dak,SUM(b.AnggKeg) AS Anggaran 
                    FROM skpd a, datakegiatan b 
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]' 
                    AND b.TahunAnggaran = '$_SESSION[thn_Login]' 
                    AND a.id_Skpd = b.id_Skpd");
                $rc = mysql_fetch_array($qc);

                $qd = mysql_query("SELECT SUM(c.nl_Pagu) AS AnggaranSub 
                    FROM skpd a,datakegiatan b,subkegiatan c  
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]' 
                    AND b.TahunAnggaran = '$_SESSION[thn_Login]' 
                    AND a.id_Skpd = b.id_Skpd 
                    AND b.id_DataKegiatan = c.id_DataKegiatan");
                $rd = mysql_fetch_array($qd);

 echo '<div class="row">
        <div class="col-md-8">
            <div class="card">
              <div class="header">
                <h4 class="title">Posting Program/Kegiatan SKPD</h4>
              </div>
              <div class="content">';

          echo "<table class='table'>
                <tr><th>Jenis</th><th>Anggaran</th><th>Data Kegiatan</th><th>Sub Kegiatan</th><th>Realisasi</th><th>Selisih</th><th>Aksi</th></tr>
                <tr><td>APBD</td><td>".number_format($rc[apbd])."</td><td>".number_format($rc[Anggaran])."</td><td>".number_format($rd[AnggaranSub])."</td><td>xxx</td><td>Selisih</td><td><button>Posting</button></td></tr>
                <tr class=alt><td>DAK</td><td>".number_format($rc[dak])."</td><td>xxx</td><td>xxx</td><td>xxx</td><td>Selisih</td><td><button>Posting</button></td></tr>
                <tr><td>APBN</td><td>".number_format($rc[apbn])."</td>
                <td>xxx</td><td>xxx</td><td>xxx</td><td>Selisih</td><td><button>Posting</button></td></tr>
                </table>";
          //akhir grid 7
          echo "</div>
                </div>
                </div>
                </div>";
    break;
    case "add":
          echo "<h2><span>Status Anggaran</span></h2>
                  <table class=tabel>
                  <thead><tr><th style=width:20%>SKPD</th><th style=width:10%>TA</th><th style=width:20%>Keg | Sub | Real</th><th style=width:20%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM statusfinal a,skpd b 
                                      WHERE a.id_Skpd = b.id_Skpd AND a.id_Skpd = '$_GET[id]'");
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>$dt[nm_Skpd]</td>
                          <td>$dt[thn_Anggaran]</td>
                          <td>$dt[StatusDataKegiatan] | $dt[StatusSubKegiatan] | $dt[StatusRealisasi]</td>
                          <td class=align-center><button class='' type=button id=id_Status value='$dt[id_Status]' onClick='ax_statusfinal(this.value)'><i class='fa fa-pencil'></i> Edit</button>
                            <button class='' type=button id='id_Status' value='$dt[id_SubKegiatan]' onClick='');\"'><i class='fa fa-trash'></i> Hapus</button>
                          </td>
                          </tr>";
                } 
                echo "</tbody></table>";
          $q=mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd='$_GET[id]'");
          $r=mysql_fetch_assoc($q);
          echo "<div class='grid_7' id='ax_statusfinal'>";
          echo "<form method=post action='modul/act_modstatusfinal.php?module=statusfinal&act=add'>
                <table>
                <tr>
                <td>Nama SKPD : </td><td><input class='input-medium' type='text' name='nm_Skpd' value='$r[nm_Skpd]'></td>
                </tr>
                <tr>
                <td>Tahun Anggaran : </td><td><select class='input-short' name=thn_Anggaran  placeholder='pilih Tahun' onchange=''>
                <option value=#>Pilih Tahun</option>
                <option value='2014'>2014</option>
                <option value='2015'>2015</option>
                <option value='2016'>2016</option>
                </select></td>
                </tr>
                <tr>
                <td>Status Data Kegiatan : </td><td><select class='input-short' name=StatusDataKegiatan  placeholder='pilih Status' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Status</option>
                <option value='final'>Final</option>
                <option value='draft'>Draft</option></select></td>
                </tr>
                <tr>
                <td>Status Sub Kegiatan : </td><td><select class='input-short' name=StatusSubKegiatan  placeholder='pilih Status' id=id_BidUrusan onchange=''>
                <option value=#>Pilih Status</option>
                <option value='final'>Final</option>
                <option value='draft'>Draft</option></select></td>
                </tr>
                <tr>
                <td>Status Realisasi : </td><td><select class='input-short' name=StatusRealisasi  placeholder='pilih Status' onchange=''>
                <option value=#>Pilih Status</option>
                <option value='final'>Final</option>
                <option value='draft'>Draft</option></select></td>
                </tr>
                <tr>
                <td></td>
                <td><input type=hidden name='id_Skpd' value='$_GET[id]'>
                <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </td>
                </tr>
                </table>
                </form></div>";

    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Program], 0,1);
          $id_BidUrusan = substr($r[id_Program], 0,3);
          echo "<div class='grid_7'>";
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
                </form>
                <div class=bottom-spacing>
                
                </div>";
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
    url: '../library/vw_skpdstatus.php',
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
