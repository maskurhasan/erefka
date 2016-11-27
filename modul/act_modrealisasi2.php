<?php
//exit();
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";

//memanggil file excel_reader
require "../../config/excel_reader.php";

//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['fileimport']['name']) ;
    move_uploaded_file($_FILES['fileimport']['tmp_name'], $target);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['fileimport']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    if($_POST['drop']==1){
//             kosongkan tabel pegawai
             $truncate ="TRUNCATE TABLE spj";
             mysql_query($truncate);
    };
    
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//        menghitung jumlah real data. Karena kita mulai pada baris ke-2, maka jumlah baris yang sebenarnya adalah 
//        jumlah baris data dikurangi 1. Demikian juga untuk awal dari pengulangan yaitu i juga dikurangi 1
        $barisreal = $baris-1;
        $k = $i-1;
        
// menghitung persentase progress
        $percent = intval($k/$barisreal * 100)."%";

// mengupdate progress
        echo '<script language="javascript">
        document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'; background-color:lightblue\">&nbsp;</div>";
        document.getElementById("info").innerHTML="'.$k.' data berhasil diinsert ('.$percent.' selesai).";
        </script>';

//       membaca data (kolom ke-1 sd terakhir)
      $no = $data->val($i,1);
      $norek = $data->val($i,2);
      $pecah = substr($norek,7,5);
      $rek = str_replace('.', '', $pecah);
      $unit = str_replace('.','',substr($norek,0,4));
      $id_Kegiatan = $unit.$rek;
      $nobukti = $data->val($i,3);
      $tanggal = $data->val($i,4);
      //konversi tanggal ke format mysql
      $tgl = date('Y-m-d',strtotime($tanggal));
      $tglhasil = $tgl[2]."-".$tgl[1]."-".$tgl[0];
      $namarek = $data->val($i,5); 
      $nilai = $data->val($i,6);
      $belanja = str_replace(',','', substr($nilai,0,-3));
      $id_Skpd = $_SESSION['id_Skpd'];
      $TahunAnggaran = $_SESSION['thn_Login'];
    //setelah data dibaca, masukkan ke tabel pegawai sql
      $query1 = "INSERT into pegawai (nama,tempat_lahir,tanggal_lahir)values('$nama','$tempat_lahir','$tanggal_lahir')";
      $query = "INSERT into realisasi2 (id_Kegiatan,NomorBukti,Tanggal,UraianBelanja,NilaiBelanja,id_Skpd,TahunAnggaran) values ('$id_Kegiatan','$nobukti','$tgl','$namarek','$belanja','$id_Skpd','$TahunAnggaran')";
      
      $hasil = mysql_query($query);

      flush();

//      kita tambahkan sleep agar ada penundaan, sehingga progress terbaca bila file yg diimport sedikit
//      pada prakteknya sleep dihapus aja karena bikin lama hehe
      //sleep(1);

    }
        
//    hapus file xls yang udah dibaca
  //unlink($_FILES['filepegawaiall']['name']);
}

?>