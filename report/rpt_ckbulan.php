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
include "../../asset/css/printer.css";
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
function rlsbulan($id_Bulan,$id_DataKegiatan){
    $q = mysql_query("SELECT SUM(a.rls_Keu2) keu FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
function ck_bulan($bulan,$id_DataKegiatan) {
    //cari jumlah sub kegiatan pada setiap datakegiatan
    //$q2 = mysql_query("SELECT id_Subkegiatan FROM subkegiatan WHERE id_DataKegiatan = '$id_DataKegiatan'");
    //$jml = mysql_num_rows($q2);

    $q = mysql_query("SELECT COUNT(b.id_Realisasi) AS jml_realisasi  
                        FROM subkegiatan a, realisasi b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND a.id_DataKegiatan = '$id_DataKegiatan' 
                        AND b.id_Bulan = '$bulan'");
    $r = mysql_fetch_array($q);
    $q1 = mysql_query("SELECT COUNT(a.id_Subkegiatan) AS jml_sub  
                        FROM subkegiatan a 
                        WHERE a.id_DataKegiatan = '$id_DataKegiatan'");
    $r1 = mysql_fetch_array($q1);
    if($r1['jml_sub'] <> $r['jml_realisasi']){
        $hasil = "-";
    } elseif($r1['jml_sub'] == 0) {
        $hasil = "-";
    } else {
        $hasil = "[OK]";
    }
    return $hasil;
}
$qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
$rskpd = mysql_fetch_array($qskpd);
echo "<div id=print>
				<div align=center>
				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
				<tr align=center><td>LAPORAN REALISASI FISIK DAN KEUANGAN</td></tr>
				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>	
	            <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>  <tr>
    <td rowspan=2>No</td>
    <td rowspan=2>Program / Kegiatan</td>
    <td rowspan=2>Anggaran</td>
    <td colspan=12>Realisasi</td>
    <td rowspan=2>Total</td>
  </tr>
  <tr>
    <td>Jan</td>
    <td>Feb</td>
    <td>Mar</td>
    <td>Apr</td>
    <td>Mei</td>
    <td>Jul</td>
    <td>Jun</td>
    <td>Ags</td>
    <td>Sep</td>
    <td>Okt</td>
    <td>Nop</td>
    <td>Des</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>";
    $q = mysql_query("SELECT *,b.id_Program,a.id_Skpd,a.TahunAnggaran  
                        FROM datakegiatan a, kegiatan b 
                        WHERE a.id_Kegiatan = b.id_Kegiatan 
                        AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                        AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                        GROUP BY b.id_Program");
    while($r=mysql_fetch_array($q)) {
            $q1 = mysql_query("SELECT nm_Program, id_Program  
                                      FROM program 
                                      WHERE id_Program = '$r[id_Program]'");
            $r1=mysql_fetch_array($q1);
        echo "<tr>
            <td>&nbsp;</td>
            <td><strong>$r1[nm_Program]</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>";
        $q2 = mysql_query("SELECT a.nm_Kegiatan, b.id_DataKegiatan,b.AnggKeg 
                FROM kegiatan a, datakegiatan b 
                WHERE a.id_Kegiatan = b.id_Kegiatan 
                AND b.id_Skpd = '$r[id_Skpd]' 
                AND b.TahunAnggaran = '$r[TahunAnggaran]' 
                AND a.id_Program = '$r1[id_Program]'");
        while ($r2=mysql_fetch_array($q2)) {
            
            echo "<tr>
                    <td>&nbsp;</td>
                    <td>$r2[nm_Kegiatan]</td>
                    <td>".number_format($r2[AnggKeg])."</td>";
                    for ($i=1; $i <= 12; $i++) { 
                        //cari 0 jika bulan 2
                        //$bulanlalu = rlsbulan($i-1,$r2['id_DataKegiatan']);
                        //$bulanini = rlsbulan($i,$r2['id_DataKegiatan']) - $bulanlalu;
                        //echo "<td>".number_format(rlsbulan($i,$r2['id_DataKegiatan']))."</td>";
                        echo "<td>".ck_bulan($i,$r2['id_DataKegiatan'])."</td>";
                    }
                    
                    
                echo "<td>&nbsp;</td>
                  </tr>";
        }
    }

echo "</table>
</body>";

}
?>