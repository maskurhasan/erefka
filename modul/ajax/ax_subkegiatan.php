<?php
include "../config/koneksi.php";

//mengambil data desa
$postur = $_POST[id_SubKegiatan];
$sql1 = 'SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"';
$result1 = mysql_query($sql1);
while($dt = mysql_fetch_array($result1)) {
	
    echo "udin bebe";
}

?>