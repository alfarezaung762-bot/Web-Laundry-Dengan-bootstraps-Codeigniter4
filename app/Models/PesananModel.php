<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'tb_pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $allowedFields = [
        'no_resi',
        'id_pelanggan',
        'kd_jenis',
        'berat_kg',
        'status',
        'status_selesai',
        'tanggal_selesai',
        'created_at',
        'foto_transaksi',
        'id_admin',
        'nama_pencuci',
        'id_washer',
        'keterangan_cuci'
    ];

    // Ambil semua pesanan + data pelanggan, jenis laundry, dan nama kurir
    public function getPesanan()
    {
        return $this->select('
                tb_pesanan.*,
                tb_pelanggan.nama_pelanggan,
                tb_jenis.jenis_laundry,
                tb_jenis.tarif,
                admin.name AS nama_admin,
                washer.name AS nama_washer
            ')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = tb_pesanan.id_pelanggan')
            ->join('tb_jenis', 'tb_jenis.kd_jenis = tb_pesanan.kd_jenis')
            ->join('laundryku AS admin', 'admin.id = tb_pesanan.id_admin', 'left')
            ->join('laundryku AS washer', 'washer.id = tb_pesanan.id_washer', 'left')
            ->orderBy('id_pesanan', 'DESC')
            ->findAll();
    }

    // Ambil 1 pesanan berdasarkan no_resi (untuk tracking)
    public function getPesananByResi($resi)
    {
        return $this->select('
                tb_pesanan.*,
                tb_pelanggan.nama_pelanggan,
                tb_jenis.jenis_laundry,
                tb_jenis.tarif,
                washer.name AS nama_washer
            ')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = tb_pesanan.id_pelanggan')
            ->join('tb_jenis', 'tb_jenis.kd_jenis = tb_pesanan.kd_jenis')
            ->join('laundryku AS washer', 'washer.id = tb_pesanan.id_washer', 'left')
            ->where('no_resi', $resi)
            ->first();
    }

    // Ambil detail lengkap berdasarkan ID
    public function getDetailById($id)
    {
        return $this->select('
                tb_pesanan.*,
                tb_pesanan.id_washer,
                tb_pelanggan.nama_pelanggan,
                tb_pelanggan.alamat_pelanggan,
                tb_pelanggan.no_pelanggan,
                tb_jenis.jenis_laundry,
                tb_jenis.tarif,
                tb_pesanan.foto_transaksi,
                admin.name AS nama_admin,
                washer.name AS nama_washer
            ')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = tb_pesanan.id_pelanggan')
            ->join('tb_jenis', 'tb_jenis.kd_jenis = tb_pesanan.kd_jenis')
            ->join('laundryku AS admin', 'admin.id = tb_pesanan.id_admin', 'left')
            ->join('laundryku AS washer', 'washer.id = tb_pesanan.id_washer', 'left')
            ->where('tb_pesanan.id_pesanan', $id)
            ->first();
    }
}
