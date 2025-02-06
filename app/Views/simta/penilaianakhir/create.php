<!DOCTYPE html>
<html>
<head>
    <title>Create Hasilakhir</title>
</head>
<body>
    <h1>Create Hasilakhir</h1>

    <form action="/hasilakhir/store" method="POST">
        <label for="id_ujianproposal">Ujian Proposal</label>
        <select name="id_ujianproposal" required>
            <?php foreach ($ujianproposalOptions as $option): ?>
                <option value="<?= $option['id_ujianproposal'] ?>"><?= $option['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="id_seminarhasil">Seminar Hasil</label>
        <select name="id_seminarhasil" required>
            <?php foreach ($seminarhasilOptions as $option): ?>
                <option value="<?= $option['id_seminarhasil'] ?>"><?= $option['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="id_ujianta">Ujian TA</label>
        <select name="id_ujianta" required>
            <?php foreach ($ujiantaOptions as $option): ?>
                <option value="<?= $option['id_ujianta'] ?>"><?= $option['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="id_mhs">Mahasiswa</label>
        <select name="id_mhs" required>
            <?php foreach ($mahasiswaOptions as $option): ?>
                <option value="<?= $option['id_mhs'] ?>"><?= $option['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="id_staf">Staf</label>
        <select name="id_staf" required>
            <?php foreach ($stafOptions as $option): ?>
                <option value="<?= $option['id_staf'] ?>"><?= $option['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="hasil_akhir">Hasil Akhir</label>
        <input type="text" name="hasil_akhir" required>
        <br>

        <input type="submit" value="Create">
    </form>
</body>
</html>
