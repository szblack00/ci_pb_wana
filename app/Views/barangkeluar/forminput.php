<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Form Input Transaksi Keluar</h5>
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>

<button type="button" class="btn btn-warning" onclick="location.href=('/barangkeluar/data')">
    <i class="fa fa-backward"></i> Kembali
</button>

<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">No.Faktur</label>
            <input type="text" name="nofaktur" value="<?= $nofaktur ?>" id="nofaktur" class="form-control" readonly>

        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Tanggal Faktur</label>
            <input type="date" name="tglfaktur" id="tglfaktur" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>
    </div>
    <div class="col-lg-5">
        <div class="form-group">
            <label for="">Cari Costumer</label>
            <div class="input-group">

                <input type="text" class="form-control" placeholder="Cari Costumer" id="namacost" name="namacost"
                    readonly>

                <input type="hidden" name="id_costumer" id="id_costumer">
                <div class=" input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="tombolCariCost" title="Cari Costumer">
                        <i class="fa fa-search"></i>
                    </button>

                    <button class="btn btn-outline-success" type="button" id="tombolTambahCost" title="Tambah Costumer">
                        <i class="fa fa-plus-square"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Kode Barang</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="kodebarang" id="kodebarang">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="tombolcaribarang">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Nama barang</label>
            <input type="text" name="namabarang" id="namabarang" class="form-control" readonly>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Harga item (Rp)</label>
            <input type="text" name="harga" id="harga" class="form-control" readonly>
        </div>
    </div>
    <div class="col-sm-1">
        <div class="form-group">
            <label for="">Qty</label>
            <input type="number" min="1" name="jml" id="jml" class="form-control" value="1">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for=""> Aksi</label>
            <div class="input-group  mb-6 ">
                <button class="btn btn-success" title="Simpan Item" id="tombolSimpanItem"> <i class="fa fa-plus"></i>
                </button> &ensp;
                <button class="btn btn-info" title="Selesai Transaksi" id="tombolSelesaiTransaksi"> <i
                        class="fa fa-save"></i>
                    Selesai Transaksi
                </button>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 tampilDataTemp">
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
function kosong() {
    $('#kodebarang').val('');
    $('#namabarang').val('');
    $('#harga').val('');
    $('#jml').val('1');
    $('#kodebarang').focus();

}

function simpanItem() {
    let nofaktur = $('#nofaktur').val();
    let kodebarang = $('#kodebarang').val();
    let namabarang = $('#namabarang').val();
    let harga = $('#harga').val();
    let jml = $('#jml').val();


    if (kodebarang.length == 0) {
        Swal.fire('Error', 'Kode barang harus di input', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "/barangkeluar/simpanItem",
            data: {
                nofaktur: nofaktur,
                kodebarang: kodebarang,
                namabarang: namabarang,
                harga: harga,
                jml: jml,


            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    swal.fire('Error', response.error, 'error');
                    kosong();
                }
                if (response.sukses) {
                    tampilDataTemp();
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        });
    }

}

function ambilDatabarang() {
    let kodebarang = $('#kodebarang').val();
    if (kodebarang.length == 0) {
        Swal.fire('Error', 'Kode barang harus di input', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "/barangkeluar/ambilDataBarang",
            data: {
                kodebarang: kodebarang
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire('Error', response.error, 'error');
                    kosong();
                }

                if (response.sukses) {
                    let data = response.sukses;

                    $('#namabarang').val(data.namabarang);
                    $('#harga').val(data.harga);
                    $('#jml').focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

}

function tampilDataTemp() {
    let faktur = $('#nofaktur').val();
    $.ajax({
        type: "post",
        url: "/barangkeluar/tampilDataTemp",
        data: {
            nofaktur: faktur
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataTemp').html("<i class='fa fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataTemp').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function buatNoFaktur() {
    let tanggal = $('#tglfaktur').val();
    $.ajax({
        type: "post",
        url: "/barangkeluar/buatNoFaktur",
        data: {
            tanggal: tanggal
        },
        dataType: "json",
        success: function(response) {
            $('#nofaktur').val(response.nofaktur);
            tampilDataTemp();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    tampilDataTemp();
    $('#tglfaktur').change(function(e) {
        buatNoFaktur();
        tampilDataTemp();

    });

    $('#tombolTambahCost').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/costumer/formtambah",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalTambahCostumer').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    });

    $('#tombolCariCost').click(function(e) {
        e.preventDefault();
        $.ajax({

            url: "/costumer/modalData",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldatacost').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    });

    $('#kodebarang').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDatabarang();
        }
    });

    $('#tombolSimpanItem').click(function(e) {
        e.preventDefault();
        simpanItem();
    });

    $('#tombolcaribarang').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/barangkeluar/modalCariBarang",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalcaribarang').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    });
    $('#tombolSelesaiTransaksi').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/barangkeluar/modalvalidasi",
            data: {
                nofaktur: $('#nofaktur').val(),
                tglfaktur: $('#tglfaktur').val(),
                id_costumer: $('#id_costumer').val(),
                totalharga: $('#totalharga').val(),

            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    swal.fire('Error', response.error, 'error')
                }
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalvalidasi').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        });

    });

});
</script>
<?= $this->Endsection('isi'); ?>