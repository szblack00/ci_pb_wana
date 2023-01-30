<div class="modal fade" id="modalTambahCostumer" data-backdrop="static" data-keyboar="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Input Costumer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?= form_open('costumer/simpan', ['class' => 'formsimpan']) ?>
                <div class="form-group">
                    <label for="">Input Nama costumer</label>
                    <input type="text" name="cosnama" id="cosnama" class="form-control">
                    <div class="invalid-feedback errorNamaCostumer">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Nomor Telepon</label>
                    <input type="text" name="telp" id="telp" class="form-control">
                    <div class="invalid-feedback errorTelp">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control">
                    <div class="invalid-feedback errorAlamat">
                    </div>
                </div>
                <div class="form-group">
                    <label for=""></label>
                    <button type="submit" class="btn btn-block btn-success" id="tombolsimpan">Simpan
                    </button>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.formsimpan').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tombolsimpan').prop('disabled', true);
                $('#tombolsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('#tombolsimpan').prop('disabled', false);
                $('#tombolsimpan').html('Simpan');
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.errNamaCostumer) {
                        $('#cosnama').addClass('is-invalid');
                        $('.errorNamaCostumer').html(err.errNamaCostumer);
                    }

                    if (err.errTelp) {
                        $('#telp').addClass('is-invalid');
                        $('.errorTelp').html(err.errTelp);
                    }

                    if (err.errAlamat) {
                        $('#alamat').addClass('is-invalid');
                        $('.errorAlamat').html(err.errAlamat);
                    }
                }
                if (response.sukses) {
                    Swal.fire({
                        title: 'Berhasil ?',
                        text: response.sukses,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ambil'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#namacost').val(response.namacost);
                            $('#idcost').val(response.idcost);
                            $('#modalTambahCostumer').modal('hide');
                        } else {
                            $('#modalTambahCostumer').modal('hide');
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