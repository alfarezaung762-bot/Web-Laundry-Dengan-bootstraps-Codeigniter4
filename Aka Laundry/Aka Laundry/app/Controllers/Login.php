<?php

namespace App\Controllers;

use App\Models\LaundrykuModel;

class Login extends BaseController
{
    public const MIN_PASSWORD_LENGTH = 8;

    public function index()
    {
        return view('/auth/login');
    }

    public function action()
    {
        $session = session();
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            session()->setFlashdata('error', 'Username dan Password wajib diisi');
            return redirect()->to('/login/index');
        }

        $usercek = new LaundrykuModel();
        $cek = $usercek->where('username', $username)->first();

        if ($cek) {
            $cekpassword = password_verify($password, $cek['password']);
            if ($cekpassword) {
                // ✅ Tambahkan id ke dalam session (role dihapus; gunakan level saja)
                $sessdata = [
                    'id'        => $cek['id'],           // ID user dari tabel laundryku
                    'username'  => $cek['username'],
                    'level'     => $cek['level'],
                    'name'      => $cek['name'],
                    'logged_in' => TRUE,
                    'last_login'=> date('Y-m-d H:i:s'),
                ];
                $session->set($sessdata);

                switch ($cek['level']) {
                    case 'superadmin':
                        return redirect()->to('/login/dashboard'); // arahkan ke dashboard yang sama seperti admin
                    case 'admin':
                        return redirect()->to('/login/dashboard');
                    case 'washer':
                        return redirect()->to('/login/washer');
                    case 'kurir':
                        return redirect()->to('/login/kurir');
                    default:
                        session()->setFlashdata('error', 'Level tidak dikenali');
                        return redirect()->to('/login/index');
                }
            } else {
                session()->setFlashdata('error', 'Password Salah');
                return redirect()->to('/login/index');
            }
        } else {
            session()->setFlashdata('error', 'Username atau Password Salah');
            return redirect()->to('/login/index');
        }
    }



    //admin
    public function dashboard()
    {
        return view('/auth/dashboard');
    }

    //pencuci
    public function washer()
    {
        return view('/washer/profile');
    }

    //kurir
    public function kurir()
    {
        return view('/kurir/profile');
    }
    //tolak akses
    public function tolak()
    {
        return view('/washer/tolak');
    }
    public function tolak2()
    {
        return view('/kurir/tolak');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login/index')->with('success', 'Berhasil logout');
    }

    public function templates()
    {

        return view('auth/dashboard');
    }

    // GET: form edit profil user yang sedang login
    public function editProfile()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login/index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id = (int) $session->get('id');
        $model = new LaundrykuModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to('/login/index')->with('error', 'User tidak ditemukan.');
        }

        return view('adminakses/edit', [
            'user'            => $user,
            'showLevelSelect' => false,
            'formAction'      => base_url('/login/updateProfile'),
            'backUrl'         => base_url('/login/dashboard'),
        ]);
    }

    // POST: update profil user yang sedang login
    public function updateProfile()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login/index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id = (int) $session->get('id');

        $name = trim((string) $this->request->getPost('name'));
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password'); // optional

        if ($name === '' || $username === '') {
            return redirect()->back()->withInput()->with('error', 'Nama dan Username wajib diisi.');
        }

        $data = [
            'name'     => $name,
            'username' => $username,
        ];

        if ($password !== '') {
            if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
                return redirect()->back()->withInput()->with('error', 'Password minimal 8 karakter.');
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model = new LaundrykuModel();
        if (!$model->update($id, $data)) {
            $errs = $model->errors();
            $msg = $errs ? implode(' ', $errs) : 'Gagal memperbarui profil.';
            return redirect()->back()->withInput()->with('error', $msg);
        }

        // sinkronkan session
        $session->set([
            'name'     => $data['name'],
            'username' => $data['username'],
        ]);

        return redirect()->to('/login/dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
