<?php

namespace App\Models;

use CodeIgniter\Model;

class Tb_Pelanggan extends Model

{
    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $allowedFields = [
        'nama_pelanggan',
        'jeniskelamin',
        'alamat_pelanggan',
        'no_pelanggan',
        'foto_pelanggan'
    ];
    
}
