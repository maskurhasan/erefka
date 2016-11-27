<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];
//cek jika status sudah final
$q = mysql_query("SELECT StatusDataKegiatan FROM statusfinal WHERE id_Skpd='$_SESSION[id_Skpd]' AND thn_Anggaran='$_SESSION[thn_Login]'");
$r = mysql_fetch_array($q);
if($r[StatusDataKegiatan] == "draft") { //cek jika masih draf 
//--------------------------------------------------------------------------------------------
$id_DataKegiatan = $_POST['id_DataKegiatan'];
$id_Kegiatan = $_POST['id_Kegiatan'];
$TahunAnggaran = $_POST['TahunAnggaran'];
$id_Skpd = $_POST['id_Skpd'];
$AnggKeg = $_POST['AnggKeg'];
$id_Ppk = $_POST['id_Ppk'];
$id_Session = $_SESSION['Sessid'];

//cek nilai anggaran
//$qc = mysql_query("SELECT * FROM ")


if ($act == "add" and $module == "datakegiatan") {        
        $qry = mysql_query("INSERT INTO datakegiatan (id_Kegiatan, 
                                              TahunAnggaran, 
                                              id_Skpd,
                                              AnggKeg, 
                                              id_Ppk,
                                              id_Session,
                                              tgl_Input) 
                                      VALUES ('$id_Kegiatan', 
                                              '$TahunAnggaran', 
                                              '$id_Skpd',
                                              '$AnggKeg',
                                              '$id_Ppk',
                                              '$id_Session',
                                              now())");
        if ($qry)
            {
                header('location:../main.php?module=datakegiatan');
            }
        else 
            {
                echo mysql_error();
            }
        exit();
} elseif($act == "edit" and $module == "datakegiatan"){
        $qry = mysql_query("UPDATE datakegiatan SET id_Kegiatan='$id_Kegiatan', 
                                              id_Ppk='$id_Ppk',
                                              id_Session='$id_Session',
                                              AnggKeg='$AnggKeg',
                                              tgl_Input=now() 
                                        WHERE id_DataKegiatan = '$id_DataKegiatan'");
        if ($qry)
            {
                header('location:../main.php?module=datakegiatan');
            }
        else 
            {
                echo mysql_error();
            }
        exit();
} elseif($act == "delete" and $module == "datakegiatan"){
      $id = $_GET['id'];
      //periksa jika ada subkegiatan
      $q = mysql_query("SELECT id_SubKegiatan FROM subkegiatan WHERE id_DataKegiatan = '$id'");
      $r = mysql_num_rows($q);
      if($r==0) {
        $qry=mysql_query("DELETE FROM datakegiatan WHERE id_DataKegiatan = '$id'");
        if($qry){
          header('location:../main.php?module=datakegiatan');
        } else {
          echo mysql_error();
        }
      } else {
        //header('location:../main.php?module=datakegiatan');
        echo "<script type=text/javascript>window.alert('Gagal Hapus:Data Sub Kegiatan ')
              window.location.href='../main.php?module=datakegiatan'</script>";

      }



} 

}  else { //end jika final 
    echo "<script type=text/javascript>window.alert('Rencana Kegiatan sudah FINAL / Belum Registrasi T.A')
        window.location.href='../main.php?module=datakegiatan'</script>";
}