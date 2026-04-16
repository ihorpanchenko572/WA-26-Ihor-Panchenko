<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-10 border-l-8 border-lime-500 pl-6">
            <h2 class="text-5xl font-black uppercase italic tracking-tighter text-white">
                Vítej <span class="text-lime-500">Zpět</span>
            </h2>
            <p class="text-zinc-500 uppercase text-[10px] font-bold tracking-[0.4em] mt-2">Pokračuj v tréninku a zapiš další progres.</p>
        </div>
        
        <div class="bg-zinc-900 border border-zinc-800 shadow-2xl relative overflow-hidden p-8 md:p-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-lime-500/5 blur-[60px] rounded-full pointer-events-none"></div>

            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="relative z-10">
                
                <div class="space-y-8">
                    <div>
                        <label for="email" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic tracking-widest">E-mail</label>
                        <input type="email" id="email" name="email" required autofocus
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-[10px] font-black uppercase text-zinc-500 mb-2 italic tracking-widest">Heslo</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-black border-2 border-zinc-800 focus:border-lime-500 p-3 text-white outline-none transition-all">
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-lime-500 text-black font-black py-5 px-4 transform -skew-x-6 hover:bg-white transition-all uppercase tracking-widest text-lg shadow-[8px_8px_0px_0px_rgba(163,230,53,0.2)]">
                            VSTOUPIT DO GYMU
                        </button>
                    </div>
                    
                    <p class="text-center text-zinc-600 font-bold uppercase text-[10px] tracking-widest pt-4 border-t border-zinc-800">
                        Ještě nemakáš? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-lime-500 hover:text-white transition-colors ml-1 border-b border-lime-500/30">Zaregistruj se</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>