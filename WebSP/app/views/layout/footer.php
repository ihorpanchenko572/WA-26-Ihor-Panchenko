<footer class="mt-auto bg-black border-t border-zinc-900 py-10 relative overflow-hidden">
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-lime-500/5 blur-[120px] rounded-full"></div>
        
        <div class="container mx-auto px-6 relative z-10 text-center md:text-left flex flex-col md:flex-row justify-between items-center">
            <div>
                <p class="text-zinc-600 text-[10px] font-black uppercase tracking-[0.5em] italic">
                    &copy; 2026 IRON LOG // HARDCORE TRAINING TRACKER
                </p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <span class="text-lime-500/30 font-black italic uppercase text-xs tracking-tighter">
                    Go hard or go home
                </span>
            </div>
        </div>
    </footer>

    <!-- LOGIKA PRO AUTOMATICKÉ MIZENÍ NOTIFIKACÍ -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Najdeme všechny notifikační zprávy s naší třídou alert-msg
        const messages = document.querySelectorAll('.alert-msg');
        
        messages.forEach(function(msg) {
            // Nastavíme časovač na 5 sekund (5000ms)
            setTimeout(function() {
                // Přidáme efekt plynulého mizení přes CSS transition
                msg.style.transition = "opacity 0.8s ease, transform 0.8s ease";
                msg.style.opacity = "0";
                msg.style.transform = "translateX(50px) skewX(-12deg)"; // Zpráva při mizení jakoby odjede doprava
                
                // Po dokončení animace (800ms) prvek úplně odstraníme z DOMu
                setTimeout(() => msg.remove(), 800);
            }, 5000);
        });
    });
    </script>

</body>
</html>