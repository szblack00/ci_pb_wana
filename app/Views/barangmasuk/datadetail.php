<table class=" table table-sm table-striped table-hover" id="">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($datadetail->getResultArray() as $row) :
        ?>
        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['brgkode']; ?></td>
            <td><?= $row['brgnama']; ?></td>
            <td style="text-align: left;">
                <?= number_format($row['dethargamasuk'], 0, ",", ".") ?></td>
            <td style="text-align: left;">
                <?= number_format($row['detjml'], 0, ",", ".") ?></td>
            <td style="text-align: left;">
                <?= number_format($row['detsubtotal'], 0, ",", ".") ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="hapusItem('<?= $row['iddetail'] ?>')"><i class="fa fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-info"
                    onclick="editItem('<?= $row['iddetail']; ?>')"> <i class="fa fa-edit"></i>
                </button>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<Script>
function editItem(id) {
    $('#iddetail').val(id);
    $.ajax({
        type: "post",
        url: "/barangmasuk/editItem",
        data: {
            iddetail: $('#iddetail').val()
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;

                $('#kdbarang').val(data.kodebarang);
                $('#namabarang').val(data.namabarang);
                $('#hargabeli').val(data.hargabeli);
                $('#jumlah').val(data.jumlah);

                $('#tombolEditItem').fadeIn();
                $('#tombolReload').fadeIn();
                $('#tombolTambahItem').fadeOut();
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function hapusItem(id) {
    Swal.fire({
        title: 'Hapus Item',
        text: "Yakin ingin menghapus Item ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangmasuk/hapusItemDetail",
                data: {
                    id: id,
                    faktur: $('#faktur').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        dataDetail();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}
</Script>