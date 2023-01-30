<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelbarang;
use App\Models\Modelbarangkeluar;
use App\Models\ModelTempBarangKeluar;
use Config\Services;
use App\Models\ModelDataBarang;
use App\Models\Modeldetailbarangkeluar;

class Barangkeluar extends BaseController
{
    private function buatFaktur()
    {
        $tanggalSekarang = date('Y-m-d');
        $modelBarangKeluar = new Modelbarangkeluar();

        $hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        $nextNourut = intval($lastNoUrut) + 1;
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNourut);

        return $noFaktur;
    }
    public function buatNoFaktur()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $modelBarangKeluar = new Modelbarangkeluar();

        $hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        $nextNourut = intval($lastNoUrut) + 1;
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNourut);

        $json  = [
            'nofaktur' => $noFaktur
        ];
        echo json_encode($json);
    }
    public function data()
    {
        return view('barangkeluar/viewdata');
    }
    public function input()
    {
        $data = [
            'nofaktur' => $this->buatFaktur()
        ];
        return view('barangkeluar/forminput', $data);
    }

    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modalTempBarangKeluar = new ModelTempBarangKeluar();
            $dataTemp = $modalTempBarangKeluar->tampilDataTemp($nofaktur);
            $data = [
                'tampildata' => $dataTemp
            ];
            $json = [
                'data' => view('/barangkeluar/datatemp', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf Tidak Bisa Dipanggil');
        }
    }

    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');
            $modelBarang = new Modelbarang();

            $cekData = $modelBarang->find($kodebarang);
            if ($cekData == null) {
                $json = [
                    'error' => 'Maaf data barang tidak di temukan...'
                ];
            } else {
                $data = [
                    'namabarang' => $cekData['brgnama'],
                    'harga' => $cekData['brgharga']
                ];

                $json = [
                    'sukses' => $data
                ];
            }
            echo json_encode($json);
        }
    }

    function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $jml = $this->request->getPost('jml');
            $harga = $this->request->getPost('harga');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelBarang = new Modelbarang();

            $ambilDataBarang = $modelBarang->find($kodebarang);
            $stokbarang = $ambilDataBarang['brgstok'];
            if ($jml > intval($stokbarang)) {
                $json = [
                    'error' => 'Stok Barang Tidak Mencukupi...'
                ];
            } else {
                $modelTempBarangKeluar->insert([
                    'detfaktur' => $faktur,
                    'detbrgkode' => $kodebarang,
                    'detharga' => $harga,
                    'detjml' => $jml,
                    'detsubtotal' => intval($jml) * intval($harga)

                ]);
                $json = [
                    'sukses' => 'Item Berhasil Ditambahkan'
                ];
            }
            echo json_encode($json);
        }
    }

    function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelTempBarangKeluar->delete($id);

            $json = [
                'sukses' => 'Item Berhasil Di Hapus'
            ];
            echo json_encode($json);
        }
    }
    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('barangkeluar/modalcaribarang')
            ];
            echo json_encode($json);
        }
    }
    public function listDataBarang()
    {
        $request = Services::request();
        $datamodel = new ModelDataBarang($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\" btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgkode . "')\">Pilih</button>";

                $row[] = $no;
                $row[] = $list->brgkode;
                $row[] = $list->brgnama;
                $row[] = number_format($list->brgharga, 0, ",", ".");
                $row[] = number_format($list->brgstok, 0, ",", ".");
                $row[] = $tombolPilih;
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

    function modalvalidasi()
    {
        $nofaktur = $this->request->getPost('nofaktur');
        $tglfaktur = $this->request->getPost('tglfaktur');
        $id_costumer = $this->request->getPost('id_costumer');
        $totalharga = $this->request->getPost('$totalharga');

        $modelTemp = new ModelTempBarangKeluar();
        $cekdata = $modelTemp->tampilDataTemp($nofaktur);

        if ($cekdata->getNumRows() > 0) {
            $data = [
                'nofaktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'id_costumer' => $id_costumer,
                'totalharga' => $totalharga,
            ];
            $json = [
                'data' => view('barangkeluar/modalvalidasi', $data)
            ];
        } else {
            $json = [
                'error' => 'Maaf Data Tidak Ditemukan'
            ];
        }
        echo json_encode($json);
    }

    function selesaitransaksi()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $id_costumer = $this->request->getPost('id_costumer');
            $totalharga = $this->request->getPost('totalharga');

            $modelTemp = new ModelTempBarangKeluar();
            $dataTemp = $modelTemp->getwhere(['detfaktur' => $nofaktur]);

            if ($dataTemp->getNumRows() == 0) {
                $json = [
                    'error' => 'Maaf, Data Item untuk faktur  ini belum ada...'
                ];
            } else {
                // simpan ke tabel barang Keluar
                $modelBarangkeluar = new Modelbarangkeluar();
                $totalharga = 0;
                foreach ($dataTemp->getResultArray() as $totalharga) :
                    $totalharga += intval($totalharga['detsubtotal']);
                endforeach;

                $modelBarangkeluar->insert([

                    'nofaktur' => $nofaktur,
                    'tglfaktur' => $tglfaktur,
                    'id_costumer' => $id_costumer,
                    'totalharga' => $totalharga
                ]);

                // simpan ke detail barang Keluar
                $modelDetailBarangKeluar = new Modeldetailbarangkeluar();
                foreach ($dataTemp->getResultArray() as $row) :
                    $modelDetailBarangKeluar->insert([
                        'detfaktur' => $row['detfaktur'],
                        'detbrgkode' => $row['detbrgkode'],
                        'detharga' => $row['detharga'],
                        'detjml' => $row['detjml'],
                        'detsubtotal' => $row['detsubtotal']
                    ]);
                endforeach;

                // hapus
                $modelTemp->emptyTable();

                $json = [
                    'sukses' => 'Transaksi Berhasil Disimpan'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa di panggil');
        }
    }


    function simpanvalidasi()
    {
        if ($this->request->isAjax()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $id_costumer = $this->request->getPost('id_costumer');
            $totalharga = $this->request->getPost('totalharga');

            $modelBarangKeluar = new Modelbarangkeluar();
            $modelBarangKeluar->insert([
                'nofaktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'id_costumer' => $id_costumer,
                'totalharga' => $totalharga
            ]);

            $modelTemp = new ModelTempBarangKeluar();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur' => $row['detfaktur'],
                    'detbrgkode' => $row['detbrgkode'],
                    'detharga' => $row['detharga'],
                    'detjml' => $row['detjml'],
                    'detsubtotal' => $row['detsubtotal'],
                ];
            }

            $modelDetail = new Modeldetailbarangkeluar();
            $modelDetail->insertBatch($fieldDetail);


            // hapus Temp databarangkeluar
            $modelTemp->hapusData($nofaktur);
            // $modelTemp->emptyTable();

            $json = [
                'sukses' => 'Data Barang Keluar Berhasil Di Simpan',
                'cetakfaktur' => site_url('barangkeluar/cetakfaktur' . $nofaktur)
            ];

            echo json_encode($json);
        }
    }
}