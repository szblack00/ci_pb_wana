<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPO extends Model
{
    protected $table            = 'po';
    protected $primaryKey       = 'id_po';
    protected $allowedFields    = ['id_po', 'file', 'faktur', 'tgl_req', 'status'];

    public function tampildata()
    {
        return $this->table('po');
    }
}