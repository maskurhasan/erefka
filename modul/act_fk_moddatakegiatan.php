<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

//cek jika status sudah final
//$q = mysql_query("SELECT StatusDataKegiatan FROM statusfinal WHERE id_Skpd='$_SESSION[id_Skpd]' AND thn_Anggaran='$_SESSION[thn_Login]'");
//$r = mysql_fetch_array($q);
//if($r[StatusDataKegiatan] == "draft") { //cek jika masih draf 
//--------------------------------------------------------------------------------------------
if ($act == "add" and $module == "kegiatanfk") {
        $id_Kegiatan = $_POST['id_Kegiatan'];
		    $id_Program = $_POST['id_Program'];
        $nm_Kegiatan = $_POST['nm_Kegiatan'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $Anggaran = $_POST['Anggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        //$tgl_Input = $_POST['tgl_Input'];
        
        $qry = mysql_query("INSERT INTO fk_kegiatan (id_Program,
                                              nm_Kegiatan,  
                                              TahunAnggaran, 
                                              Anggaran,
                                              id_Skpd, 
                                              id_Ppk,
                                              tgl_Input,
                                              id_Session) 
                                      VALUES ('$id_Program',
                                              '$nm_Kegiatan',  
                                              '$TahunAnggaran', 
                                              '$Anggaran',
                                              '$id_Skpd', 
                                              '$id_Ppk',
                                              now(),
                                              '$id_Session')");
        if ($qry)
            {
                header('location:../main.php?module=kegiatanfk');
            }
        else 
            {
                echo mysql_error();
            }
        exit();
} elseif($act == "edit" and $module == "kegiatanfk"){
        $id_Kegiatan = $_POST['id_Kegiatan'];
        $id_Program = $_POST['id_Program'];
        $nm_Kegiatan = $_POST['nm_Kegiatan'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $Anggaran = $_POST['Anggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        $qry = mysql_query("UPDATE fk_kegiatan SET id_Program='$id_Program',
                                              nm_Kegiatan='$nm_Kegiatan',  
                                              TahunAnggaran='$TahunAnggaran', 
                                              Anggaran='$Anggaran',
                                              id_Ppk='$id_Ppk',
                                              tgl_Input=now(),
                                              id_Session='$id_Session' 
                                        WHERE id_Kegiatan = '$id_Kegiatan'");
        if ($qry)
            {
                header('location:../main.php?module=kegiatanfk');
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

//}  else { //end jika final 
//    echo "<script type=text/javascript>window.alert('Rencana Kegiatan sudah FINAL / Belum Registrasi T.A')
//        window.location.href='../main.php?module=datakegiatan'</script>";
//}