<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Detail knihy - <?= htmlspecialchars($book['title']) ?></title>
</head>
<body class="bg-orange-50 text-slate-800 min-h-screen font-sans">

    <header class="bg-gradient-to-b from-orange-400 to-orange-600 border-b border-orange-700 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <h1 class="text-2xl font-bold tracking-tight text-white uppercase italic">
                Detail <span class="text-orange-100 font-light">knihy</span>
            </h1>
        </div>
    </header>

    <main class="container mx-auto px-6 py-10">
        
        <div class="mb-8">
            <a href="<?= BASE_URL ?>/index.php" class="inline-flex items-center text-orange-600 hover:text-orange-800 transition-colors font-medium">
                <span class="mr-2">←</span> Zpět na seznam knih
            </a>
        </div>

        <div class="bg-white border border-orange-200 rounded-2xl shadow-xl overflow-hidden max-w-4xl mx-auto">
            <div class="h-3 bg-gradient-to-r from-orange-300 via-orange-500 to-orange-400"></div>
            
            <div class="p-8 md:p-12">
                <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                    
                    <div class="flex-grow">
                        <h2 class="text-4xl font-black text-slate-900 leading-tight mb-2 uppercase italic">
                            <?= htmlspecialchars($book['title']) ?>
                        </h2>
                        <p class="text-2xl text-orange-600 font-light mb-6">od <?= htmlspecialchars($book['author']) ?></p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8 text-sm">
                            <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                                <span class="block text-orange-400 uppercase font-bold text-xs tracking-widest mb-1">Kategorie</span>
                                <span class="text-slate-700 font-semibold"><?= htmlspecialchars($book['category']) ?></span>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                                <span class="block text-orange-400 uppercase font-bold text-xs tracking-widest mb-1">Podkategorie</span>
                                <span class="text-slate-700 font-semibold"><?= htmlspecialchars($book['subcategory'] ?? '---') ?></span>
                            </div>
                            <div class="p-4">
                                <span class="block text-slate-400 uppercase font-bold text-xs tracking-widest mb-1">Rok vydání</span>
                                <span class="text-slate-700 font-mono text-lg"><?= htmlspecialchars($book['year']) ?></span>
                            </div>
                            <div class="p-4">
                                <span class="block text-slate-400 uppercase font-bold text-xs tracking-widest mb-1">ISBN</span>
                                <span class="text-slate-700 font-mono text-lg"><?= htmlspecialchars($book['isbn'] ?? 'Není uvedeno') ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full md:w-64 flex flex-col items-center md:items-end">
                        <div class="bg-slate-900 text-white p-6 rounded-2xl shadow-lg w-full text-center">
                            <span class="block text-orange-400 text-xs uppercase font-bold mb-1">Prodejní cena</span>
                            <span class="text-3xl font-black italic"><?= htmlspecialchars($book['price']) ?> Kč</span>
                        </div>
                        
                        <div class="mt-6 flex flex-col w-full gap-3">
                            <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="w-full text-center py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-bold transition-all shadow-md">Upravit údaje</a>
                            <?php if (!empty($book['link'])): ?>
                                <a href="<?= $book['link'] ?>" target="_blank" class="w-full text-center py-3 bg-orange-100 text-orange-700 border border-orange-200 rounded-lg font-bold hover:bg-orange-200 transition-all">Externí odkaz</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-orange-100">
                    <h3 class="text-sm uppercase font-bold text-orange-400 tracking-widest mb-4 italic">Popis a poznámky</h3>
                    <div class="text-slate-600 leading-relaxed italic">
                        <?= !empty($book['description']) ? nl2br(htmlspecialchars($book['description'])) : 'K této knize nebyl vložen žádný popis.' ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-auto border-t border-orange-200 py-8 text-center">
        <p class="text-orange-800/40 text-sm tracking-widest uppercase italic">&copy; WA 2026 - Detailní náhled knihy</p>
    </footer>

</body>
</html>