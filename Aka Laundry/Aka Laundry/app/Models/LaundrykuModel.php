<?php

namespace App\Models;

use CodeIgniter\Model;

/** @extends Model<array> */
class LaundrykuModel extends Model
{
    protected $table = 'laundryku';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // Field yang dipakai untuk login/akun (role sudah dihapus; gunakan level).
    // 'password' disimpan dalam bentuk hash (password_hash/password_verify).
    protected $allowedFields = ['username', 'password', 'level', 'name'];

    // Validasi dipakai untuk create & update (password optional saat update).
    // Catatan: 'level' tidak dibuat required di rules karena update profil tidak mengirim field level.
    // Catatan: rule password hanya validasi panjang; hashing tetap dilakukan di controller (password_hash).
    protected $validationRules = [
        'username' => 'required|min_length[3]',
        'name'     => 'required|min_length[2]',
        'password' => 'permit_empty|min_length[8]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Username wajib diisi.',
            'min_length' => 'Username minimal 3 karakter.',
        ],
        'name' => [
            'required'   => 'Nama wajib diisi.',
            'min_length' => 'Nama minimal 2 karakter.',
        ],
        'password' => [
            'min_length' => 'Password minimal 8 karakter.',
        ],
    ];

    // Model ini untuk akun/login. Status pesanan di-handle oleh model/controller pesanan.
    // (tidak terkait error kolom id_kurir; perubahan kurir ada di PesananModel/PesananController)
}
