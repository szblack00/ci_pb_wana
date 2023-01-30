<!-- Data Tables -->
<link rel="stylesheet" href="<?= Base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= Base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="modal fade" id="modaldatacost" data-backdrop="static" data-keyboar="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cari Data Costumer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="dataCostumer" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th style="text-align: center ;">No</th>
                            <th style="text-align: center ;">Nama Costumer</th>
                            <th style="text-align: center ;">No Handphone</th>
                            <th style="text-align: center ;">Alamat</th>
                            <th style="text-align: center ;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


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