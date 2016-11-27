<?php
session_start();
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(0);
if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {

//----------------------------------
include "../../config/koneksi.php";
include "../../config/fungsi.php";
include "../../config/fungsi_indotgl.php";
include "../../asset/css/printer.css";
?>
<html>
<head>
<style type="text/css">
.style4 {font-size: 10; }
.style7 {	font-size: 10;
	color: #265180;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
<script language="javascript" type="text/javascript">
window.print();
</script>
<title>Laporan</title>
</head>
<body>
<?php  
$qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
$rskpd = mysql_fetch_array($qskpd);
				echo "<div id=print>
				<div align=center>
				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
				<tr align=center><td>REKAPITULASI LAPORAN REALISASI FISIK DAN KEUANGAN</td></tr>
				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>	
	            <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                <thead>
                <tr align=center>
                  <th rowspan=3></th>
                  <th rowspan=3>Unit Kerja</th>
                  <th rowspan=1>Anggaran</th>
                  <th rowspan='' colspan=3>Target</th>
                  <th rowspan='' colspan=3>Realisasi</th>
                  <th rowspan='' colspan=3>Deviasi</th>
                  <th rowspan='3'>Ket</th>
                </tr>
                <tr>
                <th rowspan=2>PAGU</th>
                <th rowspan='2'>Fisik (%)</th>
                <th colspan=2>Keu</th>
                <th rowspan=2>Fisik (%)</th>
                <th colspan=2>Keu</th>
                <th rowspan=2>Fisik (%)</th>
                <th colspan=2>Keu</th>  
                </tr>
                <tr>
                  <th>%</th>
                  <th>Rp.</th>
                  <th>%</th>
                  <th>Rp.</th>
                  <th>%</th>
                  <th>Rp.</th>
                </tr>
                <tr>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>6</th>
                  <th>7</th>
                  <th>8</th>
                  <th>9</th>
                  <th>10</th>
                  <th>11</th>
                  <th>11</th>
                  <th>11</th>
                  <th>11</th>
                  <th>11</th>
                </tr>
                </thead>
                <tbody>";
                //dapatkan nilai target keu perbulan
                //tri I
                //$key = $arrtriwulan[5];
                //echo $key;
                function target_skpd_trw($bln,$id_Skpd,$arrtriwulan)
                {
                  $q = mysql_query("SELECT SUM(tr_Satu) AS satu,SUM(tr_Dua) AS dua,SUM(tr_Tiga) AS tiga,SUM(tr_Empat) AS empat  
                                    FROM datakegiatan 
                                    WHERE id_Skpd = '$id_Skpd'");
                  $r = mysql_fetch_array($q);
                  
                  $triwulan = $arrtriwulan[$bln];
                  if($triwulan==1) {
                    $nilaitarget = $r['satu'];
                  } elseif ($triwulan==2){
                    $nilaitarget = $r['dua'];
                  } elseif ($triwulan==3){
                    $nilaitarget = $r['tiga'];
                  } elseif ($triwulan==4) {
                    $nilaitarget = $r['empat'];
                  }
                  $trg_bln = $nilaitarget/3;

                  //hitung triwulan sebelumnya
                  $nilaitriwulan = $triwulan-1;
                  if($nilaitriwulan==1) {
                    $trg_lalu = $r['satu'];
                  } elseif($nilaitriwulan==2) {
                    $trg_lalu = $r['satu']+$r['dua'];
                  } elseif($nilaitriwulan==3) {
                    $trg_lalu = $r['satu']+$r['dua']+$r['tiga'];
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
          
                $q=mysql_query("SELECT nm_Skpd, id_Skpd,apbd FROM skpd");
                $no=1;
                while ($r=mysql_fetch_array($q)) {
                  $q1 = mysql_query("SELECT SUM(b.nl_Pagu) AS pagu,SUM(b.trg_Keu1) AS Keu1,SUM(b.trg_Keu2) AS Keu2,
                                            SUM(b.trg_Keu3) AS Keu3,SUM(b.trg_Keu4) AS Keu4
                                      FROM datakegiatan a, subkegiatan b 
                                      WHERE a.id_Skpd = '$r[id_Skpd]' 
                                      AND a.id_DataKegiatan = b.id_DataKegiatan 
                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'");
                  $r1 = mysql_fetch_array($q1);
                  $targetkeu = $r1[Keu1]+$r1[Keu2]+$r1[Keu3]+$r1[Keu4];
                  if(!empty($targetkeu)) {
                    $targetpersen = ($targetkeu/$r1[pagu]) * 100;
                  } else {
                    $targetpersen = "";
                  }

                  if(empty($_GET[bulan])) {
                      $fl_bln = 12;
                  } else {
                      $fl_bln = "$_GET[bulan]";
                  }

                  //hitung realisasi
                  $q2x=mysql_query("SELECT MAX(c.id_Bulan), SUM(c.rls_Keu2) AS keu2 
                                    FROM datakegiatan a, subkegiatan b, realisasi c 
                                    WHERE a.id_DataKegiatan = b.id_DataKegiatan 
                                    AND b.id_SubKegiatan = c.id_SubKegiatan 
                                    AND a.id_Skpd = '$r[id_Skpd]' 
                                    AND c.id_SubKegiatan = (SELECT e.id_SubKegiatan 
                                                            FROM datakegiatan d, subkegiatan e 
                                                            WHERE d.id_DataKegiatan = e.id_DataKegiatan 
                                                            AND d.id_Skpd = '$r[id_Skpd]')");
                  $q2xx=mysql_query("SELECT SUM(c.rls_Keu2) AS keu2 
                                    FROM datakegiatan a, subkegiatan b, realisasi c 
                                    WHERE a.id_DataKegiatan = b.id_DataKegiatan 
                                    AND b.id_SubKegiatan = c.id_SubKegiatan 
                                    AND a.id_Skpd = '$r[id_Skpd]' 
                                    AND c.id_Bulan = (SELECT MAX(f.id_Bulan) 
                                                            FROM datakegiatan d, subkegiatan e, realisasi f 
                                                            WHERE d.id_DataKegiatan = e.id_DataKegiatan 
                                                            AND e.id_SubKegiatan = f.id_SubKegiatan 
                                                            AND d.id_Skpd = '$r[id_Skpd]')");
                  $q2=mysql_query("SELECT MAX(c.id_Bulan) AS bln,SUM(c.rls_Keu2) AS keu2 
                                    FROM datakegiatan a, subkegiatan b, realisasi c 
                                    WHERE a.id_DataKegiatan = b.id_DataKegiatan 
                                    AND b.id_SubKegiatan = c.id_SubKegiatan 
                                    AND a.id_Skpd = '$r[id_Skpd]'");

                  $r2=mysql_fetch_array($q2);

                  
                  echo "<tr>
                    <td align=center>".$no++."</td>
                    <td><b>$r[nm_Skpd]</b></td>
                    <td align=right>".number_format($r[apbd])."</td>
                    <td></td>
                    <td>".frm_desimal($targetpersen)."</td>
                    <td align=right>".number_format(target_skpd_trw($fl_bln,$r['id_Skpd'],$arrtriwulan))."</td>
                    <td></td>
                    <td></td>
                    <td>".frm_angka($r2[keu2])."</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>";
                }


          echo "</tbody>
                </table>
                       
			<div style='clear: both'></div>
		</div>";

} //tanpa session
?>
</body>
</html>