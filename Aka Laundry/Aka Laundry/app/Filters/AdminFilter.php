<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login/index')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array($session->get('level'), ['admin', 'superadmin'])) {
            session()->setFlashdata('error', 'Akses ditolak. Anda bukan admin/superadmin.');
            return redirect()->back();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah response
    }
}
