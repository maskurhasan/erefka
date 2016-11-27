<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "dataapbn") {
        $id_DataApbn = $_POST['id_DataApbn'];
		    $id_BidangApbn = $_POST['id_BidangApbn'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $Keterangan = $_POST['Keterangan'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        
        $qry = mysql_query("INSERT INTO dataapbn (id_BidangApbn, 
                                              TahunAnggaran, 
                                              id_Skpd, 
                                              id_Ppk,
                                              Keterangan, 
                                              id_Session,
                                              tgl_Input) 
                                      VALUES ('$id_BidangApbn', 
                                              '$TahunAnggaran', 
                                              '$id_Skpd', 
                                              '$id_Ppk',
                                              '$Keterangan', 
                                              '$id_Session',
                                              now())");
        if ($qry)
            {
                header('location:../main.php?module=dataapbn');
            }
        else 
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "dataapbn"){
        $id_DataApbn = $_POST['id_DataApbn'];
        $id_BidangApbn = $_POST['id_BidangApbn'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $Keterangan = $_POST['Keterangan'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        $qry = mysql_query("UPDATE dataapbn SET Keterangan = '$Keterangan', 
                                              id_Ppk='$id_Ppk', 
                                              id_Session='$id_Session',
                                              tgl_Input=now() 
                                        WHERE id_DataApbn = '$id_DataApbn'");
        if ($qry)
            {
                header('location:../main.php?module=dataapbn');
            }
        else 
            {
                echo mysql_error();
            }
/*
CREATE TABLE IF NOT EXISTS `subapbn` (
  `id_SubApbn` int(11) NOT NULL auto_increment,
  `id_DataApbn` int(11) NOT NULL,
  `nm_SubApbn` varchar(100) NOT NULL,
  `id_JnsApbn` tinyint(1) NOT NULL,
  `anggApbn` decimal(15,2) NOT NULL,
  `anggPhln` decimal(15,2) NOT NULL,
  `pl_Swakelola` decimal(15,2) NOT NULL,
  `pl_Kontrak` decimal(15,2) NOT NULL,
  `tgl_Input` datetime NOT NULL,
  `id_Session` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_SubApbn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

*/
} elseif($act == "addsubapbn" and $module == "dataapbn"){
      $id_SubApbn = $_POST['id_SubApbn'];
      $id_DataApbn = $_POST['id_DataApbn'];
      $nm_SubApbn = $_POST['nm_SubApbn'];
      $id_JnsApbn = $_POST['id_JnsApbn'];
      $anggApbn = $_POST['anggApbn'];
      $anggPhln = $_POST['anggPhln'];
      $pl_Swakelola = $_POST['pl_Swakelola'];
      $pl_Kontrak = $_POST['pl_Kontrak'];
      $id_Session = $_POST['id_Session'];


      $qry = mysql_query("INSERT INTO subapbn (id_DataApbn,
                                              nm_SubApbn,
                                              id_JnsApbn,
                                              anggApbn,
                                              anggPhln,
                                              pl_Swakelola,
                                              pl_Kontrak,
                                              tgl_Input, 
                                              id_Session) 
                                      VALUES ('$id_DataApbn',
                                              '$nm_SubApbn',
                                              '$id_JnsApbn',
                                              '$anggApbn',
                                              '$anggPhln',
                                              '$pl_Swakelola',
                                              '$pl_Kontrak',
                                              now(), 
                                              '$id_Session')");
      
        if ($qry)
            {
                header("location:../main.php?module=dataapbn&act=subapbn&id=$id_DataApbn");
            }
        else 
            {
                echo mysql_error();
            }
      
} elseif($act == "editsubapbn" and $module == "dataapbn"){
    if(isset($_POST['simpan'])) {
      $id_SubApbn = $_POST['id_SubApbn'];
      $id_DataApbn = $_POST['id_DataApbn'];
      $nm_SubApbn = $_POST['nm_SubApbn'];
      $id_JnsApbn = $_POST['id_JnsApbn'];
      $anggApbn = $_POST['anggApbn'];
      $anggPhln = $_POST['anggPhln'];
      $pl_Swakelola = $_POST['pl_Swakelola'];
      $pl_Kontrak = $_POST['pl_Kontrak'];
      $id_Session = $_POST['id_Session'];


      $qry = mysql_query("UPDATE subapbn SET nm_SubApbn='$nm_SubApbn',
                                              id_JnsApbn='$id_JnsApbn',
                                              anggApbn='$anggApbn',
                                              anggPhln='$anggPhln',
                                              pl_Swakelola='$pl_Swakelola',
                                              pl_Kontrak='$pl_Kontrak',
                                              tgl_Input=now(), 
                                              id_Session='$id_Session'
                                  WHERE id_SubApbn = $id_SubApbn");
      
        if ($qry)
            {
                header("location:../main.php?module=dataapbn&act=subapbn&id=$id_DataApbn");
            }
        else 
            {
                echo mysql_error();
            }
    } else {
      if(isset($_POST['delete'])) {
        $id_SubApbn = $_POST['id_SubApbn'];
        $id_DataApbn = $_POST['id_DataApbn'];
        $qry = mysql_query("DELETE FROM subapbn WHERE id_SubApbn = '$id_SubApbn'");
        if ($qry)
            {
                header("location:../main.php?module=dataapbn&act=subapbn&id=$id_DataApbn");
            }
        else 
            {
                echo mysql_error();
            }
      }
    }
      
} 