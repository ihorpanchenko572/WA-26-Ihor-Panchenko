<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>IRON LOG | NO PAIN NO GAIN</title>
</head>
<body class="bg-[#080808] text-zinc-100 min-h-screen font-sans flex flex-col">

    <header class="bg-black border-b-2 border-lime-500 shadow-[0_10px_30px_rgba(163,230,53,0.1)] relative z-50">
        <div class="container mx-auto px-6 py-5 flex flex-col md:flex-row justify-between items-center">
            
            <a href="<?= BASE_URL ?>/index.php" class="group">
                <h1 class="text-4xl font-black italic tracking-tighter uppercase transition-transform group-hover:scale-105">
                    <span class="text-white">IRON</span><span class="text-lime-500 group-hover:drop-shadow-[0_0_10px_#a3e635]">LOG</span>
                </h1>
            </a>
            
            <nav class="mt-6 md:mt-0">
                <ul class="flex space-x-8 items-center font-black tracking-widest text-[11px] uppercase">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="hover:text-lime-500 transition-colors">Historie</a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=workout/create" 
                           class="bg-lime-500 text-black px-6 py-3 transform -skew-x-12 hover:bg-white transition-all shadow-[4px_4px_0px_0px_rgba(255,255,255,0.3)] inline-block">
                            + Přidat výkon
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-6 mt-6">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="bg-lime-500 text-black font-black p-4 mb-4 transform -skew-x-3 border-l-8 border-white shadow-lg animate-pulse">
                        <span class="uppercase tracking-tighter italic font-black text-lg">System:</span> 
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <?php unset($_SESSION['messages']); ?>
        <?php endif; ?>
    </div>