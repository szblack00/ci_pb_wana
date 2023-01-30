<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modeltempbarangmasuk;
use App\Models\Modelbarang;
use App\Models\Modelbarangmasuk;
use App\Models\Modeldetailbarangmasuk;


class Barangmasuk extends BaseController
{
    public function index()
    {
        return view('barangmasuk/forminput');
    }
    function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelTemp = new Modeltempbarangmasuk();
            $data = [
                'datatemp' => $modelTemp->tampilDataTemp($faktur)
            ];

            $json = [
                'data' => view('/barangmasuk/datatemp', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf Tidak Bisa Dipanggil');
        }
    }
    function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');

            $modelBarang = new Modelbarang();
            $ambilData = $modelBarang->find($kodebarang);

            if ($ambilData == Null) {
                $json = [
                    'error' =>
                    'Data Barang Tidak Ditemukan...'
                ];
            } else {
                $data = [
                    'namabarang' => $ambilData['brgnama'],
                    'hargabeli' => $ambilData['brgharga']
                ];
                $json = [
                    'sukses' => $data
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf Tidak Bisa Di panggil');
        }
    }

    function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $jumlah = $this->request->getPost('jumlah');

            $modelTempBarang = new Modeltempbarangmasuk();
            $modelTempBarang->insert([
                'detfaktur' => $faktur,
                'detbrgkode' => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'detjml' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);
            $json = [
                'sukses' => 'Data Berhasil Di tambahkan'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf Data Tidak Bisa DI Panggil');
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarang = new Modeltempbarangmasuk();
            $modelTempBarang->delete($id);

            $json = [
                'sukses' => 'Item Berhasil DiHapus'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf data tidak bisa di ambil');
        }
    }

    function cariDataBarang()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('barangmasuk/modalcaribarang')
            ];

