<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Form Tambah Data Kategori</h5>
<?= $this->endsection('judul'); ?>

<!-- sub judul -->
<?= $this->section('subjudul'); ?>

<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('kategori/index') .
        "')"
]); ?>
<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>

<div class="form-group">
    <?= form_open('kategori/simpandata'); ?>
    <label for="namakategori">Nama Kategori</label>
    <?= form_input('namakategori', '', [
        'class' => 'form-control', 'id' => 'namakategori',
        'autofocus' => true,
        'placeholder' => 'Input Data Kategori'
    ]); ?>

    <?= session()->getFlashdata('errorNamaKategori'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Simpan', ['class' => 'btn btn-success']); ?>
</div>

<?= form_close(); ?>
<?= $this->endsection('isi'); ?>