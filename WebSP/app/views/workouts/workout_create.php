<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 border-l-8 border-lime-500 pl-6">
            <h2 class="text-5xl font-black uppercase italic tracking-tighter text-white">
                Zapsat <span class="text-lime-500">nový výkon</span>
            </h2>
            <p class="text-zinc-500 uppercase text-xs font-bold tracking-widest mt-2">Zadej data a překonej své limity</p>
        </div>

        <form action="<?= BASE_URL ?>/index.php?url=workout/store" method="post" enctype="multipart/form-data" class="bg-zinc-900 border border-zinc-800 p-8 shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase text-lime-500 mb-2 italic">Název cviku</label>
                    <input type="text" name="exercise_name" required placeholder="NAPR. BENCHPRESS" 
                           class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-4 text-xl font-black uppercase italic outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">
                        Svalová skupina <span class="text-lime-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="muscle_group" required 
                                class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none appearance-none cursor-pointer transition-colors uppercase">
                            <option value="" class="bg-zinc-900 text-zinc-500 italic">-- VYBERTE PARTII --</option>
                            
                            <?php foreach ($muscleGroups as $mg): ?>
                                <option value="<?= htmlspecialchars($mg['id']) ?>" class="bg-zinc-900 text-white">
                                    <?= htmlspecialchars($mg['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-lime-500">
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">Datum tréninku</label>
                    <input type="date" name="workout_date" value="<?= date('Y-m-d') ?>" 
                           class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none">
                </div>

                <div class="bg-black p-6 border border-zinc-800">
                    <label class="block text-xs font-black uppercase text-lime-500 mb-2">Váha (KG)</label>
                    <input type="number" step="0.5" name="weight" required 
                           class="w-full bg-transparent text-5xl font-black outline-none border-b-4 border-lime-500 pb-2">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-black p-6 border border-zinc-800 text-center">
                        <label class="block text-[10px] font-black uppercase text-zinc-500 mb-1">Série</label>
                        <input type="number" name="sets" required class="w-full bg-transparent text-3xl font-black text-center outline-none">
                    </div>
                    <div class="bg-black p-6 border border-zinc-800 text-center">
                        <label class="block text-[10px] font-black uppercase text-zinc-500 mb-1">Opáčka</label>
                        <input type="number" name="reps" required class="w-full bg-transparent text-3xl font-black text-center outline-none">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">Poznámky k intenzitě / pocitu</label>
                    <textarea name="description" rows="3" class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-4 outline-none"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="images" id="file-dropzone" class="block w-full border-2 border-dashed border-zinc-800 p-10 text-center cursor-pointer hover:bg-lime-500 hover:text-black transition-all group transform -skew-x-1">
                        <span id="file-title" class="font-black uppercase italic group-hover:scale-105 block transition-transform text-zinc-400 group-hover:text-black">
                            Nahrát fotku formy / stroje
                        </span>
                        <span id="file-info" class="block text-[10px] font-bold uppercase tracking-widest mt-2 text-zinc-600 group-hover:text-zinc-900 italic">
                            ŽÁDNÝ DŮKAZ NEBYL VYBRÁN
                        </span>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                    </label>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-lime-500 text-black font-black py-6 text-2xl uppercase italic tracking-tighter hover:bg-white transition-all transform -skew-x-2 shadow-[8px_8px_0px_0px_rgba(255,255,255,0.2)]">
                        ULOŽIT VÝKON DO DATABÁZE
                    </button>
                </div>

            </div>
        </form>
    </div>
</main>

<script>
    const fileInput = document.getElementById('images');
    const fileTitle = document.getElementById('file-title');
    const fileInfo = document.getElementById('file-info');
    const dropzone = document.getElementById('file-dropzone');

    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;
        
        if (files.length === 0) {
            // Není vybráno nic - návrat k původnímu temnému stylu
            dropzone.className = "block w-full border-2 border-dashed border-zinc-800 p-10 text-center cursor-pointer hover:bg-lime-500 hover:text-black transition-all group transform -skew-x-1";
            fileTitle.textContent = 'Nahrát fotku formy / stroje';
            fileTitle.className = 'font-black uppercase italic group-hover:scale-105 block transition-transform text-zinc-400 group-hover:text-black';
            fileInfo.textContent = 'ŽÁDNÝ DŮKAZ NEBYL VYBRÁN';
            fileInfo.className = 'block text-[10px] font-bold uppercase tracking-widest mt-2 text-zinc-600 group-hover:text-zinc-900 italic';
        } else {
            // Soubory jsou úspěšně nahrány na frontend - permanentní limetkový "úspěšný" podklad
            dropzone.className = "block w-full border-2 border-lime-500 bg-lime-500 p-10 text-center cursor-pointer text-black transition-all transform -skew-x-1";
            
            if (files.length === 1) {
                fileTitle.textContent = 'DŮKAZ ZAJIŠTĚN 🦾';
                fileTitle.className = 'font-black uppercase italic text-lg block';
                fileInfo.textContent = files[0].name.toUpperCase();
                fileInfo.className = 'block text-xs font-bold tracking-tight mt-1 text-black/70';
            } else {
                fileTitle.textContent = 'VŠECHNY DŮKAZY ZAJIŠTĚNY 🦾';
                fileTitle.className = 'font-black uppercase italic text-lg block';
                fileInfo.textContent = 'CELKEM VYBRÁNO: ' + files.length + ' FOTEK FORMŮ';
                fileInfo.className = 'block text-xs font-bold tracking-tight mt-1 text-black/70';
            }
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>