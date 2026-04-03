<?php

namespace App\Controllers;

use App\Models\Tb_pelanggan;
use App\Models\Tb_jenis;
use App\Models\PesananModel;

class PesananController extends BaseController
{
    public function index()
    {
        $model = new PesananModel();
        $data['pesanan'] = $model->getPesanan();
        return view('pesanan/index', $data);
    }

    public function create()
    {
        $data['pelanggan'] = (new Tb_pelanggan())->findAll();
        $data['jenis'] = (new Tb_jenis())->findAll();
        return view('pesanan/create', $data);
    }

    public function store()
    {
        $model = new PesananModel();
        $tanggalShort = date('ymd');
        $prefix = 'LN-' . $tanggalShort . '-';
        $lastResi = $model->like('no_resi', $prefix)->orderBy('no_resi', 'DESC')->first();
        $newNumber = $lastResi ? (int)substr($lastResi['no_resi'], -3) + 1 : 1;
        $noResi = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $fotoName = null;
        $file = $this->request->getFile('foto_transaksi');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoName = $file->getRandomName();
            $file->move('uploads/foto_transaksi', $fotoName);
        }

        $model->insert([
            'no_resi'        => $noResi,
            'id_pelanggan'   => $this->request->getPost('id_pelanggan'),
            'kd_jenis'       => $this->request->getPost('kd_jenis'),
            'berat_kg'       => $this->request->getPost('berat_kg'),
            'status'         => 'Menunggu',
            'created_at'     => date('Y-m-d H:i:s'),
            'foto_transaksi' => $fotoName,
            'id_admin'       => session()->get('level') === 'admin' ? session()->get('id') : null,
            'id_washer'      => null,
            'keterangan_cuci'=> 'Menunggu Untuk Dicuci',
        ]);

