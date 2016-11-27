<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "realisasidak") {
    if(isset($_POST[simpanx])) { //add data
        $id_DataDak = $_POST['id_DataDak'];
        $id_RealisasiDak = $_POST['id_RealisasiDak'];
        $id_SubDak = $_POST['id_SubDak'];
        $id_Bulan = $_POST['id_Bulan'];
        $rls_Dak = $_POST['rls_Dak'];
        $rls_Pendamping = $_POST['rls_Pendamping'];
        $per_Fisik = $_POST['per_Fisik'];
        $per_Keu = $_POST['per_Keu'];
        $SesuaiRkpd = $_POST['SesuaiRkpd'];
        $SesuaiTeknis = $_POST['SesuaiTeknis'];
        $tx_Keterangan = $_POST['tx_Keterangan'];
        $id_Session = $_SESSION['Sessid'];
        
        $qry = mysql_query("INSERT INTO realisasidak (id_SubDak, 
                                              id_Bulan, 
                                              rls_Dak, 
                                              rls_Pendamping, 
                                              per_Fisik, 
                                              per_Keu, 
                                              SesuaiRkpd,
                                              SesuaiTeknis,
                                              tgl_Input, 
                                              id_Session) 
                                      VALUES ('$id_SubDak', 
                                              '$id_Bulan', 
                                              '$rls_Dak', 
                                              '$rls_Pendamping', 
                                              '$per_Fisik', 
                                              '$per_Keu', 
                                              '$SesuaiRkpd',
                                              '$SesuaiTeknis', 
                                              now(), 
                                              '$id_Session')");
        if ($qry)
            {
                header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
            }
        else 
            {
                echo mysql_error();
            }
    } else {

        for ($i=0; $i <=12 ; $i++) { 
          if(isset($_POST['delete'.$i])) {
            $id_DataDak = $_POST['id_DataDak'];
            $id_RealisasiDak = $_POST['id_RealisasiDak'.$i];
            $qry = mysql_query("DELETE FROM realisasidak WHERE id_RealisasiDak ='$id_RealisasiDak'");
            if ($qry)
            {
                header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
            }
        else 
            {
                echo mysql_error();
            }
          }
        }
    }
        //EDIT
        for ($i=0;$i<=12;$i++) {
            if(isset($_POST['simpan'.$i])) {
                $id_DataDak = $_POST['id_DataDak'];
                $id_RealisasiDak = $_POST['id_RealisasiDak'.$i];
                $id_SubDak = $_POST['id_SubDak'];
                $id_Bulan = $_POST['id_Bulan'];
                $rls_Dak = $_POST['rls_Dak'.$i];
                $rls_Pendamping = $_POST['rls_Pendamping'.$i];
                $per_Fisik = $_POST['per_Fisik'.$i];
                $per_Keu = $_POST['per_Keu'.$i];
                $SesuaiRkpd = $_POST['SesuaiRkpd'];
                $SesuaiTeknis = $_POST['SesuaiTeknis'];
                $tx_Keterangan = $_POST['tx_Keterangan'];
                $id_Session = $_SESSION['Sessid'];

                $qry = mysql_query("UPDATE realisasidak SET rls_Dak = '$rls_Dak', rls_Pendamping = '$rls_Pendamping',
                                                            per_Fisik='$per_Fisik'
                                    WHERE id_RealisasiDak = '$id_RealisasiDak'");

                if ($qry)
                    {
                        header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
                    }
                else 
                    {
                        echo mysql_error();
                    }
            }
        }
} elseif($act == "addlamp" and $module == "realisasidak"){
        if(isset($_POST['upload'])) {
            $id_DataDak = $_POST['id_DataDak'];
            $id_RealisasiDak = $_POST['id_Bulanlamp'];
            $Caption = $_POST['Caption'];

            $nm_file = basename($_FILES['nm_LampRealisasiDak']['name']);
            $extension = end(explode(".", $nm_file));
            $gantinama = $id_DataDak."_".$id_RealisasiDak."_".acaknmfile();
            $nm_folder = "image/syaratdokumen/"; //nama folder simpan gambar
            
            $nm_FileUpload = $gantinama.'.'.$extension;
            $pindah_foto = move_uploaded_file($_FILES['nm_LampRealisasiDak']['tmp_name'], '../../image/dak/'.$gantinama.'.'.$extension);
            
            if($pindah_foto AND !empty($nm_file)) {
                $qry = mysql_query("INSERT INTO lamprealisasidak (id_RealisasiDak, nm_LampRealisasiDak,Caption,tgl_Input,id_Session)
                                    VALUES ('$id_RealisasiDak','$nm_FileUpload','$Caption',now(),'$_SESSION[Sessid]')");
                    if ($qry)
                    {
                        header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
                    }
                else 
                    {
                        echo mysql_error();
                    }
            }
        
        } else {
            for ($i=0; $i <=12 ; $i++) { 
              if(isset($_POST['delete'.$i])) {
                $id_DataDak = $_POST['id_DataDak'];
                $id_LampRealisasiDak = $_POST['id_LampRealisasiDak'.$i];
                $nm_LampRealisasiDak = $_POST['nm_LampRealisasiDak'.$i];
                $qry = mysql_query("DELETE FROM lamprealisasiDak WHERE id_LampRealisasiDak ='$id_LampRealisasiDak'");

                if($qry) {
                    chdir('../../image/dak');
                    $hapusfile = unlink($nm_LampRealisasiDak);
                    if($hapusfile == "1") {
                        header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
                    } else {
                        echo "Gagal dihapus";
                    }
                }
              }
            }
        }

        

} elseif($act == "masalah" and $module == "realisasidak"){
        if(isset($_POST['masalah'])) {
            $id_DataDak = $_POST['id_DataDak'];
            $id_RealisasiDak = $_POST['id_Bulanlamp'];
            $nm_PermasalahanDak = $_POST['nm_PermasalahanDak'];
            $nm_SolusiDak = $_POST['nm_SolusiDak'];
            
            $qry = mysql_query("INSERT INTO lamppermasalahandak (id_RealisasiDak, nm_PermasalahanDak,nm_SolusiDak,tgl_Input,id_Session)
                                    VALUES ('$id_RealisasiDak','$nm_PermasalahanDak','$nm_SolusiDak',now(),'$_SESSION[Sessid]')");
                if ($qry)
                    {
                        header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
                    }
                else 
                    {
                        echo mysql_error();
                    }
        } else {
            for ($i=0; $i <=12 ; $i++) { 
              if(isset($_POST['delete'.$i])) {
                $id_DataDak = $_POST['id_DataDak'];
                $id_LampPermasalahanDak = $_POST['id_LampPermasalahanDak'.$i];
                $qry = mysql_query("DELETE FROM lamppermasalahandak WHERE id_LampPermasalahanDak ='$id_LampPermasalahanDak'");

                if($qry) {
                    header("location:../main.php?module=realisasidak&act=add&id=$id_DataDak");
                    } else {
                        echo mysql_error();
                    }
                }
              }
        }

} 