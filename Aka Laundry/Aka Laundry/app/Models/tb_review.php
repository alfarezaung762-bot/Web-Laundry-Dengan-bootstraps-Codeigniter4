<?php

namespace App\Models;

use CodeIgniter\Model;

/** @extends Model<array> */
class TbReviewModel extends Model
{
    protected $table      = 'tb_review';
    protected $primaryKey = 'id_review';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama_cust',
        'rating',
        'komen',
        'tgl_review',
    ];

    // Validasi dasar
    protected $validationRules = [
        'nama_cust'  => 'required|min_length[2]',
        'rating'     => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'komen'      => 'permit_empty|max_length[1000]',
        'tgl_review' => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'nama_cust' => [
            'required'   => 'Nama customer wajib diisi.',
            'min_length' => 'Nama customer minimal 2 karakter.',
        ],
        'rating' => [
            'required'               => 'Rating wajib diisi.',
            'integer'                => 'Rating harus berupa angka.',
            'greater_than_equal_to'  => 'Rating minimal 1.',
            'less_than_equal_to'     => 'Rating maksimal 5.',
        ],
        'komen' => [
            'max_length' => 'Komen maksimal 1000 karakter.',
        ],
        'tgl_review' => [
            'valid_date' => 'Format tanggal review tidak valid.',
        ],
    ];

    // Auto set tgl_review saat insert jika kosong
    protected $beforeInsert = ['setReviewDate'];

    protected function setReviewDate(array $data): array
    {
        if (!isset($data['data']) || !is_array($data['data'])) return $data;

        $tgl = $data['data']['tgl_review'] ?? null;
        if ($tgl === null || trim((string)$tgl) === '') {
            $data['data']['tgl_review'] = date('Y-m-d H:i:s');
        }

        return $data;
    }

    /**
     * Ambil review terbaru untuk ditampilkan di halaman publik
     */
    public function getLatestReviews(int $limit = 10): array
    {
        return $this->orderBy('tgl_review', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Hitung rata-rata rating
     */
    public function getAverageRating(): float
    {
        $result = $this->selectAvg('rating', 'avg_rating')->first();
        return round((float)($result['avg_rating'] ?? 0), 1);
    }

    /**
     * Hitung total review
     */
    public function getTotalReviews(): int
    {
        return (int) $this->countAllResults();
    }
}
