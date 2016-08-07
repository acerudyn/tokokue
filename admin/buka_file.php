<?php
if (isset($_GET ['open'])) {
 switch ($_GET['open']){
//untuk mengontrol menu				
	case '' :				
		if(!file_exists ("main.php")) die ("Empty Main Page!"); 
		 include "main.php";						
	break;
	
	default:
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
	 include "main.php";	 
    break;

//menjalankan link menu login	
	case 'Login' :				
		if(!file_exists ("login.php")) die ("Sorry Empty Page!"); 
		 include "login.php";						
	break;
	
	case 'Login-validasi' :				
		if(!file_exists ("login_validasi.php")) die ("Sorry Empty Page!"); 
		 include "login_validasi.php";						
	break;
	
	case 'Logout' :				
		if(!file_exists ("logout.php")) die ("Sorry Empty Page!"); 
		 include "logout.php";						
	break;
			
	case 'Halaman-Utama' :				
		if(!file_exists ("main.php")) die ("Sorry Empty Page!"); 
		 include "main.php";						
	break;	
	
	case 'Data' :				
		if(!file_exists ("data.php")) die ("Sorry Empty Page!"); 
		 include "data.php";						
	break;	
		
//password adm
	case 'Password-Adm' :				
		if(!file_exists ("password_adm.php")) die ("Sorry Empty Page!"); 
		 include "password_adm.php";						
	break;						

//data provinsi
	case 'Provinsi-Data' :				
		if(!file_exists ("provinsi_data.php")) die ("Sorry Empty Page!"); 
		 include "provinsi_data.php"; 
	break;		
	
	case 'Provinsi-Add' :				
		if(!file_exists ("provinsi_add.php")) die ("Sorry Empty Page!"); 
		 include "provinsi_add.php"; 
	break;		
	
	case 'Provinsi-Delete' :
		if(!file_exists ("provinsi_delete.php")) die ("Sorry Empty Page!"); 
		 include "provinsi_delete.php"; 
	break;	
		
	case 'Provinsi-Edit' :
		if(!file_exists ("provinsi_edit.php")) die ("Sorry Empty Page!"); 
		 include "provinsi_edit.php"; 
	break;

//jenis kategori
	case 'Kategori-Jenis' :
		if(!file_exists ("kategori_jenis.php")) die ("Sorry Empty Page!"); 
		 include "kategori_jenis.php"; 
	break;		
	
	case 'Kategori-Add' :
		if(!file_exists ("kategori_add.php")) die ("Sorry Empty Page!"); 
		 include "kategori_add.php";	 
	break;			
	
	case 'Kategori-Delete' :
		if(!file_exists ("kategori_delete.php")) die ("Sorry Empty Page!"); 
		 include "kategori_delete.php"; 
	break;		
	
	case 'Kategori-Edit' :
		if(!file_exists ("kategori_edit.php")) die ("Sorry Empty Page!"); 
		 include "kategori_edit.php"; 
	break;
		
//data barang
	case 'Barang-Data':				
		if(!file_exists ("barang_data.php")) die ("Sorry Empty Page!"); 
		 include "barang_data.php"; 
	break;		
	
	case 'Barang-Add':
		if(!file_exists ("barang_add.php")) die ("Sorry Empty Page!"); 
		 include "barang_add.php"; 
	break;		
	
	case 'Barang-Delete':
		if(!file_exists ("barang_delete.php")) die ("Sorry Empty Page!"); 
		 include "barang_delete.php"; 
	break;	
	
	case 'Barang-Edit':
		if(!file_exists ("barang_edit.php")) die ("Sorry Empty Page!"); 
		 include "barang_edit.php"; 
	break;

		
//pelanggan
	case 'Pelanggan-Data' :
		if(!file_exists ("pelanggan_data.php")) die ("Sorry Empty Page!"); 
		 include "pelanggan_data.php"; 
	break;
	
	case 'Pelanggan-Hapus' :
		if(!file_exists ("pelanggan_hapus.php")) die ("Sorry Empty Page!"); 
		 include "pelanggan_hapus.php"; 
	break;

//pembayaran
	case 'Konfirmasi-Bayar' :				
		if(!file_exists ("konfirmasi_pembayaran.php")) die ("Sorry Empty Page!"); 
		 include "konfirmasi_pembayaran.php"; 
	break;
	
	case 'Konfirmasi-Delete' :
		if(!file_exists ("konfirmasi_delete.php")) die ("Sorry Empty Page!"); 
		 include "konfirmasi_delete.php"; 
	break;
		
//pemesanan
	case 'Pemesanan-Barang' :				
		if(!file_exists ("pemesanan_barang.php")) die ("Sorry Empty Page!"); 
		 include "pemesanan_barang.php"; 
	break;
	
	case 'Pemesanan-Lihat' :				
		if(!file_exists ("pemesanan_cetak.php")) die ("Sorry Empty Page!"); 
		 include "pemesanan_cetak.php"; 
	break;
	
	case 'Pemesanan-Bayar' :				
		if(!file_exists ("pemesanan_bayar.php")) die ("Sorry Empty Page!"); 
		 include "pemesanan_bayar.php"; 
	break;
					
//master data
	case 'Laporan' :	
		if(!file_exists ("laporan.php")) die ("Sorry Empty Page!"); 
		 include "laporan.php";	
	break;						
		
//laporan
	case 'Laporan-Provinsi' :				
		if(!file_exists ("laporan_provinsi.php")) die ("Sorry Empty Page!"); 
		 include "laporan_provinsi.php"; 
	break;	
				
	case 'Laporan-Kategori' :				
		if(!file_exists ("laporan_kategori.php")) die ("Sorry Empty Page!"); 
		 include "laporan_kategori.php"; 
	break;	
					
	case 'Laporan-Barang' :	
		if(!file_exists ("laporan_barang.php")) die ("Sorry Empty Page!"); 
		 include "laporan_barang.php"; 
	break;
				
	case 'Laporan-Pelanggan' :
		if(!file_exists ("laporan_pelanggan.php")) die ("Sorry Empty Page!"); 
		 include "laporan_pelanggan.php"; 
	break;
				
	case 'Laporan-PemesananPeriode' :
		if(!file_exists ("lap_pemesananperoide.php")) die ("Sorry Empty Page!"); 
		 include "lap_pemesananperoide.php"; 
	break;
				
	case 'Laporan-PemesananLunas-Periode' :
		if(!file_exists ("lap_pemesananlunas_periode.php")) die ("Sorry Empty Page!"); 
		 include "lap_pemesananlunas_periode.php"; 
	break;
			
	case 'Laporan-PemesananLunas-Tanggal' :				
		if(!file_exists ("lap_pemesananlunas_tanggal.php")) die ("Sorry Empty Page!"); 
		 include "lap_pemesananlunas_tanggal.php"; 
	break;			
						

	}
}
?>