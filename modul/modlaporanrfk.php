<?php
session_start();
//error_reporting(0);
if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {  
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";

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
                <label>&nbsp</label><a href='?module=laporanrfk&act=rfk' class='button'>
                    <span><i class='fa fa-plus fa-lg'></i> Tambah SKPD</span>
                  </a>
                <div class=bottom-spacing>
                </div>
                <div id=vw_skpd></div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "rfk":
          echo "<div class='grid_12'>";
          echo "<div class='module'>
                <h2><span>Data Rincian Kegiatan</span></h2>
                <div class=module-table-body>
                <table  border=1>
                <thead>
                <tr>
                  <th rowspan=3></th>
                  <th rowspan=3 colspan=2>Program/Kegiatan</th>
                  <th rowspan=3>Pagu</th>
                  <th rowspan=3>Pelaksana</th>
                  <th rowspan=3>PPK</th>
                  <th rowspan='' colspan=3>Target</th>
                  <th rowspan='' colspan=3>Realisasi</th>
                  <th rowspan='3'>Ket</th>
                </tr>
                <tr>
                  <th rowspan='2'>Fisik(%)</th>
                  <th colspan=2>Keu</th>
                  <th rowspan=2>Fisik(%)</th>
                  <th colspan=2>Keu</th>
                  
                </tr>
                <tr>
                  <th>%</th>
                  <th>Rp.</th>
                  <th>%</th>
                  <th>Rp.</th>
                </tr>
                <tr>
                  <th>1</th>
                  <th colspan=2>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>6</th>
                  <th>7</th>
                  <th>8</th>
                  <th>9</th>
                  <th>10</th>
                  <th>11</th>
                  <th>12</th>
                </tr>
                </thead>
                <tbody>";
              //ambil nilai id kegiatan untuk fetch data program
              $q = mysql_query("SELECT b.id_Kegiatan, c.id_DataKegiatan, b.id_Program 
                                  FROM kegiatan b, datakegiatan c 
                                  WHERE b.id_Kegiatan = c.id_Kegiatan 
                                  AND c.id_Skpd = '$_SESSION[id_Skpd]'");
              while($r=mysql_fetch_array($q)) {
                $qp = mysql_query("SELECT nm_Program 
                                    FROM program  
                                    WHERE id_Program = '$r[id_Program]'");
                //$rp = mysql_fetch_assoc($qp);
                while ($rp=mysql_fetch_assoc($qp)) {
                echo "<tr>
                  <td></td>
                  <td colspan=2><b>$rp[nm_Program]</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td></tr>";
                
                //untuk menampilkan data kegiatan
              $q1 = mysql_query("SELECT nm_Kegiatan
                                    FROM kegiatan   
                                    WHERE id_Kegiatan = '$r[id_Kegiatan]'");
              while ($r1=mysql_fetch_array($q1)) {
                  echo "<tr>
                  <td></td>
                  <td colspan=2>$r1[nm_Kegiatan]</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td></tr>";
                
                  ///*
                  $sql2 = "SELECT * 
                            FROM subkegiatan 
                            WHERE id_DataKegiatan = '$r[id_DataKegiatan]'";
                  $q2 = mysql_query($sql2);
                  while($r2=mysql_fetch_array($q2)) {
                    //target keu
                    $trgkeu = $r2[trg_Keu1]+$r2[trg_Keu2]+$r2[trg_Keu3]+$r2[trg_Keu4];
                    $pertrgkeu = ($trgkeu / $r2[nl_Pagu]) * 100;
                    echo "<tr>
                    <td></td>
                    <td></td>
                    <td>$r2[nm_SubKegiatan]</td>
                    <td>$r2[nl_Pagu]</td>
                    <td>$r2[Pelaksana]</td>
                    <td></td>
                    <td>$r2[trg_Fisik]</td>
                    <td>$pertrgkeu</td>
                    <td>$trgkeu</td>";
                    $qa = mysql_query("SELECT MAX(id_Bulan) AS bln FROM realisasi WHERE id_SubKegiatan = '$r2[id_SubKegiatan]'");
                    $ra = mysql_fetch_assoc($qa);
                    $sql3 = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$r2[id_SubKegiatan]' AND id_Bulan = '$ra[bln]'");
                    $r3 = mysql_fetch_assoc($sql3);
                    //% keu
                    $perkeu = ($r3[rls_Keu2] / $r2[nl_Pagu]) * 100;
                    echo "<td>$r3[rls_Fisik]</td>
                    <td>$perkeu</td>
                    <td>$r3[rls_Keu2]</td>
                    <td></td>
                    </tr>";
                  }
                }
              }
              }
          echo "</tbody>
                </table></div></div>";
          echo "<div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "bulanan":
          $sql = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Program], 0,1);
          $id_BidUrusan = substr($r[id_Program], 0,3);
          echo "<div class='grid_7'>";
          echo "<form method=get action='?module=laporanrfk'>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <label>Urusan </label><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select>
                <label>Bid. Urusan : </label><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select>
                <label>Program : </label><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select>
                <label>Kegiatan : </label><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select>
                <label>Bulan :</label><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select>
                
                <fieldset>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <input id='simpanxx' class='submit-green' type='submit' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                </fieldset>
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>
          <div class=grid_12>";
          echo "<div class='module'>
                <h2><span>Data Rincian Kegiatan</span></h2>
                <div class=module-table-body>
                <table  border=1>
                <thead>
                <tr>
                  <th rowspan=3></th>
                  <th rowspan=3 colspan=2>Program/Kegiatan</th>
                  <th rowspan=3>Pagu</th>
                  <th rowspan=3>Pelaksana</th>
                  <th rowspan=3>PPK</th>
                  <th rowspan='' colspan=3>Target</th>
                  <th rowspan='' colspan=3>Realisasi</th>
                  <th rowspan='3'>Ket</th>
                </tr>
                <tr>
                  <th rowspan='2'>Fisik(%)</th>
                  <th colspan=2>Keu</th>
                  <th rowspan=2>Fisik(%)</th>
                  <th colspan=2>Keu</th>
                  
                </tr>
                <tr>
                  <th>%</th>
                  <th>Rp.</th>
                  <th>%</th>
                  <th>Rp.</th>
                </tr>
                <tr>
                  <th>1</th>
                  <th colspan=2>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>6</th>
                  <th>7</th>
                  <th>8</th>
                  <th>9</th>
                  <th>10</th>
                  <th>11</th>
                  <th>12</th>
                </tr>
                </thead>
                <tbody>";
                //dapatkan nilai target keu perbulan
                //tri I
                //$key = $arrtriwulan[5];
                //echo $key;
                function trw($bln,$subkegiatan,$arrtriwulan)
                {
                  $q = mysql_query("SELECT trg_Keu1,trg_Keu2,trg_Keu3,trg_Keu4 FROM subkegiatan WHERE id_SubKegiatan = '$subkegiatan'");
                  $r = mysql_fetch_array($q);
                  
                  $triwulan = $arrtriwulan[$bln];
                  $trg_bln = $r['trg_Keu'.$triwulan]/3;
                  //hitung triwulan sebelumnya
                  $nilaitriwulan = $triwulan-1;
                  if($nilaitriwulan==1) {
                    $trg_lalu = $r[trg_Keu1];
                  } elseif($nilaitriwulan==2) {
                    $trg_lalu = $r[trg_Keu1]+$r[trg_Keu2];
                  } elseif($nilaitriwulan==3) {
                    $trg_lalu = $r[trg_Keu1]+$r[trg_Keu2]+$r[trg_Keu3];
                  }


                  $sm_trg11 = $r[jmltrg];
                  $minusbulan = fmod($bln,3);
                  if($minusbulan > 0) {
                    $sisa = ($minusbulan * $trg_bln)+$trg_lalu;
                  }else{
                    $sisa = (3 * $trg_bln)+$trg_lalu;
                  }
                  
                  return $sisa;
                }

               $q = mysql_query("SELECT * FROM datakegiatan a, kegiatan b 
                                  WHERE a.id_Kegiatan = b.id_Kegiatan 
                                  AND a.id_Skpd = '$_SESSION[id_Skpd]'
                                  GROUP BY b.id_Program");
               while($r=mysql_fetch_array($q)) {
                  $q1 = mysql_query("SELECT * FROM program WHERE id_Program = '$r[id_Program]'");
                  $r1=mysql_fetch_array($q1);
                  //while ($r1=mysql_fetch_array($q1)) {
                  echo "<tr>
                    <td></td>
                    <td colspan=2><b>$r1[nm_Program]</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td></tr>";

                    $q2 = mysql_query("SELECT * FROM kegiatan a, datakegiatan b WHERE 
                                        a.id_Kegiatan = b.id_Kegiatan 
                                        AND a.id_Program = '$r1[id_Program]'");
                    while ($r2=mysql_fetch_array($q2)) {
                      echo "<tr>
                      <td></td>
                      <td colspan=2>$r2[nm_Kegiatan]</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td></tr>";

                      $q3 = mysql_query("SELECT * FROM subkegiatan WHERE id_DataKegiatan = '$r2[id_DataKegiatan]'");
                      while ($r3=mysql_fetch_array($q3)) {
                        //target keu
                        $trgkeu = $r3[trg_Keu1]+$r3[trg_Keu2]+$r3[trg_Keu3]+$r3[trg_Keu4];
                        $pertrgkeu = ($trgkeu / $r3[nl_Pagu]) * 100;
                        
                        $qa = mysql_query("SELECT MAX(id_Bulan) AS bln FROM realisasi WHERE id_SubKegiatan = '$r3[id_SubKegiatan]'");
                        $ra = mysql_fetch_assoc($qa);
                        if(empty($_GET[bulan])) {
                          $fl_bln = "$ra[bln]";
                        } elseif($_GET[bulan] > $ra[bln]) {
                          $fl_bln = "$ra[bln]";
                        } else {
                          $fl_bln = "$_GET[bulan]";
                        }

                        echo "<tr>
                        <td></td>
                        <td></td>
                        <td>$r3[nm_SubKegiatan]</td>
                        <td>".frm_angka($r3[nl_Pagu])."</td>
                        <td>$r3[Pelaksana]</td>";
                        $qpp = mysql_query("SELECT nm_Ppk FROM ppk WHERE id_Ppk='$r2[id_Ppk]'");
                        $rpp = mysql_fetch_array($qpp);
                  echo "<td>$rpp[nm_Ppk]</td>
                        <td>$r3[trg_Fisik]</td>
                        <td>".frm_desimal($pertrgkeu)."</td>
                        <td>".frm_angka(trw($fl_bln,$r3[id_SubKegiatan],$arrtriwulan))."</td>";
                        
                        //$sql4 = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$r3[id_SubKegiatan]' AND id_Bulan = '$ra[bln]'");
                        $sql4 = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$r3[id_SubKegiatan]' AND id_Bulan = '$fl_bln'");
                        $r4 = mysql_fetch_assoc($sql4);
                        //% keu
                        $perkeu = ($r4[rls_Keu2] / $r3[nl_Pagu]) * 100;
                        echo "<td>$r4[rls_Fisik]</td>
                        <td>".frm_desimal($perkeu)."</td>
                        <td>".frm_angka($r4[rls_Keu2])."</td>
                        <td></td>
                        </tr>";
                      } //r3
                  } //r2
                } //r1

          echo "</tbody>
                </table></div></div>";
          echo "</div>";
    break;
    case "alt2":
          echo "<div class='grid_7'>";
          echo "<form method=get action='report/rfkmodel1.php' target='_blank'>
                <table>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <tr>
                <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
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
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
                </tr>
                <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
                </tr>
                <tr>
                <td>Bulan :</td><td><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select></td>
                </tr>
                <tr>
                <td></td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button></td> 
                </tr>
                </table>
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "lampiran":
          echo "<div class='grid_5'>";
          echo "<form method=get action='report/rfkmodel1.php' target='_blank'>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <label>Urusan </label><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select>
                <label>Bid. Urusan : </label><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select>
                <label>Program : </label><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select>
                <label>Kegiatan : </label><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select>
                <label>Bulan :</label><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select>
                
                <fieldset>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button> 
                </fieldset>
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
          echo "<div class=grid_7>";
                echo "<div class=module>
                  <h2><span>Data Realisasi</span></h2>
                  <div class=module-table-body>
                  <form action=''>
                  <table id=myTable class=tablesorter>
                  <thead><tr><th style=width:5%>#</th>
                  <th style=width:25%>Nama Kegiatan</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                $sql = mysql_query("SELECT * FROM datakegiatan a,kegiatan b, ppk c 
                                      WHERE a.id_Kegiatan = b.id_Kegiatan AND a.id_Ppk = c.id_Ppk 
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                while($dt = mysql_fetch_array($sql)) {
                  echo "<tr><td>$no</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td class=align-center><a href='?module=realisasi&act=add&id=$dt[id_DataKegiatan]'><i class='fa fa-plus fa-lg'></i> Sub Kegiatan</a></td>
                          </tr>";
                } 
                echo "</tbody></table></form></div></div>";
          //akhir grid 7
          echo "</div>
                </div>";
    break;
    case "rekapskpd":
          echo "<div class='grid_7'>";
          echo "<form method=get action='report/rpt_rekapskpd.php' target='_blank'>
                <input type=hidden name=module value=laporanrfk>
                <input type=hidden name=act value=bulanan>
                <label>Urusan </label><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select>
                <label>Bid. Urusan : </label><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select>
                <label>Program : </label><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select>
                <label>Kegiatan : </label><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select>
                <label>Bulan :</label><select name=bulan>
                  <option value=0>Pilih Bulan</option>";
                  foreach ($arrbln as $key => $value) {
                    echo "<option value=$key>$key $value</option>";
                  }
                echo "</select>
                
                <fieldset>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <button type='submit' value=Cetak >Cetak</button> 
                <button type='reset' value=Cetak >Reset</button> 
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
$("#rfkbulanan").hide();
$("#test").hide();
//$(function() {
  $("#simpanxx").click({
    $("#rfkbulanan").show();
  });
//});

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



  //kembali 
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
