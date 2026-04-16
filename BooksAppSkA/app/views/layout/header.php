<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Přidat novou knihu</title>
</head>
<body class="bg-orange-50 text-slate-800 min-h-screen font-sans flex flex-col">

    <header class="bg-gradient-to-b from-orange-400 to-orange-600 border-b border-orange-700 shadow-xl">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight text-white uppercase italic">
                Aplikace <span class="text-orange-100">Knihovna</span>
            </h1>
            
                      <nav class="mt-4 md:mt-0">
    <ul class="flex items-center space-x-6">
        <li>
            <a href="<?= BASE_URL ?>/index.php" class="text-slate-200 hover:text-orange-400 transition-colors font-semibold tracking-tight">
                Seznam knih
            </a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded shadow-md transition-all border border-orange-700 font-bold text-sm">
                    + Přidat knihu
                </a>
            </li>
            <li class="text-slate-400 text-sm hidden sm:block">
                Ahoj, <span class="text-orange-400 font-bold italic"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="text-slate-400 hover:text-orange-600 transition-colors text-xs uppercase tracking-widest font-bold">
                    Odhlásit
                </a>
            </li> 

        <?php else: ?>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-slate-200 hover:text-orange-400 transition-colors font-semibold">
                    Přihlásit
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="bg-slate-800 hover:bg-slate-700 text-orange-400 px-4 py-2 rounded border border-slate-700 transition-all font-bold text-sm shadow-md">
                    Registrace
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
        </div>
    </header>

    <div class="container mx-auto px-6 pt-8">
     <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="mb-8 space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $styles = [
                            'success' => 'bg-emerald-100 border-emerald-500 text-emerald-700',
                            'error'   => 'bg-rose-100 border-rose-500 text-rose-700',
                            'notice'  => 'bg-amber-100 border-amber-500 text-amber-700',
                        ];
                        $style = $styles[$type] ?? 'bg-slate-100 border-slate-500 text-slate-700';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $style ?> border-l-4 p-4 rounded-r-lg shadow-md animate-fade-in">
                            <p class="font-semibold text-sm italic"><?= htmlspecialchars($message) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>
</div>
     