<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
$rows = is_array($pesanan ?? []) ? ($pesanan ?? []) : [];

/**
 * Ambil tanggal acuan laporan:
 * - utamakan tanggal_selesai (karena laporan transaksi selesai)
 * - fallback ke created_at
 */
$parseDate = function (array $p): ?DateTimeImmutable {
    $raw = (string)($p['tanggal_selesai'] ?? '');
    if ($raw === '' || $raw === '-' ) {
        $raw = (string)($p['created_at'] ?? '');
    }
    $raw = trim($raw);
    if ($raw === '') return null;

    try {
        return new DateTimeImmutable($raw);
    } catch (Throwable $e) {
        return null;
    }
};

$weekRangeLabel = function (int $isoYear, int $isoWeek): string {
    // ISO week: Senin sebagai awal minggu
    $start = (new DateTimeImmutable())->setISODate($isoYear, $isoWeek, 1)->setTime(0, 0, 0);
    $end   = $start->modify('+6 days');
    return $start->format('d M Y') . ' - ' . $end->format('d M Y');
};

// Group per ISO week
$weekly = []; // key => ['isoYear'=>, 'isoWeek'=>, 'count'=>, 'total'=>, 'items'=>[]]
foreach ($rows as $p) {
    $dt = $parseDate($p);
    if (!$dt) continue;

    $isoYear = (int)$dt->format('o'); // ISO year
    $isoWeek = (int)$dt->format('W'); // 01..53
    $key = $isoYear . '-W' . str_pad((string)$isoWeek, 2, '0', STR_PAD_LEFT);

    $tarif = (float)($p['tarif'] ?? 0);
    $berat = (float)($p['berat_kg'] ?? 0);
    $total = $tarif * $berat;

    if (!isset($weekly[$key])) {
        $weekly[$key] = [
            'isoYear' => $isoYear,
            'isoWeek' => $isoWeek,
            'count'   => 0,
            'total'   => 0.0,
            'items'   => [],
        ];
    }

    $weekly[$key]['count']++;
    $weekly[$key]['total'] += $total;
    $weekly[$key]['items'][] = $p + [
        '__total' => $total,
        '__date'  => $dt->format('Y-m-d H:i:s'),
    ];
}

// Urutkan minggu terbaru dulu
uksort($weekly, function ($a, $b) {
    // format: YYYY-Www (string), bisa dibandingkan secara lexicographic untuk urutan tahun+minggu
    return strcmp($b, $a);
});

$totalTransaksi = 0;
$totalPendapatan = 0.0;
foreach ($weekly as $w) {
    $totalTransaksi += (int)$w['count'];
    $totalPendapatan += (float)$w['total'];
}
?>

