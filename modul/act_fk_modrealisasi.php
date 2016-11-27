<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";

//cek jika status sudah final
//$q = mysql_query("SELECT StatusRealisasi FROM statusfinal WHERE id_Skpd='$_SESSION[id_Skpd]' AND thn_Anggaran='$_SESSION[thn_Login]'");
//$/r = mysql_fetch_array($q);
//if($r['StatusRealisasi'] == "draft") { //cek jika masih draf 
$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "realisasifk") {
    if(isset($_POST[simpan])) { //add data
        $id_Realisasi = $_POST['id_Realisasi'];
        $id_Kegiatan = $_POST['id_Kegiatan'];
        $nm_Belanja = $_POST['nm_Belanja'];
        $rls_Anggaran = $_POST['rls_Anggaran'];
        $tgl_Belanja = $_POST['tgl_Belanja'];
        $Keterangan = $_POST['Keterangan'];
        $id_Session = $_SESSION['Sessid'];

        $qry = mysql_query("INSERT INTO fk_realisasi (id_Kegiatan, 
                                              nm_Belanja, 
                                              rls_Anggaran, 
                                              tgl_Belanja, 
                                              Keterangan,
                                              tgl_Input, 
                                              id_Session) 
                                      VALUES ('$id_Kegiatan', 
                                              '$nm_Belanja', 
                                              '$rls_Anggaran', 
                                              '$tgl_Belanja', 
                                              '$Keterangan', 
                                              now(), 
                                              '$id_Session')");
        if ($qry)
            {
                header("location:../main.php?module=realisasifk&act=belanja&id=$id_Kegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    }
} elseif($act == "edit" and $module == "realisasifk"){
    if(isset($_POST[simpan])) { //add data
        $id_Realisasi = $_POST['id_Realisasi'];
        $id_Kegiatan = $_POST['id_Kegiatan'];
        $nm_Belanja = $_POST['nm_Belanja'];
        $rls_Anggaran = $_POST['rls_Anggaran'];
        $tgl_Belanja = $_POST['tgl_Belanja'];
        $Keterangan = $_POST['Keterangan'];
        $id_Session = $_SESSION['Sessid'];

        $qry = mysql_query("UPDATE fk_realisasi SET nm_Belanja='$nm_Belanja', 
                                              rls_Anggaran='$rls_Anggaran', 
                                              tgl_Belanja='$tgl_Belanja', 
                                              Keterangan='$Keterangan', 
                                              tgl_Input=now(), 
                                              id_Session='$id_Session' 
                                    WHERE id_Realisasi = '$id_Realisasi'");
        if ($qry)
            {
                header("location:../main.php?module=realisasifk&act=belanja&id=$id_Kegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    }
}
//} else { //end jika final 
//  echo "<script type=text/javascript>window.alert('Sub Kegiatan sudah FINAL / Belum Registrasi T.A')
//        window.location.href='../main.php?module=realisasi&act=add&id=$_POST[id_DataKegiatan]'</script>";
//} 