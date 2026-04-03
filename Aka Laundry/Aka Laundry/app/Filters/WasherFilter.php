<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class WasherFilter implements FilterInterface
{
        public function before(RequestInterface $request, $arguments = null)
        {
            $session = session();
            if (!$session->get('logged_in')) {
                return redirect()->to('/login/index')->with('error', 'Silakan login terlebih dahulu.');
            }
            if($session->get('level') != 'washer'){
                session()->setFlashdata('error', 'anda bukan washer');
                return redirect()->back();
            }
        }
    
        public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
        {
            // Do nothing here
        }
    }