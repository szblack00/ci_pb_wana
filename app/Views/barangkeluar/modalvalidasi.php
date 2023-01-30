<div class="modal fade" id="modalvalidasi" tabindex="-1" data-keyboar="false" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="StaticBackdropLabel">Validasi Faktur </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="">No.Faktur</label>
                    <input type="text" name="nofaktur" id="nofaktur" class="form-control" value="<?= $nofaktur; ?>"
                        readonly>

                    <input type="text" name="tglfaktur" value="<?= $tglfaktur; ?>">
                    <input type="text" name="id_costumer" value="<?= $id_costumer; ?>">

                    <div class="form-group">
                        <label for="">Total</label>
                        <input type="text" name="totalharga" id="totalharga" class="form-control"
                            value="<?= $totalharga; ?>" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btnsimpan">Simpan Data</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>

            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('.frmvalidasi').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').prop('disabled', true);
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpan').prop('disabled', false);
                    $('.btnsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Cetak Faktur',
                            text: response.sukses + " ,cetak faktur ?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Cetak!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let.windowCetak = window.open(response.cetakfaktur,
                                    "Cetak Faktur Barang Keluar",
                                    "Width=200, height=400 ");
                                windowCetak.focus();
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
            return false;
        });
    });
    </script>