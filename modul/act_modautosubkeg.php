<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";

//exit();
$module = $_GET['module'];
$act = $_GET['act'];



if ($act == "add" and $module == "autosubkeg") {
		    if(isset($_POST['Simpan'])) {
            /*
            $id_SubKegiatan = $_POST['id_SubKegiatan'];
            $id_Desa = $_POST['id_Desa'];
            $AlamatLokasi = $_POST['AlamatLokasi'];
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $nm_SubKegiatan = $_POST['nm_SubKegiatan'];
            $nl_Pagu = $_POST['nl_Pagu'];
            $nl_Fisik = $_POST['nl_Fisik'];
            $nl_Kontrak = $_POST['nl_Kontrak'];
            $nl_Pagu = $_POST['nl_Pagu'];
            $jml_Volume = $_POST['jml_Volume'];
            $id_SbDana = $_POST['id_SbDana'];
            $no_Kontrak = $_POST['no_Kontrak'];
            $JnsSubKeg = $_POST['JnsSubKeg'];
            $Pelaksana = $_POST['Pelaksana'];
            $konsPerencana = $_POST['konsPerencana'];
            $konsPengawas = $_POST['konsPengawas'];
            $tgl_Mulai = $_POST['tgl_Mulai'];
            $tgl_Selesai = $_POST['tgl_Selesai'];
            $trg_Fisik = $_POST['trg_Fisik'];
            $trg_Keu1 = $_POST['trg_Keu1'];
            $trg_Keu2 = $_POST['trg_Keu2'];
            $trg_Keu3 = $_POST['trg_Keu3'];
            $trg_Keu4 = $_POST['trg_Keu4'];
            $tgl_Input = $_POST['tgl_Input'];
            $id_Session = $_SESSION['Sessid'];
            */
          //$qw = mysql_query("DELETE FROM aksesmodul WHERE id_User = '$id_User'");
          //if($qw) {
              for ($i=0 ; $i < count($_POST['id_DataKegiatan']);$i++) {
                  //$id_DataKegiatanx = $id_DataKegiatan[$i];
                  $id_SubKegiatan = $_POST['id_SubKegiatan'][$i];
                  $id_Desa = $_POST['id_Desa'][$i];
                  $AlamatLokasi = $_POST['AlamatLokasi'][$i];
                  $id_DataKegiatan = $_POST['id_DataKegiatan'][$i];
                  $nm_SubKegiatan = $_POST['nm_SubKegiatan'][$i];
                  $nl_Pagu = $_POST['nl_Pagu'][$i];
                  $nl_Fisik = $_POST['nl_Fisik'][$i];
                  $nl_Kontrak = $_POST['nl_Kontrak'][$i];
                  $nl_Pagu = $_POST['nl_Pagu'][$i];
                  $jml_Volume = $_POST['jml_Volume'][$i];
                  $id_SbDana = $_POST['id_SbDana'][$i];
                  $no_Kontrak = $_POST['no_Kontrak'][$i];
                  $JnsSubKeg = $_POST['JnsSubKeg'][$i];
                  $Pelaksana = $_POST['Pelaksana'][$i];
                  $konsPerencana = $_POST['konsPerencana'][$i];
                  $konsPengawas = $_POST['konsPengawas'][$i];
                  $tgl_Mulai = $_POST['tgl_Mulai'][$i];
                  $tgl_Selesai = $_POST['tgl_Selesai'][$i];
                  $trg_Fisik = $_POST['trg_Fisik'][$i];
                  $trg_Keu1 = $_POST['trg_Keu1'][$i];
                  $trg_Keu2 = $_POST['trg_Keu2'][$i];
                  $trg_Keu3 = $_POST['trg_Keu3'][$i];
                  $trg_Keu4 = $_POST['trg_Keu4'][$i];
                  $AddType = 'a';
                  //$tgl_Input = $_POST['tgl_Input'][$i];
                  //$id_Session = $_SESSION['Sessid'][$i];
                  //$qss = mysql_query("INSERT INTO subkegiatan (id_Desa,AlamatLokasi,id_DataKegiatan) 
                  //                  VALUES ('$id_Desa','$AlamatLokasi','$id_DataKegiatan')");
                  $q = mysql_query("INSERT INTO subkegiatan (id_Desa,
                                                AlamatLokasi, 
                                                id_DataKegiatan, 
                                                JnsSubKeg,
                                                nm_SubKegiatan, 
                                                nl_Pagu, 
                                                nl_Fisik,
                                                nl_Kontrak,
                                                jml_Volume, 
                                                id_SbDana, 
                                                no_Kontrak,
                                                Pelaksana,
                                                konsPerencana,
                                                konsPengawas,
                                                tgl_Mulai,
                                                tgl_Selesai,
                                                trg_Fisik,
                                                trg_Keu1,
                                                trg_Keu2,
                                                trg_Keu3,
                                                trg_Keu4,
                                                tgl_Input,
                                                id_Session,
                                                AddType) 
                                        VALUES ('$id_Desa',
                                                '$AlamatLokasi', 
                                                '$id_DataKegiatan',
                                                '$JnsSubKeg', 
                                                '$nm_SubKegiatan', 
                                                '$nl_Pagu', 
                                                '$nl_Fisik',
                                                '$nl_Kontrak',
                                                '$jml_Volume', 
                                                '$id_SbDana', 
                                                '$no_Kontrak',
                                                '$Pelaksana',
                                                '$konsPerencana',
                                                '$konsPengawas',
                                                '$tgl_Mulai',
                                                '$tgl_Selesai',
                                                '$trg_Fisik',
                                                '$trg_Keu1',
                                                '$trg_Keu2',
                                                '$trg_Keu3',
                                                '$trg_Keu4',
                                                now(),
                                                '$id_Session',
                                                '$AddType')");    
              }
              if ($q) {
                header('Location:../main.php?module=autosubkeg');
              } else {
                echo mysql_error();
              }
          //}
        } else { echo "gagal"; } 
        
}  
