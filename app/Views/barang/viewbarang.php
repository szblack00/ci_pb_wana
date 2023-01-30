<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<!-- <h5>Manajemen Data Barang</h5> -->
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>


<button type="button" class="btn btn-primary" onclick="location.href=('/barang/tambah')">
    <i class="fa fa-plus-circle"></i> Tambah Barang
</button>

<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>

<?= form_open('barang/index'); ?>

<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder=" Cari data berdasarkan Kode, Nama Barang, dan Kategori"
        name="cari" autofocus value="<?= $cari; ?>">
    <div class="input-group-append">
        <button class="btn btn-outline-success" type="submit" name="tombolcari"> <i class="fa fa-search"></i> </button>
    </div>
</div>
<?= form_close(); ?>
<span class="badge badge-success">
    <h6><?= "Total Data : $totaldata"; ?></h6>
</span>
<br>
<table class="table table-striped table-bordered" style="width:100%;">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>stok</th>
            <th style="width:20%;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $nomor = 1 + (($nohalaman - 1) * 10);
        foreach ($tampildata as $row) : ?>
        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['brgkode']; ?></td>
            <td><?= $row['brgnama']; ?></td>
            <td><?= $row['katnama']; ?></td>
            <td><?= $row['satnama']; ?></td>
            <td><?= number_format($row['brgharga'], 0); ?></td>
            <td><?= number_format($row['brgstok'], 0); ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-info" onclick="edit('<?= $row['brgkode']; ?>')"> <i
                        class="fa fa-edit"></i>
                </button>

                <form method="post" action="/barang/hapus/<?= $row['brgkode']; ?>" style="display:inline;"
                    onsubmit="return hapus();">
                    <input type="hidden" value="Delete" name="_method">

                </form>


            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="float-left mt-4">
    <?= $pager->links('barang', 'paging') ?>
</div>

<script>
function edit(kode) {
    window.location.href = ('/barang/formedit/' + kode);
}

function hapus(kode) {
    Swal.fire({
        title: 'Hapus Item Barang',
        text: "Yakin Data barang dengan kode <strong>${kode}</strong> dihapus ? ",
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
</script>
<?= $this->endsection('isi'); ?>