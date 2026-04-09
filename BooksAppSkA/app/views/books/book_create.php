 <?php require_once '../app/views/layout/header.php'; ?>
    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-light tracking-widest text-orange-800/60 uppercase">Přidat novou knihu</h2>
                    <p class="text-slate-500 italic mt-1 text-sm">Vyplňte údaje a uložte knihu do databáze.</p>
                </div>
                <a href="<?= BASE_URL ?>/index.php" class="text-orange-600 hover:text-orange-800 transition-colors text-sm uppercase tracking-wider font-bold">&larr; Zpět</a>
            </div>
            
            <div class="bg-white border border-orange-200 rounded-xl shadow-2xl p-6 md:p-8">
                <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="title" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Název knihy <span class="text-rose-500">*</span></label>
                            <input type="text" id="title" name="title" required 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="author" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Autor <span class="text-rose-500">*</span></label>
                            <input type="text" id="author" name="author" placeholder="Příjmení Jméno" required 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="isbn" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">ISBN <span class="text-rose-500">*</span></label>
                            <input type="text" id="isbn" name="isbn" 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>

                        <div>
                            <label for="year" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Rok vydání <span class="text-rose-500">*</span></label>
                            <input type="number" id="year" name="year" required 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="category" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Kategorie</label>
                            <input type="text" id="category" name="category" 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="subcategory" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Podkategorie</label>
                            <input type="text" id="subcategory" name="subcategory" 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="price" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Cena knihy (Kč)</label>
                            <input type="number" id="price" name="price" step="0.5" 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="link" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Odkaz</label>
                            <input type="text" id="link" name="link" placeholder="https://..." 
                                   class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Popis knihy</label>
                            <textarea id="description" name="description" rows="5" 
                                      class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"></textarea>
                        </div>    
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-orange-700 mb-2 uppercase tracking-wider">Obrázky (zatím neřešíme)</label>
                            <div class="w-full">
                                <label for="images" class="flex flex-col items-center justify-center w-full h-24 border-2 border-orange-200 border-dashed rounded-lg cursor-pointer bg-orange-50/30 hover:bg-orange-100/50 hover:border-orange-400 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span class="text-sm text-orange-800 font-semibold">Klikni pro výběr souborů</span>
                                        <span class="text-xs text-orange-400 mt-1 uppercase tracking-tighter italic">Nahrávání bude zprovozněno později</span>
                                    </div>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 mt-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-orange-500 to-orange-700 hover:from-orange-400 hover:to-orange-600 text-white font-black py-4 px-4 rounded-md shadow-lg border border-orange-600 transition-all uppercase tracking-widest text-sm italic">
                                Uložit knihu do DB
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php require_once '../app/views/layout/footer.php'; ?>
