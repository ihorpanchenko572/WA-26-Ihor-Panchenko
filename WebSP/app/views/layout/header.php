<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>IRON LOG | NO PAIN NO GAIN</title>
    <style>
        /* Jemná animace pro notifikace */
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#080808] text-zinc-100 min-h-screen font-sans flex flex-col">

    <header class="bg-black border-b-2 border-lime-500 shadow-[0_10px_30px_rgba(163,230,53,0.1)] relative z-50">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            
            <a href="<?= BASE_URL ?>/index.php" class="group flex items-center mb-4 md:mb-0">
                <img src="<?= BASE_URL ?>/images/logo.png" 
                     alt="IRON LOG Logo" 
                     class="h-12 md:h-14 w-auto transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_15px_rgba(163,230,53,0.5)]">
            </a>
            
            <nav>
                <ul class="flex space-x-8 items-center font-black tracking-widest text-[11px] uppercase">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="text-zinc-400 hover:text-white transition-colors duration-300">
                            Historie
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=workout/create" 
                           class="bg-lime-500 text-black px-8 py-3 transform -skew-x-12 hover:bg-white transition-all duration-300 shadow-[5px_5px_0px_0px_rgba(255,255,255,0.2)] active:translate-y-1 inline-block">
                            + PŘIDAT VÝKON
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-6 mt-6">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        // Barvy podle typu zprávy (vždy v agresivním stylu)
                        $bgColor = ($type === 'success') ? 'bg-lime-500' : (($type === 'error') ? 'bg-red-600' : 'bg-zinc-700');
                        $textColor = ($type === 'success') ? 'text-black' : 'text-white';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $bgColor ?> <?= $textColor ?> font-black p-4 transform -skew-x-3 border-l-8 border-white shadow-xl animate-slide-in">
                            <span class="uppercase italic tracking-tighter text-lg mr-2">!</span> 
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>
    </div>
