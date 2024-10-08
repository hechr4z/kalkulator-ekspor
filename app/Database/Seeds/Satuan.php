<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Satuan extends Seeder
{
    public function run()
    {
        $data = [
            'satuan' => 'pcs'
        ];

        $this->db->table('satuan')->insertBatch(($data));
    }
}
