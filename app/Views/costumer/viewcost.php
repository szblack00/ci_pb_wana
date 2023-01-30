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


<table class="table table-sm table-bordered" id="databarang" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Costumer</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>




<!-- Data Tables & Plugins -->
<script src="<?= Base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
function listDataCostumer() {
    var table = $('#dataCostumer').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url": "/costumer/listData",
            "dataType": "json",
            "type": "POST"
        },
        columnDefs: [{
            "targets": [0, 3, 2, 4],
            "orderable": false,
        }],
        "order": []
    });
}

function pilih(id, nama) {
    $('#namacost').val(nama);
    $('#id_costumer').val(id);

    $('#modaldatacost').modal('hide');

}

function hapus(id, nama) {

    Swal.fire({
        title: 'Hapus Pelanggan?',
        text: "Yakin ingin menghapus data costumer " + nama + "? ",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/costumer/hapus",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Hapus Data',
                            text: response.sukses,
                        });
                        listDataCostumer();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }

            });
        }
    })
}

$(document).ready(function() {
    listDataCostumer();

});
</script>
<?= $this->endsection('isi'); ?>