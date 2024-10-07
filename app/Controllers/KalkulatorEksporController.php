<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Exwork;
use App\Models\FOB;
use App\Models\CFR;
use App\Models\CIF;
use CodeIgniter\HTTP\ResponseInterface;

class KalkulatorEksporController extends BaseController
{
    public function index()
    {
        $model_exwork = new Exwork();
        $model_fob = new FOB();

        $exwork = $model_exwork->findAll();
        $fob = $model_fob->findAll();

        $data['exwork'] = $exwork;
        $data['fob'] = $fob;

        return view('try-backend/kalkulator_ekspor', $data);
    }

    public function hitung_exwork()
    {
        $model_exwork = new Exwork();

        // Retrieve all exwork data
        $exwork = $model_exwork->findAll();

        // Get input from POST request
        $jumlah_barang = $this->request->getPost('jumlahBarang');
        $jumlah_barang = str_replace('.', '', $jumlah_barang);
        $hpp = $this->request->getPost('hpp');
        $hpp = str_replace('.', '', $hpp);
        $keuntungan = $this->request->getPost('keuntungan');
        $keuntungan = str_replace('.', '', $keuntungan);

        // Initialize variables
        $exwork_lainnya = 0;

        if (empty($exwork)) {
            // If there are no exwork records
            $harga_exwork = number_format($hpp + $keuntungan, 0, ',', '.');
        } else {
            // If there are exwork records
            $jb_hpp_keuntungan = ($hpp + $keuntungan) * $jumlah_barang;

            // Loop through all exwork input data from POST
            foreach ($this->request->getPost() as $key => $value) {
                if (strpos($key, 'exwork_') === 0) {
                    // Divide each exwork value by jumlah_barang
                    $value = str_replace('.', '', $value);
                    $exwork_lainnya += $value;
                }
            }

            // Calculate final exwork price
            $harga_exwork = 'Rp. ' . number_format(($jb_hpp_keuntungan + $exwork_lainnya) / $jumlah_barang, 0, ',', '.');
        }

        // Set flashdata for the calculated exwork price
        session()->setFlashdata('harga_exwork', $harga_exwork);

        // Redirect to the desired route with the flashdata
        return redirect()->to('/');
    }

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
        $data = [
            'komponen_fob' => $this->request->getPost('komponenFOB'),
        ];

        $model_fob = new FOB();
        $model_fob->insert($data);

        return redirect()->to('/');
    }

    public function delete_fob($id)
    {
        $model_fob = new FOB();

        $model_fob->delete($id);

        return redirect()->to('/');
    }
}
