<?= $this->extend('main/layout'); ?>

<?= $this->section('judul'); ?>
<h5>Request Purchasing Order</h5>
<?= $this->endsection('judul'); ?>

<?= $this->section('subjudul'); ?>
<button type="button" class="btn btn-primary" onclick="location.href=('/po/tambahpo')">
    <i class="fa fa-plus-circle"></i> Pengajuan Barang
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
<!-- Data Tables & Plugins -->

<table class=" table table-sm table-bordered" id="datapo" style="width: 100%;">

    <thead>
        <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>File</th>
            <th>Tanggal Permintaan</th>
            <th>Status</th>
            <th>Aksi</th>

        </tr>
    </thead>


</table>
<script>
$(document).ready(function() {
    listpo();
});

function listpo() {
    $('#datapo').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '/po/polist',
        order: false,
        columns: [{
                data: 'nomor',
                orderable: false
            },
            {
                data: 'faktur'
            },
            {
                data: 'file'
            }, {
                data: 'tgl_req'
            }, {
                data: 'status',
                orderable: false,
                "render": function(data, type, row) {
                    if (row.status == '0') {
                        return "<span class='badge badge-Danger'>Di Tolak</badge>"
                        return "<span class='badge badge-primary'>Menunggu Konfirmasi</badge>";
                    } else if (row.status == '1') {
                        return "<span class='badge badge-success'> Di Terima</badge>";
                    } else if (row.status == '2') {
                        return "<span class='badge badge-danger'>Di Tolak</badge>";
                    }
                }
            }, {
                data: 'aksi',
                orderable: false
            },
        ],
        "bDestroy": true,


    });

}

function terima(id_po) {
    Swal.fire({
        title: 'Yakin?',
        text: `ingin menerima Report ini ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('po/terima'); ?>",
                data: {
                    id_po: id_po
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        });
                        listpo();
                    }

                }
            });
        }
    })
}

function tolak(id_po) {
    Swal.fire({
        title: 'Yakin?',
        text: `ingin menolak Report ini ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('po/tolak'); ?>",
                data: {
                    id_po: id_po
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        });
                        listpo();
                    }

                }
            });
        }
    })
}
</script>
<?= $this->endsection('isi'); ?>