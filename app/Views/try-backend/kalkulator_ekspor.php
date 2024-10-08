<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Harga Ekspor</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan link Bootstrap Icons di header -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom style for the result */
        .result-harga-exwork {
            color: red;
            /* Set text color to red */
            font-size: 1.5em;
            /* Increase font size */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <form action="<?= base_url('/ganti-satuan/' . $satuan[0]['id_satuan']); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="satuan">Satuan (Sekarang '<?= $satuan[0]['satuan']; ?>'):</label>
                <div class="input-group">
                    <input required type="text" class="form-control" id="satuan" name="satuan" placeholder="Masukkan Satuan Baru (Jika ingin diganti)" autocomplete="off">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Ganti Satuan</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card p-5">
            <h1 class="text-center mb-4">Exwork Form</h1>

            <!-- Input Jumlah Barang -->
            <div class="form-group">
                <label for="jumlahBarang">Jumlah Barang Dalam 1 Kontainer:</label>
                <div class="input-group">
                    <input required type="text" class="form-control" id="jumlahBarang" name="jumlahBarang" placeholder="Masukkan Jumlah Barang" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><?= $satuan[0]['satuan']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Input HPP -->
            <div class="form-group">
                <label for="hpp">Harga Pokok Produksi (HPP):</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                    </div>
                    <input required type="text" class="form-control" id="hpp" name="hpp" placeholder="Masukkan Biaya HPP" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text">/ <?= $satuan[0]['satuan']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Input Keuntungan -->
            <div class="form-group">
                <label for="keuntungan">Keuntungan:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                    </div>
                    <input required type="text" class="form-control" id="keuntungan" name="keuntungan" placeholder="Masukkan Biaya Keuntungan" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text">/ <?= $satuan[0]['satuan']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Tabel untuk menampilkan komponen Exwork -->
            <p class="text-danger">*<i>Komponen Exwork (Sesuaikan dengan kebutuhan)</i></p>
            <table class="table table-bordered">
                <thead class="bg-primary text-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Komponen</th>
                        <th>Biaya (Rp.)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($exwork)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada Komponen Exwork yang ditambahkan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($exwork as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $item['komponen_exwork'] ?></td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input required type="text" class="form-control" id="exwork_<?= $item['id_exwork'] ?>" name="exwork_<?= $item['id_exwork'] ?>" placeholder="Masukkan Biaya <?= $item['komponen_exwork'] ?>" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= base_url('/komponen-exwork/delete/' . $item['id_exwork']) ?>" class="btn btn-outline-danger btn-sm align-center">
                                        <i class="bi bi-x-lg"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <!-- <button type="submit" class="btn btn-primary mt-2">Hitung Exwork</button> -->
                <h3 class="result-harga-exwork mt-2">Harga Exwork: <?php if (session()->getFlashdata('harga_exwork')): ?> <?= session()->getFlashdata('harga_exwork') ?> <?php endif; ?></h3>
            </div>

            <!-- Divider -->
            <hr class="my-4" style="border: 1px solid black; background-color: black;">

            <form action="<?= base_url('/komponen-exwork/add'); ?>" method="post" enctype="multipart/form-data">
                <div id="komponenExworkContainer">
                    <!-- Kolom pertama untuk input komponen Exwork -->
                    <div class="form-group">
                        <label for="komponenExwork">Komponen Exwork Baru:</label>
                        <input required type="text" class="form-control" id="komponenExwork" name="komponenExwork[]" placeholder="Masukkan Komponen Exwork" autocomplete="off">
                    </div>
                </div>

                <!-- Tombol untuk menambah kolom input baru -->
                <button type="button" class="btn btn-success mt-2" id="tambahKolom">Tambah Komponen Baru</button>
                <button type="submit" class="btn btn-primary mt-2">Submit Komponen</button>
            </form>

            <!-- Divider -->
            <!-- <hr class="my-4" style="border: 1px solid black; background-color: black;"> -->
        </div>

        <!-- Divider -->
        <hr class="my-4" style="border: 1px solid black; background-color: black;">

        <h1 class="text-center mb-4">FOB Form</h1>
        <form action="<?= base_url('/hitung-fob'); ?>" method="post" enctype="multipart/form-data">
            <!-- Input Jumlah Barang -->
            <div class="form-group">
                <label for="jumlahBarang">Jumlah Barang Dalam 1 Kontainer:</label>
                <div class="input-group">
                    <input required type="text" class="form-control" id="jumlahBarang" name="jumlahBarang" placeholder="Masukkan Jumlah Barang" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><?= $satuan[0]['satuan']; ?></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="hargaExwork">Harga Exwork:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                    </div>
                    <input required type="text" class="form-control" id="hargaExwork" name="hargaExwork" placeholder="Masukkan Harga Exwork" autocomplete="off">
                    <div class="input-group-prepend">
                        <span class="input-group-text">/ <?= $satuan[0]['satuan']; ?></span>
                    </div>
                </div>
            </div>

            <?php foreach ($fob as $item): ?>
                <div class="form-group d-flex align-items-center">
                    <!-- Tombol X di sebelah kiri label -->
                    <a href="<?= base_url('/komponen-fob/delete/' . $item['id_fob']) ?>">
                        <button class="btn btn-outline-danger btn-sm mr-2" type="button">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </a>

                    <label for="fob_<?= $item['id_fob'] ?>" class="mr-2"><?= $item['komponen_fob'] ?>:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp.</span>
                        </div>
                        <input required type="text" class="form-control" id="fob_<?= $item['id_fob'] ?>" name="fob_<?= $item['id_fob'] ?>" placeholder="Masukkan <?= $item['komponen_fob'] ?>" autocomplete="off">
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary mt-2">Hitung FOB</button>
            <span class="ml-2">Harga FOB: <?php if (session()->getFlashdata('harga_fob')): ?> <?= session()->getFlashdata('harga_fob') ?> <?php endif; ?></span>
        </form>

        <!-- Divider -->
        <hr class="my-4" style="border: 1px solid black; background-color: black;">

        <form action="<?= base_url('/komponen-fob/add'); ?>" method="post" enctype="multipart/form-data">
            <!-- Input Komponen FOB -->
            <div class="form-group">
                <label for="komponenFOB">Komponen FOB Baru:</label>
                <input required type="text" class="form-control" id="komponenFOB" name="komponenFOB" placeholder="Masukkan Komponen FOB" autocomplete="off">
                <button type="submit" class="btn btn-primary mt-2">Tambah Komponen</button>
            </div>
        </form>

        <!-- Divider -->
        <hr class="my-4" style="border: 1px solid black; background-color: black;">
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Format number to rupiah format (1.000.000)
        function formatRupiah(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        // Dynamic Exwork price calculation
        function hitungExwork() {
            let jumlahBarang = document.getElementById('jumlahBarang').value.replace(/\./g, '');
            let hpp = document.getElementById('hpp').value.replace(/\./g, '');
            let keuntungan = document.getElementById('keuntungan').value.replace(/\./g, '');

            if (!jumlahBarang || !hpp || !keuntungan) {
                document.querySelector('.result-harga-exwork').innerText = 'Harga Exwork: ';
                return;
            }

            jumlahBarang = parseFloat(jumlahBarang);
            hpp = parseFloat(hpp);
            keuntungan = parseFloat(keuntungan);

            let jb_hpp_keuntungan = (hpp + keuntungan) * jumlahBarang;

            // Initialize exwork components sum
            let exworkLainnya = 0;

            <?php foreach ($exwork as $item): ?>
                let exworkValue<?= $item['id_exwork'] ?> = document.getElementById('exwork_<?= $item['id_exwork'] ?>').value.replace(/\./g, '');
                if (exworkValue<?= $item['id_exwork'] ?>) {
                    exworkLainnya += parseFloat(exworkValue<?= $item['id_exwork'] ?>);
                }
            <?php endforeach; ?>

            // Calculate final exwork price
            let hargaExwork = (jb_hpp_keuntungan + exworkLainnya) / jumlahBarang;

            // Display formatted result
            document.querySelector('.result-harga-exwork').innerText = 'Harga Exwork: Rp. ' + formatRupiah(hargaExwork.toFixed(0));
        }

        // Add listeners to inputs for dynamic calculation
        document.querySelectorAll('#jumlahBarang, #hpp, #keuntungan').forEach(function(element) {
            element.addEventListener('keyup', function(e) {
                e.target.value = formatRupiah(e.target.value); // Format as rupiah
                hitungExwork(); // Calculate Exwork
            });
        });

        // Add event listeners to exwork component inputs
        <?php foreach ($exwork as $item): ?>
            document.getElementById('exwork_<?= $item['id_exwork'] ?>').addEventListener('keyup', function(e) {
                e.target.value = formatRupiah(e.target.value); // Format as rupiah
                hitungExwork(); // Calculate Exwork
            });
        <?php endforeach; ?>

        <?php foreach ($fob as $item): ?>
            document.getElementById('fob_<?= $item['id_fob'] ?>').addEventListener('keyup', function(e) {
                e.target.value = formatRupiah(e.target.value);
            });
        <?php endforeach; ?>

        // Script untuk menambah kolom input komponen Exwork baru
        document.getElementById('tambahKolom').addEventListener('click', function() {
            // Buat elemen baru
            var newField = document.createElement('div');
            newField.classList.add('form-group');
            newField.classList.add('komponenExworkRow');

            // Buat input field baru dengan tombol hapus
            newField.innerHTML = `
            <div class="input-group">
                <input required type="text" class="form-control" name="komponenExwork[]" placeholder="Masukkan Komponen Exwork" autocomplete="off">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger btn-remove-komponen"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>
        `;

            // Tambahkan ke container form
            document.getElementById('komponenExworkContainer').appendChild(newField);

            // Tambahkan event listener ke tombol hapus yang baru
            newField.querySelector('.btn-remove-komponen').addEventListener('click', function() {
                newField.remove();
            });
        });
    </script>
</body>

</html>