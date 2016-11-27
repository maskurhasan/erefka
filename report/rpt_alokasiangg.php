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
				<tr align=center><td>ALOKASI ANGGARAN LINGKUP PEMERINTAH KABUPATEN LUWU UTARA</td></tr>
				<tr align=center><td>TAHUN ANGGARAN : $_SESSION[thn_Login]</td></tr></table></div>	
	            <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                <thead>
                <tr align=center>
                  <th></th>
                  <th>URUSAN / SKPD</th>
                  <th>ALOKASI ANGGARAN</th>
                  <th>PERSENTASE (%)</th>
                  <th>KETERANGAN</th>
                </tr>
                <tr>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                </tr>
                </thead>
                <tbody>";
                //fungsi mencari perseen alokasi
                function persenalokasi ($anggaran,$total) {
                  $persen = ($anggaran / $total) * 100;
                  return $persen;
                }
                //total anggaran
                $q1=mysql_query("SELECT SUM(AnggKeg) AS total    
                                FROM datakegiatan 
                                WHERE TahunAnggaran = '$_SESSION[thn_Login]'");
                $r1 = mysql_fetch_array($q1);                     
                
          
                $q=mysql_query("SELECT a.nm_Skpd,SUM(b.AnggKeg) AS anggaran     
                                FROM skpd a,datakegiatan b 
                                WHERE a.id_Skpd = b.id_Skpd 
                                AND b.TahunAnggaran = '$_SESSION[thn_Login]' 
                                GROUP BY a.id_Skpd");
                $no=1;
                while ($r=mysql_fetch_array($q)) {

                  echo "<tr>
                    <td align=center>".$no++."</td>
                    <td><b>$r[nm_Skpd]</b></td>
                    <td align=right>".number_format($r['anggaran'])."</td>
                    <td>".frm_desimal(persenalokasi($r['anggaran'],$r1['total']))."</td>
                    <td align=right></td>
                    </tr>";
                }
          echo "<tr>
                <td></td>
                <td>Total</td>
                <td align=right>".number_format($r1['total'])."</td>
                <td>100%</td>
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