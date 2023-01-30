<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Form Tambah Data Satuan</h5>
<?= $this->endsection('judul'); ?>

<!-- sub judul -->
<?= $this->section('subjudul'); ?>

<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('satuan/index') .
        "')"
]); ?>
<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>

<div class="form-group">
    <?= form_open('satuan/simpandata'); ?>
    <label for="namasatuan">Nama Satuan</label>
    <?= form_input('namasatuan', '', [
        'class' => 'form-control', 'id' => 'namasatuan',
        'autofocus' => true,
        'placeholder' => 'Input Data Kategori'
    ]); ?>

    <?= session()->getFlashdata('errorNamaSatuan'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Simpan', ['class' => 'btn btn-success']); ?>
</div>

<?= form_close(); ?>
<?= $this->endsection('isi'); ?>