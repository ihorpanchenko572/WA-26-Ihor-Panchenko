<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl">
        <div class="mb-6 text-center">
            <h2 class="text-4xl font-bold tracking-tighter text-orange-500 uppercase">Nová registrace</h2>
            <p class="text-slate-400 italic mt-2 text-sm">Vstupte do světa naší digitální knihovny.</p>
        </div>
        
        <div class="bg-slate-900 border-t-4 border-orange-500 rounded-lg shadow-2xl p-6 md:p-10">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 border-b border-slate-800 pb-2 mb-2">
                        <h3 class="text-orange-400 text-xs font-bold uppercase tracking-[0.2em]">Základní údaje</h3>
                    </div>

                    <div>
                        <label for="username" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Uživatelské jméno <span class="text-orange-500">*</span></label>
                        <input type="text" id="username" name="username" required 
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">E-mail <span class="text-orange-500">*</span></label>
                        <input type="email" id="email" name="email" required 
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Heslo <span class="text-orange-500">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Potvrzení hesla <span class="text-orange-500">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                    </div>

                    <div class="md:col-span-2 border-b border-slate-800 pb-2 mb-2 mt-4">
                        <h3 class="text-amber-500 text-xs font-bold uppercase tracking-[0.2em]">Osobní informace</h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" 
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-amber-500 transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" 
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-amber-500 transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="nickname" class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Jak ti máme říkat?"
                               class="w-full bg-slate-800 border border-slate-700 rounded-md px-4 py-2 text-slate-200 placeholder-slate-600 focus:outline-none focus:border-amber-500 transition-all">
                    </div>

                    <div class="md:col-span-2 mt-6">
                        <button type="submit" 
                                class="w-full bg-orange-600 hover:bg-orange-500 text-white font-black py-4 px-4 rounded shadow-lg transition-all uppercase tracking-widest text-sm active:scale-95">
                            Vytvořit nový účet
                        </button>
                        <p class="text-center text-slate-500 text-xs mt-6 uppercase tracking-widest">
                            Už jsi členem? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-orange-400 hover:text-orange-300 transition-colors font-bold underline decoration-orange-500/30 underline-offset-4">Přihlásit se</a>.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>