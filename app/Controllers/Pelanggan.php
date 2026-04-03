<?php

namespace App\Controllers;

use App\Models\Tb_pelanggan;
use Predis\Command\Argument\Server\To;

class Pelanggan extends BaseController
{
    public function index()
    {
        $tb_pelanggan = new Tb_Pelanggan(); // memanggil model
        $all_data = $tb_pelanggan->findAll(); // mengambil semua data pelanggan
        return view('/auth/tambah_member/data_pelanggan', ['all_data' => $all_data]); // mengirim ke view dengan key 'all_data'

    }
    public function tambah() //fungsi untuk menampilkan form tambah data
    {
        return view('/auth/tambah_member/tambah_member');
    }


    public function simpan() //fungsi untuk menyimpan data
    {
        $simpan = new Tb_Pelanggan();

        // Ambil semua data dari form
        $data = $this->request->getPost();

        // Tangani upload foto jika ada
        $file = $this->request->getFile('foto_pelanggan');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            $data['foto_pelanggan'] = $newName;
        }

        $simpan->insert($data);

        return redirect()->to('/auth/tambah_member/data_pelanggan')->with('success', 'Data berhasil disimpan!');
    }



    public function edit($id) //fungsi untuk menampilkan form edit data
    {
        $model = new Tb_Pelanggan(); ////memunculkan data ke tabel edit
        $data['pelanggan'] = $model->find($id); //memunculkan data ke views tabel edit dengan value $id
        return view('auth/tambah_member/edit_pelanggan', $data); //memunculkan data ke tabel edit
    }

    public function update() //fungsi untuk mengupdate data
    {
        helper(['form']);

        // Validasi input
        if (!$this->validate([
            'nama_pelanggan' => 'required|min_length[3]',
            'jeniskelamin' => 'required|in_list[Pria,Wanita]',
            'alamat_pelanggan' => 'required',
            'no_pelanggan' => 'required|numeric|min_length[3]',
        ])) {
            // Jika validasi gagal, kembali ke form dengan error dan input sebelumnya
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new Tb_pelanggan(); //memanggil model
        $id = $this->request->getVar('id'); //memanggil id dari form

        $data = [
            'nama_pelanggan' => $this->request->getVar('nama_pelanggan'),
            'jeniskelamin' => $this->request->getVar('jeniskelamin'),
            'alamat_pelanggan' => $this->request->getVar('alamat_pelanggan'),
            'no_pelanggan' => $this->request->getVar('no_pelanggan'),
        ];

        // Handle upload foto jika ada
        $file = $this->request->getFile('foto_pelanggan');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            $data['foto_pelanggan'] = $newName;
        }

        $model->update($id, $data);

        return redirect()->to('/pelanggan/index')->with('success', 'Data berhasil diupdate!');
    }

    public function delete($id) //fungsi untuk menghapus data
    {
        $model = new Tb_pelanggan();
        $model->delete($id); // hapus berdasarkan ID

        return redirect()->to('/pelanggan/index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakKartu($id)
    {
        $model = new \App\Models\Tb_Pelanggan();
        $pelanggan = $model->find($id);

        if (!$pelanggan) {
            return redirect()->to('/pelanggan/index')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        return view('auth/tambah_member/kartu_member', ['pelanggan' => $pelanggan]);
    }
}
