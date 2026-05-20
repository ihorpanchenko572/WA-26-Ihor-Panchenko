<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-l-8 border-lime-500 pl-6">
        <div>
            <h2 class="text-6xl font-black uppercase italic tracking-tighter text-white">
                Silové <span class="text-lime-500">Statistiky</span>
            </h2>
            <p class="text-zinc-500 uppercase text-xs font-bold tracking-[0.3em] mt-2">Analýza celkového objemu zvednuté váhy</p>
        </div>
        <div class="mt-6 md:mt-0 text-right">
            <a href="<?= BASE_URL ?>/index.php" class="text-zinc-400 font-black text-xs uppercase border border-zinc-800 px-4 py-2 hover:border-lime-500 hover:text-white transition-all transform -skew-x-12 inline-block">
                Zpět na historii
            </a>
        </div>
    </div>

    <div class="bg-zinc-900 border border-zinc-800 p-8 shadow-2xl relative overflow-hidden mb-10">
        <span class="absolute -top-4 -right-2 text-8xl font-black text-white/5 italic select-none pointer-events-none">STATS</span>
        
        <div class="relative z-10 w-full h-[450px]">
            <canvas id="ironChart"></canvas>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data předaná z PHP kontroleru
    const chartLabels = <?php echo json_encode($labels); ?>;
    const chartData = <?php echo json_encode($weights); ?>;

    const ctx = document.getElementById('ironChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line', // Spojnicový graf
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Celkem zvednuto (KG)',
                data: chartData,
                borderColor: '#84cc16', // Limetkově zelená (Tailwind lime-500)
                backgroundColor: 'rgba(132, 204, 22, 0.1)', // Jemný limetkový podbarvený nádech
                borderWidth: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#84cc16',
                pointRadius: 5,
                pointHoverRadius: 8,
                tension: 0.3 // Mírné zakřivení linie (aby to nebylo ostré jako pila)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#fff', // Bílý text legendy
                        font: {
                            family: 'monospace',
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: {
                        color: '#27272a' // Tmavě šedé mřížky (Tailwind zinc-800)
                    },
                    ticks: {
                        color: '#a1a1aa', // Šedé popisky osy Y
                        font: { family: 'monospace', weight: 'bold' },
                        callback: function(value) { return value + ' kg'; }
                    }
                },
                x: {
                    grid: {
                        display: false // Schováme vertikální mřížky pro čistší vzhled
                    },
                    ticks: {
                        color: '#a1a1aa', // Šedé popisky osy X
                        font: { family: 'monospace', weight: 'bold' }
                    }
                }
            }
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>