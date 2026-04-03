<?php

namespace App\Controllers;

use App\Models\Tb_Jenis;

use function React\Promise\all;

class Jenis extends BaseController
{

    public function index()
    {
        $tb_jenis = new Tb_Jenis(); // memanggil model
        $all_data = $tb_jenis->findAll(); // mengambil semua data pelanggan
        return view('auth/layanan/jenis', ['all_data' => $all_data]); // mengirim data ke view
    }
    public function tambah()
    {
        return view('auth/layanan/tambah_layanan');
    }
    public function simpan()
    {
        $simpan = new Tb_Jenis();
        $simpan->insert($this->request->getVar());
        return redirect()->to('/jenis/index');
    }

    public function edit($id) //fungsi untuk menampilkan form edit data
    { $edit = new Tb_Jenis();
    $data['jenis'] = $edit->find($id);//memunculkan data ke views tabel edit dengan value $id
    return view('auth/layanan/edit_layanan', $data);//memunculkan data ke views tabel edit dengan value $id
    }
    
    public function update()
    {
        helper(['form']);
        if (!$this->validate([
            'jenis_laundry' => 'required|min_length[3]',
            'tarif' => 'required|numeric|min_length[3]',
            'deskripsi' => 'required|min_length[3]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $model= new Tb_Jenis();
        $id = $this->request->getVar('kd_jenis');
        $data = [
            'jenis_laundry' => $this->request->getVar('jenis_laundry'),//kiri database kanan form untuk view name
            'tarif' => $this->request->getVar('tarif'),
            'deskripsi' => $this->request->getVar('deskripsi'),
        ];
        $model->update($id, $data);
        return redirect()->to('/jenis/index')->with('success', 'Data berhasil diupdate!');
    }
    public function delete($id)
    {
        $model = new Tb_Jenis();
        $model->delete($id);
        return redirect()->to('/jenis/index')->with('success', 'Data berhasil dihapus!');
    }
}
