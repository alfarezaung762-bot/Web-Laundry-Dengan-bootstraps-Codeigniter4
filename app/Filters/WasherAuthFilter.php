<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class WasherAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $level = session()->get('level');

        // izinkan washer (opsional: admin/superadmin juga boleh masuk halaman washer)
        if (!in_array($level, ['washer', 'admin', 'superadmin'], true)) {
            return redirect()->to(base_url('/login/tolak'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
