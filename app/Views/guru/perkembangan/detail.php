<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Form Input (Kiri) -->
    <div class="lg:col-span-1 space-y-6">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('guru/perkembangan/list/' . $santri['class_id']) ?>" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800"><?= esc($santri['name']) ?></h1>
                <p class="text-slate-500 text-sm">Input catatan harian baru</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <form action="<?= base_url('guru/perkembangan/store') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>
                <input type="hidden" name="santri_id" value="<?= $santri['id'] ?>">

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="date" value="<?= date('Y-m-d') ?>" required
                           class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-slate-600 font-bold focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Subjek / Materi</label>
                    <input type="text" name="subject" required placeholder="Contoh: Hafalan, Adab, atau Materi"
                           class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-slate-600 font-bold focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan Perkembangan</label>
                    <textarea name="note" rows="4" required placeholder="Tulis perkembangan santri hari ini..."
                              class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-slate-600 focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Status</label>
                    <select name="status" class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-slate-600 font-bold focus:ring-2 focus:ring-blue-500">
                        <option value="normal">Normal / Baik</option>
                        <option value="need_attention">Perlu Perhatian Khusus</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95 duration-150">
                    Simpan Catatan
                </button>
            </form>
        </div>
    </div>

    <!-- Riwayat (Kanan) -->
    <div class="lg:col-span-2 space-y-6">
        <h2 class="text-xl font-bold text-slate-800">Riwayat Catatan Harian</h2>
        
        <div class="space-y-4">
            <?php if (empty($history)) : ?>
                <div class="bg-white p-12 rounded-3xl border border-dashed border-slate-200 text-center">
                    <p class="text-slate-400 italic">Belum ada catatan untuk santri ini.</p>
                </div>
            <?php else : ?>
                <?php foreach ($history as $h) : ?>
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all relative group">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                    <i data-lucide="calendar" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800"><?= esc($h['subject']) ?></h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><?= date('d F Y', strtotime($h['date'])) ?></p>
                                </div>
                            </div>
                            <?php if ($h['status'] === 'need_attention') : ?>
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-red-100">Perhatian</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed"><?= nl2br(esc($h['note'])) ?></p>
                        
                        <a href="<?= base_url('guru/perkembangan/delete/' . $h['id']) ?>" 
                           onclick="return confirm('Hapus catatan ini?')"
                           class="absolute top-4 right-4 text-red-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all p-2">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
