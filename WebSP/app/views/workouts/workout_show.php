<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <a href="<?= BASE_URL ?>/index.php" class="text-zinc-500 hover:text-lime-500 transition-colors font-black uppercase tracking-widest text-xs italic">
                &larr; Zpět do historie
            </a>
            <div class="flex space-x-4">
              <?php if ($workout['created_by'] === $_SESSION['user_id'] || (isset($currentUserRole) && $currentUserRole === 'admin')): ?>
              <a href="<?= BASE_URL ?>/index.php?url=workout/edit/<?= $workout['id'] ?>" class="bg-zinc-800 hover:bg-blue-600 text-white px-6 py-2 transform -skew-x-12 font-black text-xs uppercase transition-all">
                 Upravit zápis
              </a>
            <?php endif; ?>
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

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-y-8 gap-x-6 mt-12">
                            
                            <div class="sm:col-span-2 border-l-4 border-lime-500 pl-4">
                                <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-2">Váha</span>
                                <span class="text-5xl md:text-6xl font-black italic text-white whitespace-nowrap">
                                    <?= htmlspecialchars($workout['weight']) ?><span class="text-lime-500 ml-2 text-xl md:text-2xl font-black">KG</span>
                                </span>
                            </div>
                            
                            <div class="sm:col-span-1 border-l-4 border-zinc-800 pl-4">
                                <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-2">Série</span>
                                <span class="text-5xl md:text-6xl font-black italic text-white"><?= htmlspecialchars($workout['sets']) ?></span>
                            </div>
                            
                            <div class="sm:col-span-1 border-l-4 border-zinc-800 pl-4">
                                <span class="block text-zinc-500 uppercase font-black text-[10px] tracking-[0.3em] mb-2">Opakování</span>
                                <span class="text-5xl md:text-6xl font-black italic text-white"><?= htmlspecialchars($workout['reps']) ?></span>
                            </div>
                            
                        </div>

                        <div class="mt-16 pt-8 border-t border-zinc-800">
                            <h3 class="text-xs uppercase font-black text-lime-500 tracking-[0.4em] mb-4 italic">Poznámky k boji</h3>
                            <div class="text-zinc-400 leading-relaxed italic text-lg max-w-2xl">
                                <?= !empty($workout['description']) ? nl2br(htmlspecialchars($workout['description'])) : 'Žádné poznámky nebyly zapsány. Příště do toho dej víc!' ?>
                            </div>
                        </div>

                        <div class="mt-16 pt-8 border-t border-zinc-800">
                            <h3 class="text-xs uppercase font-black text-lime-500 tracking-[0.4em] mb-8 italic">Diskuze v Aréně</h3>

                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="post" class="mb-10">
                                    <input type="hidden" name="workout_id" value="<?= $workout['id'] ?>">
                                    <textarea name="content" placeholder="Napiš vzkaz bojovníkovi..." required
                                              class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-4 text-white outline-none transition-all transform -skew-x-2 italic"></textarea>
                                    <button type="submit" class="mt-4 bg-lime-500 text-black font-black py-2 px-6 transform -skew-x-12 hover:bg-white transition-all uppercase text-xs">
                                        Odeslat komentář
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="text-zinc-600 text-xs uppercase font-bold mb-10 italic">
                                    Pro přidání komentáře se musíš <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-lime-500 border-b border-lime-500/30">přihlásit</a>.
                                </p>
                            <?php endif; ?>

                            <div class="space-y-6">
                                <?php if (!empty($comments)): ?>
                                    <?php foreach ($comments as $comment): ?>
                                        <?php 
                                            $isAuthor = (isset($_SESSION['user_id']) && $comment['user_id'] === $_SESSION['user_id']);
                                            $isAdmin = (isset($currentUserRole) && $currentUserRole === 'admin');
                                        ?>
                                        <div class="bg-black/40 p-6 border-l-4 border-zinc-800 relative group transform transition-all hover:border-lime-500/50" id="comment-box-<?= $comment['id'] ?>">
                                            <div class="flex justify-between items-start mb-2">
                                                <span class="text-lime-500 font-black uppercase italic text-xs tracking-widest">
                                                    <?= htmlspecialchars($comment['nickname'] ?: $comment['username']) ?>
                                                </span>
                                                <span class="text-zinc-600 text-[9px] font-bold uppercase tracking-tighter">
                                                    <?= date('d. m. Y H:i', strtotime($comment['created_at'])) ?>
                                                </span>
                                            </div>
                                            
                                            <p class="text-zinc-400 italic text-sm leading-relaxed" id="comment-text-<?= $comment['id'] ?>">
                                                <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                            </p>

                                            <?php if ($isAuthor): ?>
                                                <form action="<?= BASE_URL ?>/index.php?url=comment/update/<?= $comment['id'] ?>" method="post" id="comment-form-<?= $comment['id'] ?>" class="hidden mt-2">
                                                    <textarea name="content" required class="w-full bg-black border border-zinc-700 focus:border-lime-500 p-3 text-white text-sm outline-none transition-all italic transform -skew-x-1"><?= htmlspecialchars($comment['content']) ?></textarea>
                                                    <div class="flex space-x-2 mt-2">
                                                        <button type="button" onclick="toggleEdit(<?= $comment['id'] ?>)" class="text-[10px] font-black uppercase border border-zinc-800 px-3 py-1 text-zinc-400 hover:text-white transition-colors">Zrušit</button>
                                                        <button type="submit" class="text-[10px] font-black uppercase bg-lime-500 px-3 py-1 text-black hover:bg-white transition-colors">Uložit</button>
                                                    </div>
                                                </form>
                                            <?php endif; ?>

                                            <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity bg-black/80 px-2 py-1 border border-zinc-800/50">
                                                <?php if ($isAuthor): ?>
                                                    <button onclick="toggleEdit(<?= $comment['id'] ?>)" class="text-[9px] font-black uppercase text-zinc-400 hover:text-lime-500 transition-colors italic">
                                                        Upravit
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($isAuthor || $isAdmin): ?>
                                                    <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $comment['id'] ?>" 
                                                       onclick="return confirm('OPRAVDU SMAZAT TENTO KOMENTÁŘ?')"
                                                       class="text-[9px] font-black uppercase text-red-600 hover:text-red-400 transition-colors italic">
                                                       Smazat
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-zinc-700 text-xs uppercase font-black italic tracking-widest">Zatím žádné ohlasy. Buď první!</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mt-12 text-zinc-600 text-[10px] font-bold uppercase tracking-widest flex flex-wrap items-center justify-between gap-4">
                            <div>
                                Zapsáno v systému: <?= date('d. m. Y H:i', strtotime($workout['created_at'])) ?>
                            </div>

                            <?php if (isset($currentUserRole) && $currentUserRole === 'admin'): ?>
                                <div class="flex items-center bg-red-950/20 px-3 py-1 border border-red-900/30">
                                    <span class="text-red-900 mr-3">ADMIN PANEL:</span>
                                    <a href="<?= BASE_URL ?>/index.php?url=user/delete/<?= $workout['created_by'] ?>" 
                                       onclick="return confirm('POZOR! OPRAVDU CHCETE SMAZAT TOHOTO UŽIVATELE? Tato akce je nevratná.')"
                                       class="text-red-500 hover:text-white transition-colors italic text-[9px]">
                                       [ ODSTRANIT AUTORA PROFILU ]
                                    </a>
                                </div>
                            <?php endif; ?>
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
                                                 class="w-full h-auto object-cover transition-all duration-500">
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

<script>
function toggleEdit(commentId) {
    const textElement = document.getElementById('comment-text-' + commentId);
    const formElement = document.getElementById('comment-form-' + commentId);
    
    if (formElement.classList.contains('hidden')) {
        formElement.classList.remove('hidden');
        textElement.classList.add('hidden');
    } else {
        formElement.classList.add('hidden');
        textElement.classList.remove('hidden');
    }
}
</script>

<?php require_once '../app/views/layout/footer.php'; ?>