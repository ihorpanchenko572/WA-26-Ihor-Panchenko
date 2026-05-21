<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-light tracking-widest text-orange-800/60 uppercase">Přihlášení</h2>
            <p class="text-slate-500 italic mt-1 text-sm">Vítejte zpět v naší Knihovně.</p>
        </div>
        
        <div class="bg-white border border-orange-200 rounded-xl shadow-2xl p-6 md:p-8">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post">
                
                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">E-mail</label>
                        <input type="email" id="email" name="email" required autofocus
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-orange-700 mb-1 uppercase tracking-wider">Heslo</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-orange-50/30 border border-orange-200 rounded-md px-4 py-2 text-slate-800 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors">
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-700 hover:from-orange-400 hover:to-orange-600 text-white font-black py-4 px-4 rounded-md shadow-lg border border-orange-600 transition-all uppercase tracking-widest text-sm italic">
                            Přihlásit se
                        </button>
                    </div>
                    
                    <p class="text-center text-slate-500 text-sm border-t border-orange-100 pt-4">
                        Nemáte ještě účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-orange-600 hover:text-orange-800 font-bold transition-colors">Zaregistrujte se</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>