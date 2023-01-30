<!-- Data Tables -->
<link rel="stylesheet" href="<?= Base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= Base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Data Tables & Plugins -->
<script src="<?= Base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= Base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<div class="modal fade" id="modalcaribarang" data-backdrop="static" data-keyboar="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Data Cari Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table id="databarang" class="table table-bordered table-hover dataTable dtr-inline collapsed"
                aria-describedby="example2_info">
                <thead>
                    <tr>
                        <th style="text-align:center ;">No</th>
                        <th style="text-align:center ;">Kode Barang</th>
                        <th style="text-align:center ;">Nama Barang</th>
                        <th style="text-align:center ;">Harga</th>
                        <th style="text-align:center ;">stock</th>
                        <th style="text-align:center ;">#</th>
                    </tr>
                </thead>
            </table>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
function pilih(kode) {
    $('#kodebarang').val(kode);
    $('#modalcaribarang').on('hidden.bs.modal', function(e) {
        ambilDatabarang();
    });
    $('#modalcaribarang').modal('hide');
}

function listDataBarang() {
    var table = $('#databarang').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url": "/barangkeluar/listDataBarang",
            "dataType": "json",
            "type": "POST"
        },
        columnDefs: [{
            "orderable": false,
            "targets": [0, 2, 3, 4, 5]
        }, ],
        "order": []
    });
}
$(document).ready(function() {
    listDataBarang();
});
</script>