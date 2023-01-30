<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelbarangkeluar extends Model
{
    protected $table            = 'barangkeluar';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur', 'tglfaktur', 'id_costumer', 'totalharga'
    ];

    public function nofaktur($tanggalSekarang)
    {
        return $this->table('barangkeluar')->select('max(faktur)as nofaktur')->where('tglfaktur', $tanggalSekarang)->get();
    }
}
