<?php

namespace App\Models;

use CodeIgniter\Model;

class PickupModel extends Model
{
    protected $table = 'pickup';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pelanggan', 'alamat', 'status', 'id_kurir', 'waktu_request', 'waktu_selesai', 'created_at'];

    public function getPickupWithPelanggan()
    {
        return $this->select('pickup.*, tb_pelanggan.nama_pelanggan')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = pickup.id_pelanggan')
            ->where('pickup.status !=', 'Selesai')
            ->findAll();
    }

    public function getRiwayatPickupSelesai($id_kurir = null)
    {
        $builder = $this->select('pickup.*, tb_pelanggan.nama_pelanggan, laundryku.name AS nama_kurir')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = pickup.id_pelanggan')
            ->join('laundryku', 'laundryku.id = pickup.id_kurir', 'left')
            ->where('pickup.status', 'Selesai')
            ->orderBy('pickup.id', 'DESC');

        if ($id_kurir) {
            $builder->where('pickup.id_kurir', $id_kurir);
        }

        return $builder->findAll();
    }
    public function getUserPickup()
    {
        return $this->select('pickup.*, tb_pelanggan.nama_pelanggan, tb_pelanggan.no_pelanggan, tb_pelanggan.alamat_pelanggan')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = pickup.id_pelanggan')
            ->where('pickup.status', 'Menunggu Pickup')
            ->orderBy('pickup.id', 'DESC')
            ->findAll();
    }
}