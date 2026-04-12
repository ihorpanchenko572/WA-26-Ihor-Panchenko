<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <a href="<?= BASE_URL ?>/index.php" class="text-zinc-500 hover:text-lime-500 transition-colors font-black uppercase tracking-widest text-xs italic">
                &larr; Zpět do historie
            </a>
            <div class="flex space-x-4">
                <a href="<?= BASE_URL ?>/index.php?url=workout/edit/<?= $workout['id'] ?>" class="bg-zinc-800 hover:bg-blue-600 text-white px-6 py-2 transform -skew-x-12 font-black text-xs uppercase transition-all">
                    Upravit zápis
                </a>
            </div>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 shadow-2xl overflow-hidden relative">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-lime-500/5 -skew-x-12 translate-x-32 pointer-events-none"></div>

            <div class="p-8 md:p-16 relative z-10">
                <div class="flex flex-col lg:flex-row gap-12">
                    
                    <div class="flex-grow">
                        <div class="mb-2">
                            <span class="bg-lime-500 text-black px-3 py-1 font-black uppercase italic text-xs">
                                <?= htmlspecialchars($workout['muscle_group']) ?>
                            </span>
                        </div>
                        <h2 class="text-6xl md:text-8xl font-black text-white uppercase italic leading-none tracking-tighter mb-6">
                            <?= htmlspecialchars($workout['exercise_name']) ?>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mt-12">
                            <div class="border-l-4 border-lime-500 pl-4">
                                <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-2">Váha</span>
                                <span class="text-5xl font-black italic text-white"><?= htmlspecialchars($workout['weight']) ?><span class="text-lime-500 ml-1 text-xl">KG</span></span>
                            </div>
                            <div class="border-l-4 border-zinc-700 pl-4">
                                <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-2">Série</span>
                                <span class="text-5xl font-black italic text-white"><?= htmlspecialchars($workout['sets']) ?></span>
                            </div>
                            <div class="border-l-4 border-zinc-700 pl-4">
                                <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-2">Opakování</span>
                                <span class="text-5xl font-black italic text-white"><?= htmlspecialchars($workout['reps']) ?></span>
                            </div>
                        </div>

                        <div class="mt-16 pt-8 border-t border-zinc-800">
                            <h3 class="text-xs uppercase font-black text-lime-500 tracking-[0.4em] mb-4 italic">Poznámky k boji</h3>
                            <div class="text-zinc-400 leading-relaxed italic text-lg max-w-2xl">
                                <?= !empty($workout['description']) ? nl2br(htmlspecialchars($workout['description'])) : 'Žádné poznámky nebyly zapsány. Příště do toho dej víc!' ?>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-zinc-600 text-[10px] font-bold uppercase tracking-widest">
                            Zapsáno v systému: <?= date('d. m. Y H:i', strtotime($workout['created_at'])) ?>
                        </div>
                    </div>

                    <div class="w-full lg:w-80 shrink-0">
                        <div class="sticky top-10">
                            <h3 class="text-xs uppercase font-black text-zinc-600 tracking-widest mb-4 text-center lg:text-right">Důkaz místo slibů</h3>
                            <div class="space-y-4">
                                <?php 
                                $imgs = json_decode($workout['images'] ?? '[]', true);
                                if (!empty($imgs)): 
                                    foreach ($imgs as $img): ?>
                                        <div class="group relative overflow-hidden border-2 border-zinc-800 hover:border-lime-500 transition-all shadow-xl">
                                            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" 
                                                 alt="Workout image" 
                                                 class="w-full h-auto object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500">
                                            <div class="absolute inset-0 bg-lime-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        </div>
                                    <?php endforeach; 
                                else: ?>
                                    <div class="aspect-square bg-black border-2 border-dashed border-zinc-800 flex items-center justify-center p-6 text-center">
                                        <p class="text-[10px] text-zinc-700 font-black uppercase italic tracking-tighter leading-tight">
                                            Bez fotky to jako by se nestalo...
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>