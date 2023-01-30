<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\Modelbarang;
use App\Models\Modelkategori;
use \Hermawan\DataTables\DataTable;
use App\Models\Modelsatuan;
use CodeIgniter\Config\Config;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->barang = new Modelbarang();
    }

    public function index()
    {
        $dataSatuan =  new Modelsatuan();
        return view(
            'barang/viewdatabarang',
            [
                'datasatuan' => $dataSatuan->findAll()
            ]
        );
    }
    function listData()
    {
        if ($this->request->isAJAX()) {
            // $db = \Config\Database::connect();
            $db = db_connect();
            $builder = $db->table('barang')->select('brgkode, brgnama, katnama, satnama, brgharga, brgstok')->join('kategori', 'katid=brgkatid')->join('satuan', 'satid=brgsatid');

            return DataTable::of($builder)
                ->addNumbering('nomor')
                ->filter(function ($builder, $request) {

                    if ($request->satuan)
                        $builder->where('brgsatid', $request->satuan);
                })
                ->add('aksi', function ($row) {
                    return "
                    <button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $row->brgkode . "')\"><i class=\"fa fa-trash-alt\"></i></button>

                    <button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $row->brgkode . "')\"><i class=\"fa fa-edit\"></i></button>";
                })
                ->toJson(true);
        }
    }
    public function tambah()
    {
        $modelkategori = new Modelkategori();
        $modelsatuan = new Modelsatuan();

        $data = [
            'datakategori' => $modelkategori->findAll(),
            'datasatuan' => $modelsatuan->findAll(),

        ];
        return view('barang/formtambah', $data);
    }

    public function simpandata()
    {
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $kategori = $this->request->getVar('kategori');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'kodebarang' => [
                'rules' => 'required|is_unique[barang.brgkode]',
                'label' => 'Kode Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada..',
                ]
            ],
            'namabarang' => [
                'rules' => 'required',
                'label' => 'Nama Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',

                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'label' => 'Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'satuan' => [
                'rules' => 'required',
                'label' => 'satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',

                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'label' => 'harga',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} hanya dalam bentuk angka'
                ]
            ],

            'stok' => [
                'rules' => 'required|numeric',
                'label' => 'satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} hanya dalam bentuk angka'
                ]
            ],
            'gambar' => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'gambar',
            ]
        ]);

        if (!$valid) {
            $sess_pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  ' . $validation->listerrors() . '
                </div>'
            ];

            session()->setflashdata($sess_pesan);
            return redirect()->to('/barang/tambah');
        } else {
            $gambar = $_FILES['gambar']['name'];
            if ($gambar != NULL) {
                $namaFileGambar = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'upload/' . $fileGambar->getName();
            } else {
                $pathGambar = '';
            }

            $this->barang->insert([
                'brgkode' => $kodebarang,
                'brgnama' => $namabarang,
                'brgkatid' => $kategori,
                'brgsatid' => $satuan,
                'brgharga' => $harga,
                'brgstok' => $stok,
                'brggambar' => $pathGambar
            ]);
            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h5><i class="icon fas fa-check"></i> Sukses!</h5>
Data Barang dengan kode <strong>' . $kodebarang . '</strong> berhasil disimpan
</div>'
            ];
            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/tambah');
        }
    }

    public function edit($kode)
    {
        $cekData = $this->barang->find($kode);
        if ($cekData) {

            $modelkategori = new Modelkategori();
            $modelsatuan = new Modelsatuan();

            $data = [
                'kode' => $cekData['brgkode'],
                'namabarang' => $cekData['brgnama'],
                'kategori' => $cekData['brgkatid'],
                'satuan' => $cekData['brgsatid'],
                'harga' => $cekData['brgharga'],
                'stok' => $cekData['brgstok'],
                'datakategori' => $modelkategori->findAll(),
                'datasatuan' => $modelsatuan->findAll(),
                'gambar' => $cekData['brggambar']
            ];

            return view('barang/formedit', $data);
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h5><i class="icon fas fa-ban"></i> Gagal!</h5>
Data Barang Tidak Di Temukan
</div>'
            ];
            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/index');
        }
    }


    public function updatedata()
    {
        $kode = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $kategori = $this->request->getVar('kategori');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namabarang' => [
                'rules' => 'required',
                'label' => 'Nama Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'label' => 'Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',

                ]
            ],
            'satuan' => [
                'rules' => 'required',
                'label' => 'satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',

                ]
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'label' => 'harga',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} hanya dalam bentuk angka'
                ]
            ],

            'stok' => [
                'rules' => 'required|numeric',
                'label' => 'satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric' => '{field} hanya dalam bentuk angka'
                ]
            ],
            'gambar' => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'gambar',
            ]
        ]);

        if (!$valid) {
            $sess_pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  ' . $validation->listerrors() . '
                </div>'
            ];

            session()->setflashdata($sess_pesan);
            return redirect()->to('/barang/tambah');
        } else {
            $cekData = $this->barang->find($kode);
            $pathGambarLama = $cekData['brggambar'];

            $gambar = $_FILES['gambar']['name'];
            if ($gambar != NULL) {
                ($pathGambarLama == '' || $pathGambarLama == NULL) ? '' :
                    unlink($pathGambarLama);
                $namaFileGambar = $kode;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'upload/' . $fileGambar->getName();
            } else {
                $pathGambar = $pathGambarLama;
            }
            $this->barang->update($kode, [

                'brgnama' => $namabarang,
                'brgkatid' => $kategori,
                'brgsatid' => $satuan,
                'brgharga' => $harga,
                'brgstok' => $stok,
                'brggambar' => $pathGambar
            ]);
            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h5><i class="icon fas fa-check"></i> Sukses!</h5>
Data Barang dengan kode <strong>' . $kode . '</strong> berhasil di Update
</div>'
            ];
            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        }
    }

    public function hapus($kode)
    {
        $cekData = $this->barang->find($kode);
        if ($cekData) {
            $pathGambarLama = $cekData['brggambar'];
            unlink($pathGambarLama);
            $this->barang->delete($kode);
            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
<button type="button" class=z-"close" data-dismiss="alert" aria-hidden="true">×</button>
<h5><i class="icon fas fa-check"></i> Sukses!</h5>
Data Barang dengan kode <strong>' . $kode . '</strong> berhasil di hapus
</div>'
            ];
            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h5><i class="icon fas fa-ban"></i> Gagal!</h5>
Data Barang Tidak Di Temukan
</div>'
            ];
            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/index');
        }
    }
}