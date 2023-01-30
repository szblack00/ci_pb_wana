<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldetailbarangkeluar extends Model
{

    protected $table            = 'detail_barangkeluar';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'detfaktur', 'detbrgkode', 'detharga', 'detjml', 'detsubtotal'
    ];

    public function tampilDataTemp($nofaktur)
    {
        return $this->table('temp_barangkeluar')->join('barang', 'detbrgkode=brgkode')->where('detfaktur', $nofaktur)->get();
    }
}