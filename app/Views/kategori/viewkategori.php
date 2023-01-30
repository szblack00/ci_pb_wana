<?= $this->extend('main/layout'); ?>
<!-- judul -->
<?= $this->section('judul'); ?>
<h5>Manajemen Data</h5>
<?= $this->endsection('judul'); ?>

<!-- sub judul -->
<?= $this->section('subjudul'); ?>

<?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('kategori/formtambah') . "')"
]); ?>

<?= $this->endsection('subjudul') ?>

<!-- isi -->
<?= $this->section('isi'); ?>
<?= session()->getFlashdata('sukses'); ?>
<?= form_open('kategori/index'); ?>

<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Cari Data Kategori" aria-label="Recipient's username"
        aria-describedby="button-addon2" name="cari" value="<?= $cari; ?>">
    <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari"><i class="fa fa-search">
        </i></button>
</div>
<?= form_close(); ?>
<table class="table table-striped table-bordered" style="width:100%;">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Nama Kategori</th>
            <th style="width:15%;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $nomor = 1 + (($nohalaman - 1) * 5);
        foreach ($tampildata as $row) : ?>
        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['katnama']; ?></td>
            <td>
                <button type="button" class="btn btn btn-info" title="Edit Data"
                    onclick="edit('<?= $row['katid']; ?>')">
                    <i class="fa fa-edit"></i>
                </button>

                <form method="post" action="/kategori/hapus/<?= $row['katid']; ?>" style="display:inline;"
                    onsubmit="hapus();">
                    <input type="hidden" value="Delete" name="_method">

                    <button type="submit" class="btn btn btn-danger" title="Hapus Data">
                        <i class=" fa fa-trash-alt"></i>
                    </button>
                </form>


            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="float-center">
    <?= $pager->links('kategori', 'paging'); ?>
</div>

<script>
function edit(id) {
    window.location = ('/kategori/formedit/' + id);
}

function hapus() {
    pesan = confirm('Yakin Data Ketegori akan Di Hapus ?');

    if (pesan) {
        window.location = ('/kategori/hapus/' + id);
    } else {
        return true;
    }
}
</script>


<?= $this->endsection('isi'); ?>