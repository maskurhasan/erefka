<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "datappk") {
        $id_Ppk = $_POST['id_Ppk'];
		    $nm_Ppk = $_POST['nm_Ppk'];
        $nip_Ppk = $_POST['nip_Ppk'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $id_Skpd = $_POST['id_Skpd'];
        $Jabatan = $_POST['Jabatan'];
        
        $qry = mysql_query("INSERT INTO ppk (nm_Ppk, 
                                              nip_Ppk, 
                                              id_Pangkat, 
                                              Jabatan, 
                                              id_Skpd,
                                              AktivPpk) 
                                      VALUES ('$nm_Ppk', 
                                              '$nip_Ppk', 
                                              '$id_Pangkat', 
                                              '$Jabatan',
                                              '$id_Skpd', 
                                              '1')");
        if ($qry)
            {
                header('location:../main.php?module=datappk');
            }
        else 
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "datappk"){
        $id_Ppk = $_POST['id_Ppk'];
        $nm_Ppk = $_POST['nm_Ppk'];
        $nip_Ppk = $_POST['nip_Ppk'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $Jabatan = $_POST['Jabatan'];
        $qry = mysql_query("UPDATE ppk SET nm_Ppk='$nm_Ppk', 
                                              nip_Ppk='$nip_Ppk', 
                                              id_Pangkat='$id_Pangkat', 
                                              Jabatan='$Jabatan' 
                                        WHERE id_Ppk = '$id_Ppk'");
        if ($qry)
            {
                header('location:../main.php?module=datappk');
            }
        else 
            {
                echo mysql_error();
            }

} elseif($act == "delete" and $module == "user"){
      //jika user dihapus
  
}  elseif($act == "akseskegiatan" and $module == "datappk"){
       /*
        if(isset($_POST['Simpan'])) {
          $id_Ppk = $_POST['id_Ppk'];
          $id_DataKegiatan = $_POST['id_DataKegiatan'];
          $qw = mysql_query("UPDATE datakegiatan SET id_Ppk= '0' WHERE id_Ppk = '$id_Ppk'");
          if($qw) {
              for ($i=0 ; $i < count($id_DataKegiatan);$i++) {
                  $id_DataKegiatanx = $id_DataKegiatan[$i];
                  $q = mysql_query("UPDATE datakegiatan SET id_Ppk= '$id_Ppk' WHERE id_DataKegiatan = '$id_DataKegiatanx'");    
              }
              if ($q) {
                header('Location:../main.php?module=datappk');
              } else {
                echo mysql_error();
              }
          }
        } else { echo "gagal"; } 
        */
        if(isset($_POST['Simpan'])) {
          $id_Ppk = $_POST['id_Ppk'];
          $id_DataKegiatan = $_POST['id_DataKegiatan'];
          $qw = mysql_query("UPDATE datakegiatan SET id_Ppk= '0' WHERE id_Ppk = '$id_Ppk'");
          if($qw) {
              for ($i=0 ; $i < count($id_DataKegiatan);$i++) {
                  $id_DataKegiatanx = $id_DataKegiatan[$i];
                  $q = mysql_query("UPDATE datakegiatan SET id_Ppk= '$id_Ppk' WHERE id_DataKegiatan = '$id_DataKegiatanx'");    
              }
              if ($q) {
                header('Location:../main.php?module=datappk');
              } else {
                echo mysql_error();
              }
          }
        } else { echo "gagal"; } 

} 