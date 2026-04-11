<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    
    <div class="max-w-3xl mx-auto">
        <div class="mb-8 flex items-end justify-between border-b border-orange-900/30 pb-4">
            <div>
                <h2 class="text-4xl font-black tracking-tighter text-white uppercase">
                    Upravit <span class="text-orange-600">knihu</span> 
                    <span class="text-orange-400/50 text-2xl ml-2">#<?= htmlspecialchars($book['id']) ?></span>
                </h2>
                <p class="text-orange-300/60 italic mt-2 text-sm">Aktualizace záznamu: <strong class="text-orange-200"><?= htmlspecialchars($book['title']) ?></strong></p>
            </div>
            <a href="<?= BASE_URL ?>/index.php" class="text-orange-500/70 hover:text-orange-400 transition-colors text-xs font-bold uppercase tracking-[0.2em] mb-1">
                &larr; Zpět do archivu
            </a>
        </div>
        
        <div class="bg-[#161616] border border-orange-900/40 rounded-2xl shadow-2xl p-6 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-600/5 blur-[80px] rounded-full"></div>

            <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="relative z-10">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="md:col-span-1">
                        <label for="id_display" class="block text-xs font-bold text-orange-700 mb-2 uppercase tracking-widest">ID v systému</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly 
                               class="w-full bg-black/50 border border-orange-900/30 rounded-lg px-4 py-3 text-orange-900 font-mono cursor-not-allowed">
                    </div>

                    <div class="md:col-span-1">
                        <label for="title" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Název knihy <span class="text-orange-600">*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all placeholder-orange-900">
                    </div>
                    
                    <div>
                        <label for="author" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Autor <span class="text-orange-600">*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>
                    
                    <div>
                        <label for="isbn" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">ISBN</label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>

                    <div>
                        <label for="year" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Rok vydání</label>
                        <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>
                    
                    <div>
                        <label for="price" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Cena (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Kategorie</label>
                        <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category']) ?>" 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>
                    
                    <div>
                        <label for="subcategory" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory']) ?>" 
                               class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="description" class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Popis díla</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full bg-orange-950/10 border border-orange-800/40 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>    
                    
                    <div class="md:col-span-2 border-t border-orange-900/20 pt-6">
                        <label class="block text-xs font-bold text-orange-400/80 mb-3 uppercase tracking-widest">Aktuálně uložené soubory</label>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <?php 
                            $currentImages = json_decode($book['images'] ?? '[]', true);
                            if (!empty($currentImages)): 
                                foreach ($currentImages as $img): ?>
                                    <div class="bg-black/50 border border-orange-800/30 rounded px-3 py-2 flex items-center shadow-inner">
                                        <span class="text-orange-200 text-[11px] font-mono italic"><?= htmlspecialchars($img) ?></span>
                                    </div>
                                <?php endforeach; 
                            else: ?>
                                <p class="text-orange-900 text-xs italic">V databázi nejsou uloženy žádné obrázky.</p>
                            <?php endif; ?>
                        </div>

                        <label class="block text-xs font-bold text-orange-400/80 mb-2 uppercase tracking-widest">Nahrát nové obrázky</label>
                        <div class="w-full">
                            <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-orange-900/40 border-dashed rounded-xl cursor-pointer bg-orange-950/5 hover:bg-orange-900/10 hover:border-orange-500 transition-all group">
                                <div class="flex flex-col items-center justify-center pt-2">
                                    <span id="file-title" class="text-[11px] text-orange-300/60 group-hover:text-orange-400 font-bold tracking-widest uppercase">Klikni pro výběr souborů</span>
                                    <span id="file-info" class="text-[10px] text-orange-700 mt-2 bg-black/40 px-2 py-1 rounded border border-orange-900/20 shadow-sm text-center">
                                        POZOR: Nový výběr přepíše všechny stávající obrázky!
                                    </span>
                                </div>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 mt-6">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-black py-4 px-6 rounded-lg shadow-[0_10px_20px_rgba(234,88,12,0.2)] transition-all uppercase tracking-[0.25em] text-sm active:scale-[0.98]">
                            Potvrdit změny a uložit
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('images');
        const fileTitle = document.getElementById('file-title');
        const fileInfo = document.getElementById('file-info');

        fileInput.addEventListener('change', function(event) {
            const files = event.target.files;
            
            if (files.length === 0) {
                fileTitle.textContent = 'Klikni pro výběr souborů';
                fileTitle.className = 'text-[11px] text-orange-300/60 font-bold uppercase tracking-widest';
                fileInfo.textContent = 'POZOR: Nový výběr přepíše všechny stávající obrázky!';
            } else if (files.length === 1) {
                fileTitle.textContent = 'Soubor připraven';
                fileTitle.className = 'text-[11px] text-orange-500 font-bold uppercase tracking-widest';
                fileInfo.textContent = files[0].name;
            } else {
                fileTitle.textContent = 'Soubory připraveny';
                fileTitle.className = 'text-[11px] text-orange-500 font-bold uppercase tracking-widest';
                fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
            }
        });
    </script>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>