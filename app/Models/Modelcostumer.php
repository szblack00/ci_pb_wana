<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelcostumer extends Model
{
    protected $table            = 'costumer_pt';
    protected $primaryKey       = 'costid';
    protected $allowedFields    = [
        'costnama', 'costtelp', 'costalamat'
    ];

    public function tampildata()
    {
        return $this->table('costumer_pt');
    }

    public function ambilDataLast()
    {
        return $this->table('costumer_pt')->limit(1)->orderBy('costid', 'DESC')->get();
    }
}