<?php

namespace App\Controllers;

use Config\Database;
use Config\Services;
use App\Models\Modelcostumer;
use App\Models\ModelDataCostumer;
use Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;


class Costumer extends BaseController
{
    // public function __construct()
    // {
    //     $this->costumer_pt = new Modelcostumer();
    // }
    public function index()
    {
        return view('costumer/viewcost');
    }
    function colist()
    {
        if ($this->request->isAJAX()) {
            $db = Database::connect();
            $builder = $db->table('costumer_pt')->select('costid,costnama,costtelp,costalamat');

            return DataTable::of($builder)
                ->addNumbering('nomor')
                ->toJson(true);
        }
    }
    public function formtambah()
    {
        $json = ['data' => view('costumer/modaltambah')];
        echo json_encode($json);
    }
    public function simpan()
    {
        $namacost = $this->request->getPost('cosnama');
        $tlp = $this->request->getPost('telp');
        $alamat = $this->request->getPost('alamat');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'cosnama' => [
                'rules' => 'required',
                'label' => 'Nama Costumer',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
            'telp' => [
                'rules' => 'required|is_unique[costumer_pt.costtelp]',
                'label' => 'No.Telp atau Handphone',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} No Telp sudah ada'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'label' => 'Alamat',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong'
                ]
            ],
        ]);

        if (!$valid) {
            $json = [
                'error' => [
                    'errNamaCostumer' => $validation->getError('cosnama'),
                    'errTelp' => $validation->getError('telp'),
                    'errAlamat' => $validation->getError('alamat'),
                ]
            ];
        } else {
            $modelCostumer = new Modelcostumer();
            $modelCostumer->insert([

                'costnama' => $namacost,
                'costtelp' => $tlp,
                'costalamat' => $alamat,
            ]);

            $rowData = $modelCostumer->ambilDataLast()->getRowArray();

            $json = [
                'sukses' => 'Data Costumer Berhasil Disimpan, Ambil Data Terakhir ? ',
                'namacost' => $rowData['costnama'],
                'idcost' => $rowData['costid']
            ];
        }
        echo json_encode($json);
    }
    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('costumer/modaldata')
            ];
            echo json_encode($json);
        }
    }
    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelDataCostumer($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\" btn btn-sm btn-info\" onclick=\"pilih('" . $list->costid . "','" . $list->costnama . "')\">Pilih</button>";


                $tombolHapus = "<button type=\"button\" class=\" btn btn-sm btn-danger\" onclick=\"hapus('" . $list->costid . "','" . $list->costnama . "')\">Hapus</button>";

                $row[] = $no;
                $row[] = $list->costnama;
                $row[] = $list->costtelp;
                $row[] = $list->costalamat;
                $row[] = $tombolPilih . "  " . $tombolHapus;
                $row[] = "";
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getpost('id');

            $modelCostumer = new Modelcostumer();
            $modelCostumer->delete($id);
            $json = [
                'sukses' => 'Data costumer berhasil di hapus'
            ];
            echo json_encode($json);
        }
    }
}