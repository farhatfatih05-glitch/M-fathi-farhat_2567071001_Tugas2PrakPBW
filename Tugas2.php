
<?php

function hitungNilaiAkhir($tugas, $uts, $uas) {
    $nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);
    return $nilaiAkhir;
}

function tentukanGrade($nilaiAkhir) {
    if ($nilaiAkhir >= 85) {
        return "A";
    } elseif ($nilaiAkhir >= 75) {
        return "B";
    } elseif ($nilaiAkhir >= 65) {
        return "C";
    } elseif ($nilaiAkhir >= 50) {
        return "D";
    } else {
        return "E";
    }
}

function tentukanStatus($nilaiAkhir) {
    if ($nilaiAkhir >= 65) {
        return "Lulus";
    } else {
        return "Tidak Lulus";
    }
}

$hasil = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = trim($_POST["nama"]);
    $nim = trim($_POST["nim"]);
    $tugas = $_POST["tugas"];
    $uts = $_POST["uts"];
    $uas = $_POST["uas"];

    if (
        $nama == "" ||
        $nim == "" ||
        $tugas === "" ||
        $uts === "" ||
        $uas === ""
    ) {
        $error = "Semua data harus diisi!";
    } elseif (
        !is_numeric($tugas) ||
        !is_numeric($uts) ||
        !is_numeric($uas)
    ) {
        $error = "Nilai harus berupa angka!";
    } elseif (
        $tugas < 0 || $tugas > 100 ||
        $uts < 0 || $uts > 100 ||
        $uas < 0 || $uas > 100
    ) {
        $error = "Nilai harus berada dalam rentang 0 sampai 100!";
    } else {

        $tugas = (float) $tugas;
        $uts = (float) $uts;
        $uas = (float) $uas;

        $nilaiAkhir = hitungNilaiAkhir($tugas, $uts, $uas);
        $grade = tentukanGrade($nilaiAkhir);
        $status = tentukanStatus($nilaiAkhir);

        $hasil = true;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghitung Nilai Mahasiswa</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #333;
            padding: 30px 15px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 25px;
        }

        h3 {
            color: #1e40af;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 4px rgba(37, 99, 235, 0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1d4ed8;
        }

        .error {
            margin-top: 15px;
            padding: 12px;
            background: #fee2e2;
            color: #b91c1c;
            border-radius: 6px;
        }

        .hasil {
            margin-top: 25px;
            padding: 20px;
            background: #eff6ff;
            border-radius: 8px;
            border-left: 5px solid #2563eb;
        }

        .hasil p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .nilai-akhir {
            color: #2563eb;
            font-size: 22px;
            font-weight: bold;
        }

        .status {
            color: #15803d;
            font-weight: bold;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Program Penghitung Nilai Mahasiswa</h2>

    <form method="POST">

        <div class="form-group">
            <label>Nama Mahasiswa:</label>
            <input type="text" name="nama" required>
        </div>

        <div class="form-group">
            <label>NIM:</label>
            <input type="text" name="nim" required>
        </div>

        <div class="form-group">
            <label>Nilai Tugas:</label>
            <input type="number" name="tugas" min="0" max="100" step="any" required>
        </div>

        <div class="form-group">
            <label>Nilai UTS:</label>
            <input type="number" name="uts" min="0" max="100" step="any" required>
        </div>

        <div class="form-group">
            <label>Nilai UAS:</label>
            <input type="number" name="uas" min="0" max="100" step="any" required>
        </div>

        <button type="submit">Hitung Nilai</button>

    </form>

    <?php if ($error != ""): ?>
        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($hasil): ?>
        <div class="hasil">

            <h3>Hasil Perhitungan</h3>

            <p>Nama: <?php echo htmlspecialchars($nama); ?></p>
            <p>NIM: <?php echo htmlspecialchars($nim); ?></p>
            <p>Nilai Tugas: <?php echo $tugas; ?></p>
            <p>Nilai UTS: <?php echo $uts; ?></p>
            <p>Nilai UAS: <?php echo $uas; ?></p>

            <hr>

            <p class="nilai-akhir">
                Nilai Akhir:
                <?php echo number_format($nilaiAkhir, 2, ',', '.'); ?>
            </p>

            <p>Grade: <?php echo $grade; ?></p>
            <p class="status">Status: <?php echo $status; ?></p>

        </div>
    <?php endif; ?>

</div>

</body>
</html>
