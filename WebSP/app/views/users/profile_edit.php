<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-2xl mx-auto">
        
        <div class="mb-8">
            <a href="<?= BASE_URL ?>/index.php?url=user/profile" class="text-zinc-500 hover:text-lime-500 transition-colors font-black uppercase tracking-widest text-xs italic">
                &larr; Zpět na profil
            </a>
            <h2 class="text-5xl font-black text-white uppercase italic tracking-tighter mt-4">
                Změna <span class="text-lime-500">Formy</span>
            </h2>
            <p class="text-zinc-500 text-xs uppercase font-bold tracking-widest mt-1">Uprav své identifikační údaje</p>
        </div>

        <div class="bg-zinc-900 border border-zinc-800 p-8 shadow-2xl">
            <form action="<?= BASE_URL ?>/index.php?url=user/update" method="post" class="space-y-6">
                
                <div>
                    <label class="block text-zinc-400 uppercase font-black text-[10px] tracking-[0.2em] mb-2 italic">Nové jméno / Přezdívka</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required
                           class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-4 text-white font-bold outline-none transition-all transform -skew-x-2 italic">
                </div>

                <div>
                    <label class="block text-zinc-400 uppercase font-black text-[10px] tracking-[0.2em] mb-2 italic">Nový Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                           class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-4 text-white font-bold outline-none transition-all transform -skew-x-2">
                </div>

                <div class="pt-4 flex justify-end space-x-4">
                    <a href="<?= BASE_URL ?>/index.php?url=user/profile" class="border border-zinc-800 hover:border-zinc-600 text-zinc-400 hover:text-white font-black px-6 py-3 transform -skew-x-12 text-xs uppercase transition-all">
                        Zrušit
                    </a>
                    <button type="submit" 
                            class="bg-lime-500 text-black font-black px-8 py-3 transform -skew-x-12 hover:bg-white transition-all uppercase text-xs tracking-widest">
                        Uložit změny
                    </button>
                </div>

            </form>
        </div>

    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>