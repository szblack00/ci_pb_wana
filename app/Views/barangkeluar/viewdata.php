<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Data Transaksi Keluar</h5>
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>

<button type="button" class="btn btn-primary" onclick="location.href=('/barangkeluar/input')">
    <i class="fa fa-plus-circle"></i> Input Transaksi
</button>

<?= $this->endsection('subjudul'); ?>

<?= $this->section('isi'); ?>
<?= form_open('barangmasuk/data'); ?>
<?= $this->Endsection('isi'); ?>