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
        .result-harga-exwork,
        .result-harga-fob {
            color: red;
            /* Set text color to red */
            font-size: 1.5em;
            /* Increase font size */
        }


        /* Initially hide the submit button and komponen container */
        #komponenExworkContainer,
        #komponenFOBContainer,
        #submitKomponenExworkButton,
        #submitKomponenFOBButton {
            display: none;
        }

        /* Membuat tabel bisa digeser ke kanan jika kolomnya terlalu panjang */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .table {
            min-width: 500px;
            /* Menjaga agar tabel tetap panjang */
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
        <div class="card shadow p-4">
            <h1 class="text-center mb-4">Exwork Form</h1>

            <!-- Input Jumlah Barang -->
            <div class="form-group">
                <label for="jumlahBarangExwork">Jumlah Barang Dalam 1 Kontainer:</label>
                <div class="input-group">
                    <input required type="text" class="form-control" id="jumlahBarangExwork" name="jumlahBarangExwork" placeholder="Masukkan Jumlah Barang" autocomplete="off">
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
            <div class="table-responsive">
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
                                            <input required type="text" class="form-control" id="exwork_<?= $item['id_exwork'] ?>" name="exwork_<?= $item['id_exwork'] ?>" placeholder="Masukkan <?= $item['komponen_exwork'] ?>" autocomplete="off">
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
            </div>

            <div class="d-flex justify-content-between">
                <!-- <button type="submit" class="btn btn-primary mt-2">Hitung Exwork</button> -->
                <h3 class="result-harga-exwork mt-2">Harga Exwork: <?php if (session()->getFlashdata('harga_exwork')): ?> <?= session()->getFlashdata('harga_exwork') ?> <?php endif; ?></h3>
            </div>

            <!-- Divider -->
            <hr class="mt-2" style="border: 1px solid black; background-color: black;">

            <!-- Form tambah komponen Exwork -->
            <form action="<?= base_url('/komponen-exwork/add'); ?>" method="post" enctype="multipart/form-data">

                <!-- Tombol untuk menambah kolom input baru -->
                <button type="button" class="btn btn-success mb-2" id="tambahKolomExwork">Tambah Komponen Baru</button>

                <!-- Container untuk kolom input baru, awalnya disembunyikan -->
                <div id="komponenExworkContainer">
                    <!-- Kolom pertama untuk input komponen Exwork, ini hanya muncul setelah tombol ditekan -->
                </div>

                <!-- Tombol Submit, awalnya disembunyikan -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="submitKomponenExworkButton">Simpan Komponen (0)</button>
                </div>
            </form>

            <!-- Divider -->
            <!-- <hr class="my-4" style="border: 1px solid black; background-color: black;"> -->
        </div>

        <div class="card shadow p-4 mt-4">
            <h1 class="text-center mb-4">FOB Form</h1>

            <!-- Input Jumlah Barang -->
            <div class="form-group">
                <label for="jumlahBarangFOB">Jumlah Barang Dalam 1 Kontainer:</label>
                <div class="input-group">
                    <input required type="text" class="form-control" id="jumlahBarangFOB" name="jumlahBarangFOB" placeholder="Masukkan Jumlah Barang" autocomplete="off">
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

            <!-- Tabel untuk menampilkan komponen FOB -->
            <p class="text-danger">*<i>Komponen FOB (Sesuaikan dengan kebutuhan)</i></p>
            <div class="table-responsive">
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
                        <?php if (empty($fob)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada Komponen FOB yang ditambahkan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($fob as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $item['komponen_fob'] ?></td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input required type="text" class="form-control" id="fob_<?= $item['id_fob'] ?>" name="fob_<?= $item['id_fob'] ?>" placeholder="Masukkan <?= $item['komponen_fob'] ?>" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('/komponen-fob/delete/' . $item['id_fob']) ?>" class="btn btn-outline-danger btn-sm align-center">
                                            <i class="bi bi-x-lg"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <h3 class="result-harga-fob mt-2">Harga FOB: </h3>
            </div>

            <!-- Divider -->
            <hr class="mt-2" style="border: 1px solid black; background-color: black;">

            <!-- Form tambah komponen FOB -->
            <form action="<?= base_url('/komponen-fob/add'); ?>" method="post" enctype="multipart/form-data">

                <!-- Tombol untuk menambah kolom input baru -->
                <button type="button" class="btn btn-success mb-2" id="tambahKolomFOB">Tambah Komponen Baru</button>

                <!-- Container untuk kolom input baru, awalnya disembunyikan -->
                <div id="komponenFOBContainer">
                    <!-- Kolom pertama untuk input komponen FOB, ini hanya muncul setelah tombol ditekan -->
                </div>

                <!-- Tombol Submit, awalnya disembunyikan -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="submitKomponenFOBButton">Simpan Komponen (0)</button>
                </div>
            </form>
        </div>
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
            let jumlahBarang = document.getElementById('jumlahBarangExwork').value.replace(/\./g, '');
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

        function hitungFOB() {
            let jumlahBarang = document.getElementById('jumlahBarangFOB').value.replace(/\./g, '');
            let hargaExwork = document.getElementById('hargaExwork').value.replace(/\./g, '');

            if (!jumlahBarang || !hargaExwork) {
                document.querySelector('.result-harga-fob').innerText = 'Harga FOB: ';
                return;
            }

            jumlahBarang = parseFloat(jumlahBarang);
            hargaExwork = parseFloat(hargaExwork);

            let jb_he = hargaExwork * jumlahBarang;

            let fobLainnya = 0;

            <?php foreach ($fob as $item): ?>
                let fobValue<?= $item['id_fob'] ?> = document.getElementById('fob_<?= $item['id_fob'] ?>').value.replace(/\./g, '');
                if (fobValue<?= $item['id_fob'] ?>) {
                    fobLainnya += parseFloat(fobValue<?= $item['id_fob'] ?>);
                }
            <?php endforeach; ?>

            let hargaFOB = (jb_he + fobLainnya) / jumlahBarang;

            document.querySelector('.result-harga-fob').innerText = 'Harga FOB: Rp. ' + formatRupiah(hargaFOB.toFixed(0));
        }

        // Add listeners to inputs for dynamic calculation
        document.querySelectorAll('#jumlahBarangExwork, #hpp, #keuntungan').forEach(function(element) {
            element.addEventListener('keyup', function(e) {
                e.target.value = formatRupiah(e.target.value); // Format as rupiah
                hitungExwork(); // Calculate Exwork
            });
        });

        document.querySelectorAll('#jumlahBarangFOB, #hargaExwork').forEach(function(element) {
            element.addEventListener('keyup', function(e) {
                e.target.value = formatRupiah(e.target.value); // Format as rupiah
                hitungFOB(); // Calculate Exwork
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
                hitungFOB();
            });
        <?php endforeach; ?>

        function tambahKolomKomponen(idTambahKolom, idContainer, idSubmitButton, placeholderText, inputName) {
            document.getElementById(idTambahKolom).addEventListener('click', function() {
                // Tampilkan container dan tombol submit jika belum tampil
                document.getElementById(idContainer).style.display = 'block';
                document.getElementById(idSubmitButton).style.display = 'inline-block';

                // Buat elemen baru
                var newField = document.createElement('div');
                newField.classList.add('form-group');
                newField.classList.add('komponenRow');

                // Buat input field baru dengan tombol hapus
                newField.innerHTML = `
                    <div class="input-group">
                        <input required type="text" class="form-control" name="` + inputName + `[]" placeholder="Masukkan Komponen ` + placeholderText + `" autocomplete="off">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger btn-remove-komponen"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                `;

                // Tambahkan ke container form
                document.getElementById(idContainer).appendChild(newField);

                // Update jumlah kolom
                updateJumlahKolom(idContainer, idSubmitButton);

                // Tambahkan event listener ke tombol hapus yang baru
                newField.querySelector('.btn-remove-komponen').addEventListener('click', function() {
                    newField.remove();

                    // Jika semua field dihapus, sembunyikan tombol submit dan container
                    if (document.querySelectorAll('#' + idContainer + ' .komponenRow').length === 0) {
                        document.getElementById(idContainer).style.display = 'none';
                        document.getElementById(idSubmitButton).style.display = 'none';
                    }

                    // Update jumlah kolom
                    updateJumlahKolom(idContainer, idSubmitButton);
                });
            });
        }

        // Function untuk update jumlah kolom komponen
        function updateJumlahKolom(idContainer, idSubmitButton) {
            var jumlahKolom = document.querySelectorAll('#' + idContainer + ' .komponenRow').length;

            // Update teks pada tombol Simpan Komponen
            document.getElementById(idSubmitButton).textContent = 'Simpan Komponen (' + jumlahKolom + ')';
        }

        // Panggil fungsi untuk Exwork dan FOB
        tambahKolomKomponen('tambahKolomExwork', 'komponenExworkContainer', 'submitKomponenExworkButton', 'Exwork', 'komponenExwork');
        tambahKolomKomponen('tambahKolomFOB', 'komponenFOBContainer', 'submitKomponenFOBButton', 'FOB', 'komponenFOB');
    </script>
</body>

</html>