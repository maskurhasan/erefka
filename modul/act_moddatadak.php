<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "datadak") {
        $id_DataDak = $_POST['id_DataDak'];
		    $id_BidangDak = $_POST['id_BidangDak'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        
        $qry = mysql_query("INSERT INTO datadak (id_BidangDak, 
                                              TahunAnggaran, 
                                              id_Skpd, 
                                              id_Ppk, 
                                              id_Session,
                                              tgl_Input) 
                                      VALUES ('$id_BidangDak', 
                                              '$TahunAnggaran', 
                                              '$id_Skpd', 
                                              '$id_Ppk', 
                                              '$id_Session',
                                              now())");
        if ($qry)
            {
                header('location:../main.php?module=datadak');
            }
        else 
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "datadak"){
        $id_DataDak = $_POST['id_DataDak'];
        $id_BidangDak = $_POST['id_BidangDak'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        $qry = mysql_query("UPDATE datadak SET id_Ppk='$id_Ppk', 
                                              id_Session='$id_Session',
                                              tgl_Input=now() 
                                        WHERE id_DataDak = '$id_DataDak'");
        if ($qry)
            {
                header('location:../main.php?module=datadak');
            }
        else 
            {
                echo mysql_error();
            }

} elseif($act == "addsubdak" and $module == "datadak"){
      $id_SubDak = $_POST['id_SubDak'];
      $id_DataDak = $_POST['id_DataDak'];
      $nm_SubDak = $_POST['nm_SubDak'];
      $Volume = $_POST['Volume'];
      $Paket = $_POST['Paket'];
      $JpManfaat = $_POST['JpManfaat'];
      $anggDak = $_POST['anggDak'];
      $anggPendamping = $_POST['anggPendamping'];
      $pl_Swakelola = $_POST['pl_Swakelola'];
      $pl_Kontrak = $_POST['pl_Kontrak'];
      $id_Session = $_POST['id_Session'];


      $qry = mysql_query("INSERT INTO subdak (id_DataDak,
                                              nm_SubDak,
                                              Volume,
                                              Paket,
                                              JpManfaat,
                                              anggDak,
                                              anggPendamping,
                                              pl_Swakelola,
                                              pl_Kontrak,
                                              tgl_Input, 
                                              id_Session) 
                                      VALUES ('$id_DataDak',
                                              '$nm_SubDak',
                                              '$Volume',
                                              '$Paket',
                                              '$JpManfaat',
                                              '$anggDak',
                                              '$anggPendamping',
                                              '$pl_Swakelola',
                                              '$pl_Kontrak',
                                              now(), 
                                              '$id_Session')");
      
        if ($qry)
            {
                header("location:../main.php?module=datadak&act=subdak&id=$id_DataDak");
            }
        else 
            {
                echo mysql_error();
            }
      
} elseif($act == "editsubdak" and $module == "datadak"){
    if(isset($_POST['simpan'])) {
      $id_SubDak = $_POST['id_SubDak'];
      $id_DataDak = $_POST['id_DataDak'];
      $nm_SubDak = $_POST['nm_SubDak'];
      $Volume = $_POST['Volume'];
      $Paket = $_POST['Paket'];
      $JpManfaat = $_POST['JpManfaat'];
      $anggDak = $_POST['anggDak'];
      $anggPendamping = $_POST['anggPendamping'];
      $pl_Swakelola = $_POST['pl_Swakelola'];
      $pl_Kontrak = $_POST['pl_Kontrak'];
      $id_Session = $_POST['id_Session'];


      $qry = mysql_query("UPDATE subdak SET nm_SubDak='$nm_SubDak',
                                              Volume='$Volume',
                                              Paket='$Paket',
                                              JpManfaat='$JpManfaat',
                                              anggDak='$anggDak',
                                              anggPendamping='$anggPendamping',
                                              pl_Swakelola='$pl_Swakelola',
                                              pl_Kontrak='$pl_Kontrak',
                                              tgl_Input=now(), 
                                              id_Session='$id_Session'
                                  WHERE id_SubDak = $id_SubDak");
      
        if ($qry)
            {
                header("location:../main.php?module=datadak&act=subdak&id=$id_DataDak");
            }
        else 
            {
                echo mysql_error();
            }
    } else {
      if(isset($_POST['delete'])) {
        $id_SubDak = $_POST['id_SubDak'];
        $id_DataDak = $_POST['id_DataDak'];
        $qry = mysql_query("DELETE FROM subdak WHERE id_SubDak = '$id_SubDak'");
        if ($qry)
            {
                header("location:../main.php?module=datadak&act=subdak&id=$id_DataDak");
            }
        else 
            {
                echo mysql_error();
            }
      }
    }
      
} 