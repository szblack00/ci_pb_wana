<table class=" table table-sm table-hover table-bordered" style="width:100% ;">
    <thead>
        <tr>
            <th colspan="5"></th>
            <th colspan="2" style="text-align: right;">
                <?php
                $totalHarga = 0;
                foreach ($tampildata->getResultArray() as $row) :
                    $totalHarga += $row['detsubtotal'];
                endforeach ?>
                <h3><?= number_format($totalHarga, 0, ",", ".") ?></h3>
                <input type="hidden" name="totalharga" id="totalharga" value="<?= $totalHarga; ?>">
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align:center ;">No</th>
            <th style="text-align:center ;">Kode Barang</th>
            <th style="text-align:center ;">Nama Barang</th>
            <th style="text-align:center ;">Harga</th>
            <th style="text-align:center ;">Jumlah</th>
            <th style="text-align:center ;">SubTotal</th>
            <th style="text-align:center ;">aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
        <tr>
            <td style=" text-align:center ;"><?= $nomor++; ?></td>
            <td style=" text-align:center ;"><?= $row['detbrgkode']; ?></td>
            <td style=" text-align:center ;"><?= $row['brgnama']; ?></td>
            <td style=" text-align:center ;"><?= number_format($row['detharga'], 0, ",", ".") ?></td>
            <td style=" text-align:center ;"><?= number_format($row['detjml'], 0, ",", ".") ?></td>
            <td style=" text-align:center ;"><?= number_format($row['detsubtotal'], 0, ",", ".") ?></td>
            <td style="text-align: center;">
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['id'] ?>')"><i
                        class="fa fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<script>
function hapusItem(id) {
    Swal.fire({
        title: 'Hapus Item?',
        text: "Yakin menghapus item ini ? ",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangkeluar/hapusItem",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire('Berhasil', response.sukses, 'success');
                        tampilDataTemp();
                        kosong();
                    }
                }
            });
        }
    })

}
</script>