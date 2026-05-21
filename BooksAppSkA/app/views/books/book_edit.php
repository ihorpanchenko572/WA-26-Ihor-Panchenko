<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-light tracking-widest text-orange-800/60 uppercase">
                    Upravit <span class="font-normal text-orange-600">knihu</span> 
                    <span class="text-orange-400 text-2xl ml-1">#<?= htmlspecialchars($book['id']) ?></span>
                </h2>
                <p class="text-slate-500 italic mt-1 text-sm">Aktualizace záznamu: <strong class="text-orange-600 font-semibold"><?= htmlspecialchars($book['title']) ?></strong></p>
            </div>
            <a href="<?= BASE_URL ?>/index.php" class="text-orange-600 hover:text-orange-800 transition-colors text-sm uppercase tracking-wider font-bold">
                &larr; Zpět
            </a>
        </div>
        
        <div class="bg-white border border-orange-200 rounded-xl shadow-2xl p-6 md:p-8">
            <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="id_display" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">ID v systému</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly 
                               class="w-full bg-orange-50/50 border border-orange-200 rounded-md px-4 py-2 text-slate-400 font-mono cursor-not-allowed">
                    </div>

                    <div>
                        <label for="title" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Název knihy <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required 
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="author" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Autor <span class="text-rose-500">*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required 
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="isbn" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">ISBN</label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" 
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>

                    <div>
                        <label for="year" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Rok vydání <span class="text-rose-500">*</span></label>
                        <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required 
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="price" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Cena (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" 
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Kategorie <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select id="category" name="category" required
                                    class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all appearance-none cursor-pointer">
                                <option value="">-- Vyberte kategorii --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <?php $isSelected = ($book['category'] == $cat['id']) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $isSelected ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-orange-600/70">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="subcategory" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Podkategorie</label>
                        <div class="relative">
                            <select id="subcategory" name="subcategory" 
                                    class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all appearance-none cursor-pointer">
                                <option value="" class="text-slate-400 italic">-- Vyberte podkategorii (volitelné) --</option>
                                <?php foreach ($subcategories as $sub): ?>
                                    <?php $isSubSelected = ($book['subcategory'] == $sub['id']) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($sub['id']) ?>" <?= $isSubSelected ?>>
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-orange-600/70">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="description" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Popis díla</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>    
                    
                    <div class="md:col-span-2 border-t border-orange-100 pt-6">
                        <label class="block text-xs font-bold text-orange-700 mb-2 uppercase tracking-wider">Aktuálně uložené soubory</label>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php 
                            $currentImages = json_decode($book['images'] ?? '[]', true);
                            if (!empty($currentImages)): 
                                foreach ($currentImages as $img): ?>
                                    <div class="bg-orange-50 border border-orange-200 rounded px-3 py-1.5 flex items-center shadow-sm">
                                        <span class="text-orange-800 text-xs font-mono italic"><?= htmlspecialchars($img) ?></span>
                                    </div>
                                <?php endforeach; 
                            else: ?>
                                <p class="text-slate-400 text-xs italic">V databázi nejsou uloženy žádné obrázky.</p>
                            <?php endif; ?>
                        </div>

                        <label class="block text-xs font-semibold text-slate-400 mb-2 uppercase tracking-wider">Nahrát nové obrázky</label>
                        <div class="w-full">
                            <label for="images" class="flex flex-col items-center justify-center w-full h-24 border-2 border-orange-300 border-dashed rounded-lg cursor-pointer bg-orange-50/20 hover:bg-orange-50/50 hover:border-orange-500 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-2 text-center px-4">
                                    <span id="file-title" class="text-sm text-orange-700 font-semibold">Klikni pro výběr souborů</span>
                                    <span id="file-info" class="text-xs text-slate-400 mt-1">POZOR: Nový výběr přepíše všechny stávající obrázky!</span>
                                </div>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2 mt-4">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-700 hover:from-orange-400 hover:to-orange-600 text-white font-black py-4 px-4 rounded-md shadow-lg border border-orange-600 transition-all uppercase tracking-widest text-sm italic">
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
                fileTitle.className = 'text-sm text-orange-700 font-semibold';
                fileInfo.textContent = 'POZOR: Nový výběr přepíše všechny stávající obrázky!';
            } else if (files.length === 1) {
                fileTitle.textContent = 'Soubor připraven';
                fileTitle.className = 'text-sm text-orange-600 font-bold';
                fileInfo.textContent = files[0].name;
            } else {
                fileTitle.textContent = 'Soubory připraveny';
                fileTitle.className = 'text-sm text-orange-600 font-bold';
                fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
            }
        });
    </script>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>