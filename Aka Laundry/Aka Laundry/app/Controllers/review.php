<?php

namespace App\Controllers;

use App\Models\TbReviewModel;
use CodeIgniter\HTTP\RedirectResponse;

class Review extends BaseController
{
    protected TbReviewModel $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new TbReviewModel();
    }

    /**
     * Submit review baru
     */
    public function submit(): RedirectResponse
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_cust' => 'required|min_length[2]|max_length[100]',
            'rating'    => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
            'komen'     => 'permit_empty|max_length[1000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('review_error', 'Gagal mengirim review. Pastikan data valid.');
        }

        $data = [
            'nama_cust'  => $this->request->getPost('nama_cust'),
            'rating'     => (int) $this->request->getPost('rating'),
            'komen'      => $this->request->getPost('komen') ?? '',
            'tgl_review' => date('Y-m-d H:i:s'),
        ];

        if ($this->reviewModel->insert($data)) {
            return redirect()->to(site_url('user/index') . '#review-section')
                ->with('review_success', 'Terima kasih atas review Anda!');
        }

        return redirect()->back()
            ->withInput()
            ->with('review_error', 'Gagal menyimpan review. Silakan coba lagi.');
    }

    /**
     * Get reviews (untuk AJAX jika diperlukan)
     */
    public function getReviews(): \CodeIgniter\HTTP\ResponseInterface
    {
        $reviews = $this->reviewModel
            ->orderBy('tgl_review', 'DESC')
            ->limit(10)
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data'    => $reviews,
        ]);
    }
}
