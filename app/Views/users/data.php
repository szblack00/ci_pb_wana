<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Manajemen Users</h5>
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>
Manajemen User Aktif
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

<table class="table table-sm table-bordered" id="userdata" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Users</th>
            <th>Nama Users</th>
            <th>Level</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    $(document).ready(function() {
        let dataUser = $('#userdata').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/users/listData',
            order: [],
            columns: [{
                    data: 'nomor',
                    "width": "5%",
                    orderable: false
                },
                {
                    data: 'userid',
                    "width": "20%"
                },
                {
                    data: 'username'
                },
                {
                    data: 'levelnama'
                },
                {
                    data: 'status',
                    orderable: false,
                    "width": "20%",
                },
                {
                    data: 'aksi',
                    orderable: false,
                    "width": "15%"
                },
            ]
        });

    });
</script>

<?= $this->endSection('isi'); ?>