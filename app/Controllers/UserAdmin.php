<?php

namespace App\Controllers;

use App\Models\LaundrykuModel;

class UserAdmin extends BaseController
{
    // 🛡️ Validasi agar hanya admin/superadmin yang bisa akses
    private function checkAccess()
    {
        $level = (string) session()->get('level');
        if (!in_array($level, ['superadmin', 'admin'], true)) {
            return redirect()->to('/login/index')->with('error', 'Akses hanya untuk ADMIN / SUPERADMIN');
        }
    }

    private function isSuperadmin(): bool
    {
        return ((string) session()->get('level')) === 'superadmin';
    }

    private function isAdmin(): bool
    {
        return ((string) session()->get('level')) === 'admin';
    }

    private function getUserOr404(int $id): array
    {
        $model = new LaundrykuModel();
        $user = $model->find($id);

        if (!$user) {
            // fallback aman tanpa membuat file baru (CI akan tampilkan 404 default)
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }
        return $user;
    }

    private function ensureCanManageTarget(array $targetUser)
    {
        // superadmin: boleh semua
        if ($this->isSuperadmin()) return;

        // admin: hanya boleh kelola washer
        if ($this->isAdmin() && (($targetUser['level'] ?? '') === 'washer')) return;

        return redirect()->to('/useradmin')->with('error', 'Admin hanya boleh mengelola user level WASHER.');
    }

    public function index()
    {
        if ($res = $this->checkAccess()) return $res;

        $model = new LaundrykuModel();
        $data['users'] = $model->findAll();
        return view('adminakses/index', $data);
    }

    public function create()
    {
        if ($res = $this->checkAccess()) return $res;

        // admin dilarang create
        if (!$this->isSuperadmin()) {
            return redirect()->to('/useradmin')->with('error', 'Hanya SUPERADMIN yang boleh menambah user.');
        }

        return view('adminakses/create');
    }

    public function store()
    {
        if ($res = $this->checkAccess()) return $res;

        // admin dilarang store
        if (!$this->isSuperadmin()) {
            return redirect()->to('/useradmin')->with('error', 'Hanya SUPERADMIN yang boleh menambah user.');
        }

        $model = new LaundrykuModel();
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $model->insert([
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'level'    => $this->request->getPost('level'), // ✅ bisa superadmin
            'role'     => $this->request->getPost('role')
        ]);

        return redirect()->to('/useradmin')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if ($res = $this->checkAccess()) return $res;

        $id = (int) $id;
        $user = $this->getUserOr404($id);
        if ($res = $this->ensureCanManageTarget($user)) return $res;

        $data['user'] = $user;
        // admin tidak boleh ubah level
        $data['showLevelSelect'] = $this->isSuperadmin();

        return view('adminakses/edit', $data);
    }

    public function update($id)
    {
        if ($res = $this->checkAccess()) return $res;

        $id = (int) $id;
        $target = $this->getUserOr404($id);
        if ($res = $this->ensureCanManageTarget($target)) return $res;

        $model = new LaundrykuModel();

        $data = [
            'name'     => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
        ];

        // superadmin boleh ubah level; admin dipaksa tetap washer
        if ($this->isSuperadmin()) {
            $data['level'] = $this->request->getPost('level');
        } else {
            $data['level'] = 'washer';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);
        return redirect()->to('/useradmin')->with('success', 'User berhasil diperbarui!');
    }

    public function delete($id)
    {
        if ($res = $this->checkAccess()) return $res;

        $id = (int) $id;
        $target = $this->getUserOr404($id);
        if ($res = $this->ensureCanManageTarget($target)) return $res;

        $model = new LaundrykuModel();
        $model->delete($id);
        return redirect()->to('/useradmin')->with('success', 'User berhasil dihapus!');
    }
}
