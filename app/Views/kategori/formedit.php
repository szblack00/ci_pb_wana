<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Form Edit Data</h5>
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

<?= form_open('kategori/updatedata', '', [
    'idkategori' => $id
]); ?>

<div class="form-group">
    <label for="namakategori">Nama Kategori</label>
    <?= form_input('namakategori', $nama, [
        'class' => 'form-control', 'id' => 'namakategori',
        'autofocus' => true,
    ]); ?>

    <?= session()->getFlashdata('errorNamaKategori'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Update', ['class' => 'btn btn-success']); ?>
</div>

<?= form_close(); ?>
<?= $this->endsection('isi'); ?>