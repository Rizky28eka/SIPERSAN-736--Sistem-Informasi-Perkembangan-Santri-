<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport_<?= str_replace(' ', '_', $santri['name']) ?>_<?= $activeAY['year'] ?? '' ?></title>
    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; background: #fff; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: auto; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18pt; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 10pt; }
        
        .title { text-align: center; font-weight: bold; font-size: 14pt; text-transform: uppercase; margin-bottom: 20px; text-decoration: underline; }
        
        .metadata { width: 100%; margin-bottom: 20px; }
        .metadata td { padding: 3px 5px; vertical-align: top; }
        .metadata .label { width: 150px; }
        .metadata .separator { width: 10px; text-align: center; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        
        .section-title { font-weight: bold; margin-bottom: 10px; display: block; text-transform: uppercase; font-size: 11pt; border-bottom: 1px solid #000; width: fit-content; }
        
        .footer { margin-top: 50px; width: 100%; }
        .footer td { text-align: center; width: 33.33%; padding-top: 10px; }
        .signature-space { height: 80px; }
        
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
        
        .summary-box { border: 1px solid #000; padding: 10px; margin-top: 10px; min-height: 60px; }
    </style>
</head>
<body>
    <div class="no-print" style="background: #f4f4f4; padding: 10px; text-align: center; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #007bff; color: #fff; border: none; border-radius: 5px; font-weight: bold;">CETAK RAPORT SEKARANG</button>
    </div>

    <div class="container">
        <!-- School Header -->
        <div class="header">
            <h1>YAYASAN PENDIDIKAN ISLAM SIPERSAN</h1>
            <p>Jl. Pembangunan No. 45, Jakarta Selatan. Telp: (021) 1234567</p>
            <p>Email: info@sipersan.sch.id | Website: www.sipersan.sch.id</p>
        </div>

        <div class="title">LAPORAN HASIL BELAJAR SANTRI (RAPORT)</div>

        <!-- Student Metadata -->
        <table class="metadata">
            <tr>
                <td class="label">Nama Santri</td><td class="separator">:</td><td class="value"><strong><?= $santri['name'] ?></strong></td>
                <td class="label">Semester</td><td class="separator">:</td><td class="value"><?= $activeAY['semester'] ?? '-' ?> (Ganjil)</td>
            </tr>
            <tr>
                <td class="label">NISN</td><td class="separator">:</td><td class="value"><?= $santri['nisn'] ?></td>
                <td class="label">Tahun Ajaran</td><td class="separator">:</td><td class="value"><?= $activeAY['year'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label">Kelas</td><td class="separator">:</td><td class="value"><?= $santri['class_name'] ?></td>
                <td class="label">Tanggal Cetak</td><td class="separator">:</td><td class="value"><?= date('d F Y') ?></td>
            </tr>
        </table>

        <!-- Academic Grades -->
        <span class="section-title">A. Nilai Akademik & Al-Qur'an</span>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Mata Pelajaran / Materi</th>
                    <th style="width: 80px;">Angka</th>
                    <th style="width: 80px;">Huruf</th>
                    <th>Deskripsi Kemajuan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($grades)) : ?>
                    <tr><td colspan="5" style="text-align: center; font-style: italic;">Data nilai belum tersedia</td></tr>
                <?php else : ?>
                    <?php foreach ($grades as $index => $g) : ?>
                        <tr>
                            <td style="text-align: center;"><?= $index + 1 ?></td>
                            <td><?= $g['category'] ?></td>
                            <td style="text-align: center; font-weight: bold;"><?= $g['score_numeric'] ?></td>
                            <td style="text-align: center;"><?= $g['score_letter'] ?></td>
                            <td style="font-size: 10pt;"><?= $g['notes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Attendance -->
        <span class="section-title">B. Ketidakhadiran</span>
        <table class="data-table" style="width: 50%;">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th style="width: 100px;">Jumlah Hari</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sakit = count(array_filter($attendance, fn($a) => $a['status'] == 'Sakit'));
                $izin = count(array_filter($attendance, fn($a) => $a['status'] == 'Izin'));
                $alfa = count(array_filter($attendance, fn($a) => $a['status'] == 'Alfa'));
                ?>
                <tr><td>Sakit</td><td style="text-align: center;"><?= $sakit ?></td></tr>
                <tr><td>Izin</td><td style="text-align: center;"><?= $izin ?></td></tr>
                <tr><td>Tanpa Keterangan (Alfa)</td><td style="text-align: center;"><?= $alfa ?></td></tr>
            </tbody>
        </table>

        <!-- Development & Character -->
        <span class="section-title">C. Perkembangan Karakter & Ekstrakurikuler</span>
        <table class="data-table">
            <tr>
                <td style="width: 200px; font-weight: bold; vertical-align: top;">Kegiatan Ekstrakurikuler</td>
                <td><?= $development['extracurricular'] ?? '-' ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; vertical-align: top;">Akhlak & Kepribadian</td>
                <td style="font-style: italic;"><?= $development['personality'] ?? '-' ?></td>
            </tr>
        </table>

        <span class="section-title">D. Catatan Wali Kelas</span>
        <div class="summary-box">
            <?= $development['teacher_notes'] ?? 'Ananda menunjukkan perkembangan yang baik, tingkatkan terus semangat belajarnya.' ?>
        </div>

        <!-- Signature Section -->
        <table class="footer">
            <tr>
                <td>
                    Mengetahui,<br>Orang Tua/Wali Santri
                    <div class="signature-space"></div>
                    ( .................................... )
                </td>
                <td>
                    <br>Kepala Yayasan
                    <div class="signature-space"></div>
                    <strong>Drs. H. Ahmad Fauzi, M.Pd.I</strong>
                </td>
                <td>
                    Jakarta, <?= date('d F Y') ?><br>Wali Kelas
                    <div class="signature-space"></div>
                    <strong><?= $teacher ?></strong>
                </td>
            </tr>
        </table>
    </div>

    <script>
        // Auto-print when page loads if needed
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
