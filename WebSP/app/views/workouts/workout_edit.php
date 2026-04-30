<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-4xl mx-auto">
        <div class="mb-10 border-l-8 border-blue-500 pl-6">
            <h2 class="text-5xl font-black uppercase italic tracking-tighter text-white">
                Upravit <span class="text-blue-500">záznam</span>
            </h2>
        </div>

        <form action="<?= BASE_URL ?>/index.php?url=workout/update/<?= $workout['id'] ?>" method="post" enctype="multipart/form-data" class="bg-zinc-900 border border-zinc-800 p-8 shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase text-blue-500 mb-2 italic">Název cviku</label>
                    <input type="text" name="exercise_name" value="<?= htmlspecialchars($workout['exercise_name']) ?>" required
                           class="w-full bg-black border-2 border-zinc-800 focus:border-blue-500 p-4 text-xl font-black uppercase italic outline-none transition-all">
                </div>

                <div>
    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">
        Svalová skupina <span class="text-lime-500">*</span>
    </label>
    <div class="relative">
        <select name="muscle_group" required 
                class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none appearance-none cursor-pointer transition-colors uppercase">
            
            <?php foreach ($muscleGroups as $mg): ?>
                <?php 
                // Porovnáme ID z databáze tréninku s ID v číselníku svalů
                $isSelected = ($workout['muscle_group'] == $mg['id']) ? 'selected' : ''; 
                ?>
                <option value="<?= htmlspecialchars($mg['id']) ?>" <?= $isSelected ?> class="bg-zinc-900 text-white">
                    <?= htmlspecialchars($mg['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- Designová šipka -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-lime-500">
            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
        </div>
    </div>
</div>

                <div>
                    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">Datum tréninku</label>
                    <input type="date" name="workout_date" value="<?= $workout['workout_date'] ?>"
                           class="w-full bg-black border-2 border-zinc-800 focus:border-blue-500 p-3 text-white outline-none">
                </div>

                <div class="bg-black p-6 border border-zinc-800">
                    <label class="block text-xs font-black uppercase text-blue-500 mb-2">Váha (KG)</label>
                    <input type="number" step="0.5" name="weight" value="<?= $workout['weight'] ?>" required 
                           class="w-full bg-transparent text-5xl font-black outline-none border-b-4 border-blue-500 pb-2">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-black p-6 border border-zinc-800 text-center">
                        <label class="block text-[10px] font-black uppercase text-zinc-500 mb-1">Série</label>
                        <input type="number" name="sets" value="<?= $workout['sets'] ?>" required class="w-full bg-transparent text-3xl font-black text-center outline-none">
                    </div>
                    <div class="bg-black p-6 border border-zinc-800 text-center">
                        <label class="block text-[10px] font-black uppercase text-zinc-500 mb-1">Opáčka</label>
                        <input type="number" name="reps" value="<?= $workout['reps'] ?>" required class="w-full bg-transparent text-3xl font-black text-center outline-none">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black uppercase text-zinc-500 mb-2">Poznámky</label>
                    <textarea name="description" rows="3" class="w-full bg-black border-2 border-zinc-800 focus:border-blue-500 p-4 outline-none"><?= htmlspecialchars($workout['description']) ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-blue-600 text-white font-black py-6 text-2xl uppercase italic tracking-tighter hover:bg-white hover:text-black transition-all transform -skew-x-2">
                        AKTUALIZOVAT ZÁZNAM
                    </button>
                    <a href="<?= BASE_URL ?>/index.php" class="block text-center mt-6 text-zinc-600 font-bold uppercase text-xs tracking-[0.3em] hover:text-white transition-colors">Zrušit a jít zpět</a>
                </div>

            </div>
        </form>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>