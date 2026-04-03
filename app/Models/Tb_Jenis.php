<?php

namespace App\Models;

use CodeIgniter\Model;

class Tb_Jenis extends Model
{
    protected $table = 'tb_jenis'; //masukan tabel
    protected $primaryKey = 'kd_jenis'; //primary
    protected $returnType = 'array';

    protected $allowedFields = [
        'jenis_laundry',
        'deskripsi',
        'tarif'
    ]; //ini untuk menentukan field mana saja yang boleh diisi di data base

    public function getAllForPublic(): array
    {
        return $this->orderBy('tarif', 'ASC')->findAll() ?? [];
    }
}
