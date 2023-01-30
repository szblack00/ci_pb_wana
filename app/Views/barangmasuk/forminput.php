<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Input Transaksi Masuk</h5>
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>

<button type="button" class="btn btn-warning" onclick="location.href=('/barangmasuk/data')">
    <i class="fa fa-backward"></i> Kembali
</button>

<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="form-group col-md-6">
        <label for="">Faktur Barang Masuk</label>
        <input type="text" class="form-control" placeholder="No.Faktur" name="faktur" id="faktur">
    </div>
    <div class="form-group col-md-6">
        <label for="">Tanggal Faktur</label>
        <input type="date" class="form-control" name="tglfaktur" id="tglfaktur" value="<?= date('Y-m-d'); ?>">
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        Input Barang
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="">Kode Barang</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Kode Barang" name="kdbarang" id="kdbarang">
                    <div class="input-group-append">
                        <button class="btn btn-outline-btn-primary" type="button" id="tombolCariBarang"><i
                                class="fa fa-search text-blue"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="">Nama Barang</label>
                <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
            </div>
            <div class="form-group col-md-3">
                <label for="">Harga Beli</label>
                <input type="number" class="form-control" name="hargabeli" id="hargabeli" readonly>
            </div>
            <div class="form-group col-md-1">
                <label for="">Jumlah</label>
                <input type="number" min="1" class="form-control" name="jumlah" id="jumlah">
            </div>
            <div class="form-group col-md-1">
                <label for="">Aksi</label>
                <div class="input Group">

                    <button type="button" class="btn btn-sm btn-info" title="Tambah Item" id="tombolTambahItem">
                        <i class="fa fa-plus-square"></i>
                    </button>&nbsp;
                    <button type="button" class="btn btn-sm btn-warning" title="Reload Data Item" id="tombolReload">
                        <i class="fa fa-sync"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row" id="tampilDataTemp"></div>
        <div class="row justify-content-end">
            <button type="button" class="btn btn-lg btn-success" id="tombolselesai"> <i class="fa  fa fa-save"> Selesai
                    Transaksi</i></button>
        </div>
    </div>
</div>
<div class="modalcaribarang" style="display: none;"></div>

<script>
function dataTemp() {
    let faktur = $('#faktur').val();

    $.ajax({
        type: "post",
        url: "/barangmasuk/dataTemp",
        data: {
            faktur: faktur
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('#tampilDataTemp').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function kosong() {
    $('#kdbarang').val('');
    $('#namabarang').val('');
    $('#hargabeli').val('');
    $('#jumlah').val('');
    $('#kdbarang').focus();
}

function clearjml() {
    $('#jumlah').val('');
}
// get data barang
function ambilDataBarang() {
    let kodebarang = $('#kdbarang').val();

    $.ajax({
        type: "post",
        url: "/barangmasuk/ambilDataBarang",
        data: {
            kodebarang: kodebarang
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;
                $('#namabarang').val(data.namabarang);
                $('#hargabeli').val(data.hargabeli);

                $('#jumlah').focus();
            }
            if (response.error) {
                alert(response.error);

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    dataTemp();

    $('#faktur').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            dataTemp();
        }
    });
    $('#kdbarang').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDataBarang();

        }
    });

    //tambah item
    $('#tombolTambahItem').click(function(e) {
        e.preventDefault();

        let faktur = $('#faktur').val();
        let kodebarang = $('#kdbarang').val();
        let namabarang = $('#namabarang').val();
        let hargabeli = $('#hargabeli').val();
        let jumlah = $('#jumlah').val();

        //Alert 
        if (faktur.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf Faktur Tidak Boleh kosong',
            })
        } else if (kodebarang.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf Kode barang Tidak Boleh kosong',
            })
        } else if (namabarang.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf Nama Tidak Boleh kosong',
            })
        } else if (hargabeli.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf Harga Tidak Boleh kosong',
            })
        } else if (jumlah.length == '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Maaf Jumlah Tidak Boleh kosong',
            })

        } else {

            $.ajax({
                type: "post",
                url: "/barangmasuk/simpanTemp",
                data: {
                    faktur: faktur,
                    kodebarang: kodebarang,
                    hargabeli: hargabeli,
                    jumlah: jumlah,
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {

                    }
                    dataTemp();
                    kosong();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    });

    $('#tombolReload').click(function(e) {
        e.preventDefault();
        dataTemp();
    });

    $('#tombolCariBarang').click(function(e) {
        e.preventDefault();
        dataTemp();
        kosong();
        $.ajax({
            url: "/barangmasuk/cariDataBarang",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalcaribarang').html(response.data).show();
                    $('#modalcaribarang').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolselesai').click(function(e) {
        e.preventDefault();
        let faktur = $('#faktur').val();
        if (faktur.length == 0) {
            swal.fire({
                title: 'pesan',
                icon: 'warning',
                text: 'Maaf, Faktur Tidak Boleh Kosong'

            });
        } else {
            Swal.fire({
                title: 'Selesai Transaksi',
                text: "Yakin Transaksi ini di simpan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "/barangmasuk/selesaiTransaksi",
                        data: {
                            faktur: faktur,
                            tglfaktur: $('#tglfaktur').val()
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.error) {
                                swal.fire({
                                    title: 'Gagal Menyimpan Faktur',
                                    icon: 'error',
                                    text: response.error

                                });
                            }
                            if (response.sukses) {
                                swal.fire({
                                    title: 'Berhasil',
                                    icon: 'success',
                                    text: response.sukses
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload()
                                    }
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + '\n' + thrownError);
                        }
                    });
                }
            })
        }

    });
});
</script>
<?= $this->endsection('isi'); ?>