<style>
    .page-card { border: none; border-radius: 15px; overflow: hidden; }
    .page-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .page-header .status-badge{
        background: rgba(255,255,255,0.2);
        padding: 8px 14px;
        border-radius: 20px;
        font-size: .9rem;
        display:inline-block;
        white-space: nowrap;
    }
    .info-section{
        background:#f8f9fc;
        border-radius:10px;
        padding:16px 16px;
        margin-bottom:16px;
        border:1px solid #eaecf4;
    }
    .helper-text{ font-size:.85rem; color:#858796; }
    .mono{ font-variant-numeric: tabular-nums; }
    .btn-icon{ width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; }
    .table thead th{ vertical-align: middle; }
    .table-hover tbody tr:hover{ background:#f8f9fc; }
    .week-card { border: 1px solid #eaecf4; border-radius: 12px; overflow:hidden; }
    .week-head {
        background: #f8f9fc;
        padding: 14px 16px;
        display:flex;
        align-items:center;
        justify-content: space-between;
        gap: 10px;
        cursor: pointer;
    }
    .week-meta { font-size: .9rem; color:#4b5563; }
    .week-total { font-weight: 700; }
    .week-pill {
        background: rgba(78,115,223,.12);
        color:#224abe;
        padding:6px 10px;
        border-radius:999px;
        font-weight:600;
        white-space:nowrap;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            <div class="card page-card shadow mb-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-history mr-2"></i>Laporan Mingguan (Riwayat Transaksi)
                            </h4>
                            <div class="helper-text text-white-50">Ringkasan pendapatan per minggu + detail transaksi.</div>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <span class="status-badge mr-2">
                                <i class="fas fa-list mr-1"></i>Total: <?= esc($totalTransaksi) ?>
                            </span>
                            <span class="status-badge">
                                <i class="fas fa-money-bill-wave mr-1"></i>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label class="small text-muted mb-1">Filter Minggu</label>
                                <select id="weekFilter" class="form-control">
                                    <option value="">Semua Minggu</option>
                                    <?php foreach ($weekly as $key => $w): ?>
                                        <?php
                                            $label = 'Minggu ' . str_pad((string)$w['isoWeek'], 2, '0', STR_PAD_LEFT)
                                                . ' (' . $weekRangeLabel((int)$w['isoYear'], (int)$w['isoWeek']) . ')';
                                        ?>
                                        <option value="<?= esc($key) ?>"><?= esc($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="helper-text mt-2">Pilih minggu untuk melihat pendapatan perminggu.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Catatan</label>
                                <div class="form-control bg-white" style="height:auto;">
                                    <span class="helper-text">Total dihitung dari <b>tarif × berat</b>. Tanggal acuan: <b>tanggal_selesai</b> (fallback: created_at).</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="weeklyWrap">
                        <?php if (empty($weekly)): ?>
                            <div class="alert alert-warning mb-0">Belum ada data transaksi untuk dibuat laporan mingguan.</div>
                        <?php else: ?>
                            <?php foreach ($weekly as $key => $w): ?>
                                <?php
                                    $isoWeekLabel = 'Minggu ' . str_pad((string)$w['isoWeek'], 2, '0', STR_PAD_LEFT);
                                    $rangeLabel = $weekRangeLabel((int)$w['isoYear'], (int)$w['isoWeek']);
                                ?>
                                <div class="week-card mb-3" data-week="<?= esc($key) ?>">
                                    <div class="week-head" data-toggle="collapse" data-target="#weekBody-<?= esc($key) ?>" aria-expanded="false" aria-controls="weekBody-<?= esc($key) ?>">
                                        <div>
                                            <div class="week-pill d-inline-block mb-1"><?= esc($isoWeekLabel) ?> &middot; <?= esc($rangeLabel) ?></div>
                                            <div class="week-meta">
                                                Total transaksi: <b><?= esc((string)$w['count']) ?></b>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="week-meta">Pendapatan</div>
                                            <div class="week-total mono">Rp <?= number_format((float)$w['total'], 0, ',', '.') ?></div>
                                        </div>
                                    </div>

                                    <div id="weekBody-<?= esc($key) ?>" class="collapse">
                                        <div class="p-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle mb-0">
                                                    <thead class="table-light text-center">
                                                        <tr>
                                                            <th style="width:70px;">No</th>
                                                            <th>No Resi</th>
                                                            <th>Nama Pelanggan</th>
                                                            <th>Jenis Laundry</th>
                                                            <th style="width:120px;">Tarif</th>
                                                            <th style="width:90px;">Berat</th>
                                                            <th style="width:140px;">Total</th>
                                                            <th style="width:140px;">Status</th>
                                                            <th>Keterangan</th>
                                                            <th style="width:90px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1; foreach (($w['items'] ?? []) as $p): ?>
                                                            <?php
                                                                $tarif = (float)($p['tarif'] ?? 0);
                                                                $berat = (float)($p['berat_kg'] ?? 0);
                                                                $total = (float)($p['__total'] ?? ($tarif * $berat));
                                                            ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td class="mono font-weight-bold"><?= esc($p['no_resi'] ?? '-') ?></td>
                                                                <td><?= esc($p['nama_pelanggan'] ?? '-') ?></td>
                                                                <td><?= esc($p['jenis_laundry'] ?? '-') ?></td>
                                                                <td class="text-right mono">Rp <?= number_format($tarif, 0, ',', '.') ?></td>
                                                                <td class="text-center mono"><?= esc((string)($p['berat_kg'] ?? '-')) ?> Kg</td>
                                                                <td class="text-right mono font-weight-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
                                                                <td class="text-center">
                                                                    <span class="badge badge-info"><?= esc($p['status'] ?? '-') ?></span>
                                                                    <?php if (($p['status'] ?? '') === 'Selesai' && !empty($p['status_selesai'])): ?>
                                                                        <div class="small text-muted fst-italic">(<?= esc($p['status_selesai']) ?>)</div>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (($p['status'] ?? '') === 'Selesai'): ?>
                                                                        <?php if (($p['status_selesai'] ?? '') === 'Sudah Diambil'): ?>
                                                                            <span class="text-success"><i class="fas fa-check-circle mr-1"></i>Sudah diambil</span>
                                                                            <?= !empty($p['nama_pelanggan']) ? ' oleh: ' . esc($p['nama_pelanggan']) : '' ?>
                                                                        <?php elseif (($p['status_selesai'] ?? '') === 'Belum Diambil'): ?>
                                                                            <span class="text-warning"><i class="fas fa-clock mr-1"></i>Belum diambil</span>
                                                                        <?php else: ?>
                                                                            <span class="text-success">Selesai</span>
                                                                        <?php endif; ?>

                                                                        <?php if (!empty($p['id_washer'])): ?>
                                                                            <div class="small text-muted">
                                                                                Washer: <?= esc($p['id_washer']) ?><?= !empty($p['nama_washer']) ? ' (' . esc($p['nama_washer']) . ')' : '' ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="<?= base_url('/pesanan/riwayat_struk/' . ($p['id_pesanan'] ?? '')) ?>"
                                                                       class="btn btn-sm btn-outline-success btn-icon"
                                                                       title="Cetak"
                                                                       target="_blank" rel="noopener">
                                                                        <i class="fas fa-print"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div><!-- /card-body -->
            </div><!-- /card -->

        </div>
    </div>
</div>

<script>
(function () {
    const sel = document.getElementById('weekFilter');
    const wrap = document.getElementById('weeklyWrap');
    if (!sel || !wrap) return;

    function applyWeekFilter() {
        const key = (sel.value || '').trim();
        const cards = wrap.querySelectorAll('[data-week]');
        let shown = 0;

        cards.forEach(card => {
            const ok = !key || card.getAttribute('data-week') === key;
            card.style.display = ok ? '' : 'none';
            if (ok) shown++;
        });
    }

    sel.addEventListener('change', applyWeekFilter);
    applyWeekFilter();
})();
</script>

<?= $this->endSection(); ?>