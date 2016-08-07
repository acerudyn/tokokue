<?php
date_default_timezone_set("Asia/Jakarta");

//skrip kode data otomatis
function buatKode($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);
	
	// membaca panjang kolom
	$hasil 		= mysql_fetch_field($struktur,0);
	//$panjang	= $hasil->max_length; 
	

 	$qry	= mysql_query("SELECT MAX(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka	= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}


//skrip membalik format tanggal d-m-y
function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$awal="$thn-$bln-$tgl";
	return $awal;
}


function IndonesiaTgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$awal="$tgl-$bln-$thn";
	return $awal;
}

//skrip memformat tampilan angka dalam nilai rupiah
function format_angka($angka) {
	if ($angka > 1) {
		$hasil =  number_format($angka,0, ",",".");
	}
	else {
		$hasil = 0; 
	}
	return $hasil;
}
?>