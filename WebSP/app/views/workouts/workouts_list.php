<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-l-8 border-lime-500 pl-6">
        <div>
            <h2 class="text-6xl font-black uppercase italic tracking-tighter text-white">
                Historie <span class="text-lime-500">Bojů</span>
            </h2>
            <p class="text-zinc-500 uppercase text-xs font-bold tracking-[0.3em] mt-2">Přehled tvé dřiny v gymu</p>
        </div>
        <div class="mt-6 md:mt-0 text-right">
            <span class="text-zinc-700 font-black italic text-4xl uppercase select-none">No Excuses</span>
        </div>
    </div>

    <?php if (empty($workouts)): ?>
        <div class="border-2 border-dashed border-zinc-800 p-20 text-center">
            <p class="text-zinc-500 uppercase tracking-widest font-bold mb-4">Zatím jsi nic nezvedl. Koukej začít!</p>
            <a href="<?= BASE_URL ?>/index.php?url=workout/create" class="text-lime-500 font-black border-b-2 border-lime-500 pb-1 hover:text-white hover:border-white transition-all">ZAPSAT PRVNÍ TRÉNINK</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($workouts as $w): ?>
                <div class="group bg-zinc-900 border border-zinc-800 p-8 relative overflow-hidden hover:border-lime-500 transition-all shadow-2xl">
                    <span class="absolute -top-4 -right-2 text-8xl font-black text-white/5 italic group-hover:text-lime-500/10 transition-colors pointer-events-none">#<?= $w['id'] ?></span>

                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest border-b border-zinc-800 pb-1"><?= date('d / m / Y', strtotime($w['workout_date'])) ?></span>
                        <span class="bg-lime-500 text-black text-[9px] px-2 py-1 font-black uppercase italic"><?= htmlspecialchars($w['muscle_group']) ?></span>
                    </div>
                    
                    <h3 class="text-2xl font-black uppercase italic mb-6 leading-none tracking-tight group-hover:text-lime-400 transition-colors">
                        <?= htmlspecialchars($w['exercise_name']) ?>
                    </h3>
                    
                    <div class="flex items-baseline space-x-3 mb-8">
                        <span class="text-6xl font-black text-white italic"><?= htmlspecialchars($w['weight']) ?></span>
                        <span class="text-lime-500 font-black uppercase text-sm italic tracking-tighter">KG</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-t border-zinc-800 pt-6">
                        <div class="bg-black/50 p-3">
                            <span class="block text-zinc-600 text-[9px] uppercase font-black tracking-widest mb-1">Série</span>
                            <span class="text-2xl font-black italic"><?= htmlspecialchars($w['sets']) ?></span>
                        </div>
                        <div class="bg-black/50 p-3 border-l border-zinc-800">
                            <span class="block text-zinc-600 text-[9px] uppercase font-black tracking-widest mb-1">Opáčka</span>
                            <span class="text-2xl font-black italic"><?= htmlspecialchars($w['reps']) ?></span>
                        </div>
                    </div>

                   <div class="mt-8 flex justify-between items-center opacity-40 group-hover:opacity-100 transition-opacity">
    
    <a href="<?= BASE_URL ?>/index.php?url=workout/show/<?= $w['id'] ?>" 
       class="text-[10px] font-black hover:text-lime-500 transition-all uppercase tracking-[0.2em] italic border-b-2 border-transparent hover:border-lime-500">
       DETAIL
    </a>

    <div class="flex space-x-4">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $w['user_id']): ?>
            
            <a href="<?= BASE_URL ?>/index.php?url=workout/edit/<?= $w['id'] ?>" 
               class="text-[10px] font-black hover:text-blue-400 transition-all uppercase italic">
               Edit
            </a>
            
            <a href="<?= BASE_URL ?>/index.php?url=workout/delete/<?= $w['id'] ?>" 
               onclick="return confirm('Smazat tento výkon? Žádná lítost?')" 
               class="text-[10px] font-black hover:text-red-600 transition-all uppercase italic text-zinc-600">
               Smazat
            </a>

        <?php endif; ?>
    </div>
</div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>