            echo json_encode($json);
        } else {
            exit('Maaf Data Tidak Bisa Di Panggil');
        }
    }

    function detailCariBarang()
    {
        if ($this->request->isAJAX()) {
            $cari = $this->request->getPost('cari');

            $modalbarang = new Modelbarang();
            $data = $modalbarang->tampildata_cari($cari)->get();

            if ($data != null) {
                $json = [
                    'data' => view('barangmasuk/detaildatabarang', [
                        'tampildata' => $data
                    ])
                ];

                echo json_encode($json);
            }
        } else {
            exit('Maaf Data Tidak Bisa Di Panggil');
        }
    }
    function selesaiTransaksi()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $tglfaktur = $this->request->getPost('tglfaktur');

            $modelTemp = new Modeltempbarangmasuk();
            $dataTemp = $modelTemp->getwhere(['detfaktur' => $faktur]);

            if ($dataTemp->getNumRows() == 0) {
                $json = [
                    'error' => 'Maaf, Data item untuk faktur  ini belum ada...'
                ];
            } else {
                // simpan ke tabel barang masuk
                $modelBarangMasuk = new Modelbarangmasuk();
                $totalSubTotal = 0;
                foreach ($dataTemp->getResultArray() as $total) :
                    $totalSubTotal += intval($total['detsubtotal']);
                endforeach;

                $modelBarangMasuk->insert([
                    'faktur' => $faktur,
                    'tglfaktur' => $tglfaktur,
                    'totalharga' => $totalSubTotal
                ]);

                // simpan ke detail barang masuk
                $modelDetailBarangMasuk = new Modeldetailbarangmasuk();
                foreach ($dataTemp->getResultArray() as $row) :
                    $modelDetailBarangMasuk->insert([
                        'detfaktur' => $row['detfaktur'],
                        'detbrgkode' => $row['detbrgkode'],
                        'dethargamasuk' => $row['dethargamasuk'],
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
    public function data()
    {
        $tombolcari = $this->request->getPost('tombolcari');

        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_faktur', $cari);
            redirect()->to('/barangmasuk/data');
        } else {
            $cari = session()->get('cari_faktur');
        }

        $modelBarangMasuk = new Modelbarangmasuk();

        $totaldata = $cari ? $modelBarangMasuk->tampildata_cari($cari)->countAllResults() : $modelBarangMasuk->countAllResults();

        $databarangmasuk = $cari ? $modelBarangMasuk->tampildata_cari($cari)->paginate(5, 'barangmasuk') : $modelBarangMasuk->paginate(10, 'barangmasuk');

        $nohalaman = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;

        $data = [
            'tampildata' => $databarangmasuk,
            'pager' => $modelBarangMasuk->pager,
            'nohalaman' => $nohalaman,
            'cari' => $cari,
            'totaldata' => $totaldata
        ];
        return view('barangmasuk/viewdata', $data);
    }

    function detailItem()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $modelDetail = new Modeldetailbarangmasuk();
            $data = [
                'tampildatadetail' => $modelDetail->dataDetail($faktur)
            ];

            $json = [
                'data' => view('barangmasuk/modaldetailitem', $data)
            ];
            echo json_encode($json);
        }
    }

    function edit($faktur)
    {
        $modelBarangMasuk = new Modelbarangmasuk();
        $cekFaktur = $modelBarangMasuk->cekFaktur($faktur);

        if ($cekFaktur->getNumRows() > 0) {
            $row = $cekFaktur->getRowArray();

            $data = [
                'nofaktur' => $row['faktur'],
                'tanggal' => $row['tglfaktur']
            ];
            return view('barangmasuk/formedit', $data);
        } else {
            exit('Data Tidak Ditemukan');
        }
    }

    function dataDetail()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $modelDetail = new Modeldetailbarangmasuk();
            $data = [
                'datadetail' => $modelDetail->dataDetail($faktur)
            ];

            $totalHargaFaktur = number_format($modelDetail->ambilTotalHarga($faktur), 0, ",", ".");
            $json = [
                'data' => view('barangmasuk/datadetail', $data),
                'totalharga' => $totalHargaFaktur
            ];
            echo json_encode($json);
        }
    }

    function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $modelDetail = new Modeldetailbarangmasuk();
            $ambilData = $modelDetail->ambilDetailBerId($iddetail);
            $row = $ambilData->getRowArray();

            $data = [
                'kodebarang' => $row['detbrgkode'],
                'namabarang' => $row['brgnama'],
                'hargabeli' => $row['dethargamasuk'],
                'jumlah' => $row['detjml']

            ];
            $json = [
                'sukses' => $data
            ];
            echo json_encode($json);
        }
    }
    function simpanDetail()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $jumlah = $this->request->getPost('jumlah');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->insert([
                'detfaktur' => $faktur,
                'detbrgkode' => $kodebarang,
                'dethargamasuk' => $hargabeli,
                'detjml' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);
            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' => 'Data Berhasil Di Update'

            ];
            echo json_encode($json);
        } else {
            exit('Maaf Data Tidak Bisa DI Panggil');
        }
    }
    function updateItem()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $hargabeli = $this->request->getPost('hargabeli');
            $jumlah = $this->request->getPost('jumlah');
            $iddetail = $this->request->getPost('iddetail');

            $modelDetail = new Modeldetailbarangmasuk();
            $modelBarangMasuk = new Modelbarangmasuk();

            $modelDetail->update($iddetail, [
                'dethargamasuk' => $hargabeli,
                'detjml' => $jumlah,
                'detsubtotal' => intval($jumlah) * intval($hargabeli)
            ]);

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga
            ]);

            $json = [
                'sukses' => 'Data Berhasil Di Update'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf Data Tidak Bisa Di Panggil');
        }
    }
    function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $faktur = $this->request->getPost('faktur');

            $modelDetail = new Modeldetailbarangmasuk();

            $modelBarangMasuk = new Modelbarangmasuk();

            $ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

            $modelBarangMasuk->update($faktur, [
                'totalharga' => $ambilTotalHarga

            ]);
            $modelDetail->delete($id);
            $json = [
                'sukses' => 'Item Berhasil DiHapus'
            ];
            echo json_encode($json);
        } else {
            exit('Maaf data tidak bisa di ambil');
        }
    }
    public function hapusTransaksi()
    {
        $faktur = $this->request->getPost('faktur');
        $db = \Config\Database::connect();
        $modelBarangMasuk = new Modelbarangmasuk();

        $db->table('detail_barangmasuk')->delete(['detfaktur' => $faktur]);
        $modelBarangMasuk->delete($faktur);

        $json = [
            'sukses' => $faktur
        ];
        echo json_encode($json);
    }
}