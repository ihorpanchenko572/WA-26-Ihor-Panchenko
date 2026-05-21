<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-2xl mx-auto">
        
        <div class="mb-8">
            <h2 class="text-5xl font-black text-white uppercase italic tracking-tighter">
                Profil <span class="text-lime-500">Bojovníka</span>
            </h2>
            <p class="text-zinc-500 text-xs uppercase font-bold tracking-widest mt-1">Tvoje vizitka v systému IRON LOG</p>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-lime-500/5 -skew-x-12 translate-x-20 pointer-events-none"></div>

            <div class="space-y-6 relative z-10">
                <div class="border-l-4 border-lime-500 pl-4">
                    <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-1">Přezdívka / Jméno</span>
                    <span class="text-2xl font-black italic text-white uppercase"><?= htmlspecialchars($user['username']) ?></span>
                </div>

                <div class="border-l-4 border-zinc-800 pl-4">
                    <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-1">Registrační Email</span>
                    <span class="text-lg font-bold text-zinc-300"><?= htmlspecialchars($user['email']) ?></span>
                </div>

                <div class="border-l-4 border-zinc-800 pl-4">
                    <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-1">Hodnost v systému</span>
                    <span class="text-xs uppercase font-black px-2 py-1 bg-zinc-800 inline-block text-lime-500 italic tracking-wider mt-1">
                        <?= htmlspecialchars($user['role']) ?>
                    </span>
                </div>

                <div class="border-l-4 border-zinc-800 pl-4">
                    <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-1">Členem arény od</span>
                    <span class="text-sm font-medium text-zinc-400"><?= date('d. m. Y H:i', strtotime($user['created_at'])) ?></span>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-zinc-800 flex justify-end">
                <a href="<?= BASE_URL ?>/index.php?url=user/edit" 
                   class="bg-lime-500 text-black font-black px-6 py-3 transform -skew-x-12 hover:bg-white transition-all uppercase text-xs tracking-widest shadow-[4px_4px_0px_0px_rgba(255,255,255,0.1)]">
                    Upravit profil
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>