<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl">
        <div class="mb-10 border-l-8 border-lime-500 pl-6">
            <h2 class="text-5xl font-black uppercase italic tracking-tighter text-white">
                Vstoupit do <span class="text-lime-500">Arény</span>
            </h2>
            <p class="text-zinc-500 uppercase text-[10px] font-bold tracking-[0.4em] mt-2">Vytvoř si účet a začni sledovat svou cestu za železem.</p>
        </div>
        
        <div class="bg-zinc-900 border border-zinc-800 shadow-2xl relative overflow-hidden p-8 md:p-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-lime-500/5 blur-[60px] rounded-full pointer-events-none"></div>

            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post" class="relative z-10">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="md:col-span-2">
                        <h3 class="text-lime-500 text-[11px] font-black uppercase tracking-[0.3em] border-b border-zinc-800 pb-2 mb-4 italic">Bojová Identita</h3>
                    </div>

                    <div class="md:col-span-1">
                        <label for="username" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">Uživatelské jméno <span class="text-lime-500">*</span></label>
                        <input type="text" id="username" name="username" required 
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white font-black uppercase italic outline-none transition-all">
                    </div>

                    <div class="md:col-span-1">
                        <label for="email" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">E-mail <span class="text-lime-500">*</span></label>
                        <input type="email" id="email" name="email" required 
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                    </div>

                    <div class="md:col-span-1">
                        <label for="password" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">Heslo <span class="text-lime-500">*</span></label>
                        <input type="password" id="password" name="password" required minlength="8"
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                        <div class="mt-2 flex items-start space-x-2">
                            <span class="text-lime-500 font-black text-xs italic">!</span>
                            <p class="text-[9px] text-zinc-500 uppercase font-bold leading-tight tracking-wider">
                                MINIMÁLNĚ <span class="text-white">8 ZNAKŮ</span> A <span class="text-white">JEDNO VELKÉ PÍSMENO</span> PRO MAXIMÁLNÍ ZABEZPEČENÍ.
                            </p>
                        </div>
                    </div>

                    <div class="md:col-span-1">
                        <label for="password_confirm" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">Potvrzení hesla <span class="text-lime-500">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required minlength="8"
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 mt-6">
                        <h3 class="text-zinc-600 text-[11px] font-black uppercase tracking-[0.3em] border-b border-zinc-800 pb-2 mb-4 italic">Profilové Detaily</h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" 
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" 
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="nickname" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic">Bojová přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="NAPR. TANK_88"
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white placeholder-zinc-800 font-black uppercase italic outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 mt-10">
                        <button type="submit" 
                                class="w-full bg-lime-500 text-black font-black py-5 px-4 transform -skew-x-6 hover:bg-white transition-all uppercase tracking-widest text-lg shadow-[8px_8px_0px_0px_rgba(163,230,53,0.2)]">
                            VYTVOŘIT ÚČET
                        </button>
                        <p class="text-center text-zinc-600 font-bold uppercase text-[10px] tracking-widest mt-6">
                            Už jsi členem? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-lime-500 hover:text-white transition-colors ml-1 border-b border-lime-500/30">Přihlas se zde</a>.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>