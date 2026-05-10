<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport_<?= str_replace(' ', '_', $santri['name']) ?>_<?= $activeAY['year'] ?? '' ?></title>
    <style>
        /* ══ PRINT SETTINGS ══════════════════════════════════════════════════ */
        @page {
            size: A4 portrait;
            margin: 15mm 20mm 15mm 20mm;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }
        .container { max-width: 170mm; margin: 0 auto; }

        /* ══ KETERANGAN CETAK (hanya tampil di layar) ═══════════════════════ */
        .no-print {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 12px 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .no-print button {
            background: white;
            color: #1e40af;
            border: none;
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: bold;
            font-size: 10pt;
            cursor: pointer;
        }
        .no-print button:hover { background: #dbeafe; }

        /* ══ KANAN HEADER ════════════════════════════════════════════════════ */
        .header-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header-logo {
            width: 55px; height: 55px;
            border: 2px solid #000;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 20pt; font-weight: bold;
            flex-shrink: 0;
        }
        .header-text { flex: 1; text-align: center; }
        .header-text h1 { font-size: 14pt; text-transform: uppercase; letter-spacing: 1px; }
        .header-text .sub { font-size: 9pt; margin-top: 2px; }
        .header-text .addr { font-size: 8.5pt; color: #333; }

        /* ══ JUDUL ════════════════════════════════════════════════════════════ */
        .rapor-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 10px 0 6px;
            letter-spacing: 1px;
        }
        .rapor-subtitle {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 12px;
        }

        /* ══ METADATA SANTRI ════════════════════════════════════════════════ */
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .meta-table td { padding: 2px 4px; vertical-align: top; font-size: 10.5pt; }
        .meta-table .lbl { width: 135px; }
        .meta-table .sep { width: 12px; text-align: center; }

        /* ══ SECTION TITLE ═══════════════════════════════════════════════════ */
        .section-title {
            font-weight: bold;
            font-size: 10.5pt;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin: 10px 0 6px;
            display: block;
        }

        /* ══ TABEL NILAI ════════════════════════════════════════════════════ */
        table.nilai {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 10.5pt;
        }
        table.nilai th, table.nilai td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }
        table.nilai th {
            background: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .no-col   { width: 28px; text-align: center; }
        .ang-col  { width: 55px; text-align: center; }
        .hrf-col  { width: 45px; text-align: center; }
        .sub-header { background: #e8e8e8; font-weight: bold; font-style: italic; }
        .sum-row   { background: #f5f5f5; font-weight: bold; }

        /* ══ TABEL PERKEMBANGAN ═════════════════════════════════════════════ */
        table.perkembangan {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            margin-bottom: 6px;
        }
        table.perkembangan th, table.perkembangan td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }
        table.perkembangan th {
            background: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .kep-col  { width: 180px; }
        .bcl-col  { width: 35px; text-align: center; }
        .dot-fill { font-size: 14pt; line-height: 0; }

        /* ══ KETIDAKHADIRAN ════════════════════════════════════════════════ */
        table.absen {
            border-collapse: collapse;
            font-size: 10.5pt;
            margin-bottom: 6px;
        }
        table.absen th, table.absen td {
            border: 1px solid #000;
            padding: 4px 8px;
        }
        table.absen th { background: #f0f0f0; text-align: center; font-weight: bold; }

        /* ══ CATATAN ═════════════════════════════════════════════════════════ */
        .catatan-box {
            border: 1px solid #000;
            min-height: 50px;
            padding: 6px;
            font-size: 10pt;
            font-style: italic;
            margin-bottom: 8px;
        }

        /* ══ FOOTER TTD ══════════════════════════════════════════════════════ */
        table.footer {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }
        table.footer td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 0 4px;
            font-size: 10pt;
        }
        .ttd-space { height: 65px; }
        .nama-ttd { border-top: 1px solid #000; padding-top: 3px; font-weight: bold; }

        /* ══ PRINT HIDE ══════════════════════════════════════════════════════ */
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<!-- Toolbar (tidak ikut cetak) -->
<div class="no-print">
    <span>📄 Raport Santri — Siap Cetak</span>
    <button onclick="window.print()">🖨️ CETAK SEKARANG</button>
    <button onclick="window.history.back()" style="background:#e0e7ff; color:#3730a3; margin-left:6px;">← Kembali</button>
</div>

<div class="container">

    <!-- ══ KANAN HEADER ══════════════════════════════════════════════════ -->
    <div class="header-wrap">
        <div class="header-logo">☪</div>
        <div class="header-text">
            <h1>YAYASAN PENDIDIKAN ISLAM</h1>
            <div class="sub">TKA &bull; TPA PAKET A &amp; B</div>
            <div class="addr">Banyuasin, Sumatera Selatan &bull; Telp: (0711) xxxxxxx</div>
        </div>
        <div class="header-logo" style="font-size:9pt; border-radius:4px;">
            <div style="text-align:center; font-size:8pt;">
                Foto<br>Santri<br>3×4
            </div>
        </div>
    </div>

    <!-- ══ JUDUL ════════════════════════════════════════════════════════ -->
    <div class="rapor-title">HASIL EVALUASI BELAJAR</div>
    <div class="rapor-subtitle">
        Nama Santri : <strong><?= esc($santri['name']) ?></strong> &nbsp;|&nbsp;
        N.I.S : <strong><?= esc($santri['nisn'] ?? '-') ?></strong> &nbsp;|&nbsp;
        Kelas : <strong><?= esc($santri['class_name']) ?></strong> &nbsp;|&nbsp;
        Semester : <strong><?= esc($activeAY['semester'] ?? '-') ?></strong> &nbsp;|&nbsp;
        Tahun Pelajaran : <strong><?= esc($activeAY['year'] ?? '-') ?></strong>
    </div>

    <!-- ══ RAGAM PRESTASI ════════════════════════════════════════════════ -->
    <span class="section-title">Ragam Prestasi</span>
    <table class="nilai">
        <thead>
            <tr>
                <th class="no-col">No.</th>
                <th>Ragam Prestasi</th>
                <th class="ang-col">Angka</th>
                <th class="hrf-col">Huruf</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mapping kategori sesuai rapor fisik TKA/TPA
            $categories = [
                'a' => "Iqro'/Tartam Al-Qur'an",
                'b' => 'Ilmu Tajwid *)',
                'c' => 'Praktek Tajwid',
                'd' => 'Bacaan Islam *)',
                'e' => 'Hafalan Bacaan Sholat',
                'f' => 'Hafalan Doa Sehari-hari',
                'g' => 'Hafalan Surat-Surat Pendek',
                'h' => 'Hafalan Ayat-Ayat Pilihan',
                'i' => 'Menulis/Tahsinul Kitabah',
                'j' => 'Praktek Sholat',
            ];
            $muatanLokal = [
                'a' => 'Hafalan Hadits/Mahfuzhat',
                'b' => 'Bahasa Arab',
                'c' => 'Bahasa Inggris',
            ];

            // Build lookup map
            $gradeByCategory = [];
            foreach ($grades as $g) {
                $gradeByCategory[$g['category']] = $g;
            }

            $totalAngka  = 0;
            $countAngka  = 0;

            foreach ($categories as $alpha => $label) :
                $g     = $gradeByCategory[$label] ?? null;
                $score = $g['score_numeric'] ?? null;
                $letter= $g['score_letter'] ?? '';
                if ($score !== null) { $totalAngka += $score; $countAngka++; }
            ?>
                <tr>
                    <td class="no-col"><?= strtolower($alpha) ?>.</td>
                    <td><?= esc($label) ?></td>
                    <td class="ang-col"><?= $score !== null ? $score : '..........' ?></td>
                    <td class="hrf-col"><?= $score !== null ? $letter : '..........' ?></td>
                </tr>
            <?php endforeach; ?>

            <!-- Muatan Lokal -->
            <tr>
                <td colspan="4" class="sub-header" style="padding-left: 8px;">
                    11. Muatan Lokal :
                </td>
            </tr>
            <?php foreach ($muatanLokal as $alpha => $label) :
                $g     = $gradeByCategory[$label] ?? null;
                $score = $g['score_numeric'] ?? null;
                $letter= $g['score_letter'] ?? '';
                if ($score !== null) { $totalAngka += $score; $countAngka++; }
            ?>
                <tr>
                    <td class="no-col"><?= strtolower($alpha) ?>.</td>
                    <td style="padding-left: 20px;"><?= esc($label) ?></td>
                    <td class="ang-col"><?= $score !== null ? $score : '..........' ?></td>
                    <td class="hrf-col"><?= $score !== null ? $letter : '..........' ?></td>
                </tr>
            <?php endforeach; ?>

            <!-- Jumlah & Rata-rata -->
            <tr class="sum-row">
                <td colspan="2" style="text-align: right; padding-right: 10px;">Jumlah Nilai</td>
                <td class="ang-col"><?= $totalAngka ?: '..........' ?></td>
                <td class="hrf-col"></td>
            </tr>
            <tr class="sum-row">
                <td colspan="2" style="text-align: right; padding-right: 10px;">Nilai Rata-rata</td>
                <td class="ang-col"><?= $countAngka > 0 ? number_format($totalAngka / $countAngka, 1) : '..........' ?></td>
                <td class="hrf-col"></td>
            </tr>
            <tr class="sum-row">
                <td colspan="2" style="text-align: right; padding-right: 10px;">Rangking / Peringkat ke</td>
                <td class="ang-col">.....</td>
                <td class="hrf-col">dari ...... Santri</td>
            </tr>
        </tbody>
    </table>
    <p style="font-size:9pt; margin-bottom:10px;">*) Khusus Santri TPA Paket A</p>

    <!-- ══ PERKEMBANGAN INDIVIDU ═════════════════════════════════════════ -->
    <span class="section-title">Perkembangan Individu Santri</span>

    <table class="perkembangan">
        <thead>
            <tr>
                <th rowspan="2" style="width:30px;">No</th>
                <th rowspan="2">Kegiatan Ekstra Kurikulum dan Kepribadian</th>
                <th colspan="3">Nilai</th>
            </tr>
            <tr>
                <th class="bcl-col">B</th>
                <th class="bcl-col">C</th>
                <th class="bcl-col">K</th>
            </tr>
        </thead>
        <tbody>
            <!-- Kegiatan Ekstra Kurikulum -->
            <?php
            $ekskulRows = [];
            for ($i = 1; $i <= 3; $i++) {
                $kegiatan = $development["ekskul_{$i}"] ?? '';
                $nilai    = $development["ekskul_{$i}_nilai"] ?? null;
                $ekskulRows[] = ['kegiatan' => $kegiatan, 'nilai' => $nilai, 'no' => $i];
            }
            foreach ($ekskulRows as $row) :
                $k = $row['kegiatan'] ?: '.......................................';
                $v = $row['nilai'];
            ?>
                <tr>
                    <td style="text-align:center;"><?= $row['no'] ?>.</td>
                    <td><?= esc($k) ?></td>
                    <td class="bcl-col" style="text-align:center;"><?= $v === 'B' ? '✓' : '' ?></td>
                    <td class="bcl-col" style="text-align:center;"><?= $v === 'C' ? '✓' : '' ?></td>
                    <td class="bcl-col" style="text-align:center;"><?= $v === 'K' ? '✓' : '' ?></td>
                </tr>
            <?php endforeach; ?>

            <!-- Separator -->
            <tr>
                <td colspan="5" class="sub-header" style="padding-left:8px;">Kepribadian</td>
            </tr>
            <?php
            $kepItems = [
                'disiplin'           => '1. Kedisiplinan',
                'jujur'              => '2. Kejujuran',
                'kerja_sama'         => '3. Kerjasama',
                'rajin'              => '4. Kerajinan',
                'kemampuan_berfikir' => '5. Kemampuan Berfikir/Akal',
            ];
            foreach ($kepItems as $field => $label) :
                $val = $development[$field] ?? null;
            ?>
                <tr>
                    <td></td>
                    <td><?= $label ?></td>
                    <td class="bcl-col" style="text-align:center;"><?= $val === 'B' ? '✓' : '' ?></td>
                    <td class="bcl-col" style="text-align:center;"><?= $val === 'C' ? '✓' : '' ?></td>
                    <td class="bcl-col" style="text-align:center;"><?= $val === 'K' ? '✓' : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-size:9pt; padding:3px 6px;">B = Baik &nbsp;&nbsp; C = Cukup &nbsp;&nbsp; K = Kurang</td>
                <td class="bcl-col" style="text-align:center; font-weight:bold; font-size:9pt;">Baik</td>
                <td class="bcl-col" style="text-align:center; font-weight:bold; font-size:9pt;">Cukup</td>
                <td class="bcl-col" style="text-align:center; font-weight:bold; font-size:9pt;">Kurang</td>
            </tr>
        </tfoot>
    </table>

    <!-- ══ KETIDAKHADIRAN ════════════════════════════════════════════════ -->
    <table class="absen">
        <thead>
            <tr>
                <th colspan="4" style="text-align:left; padding-left:6px;">Ketidakhadiran</th>
            </tr>
            <tr>
                <th>1. Sakit</th>
                <th>2. Izin</th>
                <th>3. Tanpa Keterangan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center; width:80px;">
                    <?= ($development['sakit_hari'] ?? 0) ?> hari
                </td>
                <td style="text-align:center; width:80px;">
                    <?= ($development['izin_hari'] ?? 0) ?> hari
                </td>
                <td style="text-align:center; width:120px;">
                    <?= ($development['tanpa_keterangan_hari'] ?? 0) ?> hari
                </td>
                <td style="width:180px; padding:4px 6px; font-size:9.5pt;">
                    <?php
                    $totalAbsen = ($development['sakit_hari'] ?? 0)
                                + ($development['izin_hari'] ?? 0)
                                + ($development['tanpa_keterangan_hari'] ?? 0);
                    echo $totalAbsen > 0 ? "Total tidak hadir: {$totalAbsen} hari" : "Sempurna, tidak pernah absen";
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ══ CATATAN WALI KELAS ════════════════════════════════════════════ -->
    <div style="margin-top: 8px;">
        <div style="font-weight:bold; font-size:10pt; margin-bottom:4px;">
            Catatan Untuk Orang Tua / Wali :
        </div>
        <div class="catatan-box">
            <?php if (!empty($development['teacher_notes'])) : ?>
                <?= esc($development['teacher_notes']) ?>
            <?php else : ?>
                &nbsp;
            <?php endif; ?>
        </div>
    </div>

    <!-- ══ TANDA TANGAN ══════════════════════════════════════════════════ -->
    <table class="footer">
        <tr>
            <td>
                Mengetahui,<br>Orang Tua / Wali
                <div class="ttd-space"></div>
                <div class="nama-ttd">( ................................ )</div>
            </td>
            <td>
                <?= $activeAY['year'] ?? date('Y') ?>, Banyuasin .............. 20.....
                <br>Kepala Unit,
                <div class="ttd-space"></div>
                <div class="nama-ttd">N.I.P. ...............................&nbsp;</div>
            </td>
            <td>
                &nbsp;<br>Wali Kelas
                <div class="ttd-space"></div>
                <div class="nama-ttd"><?= esc($teacher) ?></div>
            </td>
        </tr>
    </table>

</div><!-- /container -->

<script>
    // Cetak otomatis jika ada query ?autoprint=1
    if (new URLSearchParams(window.location.search).get('autoprint') === '1') {
        window.onload = () => window.print();
    }
</script>
</body>
</html>
