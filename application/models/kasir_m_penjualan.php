<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_m_penjualan extends CI_Model {

    public function __construct() {
        $this->db = $this->load->database('dbkasir', true);
    }

    public function nomor_invoice($id_kasir) {
        $this->db->where('id_kasir', $id_kasir);
        return $this->db->count_all_results('laporan_penjualan');
    }

    public function cari_pelanggan($keyword) {
        $this->db->select('id_pelanggan, nama_pelanggan, level');
        $this->db->from('pelanggan');
        $this->db->where('level', 4);
        $this->db->like('nama_pelanggan', $keyword);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function lihat_barang() {
        $query = $this->db->get('barang');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function tambah_laporan_penjualan($input_laporan_penjualan) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->insert('laporan_penjualan', $input_laporan_penjualan);
    }

    public function tambah_detail_penjualan($detail_penjualan) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->insert('detail_penjualan', $detail_penjualan);
    }

    public function tambah_laporan_penjualan_pusat($input_laporan_penjualan) {
        $this->load->database();

        $this->db->insert('laporan_penjualan', $input_laporan_penjualan);
    }

    public function tambah_detail_penjualan_pusat($detail_penjualan) {
        $this->load->database();

        $this->db->insert('detail_penjualan', $detail_penjualan);
    }

    public function perbarui_stok_barang($id_barang, $id_toko, $jumlah) {
        $this->load->database();

        $query = 'UPDATE stok_barang SET stok_barang = stok_barang - ' . $jumlah;
        $query .= ' WHERE id_barang = "' . $id_barang . '" AND id_toko = "' . $id_toko . '"';
        $this->db->query($query); 
    }

    public function perbarui_status_penjualan_lokal($id_invoice) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->set('status_upload', 1);
        $dbkasir->where('id_invoice', $id_invoice);
        $dbkasir->update('laporan_penjualan');
    }
}
?>