<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Data Stok Barang</h5>
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>


<button type="button" class="btn btn-primary" onclick="location.href=('/barang/tambah')">
    <i class="fa fa-plus-circle"></i> Tambah Barang
</button>

<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>
<!-- Data Tables -->
<link rel="stylesheet" href="<?= Base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= Base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Data Tables & Plugins -->
<script src="<?= Base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="form-group">
    <label for="">Filter satuan</label>
    <select name="satuan" id="satuan" class="form-control form-control-sm">
        <option value=""> Pilih </option>
        <?php foreach ($datasatuan as $row) : ?>
            <option value="<?= $row['satid'] ?>"><?= $row['satnama']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<table class="table table-sm table-bordered" id="databarang" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>kategori</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>stock</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    $(document).ready(function() {
        dataBarang = $('#databarang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/barang/listData',
                data: function(d) {
                    d.satuan = $('#satuan').val()
                }
            },
            order: [],
            columns: [{
                    data: 'nomor',
                    orderable: false
                }, {
                    data: 'brgkode'
                },
                {
                    data: 'brgnama'
                },
                {
                    data: 'katnama'
                },
                {
                    data: 'satnama'
                },
                {
                    data: 'brgharga'
                },
                {
                    data: 'brgstok'
                },
                {
                    data: 'aksi'
                },

            ]
        });
        $('#satuan').change(function(e) {
            e.preventDefault();
            dataBarang.ajax.reload();

        });
    });

    function hapus(kode) {
        Swal.fire({
            title: 'Hapus Item Barang',
            text: "Yakin Data barang dengan kode dihapus ? ",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                return True
            }
        })
    }

    function edit(kode) {

        window.location = ('/barang/formedit/' + kode);
    }
</script>

<?= $this->endsection('isi'); ?>