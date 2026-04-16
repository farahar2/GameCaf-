<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<!-- Main Content Area -->
<main class="md:ml-72 px-6 pt-8 pb-32 max-w-7xl mx-auto">

    <!-- Page Title Section -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
                EXPLOREZ
            </span>
            <h1 class="font-headline text-5xl font-extrabold text-on-background tracking-tight">
                Catalogue de Jeux
            </h1>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">

            <!-- Search Bar -->
            <form action="/games" method="GET" class="relative flex-grow sm:w-80 flex gap-2">

                <!-- Keep category filter if set -->
                <?php if (!empty($_GET['category'])): ?>
                    <input type="hidden"
                           name="category"
                           value="<?= htmlspecialchars($_GET['category']) ?>"/>
                <?php endif; ?>

                <div class="relative flex-grow">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        search
                    </span>
                    <input type="text"
                           name="search"
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                           placeholder="Rechercher un jeu..."
                           class="w-full bg-surface-container-highest border-none rounded-full py-4 pl-12 pr-6 focus:ring-2 focus:ring-primary/20 text-on-surface placeholder:text-on-surface-variant/60"/>
                </div>

                <button type="submit"
                        class="bg-surface-container-high p-4 rounded-full flex items-center justify-center text-primary transition-transform active:scale-95">
                    <span class="material-symbols-outlined">filter_list</span>
                </button>
            </form>

            <!-- Admin: Add Game Button -->
            <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/games/create"
                   class="bg-primary text-on-primary px-6 py-4 rounded-full font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">add</span>
                    Ajouter
                </a>
            <?php endif; ?>

        </div>
    </div>

    <!-- Category Filter Chips -->
    <div class="flex gap-3 mb-10 overflow-x-auto pb-4">
        <?php
        $categories    = ['Tous', 'Stratégie', 'Famille', 'Ambiance', 'Experts'];
        $activeCategory = $_GET['category'] ?? 'Tous';

        foreach ($categories as $cat):
            $isActive = ($activeCategory === $cat);
            $href     = ($cat === 'Tous') ? '/games' : '/games?category=' . urlencode($cat);

            // Keep search if exists
            if (!empty($_GET['search']) && $cat !== 'Tous') {
                $href .= '&search=' . urlencode($_GET['search']);
            }
        ?>
            <a href="<?= $href ?>"
               class="px-6 py-2 rounded-full font-medium whitespace-nowrap transition-all
                      <?= $isActive
                          ? 'bg-primary text-on-primary shadow-md shadow-primary/20'
                          : 'bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary-container' ?>">
                <?= $cat ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Success/Error Messages -->
    <?php if (!empty($_GET['success'])): ?>
        <div class="bg-secondary-container text-on-secondary-container px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <?php
            $messages = [
                'created' => 'Jeu ajouté avec succès!',
                'updated' => 'Jeu modifié avec succès!',
                'deleted' => 'Jeu supprimé avec succès!',
            ];
            echo $messages[$_GET['success']] ?? 'Opération réussie!';
            ?>
        </div>
    <?php endif; ?>

    <!-- Games Grid -->
    <?php if (empty($games)): ?>

        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="text-8xl mb-6">🎲</div>
            <h2 class="font-headline text-2xl font-bold text-on-background mb-2">
                Aucun jeu trouvé
            </h2>
            <p class="text-on-surface-variant mb-8">
                <?php if (!empty($_GET['search'])): ?>
                    Aucun résultat pour "<?= htmlspecialchars($_GET['search']) ?>"
                <?php else: ?>
                    Aucun jeu dans cette catégorie pour le moment.
                <?php endif; ?>
            </p>
            <a href="/games"
               class="bg-primary text-on-primary px-8 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                Voir tous les jeux
            </a>
        </div>

    <?php else: ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($games as $game): ?>

                <div class="bg-surface-container-lowest rounded-xl overflow-hidden flex flex-col group hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md">

                    <!-- Game Image -->
                    <div class="relative h-64 overflow-hidden">
                        <img alt="<?= htmlspecialchars($game['name']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             src="<?= htmlspecialchars($game['image_url'] ?? 'https://placehold.co/400x300/ffdcc3/8d4b00?text=' . urlencode($game['name'])) ?>"/>

                        <!-- Availability Badge -->
                        <div class="absolute top-4 left-4">
                            <?php if ($game['is_available']): ?>
                                <span class="bg-secondary text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Disponible
                                </span>
                            <?php else: ?>
                                <span class="bg-tertiary text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Occupé
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Admin Actions (Top Right) -->
                        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <div class="absolute top-4 right-4 flex gap-2">
                                <a href="/games/<?= $game['id'] ?>/edit"
                                   class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg hover:bg-white transition-colors">
                                    <span class="material-symbols-outlined text-primary text-xl">edit</span>
                                </a>
                                <form action="/games/<?= $game['id'] ?>/delete"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer ce jeu?')">
                                    <button type="submit"
                                            class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg hover:bg-white transition-colors">
                                        <span class="material-symbols-outlined text-error text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <!-- Client: Favorite Button -->
                            <div class="absolute top-4 right-4">
                                <div class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg">
                                    <span class="material-symbols-outlined text-primary text-xl">favorite</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Game Info -->
                    <div class="p-6 flex flex-col flex-grow">

                        <!-- Category Badge -->
                        <div class="flex items-center gap-2 mb-3">
                            <?php
                            $catStyles = [
                                'Stratégie' => 'bg-primary-fixed text-on-primary-fixed-variant',
                                'Famille'   => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                                'Ambiance'  => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                                'Experts'   => 'bg-primary-fixed text-on-primary-fixed-variant',
                            ];
                            $catStyle = $catStyles[$game['category_name'] ?? ''] ?? 'bg-surface-container text-on-surface-variant';
                            ?>
                            <span class="<?= $catStyle ?> text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                <?= htmlspecialchars($game['category_name'] ?? 'Jeu') ?>
                            </span>

                            <!-- Stock Badge (Admin only) -->
                            <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase
                                    <?= $game['stock'] > 0
                                        ? 'bg-secondary-container text-on-secondary-container'
                                        : 'bg-error-container text-on-error-container' ?>">
                                    Stock: <?= $game['stock'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Game Name -->
                        <h3 class="font-headline text-2xl font-bold text-on-background mb-4">
                            <?= htmlspecialchars($game['name']) ?>
                        </h3>

                        <!-- Players & Duration -->
                        <div class="flex items-center justify-between mb-6 text-on-surface-variant text-sm font-medium">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-primary text-lg">group</span>
                                <span><?= $game['min_players'] ?>-<?= $game['max_players'] ?> Joueurs</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                                <span><?= $game['duration'] ?> min</span>
                            </div>
                        </div>

                        <!-- Difficulty Bars -->
                        <div class="flex items-center gap-2 mb-8">
                            <span class="text-xs text-on-surface-variant uppercase tracking-widest font-bold">
                                Difficulté
                            </span>
                            <div class="flex gap-1">
                                <?php
                                $difficultyMap = [
                                    'easy'   => 1,
                                    'medium' => 2,
                                    'hard'   => 3,
                                    'expert' => 3,
                                ];
                                $diffLevel = $difficultyMap[strtolower($game['difficulty'])] ?? 1;

                                for ($i = 1; $i <= 3; $i++):
                                ?>
                                    <div class="w-6 h-1 rounded-full
                                        <?= $i <= $diffLevel
                                            ? 'bg-primary'
                                            : 'bg-outline-variant' ?>">
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <span class="text-xs text-on-surface-variant capitalize">
                                <?= htmlspecialchars($game['difficulty']) ?>
                            </span>
                        </div>

                        <!-- Action Button -->
                        <a href="/games/<?= $game['id'] ?>"
                           class="mt-auto w-full text-center bg-surface-container-low text-primary font-bold py-4 rounded-xl hover:bg-primary hover:text-on-primary transition-all active:scale-95">
                            Voir Détails
                        </a>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

<!-- Bottom Nav (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav = [
        ['uri' => '/',      'icon' => 'home',      'label' => 'Home'],
        ['uri' => '/games', 'icon' => 'grid_view',  'label' => 'Catalog'],
        ['uri' => '/reservations/create', 'icon' => 'event',  'label' => 'Book'],
        ['uri' => '/reservations/my',     'icon' => 'person', 'label' => 'Profile'],
    ];

    $currentUri = $_SERVER['REQUEST_URI'] ?? '/';

    foreach ($mobileNav as $item):
        $isActive = str_starts_with($currentUri, $item['uri'])
                    && !($item['uri'] === '/' && $currentUri !== '/');
    ?>
        <a href="<?= $item['uri'] ?>"
           class="flex flex-col items-center justify-center px-4 py-1 transition-all duration-200
                  <?= $isActive
                      ? 'bg-[#ffdbcc] text-[#8d4b00] rounded-2xl'
                      : 'text-stone-500 hover:bg-[#fff1eb]' ?>">
            <span class="material-symbols-outlined mb-1"
                  style="<?= $isActive ? "font-variation-settings: 'FILL' 1;" : '' ?>">
                <?= $item['icon'] ?>
            </span>
            <span class="text-xs font-medium"><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<?php require __DIR__ . '/../layouts/footer.php'; ?>