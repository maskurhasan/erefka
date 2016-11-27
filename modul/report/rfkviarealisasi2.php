<?php
session_start();
if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {

//----------------------------------
include "../../config/koneksi.php";
include "../../config/fungsi.php";
include "../../config/fungsi_indotgl.php";
include "../../assets/css/printer.css";
include "../../config/errormode.php";
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
				<tr align=center><td>LAPORAN REALISASI FISIK DAN KEUANGAN</td></tr>
				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>	
	            <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                <thead>
                <tr align=center>
                  <th rowspan=3></th>
                  <th rowspan=3 colspan=2>Program/Kegiatan</th>
                  <th rowspan=1 colspan=3>Anggaran</th>
                  
                  <th rowspan=3>Volume</th>
                  <th rowspan=3>Sumber Dana</th>
                  <th rowspan=3>Lokasi</th>
                  <th rowspan=3>Pelaksana</th>
                  <th rowspan=3>Konsultan Perencana</th>
                  <th rowspan=3>Konsultan Pengawas</th>
                  <th rowspan=3>Tanggal Mulai Pekerjaan</th>
                  <th rowspan=3>Tanggal Selesai Pekerjaan</th>
                  <th rowspan=3>PPK</th>
                  <th rowspan='' colspan=3>Target</th>
                  <th rowspan='' colspan=3>Realisasi</th>
                  <th rowspan='3'>Ket</th>
                </tr>
                <tr>
                <th rowspan=2>PAGU</th>
                <th rowspan=2>Fisik</th>
                <th rowspan=2>Kontrak</th>
                  <th rowspan='2'>Fisik (%)</th>
                  <th colspan=2>Keu</th>
                  <th rowspan=2>Fisik (%)</th>
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
                  <th>3</th>
                  <th>3</th>
                  <th>4</th>
                  <th>4</th>
                  <th>4</th>
                  <th>4</th>
                  <th>4</th>
                  <th>4</th>
                  <th>4</th>
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
                    $trg_lalu = $r['trg_Keu1'];
                  } elseif($nilaitriwulan==2) {
                    $trg_lalu = $r['trg_Keu1']+$r['trg_Keu2'];
                  } elseif($nilaitriwulan==3) {
                    $trg_lalu = $r['trg_Keu1']+$r['trg_Keu2']+$r['trg_Keu3'];
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

                function realisasiver2($id_Kegiatan,$id_Skpd,$TahunAnggaran){
                  $sql = "SELECT SUM(NilaiBelanja) AS NilaiRealisasi
                        FROM realisasi2
                        WHERE id_Skpd = '$id_Skpd' 
                        AND id_Kegiatan = '$id_Kegiatan' 
                        AND TahunAnggaran = '$TahunAnggaran'
                        GROUP BY id_Kegiatan";
                  $r = mysql_fetch_array(mysql_query($sql));
                  return $r['NilaiRealisasi'];
                }

               $q = mysql_query("SELECT * FROM datakegiatan a, kegiatan b 
                                  WHERE a.id_Kegiatan = b.id_Kegiatan 
                                  AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                                  AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                                  GROUP BY b.id_Program");
               $no = 1;
               while($r=mysql_fetch_array($q)) {
                  $q1 = mysql_query("SELECT nm_Program, id_Program  
                                      FROM program 
                                      WHERE id_Program = '$r[id_Program]'");
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>";

                    $q2 = mysql_query("SELECT a.id_Kegiatan,a.nm_Kegiatan, b.id_DataKegiatan,c.nm_Ppk,b.AnggKeg,d.nm_SbDana 
                                        FROM kegiatan a, datakegiatan b 
                                        LEFT JOIN ppk c 
                                        ON b.id_Ppk = c.id_Ppk 
                                        LEFT JOIN sumberdana d 
                                        ON b.id_SbDana = d.id_SbDana  
                                        WHERE a.id_Kegiatan = b.id_Kegiatan 
                                        AND b.id_Skpd = '$r[id_Skpd]' 
                                        AND b.TahunAnggaran = '$r[TahunAnggaran]' 
                                        AND a.id_Program = '$r1[id_Program]'");
                    while ($r2=mysql_fetch_array($q2)) {
                      echo "<tr>
                      <td>".$no++."</td>
                      <td colspan=2>$r2[nm_Kegiatan]</td>
                      <td>".frm_angka($r2[AnggKeg])."</td>
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
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>".number_format(realisasiver2($r2['id_Kegiatan'],$_SESSION['id_Skpd'],$_SESSION['thn_Login']))."</td>
                      <td></td>
                      </tr>";
                      /*
                      $q3 = mysql_query("SELECT * 
                                        FROM subkegiatan a 
                                        WHERE a.id_DataKegiatan = '$r2[id_DataKegiatan]'");
                      while ($r3=mysql_fetch_array($q3)) {
                        //target keu
                        $trgkeu = $r3['trg_Keu1']+$r3['trg_Keu2']+$r3['trg_Keu3']+$r3['trg_Keu4'];
                        $pertrgkeu = ($trgkeu / $r3[nl_Pagu]) * 100;
                        
                        $qa = mysql_query("SELECT MAX(id_Bulan) AS bln FROM realisasi WHERE id_SubKegiatan = '$r3[id_SubKegiatan]'");
                        $ra = mysql_fetch_assoc($qa);
                        if(empty($_GET[bulan])) {
                          $fl_bln = "$ra[bln]";
                        //} elseif($_GET[bulan] > $ra[bln]) {
                        //  $fl_bln = "$ra[bln]";
                        } else {
                          $fl_bln = "$_GET[bulan]";
                        }

                        echo "<tr>
                        <td></td>
                        <td></td>
                        <td>$r3[nm_SubKegiatan]</td>
                        <td>".frm_angka($r3[nl_Pagu])."</td>
                        <td>".frm_angka($r3[nl_Fisik])."</td>
                        <td>".frm_angka($r3[nl_Kontrak])."</td>
                        <td>$r3[jml_Volume]</td>
                        <td>$r2[nm_SbDana]</td>
                        <td>$r3[AlamatLokasi]</td>
                        <td>$r3[Pelaksana]</td>
                        <td>$r3[konsPerencana]</td>
                        <td>$r3[konsPengawas]</td>
                        <td>".tgl_standar($r3[tgl_Mulai])."</td>
                        <td>".tgl_standar($r3[tgl_Selesai])."</td>";
                        $qpp = mysql_query("SELECT nm_Ppk FROM ppk WHERE id_Ppk='$r2[id_Ppk]'");
                        $rpp = mysql_fetch_array($qpp);
                  echo "<td>$r2[nm_Ppk]</td>
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
                      */
                  } //r2
                } //r1
          $qtxx=mysql_query("SELECT SUM(a.AnggKeg) AS total    
                            FROM datakegiatan a,
                            LEFT JOIN subkegiatan b 
                            ON a.id_DataKegiatan = b.id_DataKegiatan  
                            WHERE a.TahunAnggaran = '$_SESSION[thn_Login]' 
                            AND a.id_Skpd = '$_SESSION[id_Skpd]'");
          $qt=mysql_query("SELECT SUM(AnggKeg) AS total    
                            FROM datakegiatan  
                            WHERE TahunAnggaran = '$_SESSION[thn_Login]' 
                            AND id_Skpd = '$_SESSION[id_Skpd]'");
          $rt = mysql_fetch_array($qt);

          $qt1=mysql_query("SELECT SUM(c.rls_Keu2) AS totalrealisasi    
                            FROM datakegiatan a,subkegiatan b,realisasi c   
                            WHERE a.TahunAnggaran = '$_SESSION[thn_Login]' 
                            AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                            AND a.id_DataKegiatan = b.id_DataKegiatan 
                            AND b.id_SubKegiatan = c.id_SubKegiatan 
                            AND c.id_Bulan = '$_GET[bulan]'");
          $rt1 = mysql_fetch_array($qt1);    

          echo "<tr>
                  <td></td>
                      <td colspan=2>JUMLAH</td>
                      <td>".frm_angka($rt[total])."</td>
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
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>".frm_angka($rt1['totalrealisasi'])."</td>
                      <td></td>
                </tr>
                </tbody>
                </table>
                       
			<div style='clear: both'></div>
		</div>";

} //tanpa session
?>
</body>
</html>