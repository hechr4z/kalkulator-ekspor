<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Exwork;
use App\Models\FOB;
use App\Models\CFR;
use App\Models\CIF;
use App\Models\Satuan;
use CodeIgniter\HTTP\ResponseInterface;

class KalkulatorEksporController extends BaseController
{
    public function index()
    {
        $model_exwork = new Exwork();
        $model_fob = new FOB();
        $model_cfr = new CFR();
        $model_satuan = new Satuan();

        $exwork = $model_exwork->findAll();
        $fob = $model_fob->findAll();
        $cfr = $model_cfr->findAll();
        $satuan = $model_satuan->findAll();

        $data['exwork'] = $exwork;
        $data['fob'] = $fob;
        $data['cfr'] = $cfr;
        $data['satuan'] = $satuan;

        return view('try-backend/kalkulator_ekspor', $data);
    }

    public function ganti_satuan($id)
    {
        $model_satuan = new Satuan();

        // Mencari satuan berdasarkan ID
        $satuan = $model_satuan->find($id);

        // Jika satuan ditemukan, lakukan update
        if ($satuan) {
            // Mengambil input dari form
            $data = [
                'satuan' => $this->request->getPost('satuan'),
            ];

            // Melakukan update data pada model
            $model_satuan->update($id, $data);

            // Redirect setelah update berhasil
            return redirect()->to('/');
        } else {
            // Jika data tidak ditemukan, bisa diarahkan ke halaman error
            return redirect()->to('/')->with('error', 'Data satuan tidak ditemukan.');
        }
    }

    // public function hitung_exwork()
    // {
    //     $model_exwork = new Exwork();

    //     // Retrieve all exwork data
    //     $exwork = $model_exwork->findAll();

    //     // Get input from POST request
    //     $jumlah_barang = $this->request->getPost('jumlahBarang');
    //     $jumlah_barang = str_replace('.', '', $jumlah_barang);
    //     $hpp = $this->request->getPost('hpp');
    //     $hpp = str_replace('.', '', $hpp);
    //     $keuntungan = $this->request->getPost('keuntungan');
    //     $keuntungan = str_replace('.', '', $keuntungan);

    //     // Initialize variables
    //     $exwork_lainnya = 0;

    //     if (empty($exwork)) {
    //         // If there are no exwork records
    //         $harga_exwork = number_format($hpp + $keuntungan, 0, ',', '.');
    //     } else {
    //         // If there are exwork records
    //         $jb_hpp_keuntungan = ($hpp + $keuntungan) * $jumlah_barang;

    //         // Loop through all exwork input data from POST
    //         foreach ($this->request->getPost() as $key => $value) {
    //             if (strpos($key, 'exwork_') === 0) {
    //                 // Divide each exwork value by jumlah_barang
    //                 $value = str_replace('.', '', $value);
    //                 $exwork_lainnya += $value;
    //             }
    //         }

    //         // Calculate final exwork price
    //         $harga_exwork = 'Rp. ' . number_format(($jb_hpp_keuntungan + $exwork_lainnya) / $jumlah_barang, 0, ',', '.');
    //     }

    //     // Set flashdata for the calculated exwork price
    //     session()->setFlashdata('harga_exwork', $harga_exwork);

    //     // Redirect to the desired route with the flashdata
    //     return redirect()->to('/');
    // }

    public function add_exwork()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'komponenExwork.*' => 'required',  // Ensure each component is required
        ]);

        if (!$this->validate($validation->getRules())) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $validation->getErrors())->withInput();
        }

        // Get the array of komponenExwork
        $komponenExworkArray = $this->request->getPost('komponenExwork');

        $model_exwork = new Exwork();

        // Loop through the array and insert each komponenExwork into the database
        foreach ($komponenExworkArray as $komponenExwork) {
            $data = [
                'komponen_exwork' => esc($komponenExwork),  // Sanitize the input
            ];
            $model_exwork->insert($data);
        }

        return redirect()->to('/')->with('success', 'Komponen Exwork berhasil ditambahkan!');
    }

    public function delete_exwork($id)
    {
        $model_exwork = new Exwork();

        $model_exwork->delete($id);

        return redirect()->to('/');
    }

    public function add_fob()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'komponenFOB.*' => 'required',  // Ensure each component is required
        ]);

        if (!$this->validate($validation->getRules())) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $validation->getErrors())->withInput();
        }

        // Get the array of komponenFOB
        $komponenFOBArray = $this->request->getPost('komponenFOB');

        $model_fob = new FOB();

        // Loop through the array and insert each komponenFOB into the database
        foreach ($komponenFOBArray as $komponenFOB) {
            $data = [
                'komponen_fob' => esc($komponenFOB),  // Sanitize the input
            ];
            $model_fob->insert($data);
        }

        return redirect()->to('/')->with('success', 'Komponen FOB berhasil ditambahkan!');
    }

    public function delete_fob($id)
    {
        $model_fob = new FOB();

        $model_fob->delete($id);

        return redirect()->to('/');
    }

    public function add_cfr()
    {
        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'komponenCFR.*' => 'required',  // Ensure each component is required
        ]);

        if (!$this->validate($validation->getRules())) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $validation->getErrors())->withInput();
        }

        // Get the array of komponenCFR
        $komponenCFRArray = $this->request->getPost('komponenCFR');

        $model_cfr = new CFR();

        // Loop through the array and insert each komponenCFR into the database
        foreach ($komponenCFRArray as $komponenCFR) {
            $data = [
                'komponen_cfr' => esc($komponenCFR),  // Sanitize the input
            ];
            $model_cfr->insert($data);
        }

        return redirect()->to('/')->with('success', 'Komponen CFR berhasil ditambahkan!');
    }
}
