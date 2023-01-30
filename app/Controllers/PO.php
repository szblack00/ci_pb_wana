<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelPO;
use Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class PO extends BaseController
{
    public function __construct()
    {
        // $this->po = new ModelPO();
    }
    public function index()
    {
        return view('po/viewpo');
    }

    public function tambahpo()
    {
        return view('po/forminput');
    }


    function polist()
    {
        if ($this->request->isAJAX()) {
            $db = Database::connect();
            $builder = $db->table('po')->select('id_po,faktur,file,tgl_req,status');

            return DataTable::of($builder)

                ->addNumbering('nomor')
                ->add('aksi', function ($row) {
                    if (session('idlevel') == '1') {
                        return "<button type=\"button\" class=\"btn btn-sm btn-success\" onclick=\"terima('" . $row->id_po . "')\"><i class=\"fa fa-check\"></i></button>
                    
                        <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"tolak('" . $row->id_po . "')\"><i class=\"fa fa-times\"></i></button>";
                    }
                })

                ->toJson(true);
        }
    }

    public function terima()
    {

        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_po');

            $updatedata = [
                'status' => '1'
            ];
            $po = new ModelPO();
            $po->update($id, $updatedata);

            $msg = [
                'sukses' => 'Berhasil disetujui'
            ];


            echo json_encode($msg);
        }
    }
    public function tolak()
    {

        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_po');

            $updatedata = [
                'status' => '2'
            ];
            $po = new ModelPO();
            $po->update($id, $updatedata);

            $msg = [
                'Sukses' => 'Berhasil Di Update'
            ];


            echo json_encode($msg);
        }
    }
}
