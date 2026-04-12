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
                    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">Svalová skupina</label>
                    <input type="text" name="muscle_group" placeholder="NAPR. HRUDNÍK" 
                           class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none">
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
                    <label for="images" class="block w-full border-2 border-dashed border-zinc-800 p-10 text-center cursor-pointer hover:bg-lime-500 hover:text-black transition-all group">
                        <span class="font-black uppercase italic group-hover:scale-110 block">Nahrát fotku formy / stroje</span>
                        <input type="file" id="images" name="images[]" multiple class="hidden">
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

<?php require_once '../app/views/layout/footer.php'; ?>