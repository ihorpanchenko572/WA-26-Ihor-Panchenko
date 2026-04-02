<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if (empty($books)): ?>
        <div class="col-span-full p-10 text-center text-slate-400 italic bg-white rounded-xl border border-orange-200">
            V databázi se zatím nenachází žádné knihy.
        </div>
    <?php else: ?>
        <?php foreach ($books as $book): ?>
            <div class="bg-white border border-orange-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group">
                <div class="h-2 bg-gradient-to-r from-orange-300 to-orange-500"></div>
                
                <div class="p-6 flex-grow">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-xs font-mono text-orange-400">#<?= htmlspecialchars($book['id']) ?></span>
                        <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                            <?= htmlspecialchars($book['year']) ?>
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-orange-600 transition-colors mb-1">
                        <?= htmlspecialchars($book['title']) ?>
                    </h3>
                    <p class="text-slate-500 italic mb-4">od <?= htmlspecialchars($book['author']) ?></p>
                    
                    <div class="text-2xl font-black text-orange-500">
                        <?= htmlspecialchars($book['price']) ?> <span class="text-sm font-normal text-slate-400">Kč</span>
                    </div>
                </div>

                <div class="bg-orange-50/50 p-4 border-t border-orange-50 flex justify-around items-center">
                    <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-sm font-semibold text-slate-600 hover:text-orange-600 transition-colors">Detail</a>
                    <div class="h-4 w-px bg-orange-200"></div>
                    <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">Upravit</a>
                    <div class="h-4 w-px bg-orange-200"></div>
                    <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-sm font-semibold text-slate-600 hover:text-rose-600 transition-colors">Smazat</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>