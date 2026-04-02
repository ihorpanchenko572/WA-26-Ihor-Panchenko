<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Knihovna - Seznam knih</title>
</head>
<body class="bg-orange-50 text-slate-800 min-h-screen font-sans">

    <header class="bg-gradient-to-b from-orange-400 to-orange-600 border-b border-orange-700 shadow-xl">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight text-white uppercase italic">
                Aplikace <span class="text-orange-100">Knihovna</span>
            </h1>
            
            <nav class="mt-4 md:mt-0">
                <ul class="flex space-x-6">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="text-white hover:text-orange-100 transition-colors font-medium">Seznam knih</a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-orange-700 hover:bg-orange-800 text-white px-4 py-2 rounded-md transition-all shadow-inner border border-orange-800">
                            + Přidat knihu
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-6 py-10">
        
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

        <div class="flex justify-between items-end mb-6">
            <h2 class="text-3xl font-light tracking-widest text-orange-800/60 uppercase">Dostupné knihy</h2>
        </div>
        
        <div class="bg-white border border-orange-200 rounded-xl overflow-hidden shadow-2xl backdrop-blur-sm">
            <?php if (empty($books)): ?>
                <div class="p-10 text-center text-slate-400 italic">
                    V databázi se zatím nenachází žádné knihy.
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-orange-100 border-b border-orange-200">
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-orange-800 tracking-wider text-center">ID</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-orange-800 tracking-wider">Název knihy</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-orange-800 tracking-wider">Autor</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-orange-800 tracking-wider">Rok</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-orange-800 tracking-wider text-right">Cena</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-orange-800 tracking-wider text-center">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-100">
                            <?php foreach ($books as $book): ?>
                                <tr class="hover:bg-orange-50/50 transition-colors group">
                                    <td class="px-6 py-4 text-center text-slate-400 text-sm italic"><?= htmlspecialchars($book['id']) ?></td>
                                    <td class="px-6 py-4 font-medium text-slate-900 group-hover:text-orange-600"><?= htmlspecialchars($book['title']) ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($book['author']) ?></td>
                                    <td class="px-6 py-4 text-slate-500 font-mono"><?= htmlspecialchars($book['year']) ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-800"><?= htmlspecialchars($book['price']) ?> Kč</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-3 text-sm">
                                            <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-orange-600 hover:text-orange-800 transition-colors underline decoration-orange-200 underline-offset-4">Detail</a>
                                            <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-emerald-600 hover:text-emerald-800 transition-colors underline decoration-emerald-200 underline-offset-4">Upravit</a>
                                            <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-rose-600 hover:text-rose-800 transition-colors underline decoration-rose-200 underline-offset-4">Smazat</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="mt-auto border-t border-orange-200 py-8 text-center">
        <p class="text-orange-800/40 text-sm tracking-widest uppercase italic">&copy; WA 2026 - Výukový projekt v pomerančovém stylu</p>
    </footer>

</body>
</html>