        return redirect()->to('/pesanancontroller/index')->with('success', 'Pesanan berhasil dibuat! (Menunggu)');
    }

    public function detail($id)
    {
        $model = new PesananModel();
        $pesanan = $model->getDetailById($id);

        if (!$pesanan) {
            return redirect()->to('/pesanancontroller/index')->with('error', 'Data tidak ditemukan');
        }

        return view('pesanan/detail', ['pesanan' => $pesanan]);
    }

    public function track($no_resi)
    {
        $no_resi = trim((string)$no_resi);

        $model = new PesananModel();
        $data['pesanan'] = $model->getPesananByResi($no_resi);
        return view('pesanan/track', $data);
    }

    public function trackingForm()
    {
        return view('pesanan/lacak');
    }

    public function trackingResult()
    {
        $resi = trim((string)$this->request->getGet('no_resi'));

        $model = new PesananModel();
        $data['pesanan'] = $model->getPesananByResi($resi);
        return view('pesanan/track', $data);
    }

    public function editStatus($id_pesanan)
    {
        $model = new PesananModel();
        $pesanan = $model->select('tb_pesanan.*, tb_pelanggan.nama_pelanggan, tb_jenis.jenis_laundry')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = tb_pesanan.id_pelanggan')
            ->join('tb_jenis', 'tb_jenis.kd_jenis = tb_pesanan.kd_jenis')
            ->where('id_pesanan', $id_pesanan)
            ->first();

        return view('pesanan/edit_status', ['pesanan' => $pesanan]);
    }

    public function updateStatus($id_pesanan)
    {
        $model = new PesananModel();
        $statusBaru = $this->request->getPost('status');
        $statusSelesai = $this->request->getPost('status_selesai');

        $data = ['status' => $statusBaru];

        // Konsistenkan keterangan untuk status Menunggu
        if ($statusBaru === 'Menunggu') {
            $data['keterangan_cuci'] = 'Menunggu Untuk Dicuci';
        }

        if ($statusBaru === 'Selesai') {
            $data['status_selesai'] = $statusSelesai;

            // Hanya isi tanggal_selesai jika status_selesai == 'Sudah Diambil'
            if ($statusSelesai === 'Sudah Diambil') {
                $data['tanggal_selesai'] = \CodeIgniter\I18n\Time::now('Asia/Jakarta', 'en_US')->toDateTimeString();
            } else {
                $data['tanggal_selesai'] = null; // Kosongkan jika belum diambil
            }
        } else {
            // Reset jika belum selesai
            $data['status_selesai'] = null;
            $data['tanggal_selesai'] = null;
        }

        $model->update($id_pesanan, $data);

        return redirect()->to('/pesanancontroller/index')->with('success', 'Status berhasil diperbarui.');
    }




    public function washerView()
    {
        $model = new PesananModel();
        $data['pesanan'] = $model
            ->select('
                tb_pesanan.*,
                tb_pelanggan.nama_pelanggan,
                tb_jenis.jenis_laundry,
                washer.name AS nama_washer
            ')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = tb_pesanan.id_pelanggan')
            ->join('tb_jenis', 'tb_jenis.kd_jenis = tb_pesanan.kd_jenis')
            ->join('laundryku AS washer', 'washer.id = tb_pesanan.id_washer', 'left')
            ->whereIn('tb_pesanan.status', ['Menunggu', 'Proses'])
            ->orderBy('tb_pesanan.id_pesanan', 'DESC')
            ->findAll();
        return view('pesanan/washer', $data);
    }

    public function washerCuci($id)
    {
        $model = new PesananModel();
        $pesanan = $model->find($id);

        // Jika pesanan sudah dikunci oleh washer lain
        if (!empty($pesanan['id_washer']) && $pesanan['id_washer'] != session()->get('id')) {
            return redirect()->to('/pesanancontroller/washer')->with('warning', 'Pesanan sedang ditangani washer lain.');
        }

        // Hanya boleh ambil jika masih Menunggu
        if ($pesanan['status'] !== 'Menunggu') {
            return redirect()->to('/pesanancontroller/washer')->with('warning', 'Status pesanan tidak bisa diambil.');
        }

        $model->update($id, [
            'status' => 'Proses',
            'keterangan_cuci' => 'Sedang Dicuci',
            'id_washer' => session()->get('id')
        ]);

        return redirect()->to('/pesanancontroller/washer')->with('success', 'Pesanan diterima & mulai dicuci.');
    }



    public function washerJemur($id)
    {
        $model = new PesananModel();
        $pesanan = $model->find($id);

        if ($pesanan['id_washer'] != session()->get('id')) {
            return redirect()->to('/pesanancontroller/washer')->with('error', 'Kamu tidak berhak melanjutkan pesanan ini.');
        }

        $model->update($id, [
            'status' => 'Proses',
            'keterangan_cuci' => 'Sedang Dijemur'
        ]);
        return redirect()->to('/pesanancontroller/washer')->with('success', 'Pesanan sedang dijemur.');
    }


    public function washerSetrika($id)
    {
        $model = new PesananModel();
        $pesanan = $model->find($id);

        if ($pesanan['id_washer'] != session()->get('id')) {
            return redirect()->to('/pesanancontroller/washer')->with('error', 'Kamu tidak berhak melanjutkan pesanan ini.');
        }

        $model->update($id, [
            'status' => 'Proses',
            'keterangan_cuci' => 'Sedang Disetrika'
        ]);
        return redirect()->to('/pesanancontroller/washer')->with('success', 'Pesanan sedang disetrika.');
    }





    public function washerSelesai($id)
    {
        $model = new PesananModel();
        $pesanan = $model->find($id);

        if ($pesanan['id_washer'] != session()->get('id')) {
            return redirect()->to('/pesanancontroller/washer')->with('error', 'Kamu tidak berhak menyelesaikan pesanan ini.');
        }

        $model->update($id, [
            'status' => 'Selesai',
            'status_selesai' => 'Selesai - belum diambil/antar',
            'keterangan_cuci' => 'Selesai dicuci',
            'tanggal_selesai' => date('Y-m-d H:i:s'),
            'id_washer' => session()->get('id')
        ]);
        return redirect()->to('/pesanancontroller/washer')->with('success', 'Pesanan selesai dicuci.');
    }





    public function kurirView()
    {
        // Kolom kurir (mis. id_kurir) sudah dihapus dari tb_pesanan.
        return redirect()->to('/pesanancontroller/index')->with('warning', 'Fitur kurir sudah dinonaktifkan.');
    }


    public function kurirAntar($id)
    {
        // Kolom kurir (mis. id_kurir) sudah dihapus dari tb_pesanan.
        return redirect()->to('/pesanancontroller/index')->with('warning', 'Fitur kurir sudah dinonaktifkan.');
    }


    public function markAsTaken($id)
    {
        // Kolom kurir (mis. id_kurir) sudah dihapus dari tb_pesanan.
        return redirect()->to('/pesanancontroller/index')->with('warning', 'Fitur kurir sudah dinonaktifkan.');
    }


    public function riwayatTransaksi()
    {
        $model = new \App\Models\PesananModel();
        $data['pesanan'] = $model
            ->select('
                tb_pesanan.*,
                tb_pelanggan.nama_pelanggan,
                tb_jenis.jenis_laundry,
                tb_jenis.tarif,
                washer.name AS nama_washer
            ')
            ->join('tb_pelanggan', 'tb_pelanggan.id_pelanggan = tb_pesanan.id_pelanggan')
            ->join('tb_jenis', 'tb_jenis.kd_jenis = tb_pesanan.kd_jenis')
            ->join('laundryku AS washer', 'washer.id = tb_pesanan.id_washer', 'left')
            ->where('tb_pesanan.status', 'Selesai')
            ->where('tb_pesanan.status_selesai', 'Sudah Diambil')
            ->orderBy('tb_pesanan.id_pesanan', 'DESC')
            ->findAll();

        return view('pesanan/riwayat', $data);
    }
    public function riwayatStruk($id)
    {
        $model = new \App\Models\PesananModel();
        $pesanan = $model->getDetailById($id);

        if (!$pesanan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('pesanan/struk_riwayat', ['pesanan' => $pesanan]);
    }
    public function editBeratAdmin($id)
    {
        $model = new \App\Models\PesananModel();
        $pesanan = $model->find($id);

        if (!$pesanan) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $data['pesanan'] = $pesanan;
        $data['jenis'] = (new \App\Models\Tb_jenis())->findAll();

        return view('pesanan/edit_berat_admin', $data);
    }

    public function strukBerhasil($id)
    {
        $model = new \App\Models\PesananModel();
        $data['pesanan'] = $model->getDetailById($id);

        if (!$data['pesanan']) {
            return redirect()->to('/kurir/pickup-admin')->with('error', 'Data tidak ditemukan.');
        }

        return view('pesanan/struk_berhasil', $data);
    }

    public function cetakStruk($id)
    {
        $model = new PesananModel();
        $data['pesanan'] = $model->getDetailById($id);

        if (!$data['pesanan']) {
            return redirect()->to('/pesanancontroller/index')->with('error', 'Struk tidak ditemukan.');
        }

        return view('pesanan/struk', $data);
    }
}
