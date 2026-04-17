<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-7xl mx-auto">

    <!-- Page Title -->
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
            <form action="games" method="GET" class="flex gap-3 flex-grow">

                <?php if (!empty($_GET['category_id'])): ?>
                    <input type="hidden" name="category_id"
                           value="<?= htmlspecialchars($_GET['category_id']) ?>"/>
                <?php endif; ?>

                <div class="relative flex-grow sm:w-80">
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
                        class="bg-surface-container-high p-4 rounded-full flex items-center justify-center text-primary active:scale-95 hover:bg-surface-variant transition-all">
                    <span class="material-symbols-outlined">filter_list</span>
                </button>
            </form>

            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="games/create"
                   class="bg-primary text-on-primary px-6 py-4 rounded-full font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-lg shadow-primary/20 whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Ajouter
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Category Chips -->
    <div class="flex gap-3 mb-10 overflow-x-auto pb-4">
        <a href="games"
           class="px-6 py-2 rounded-full font-medium whitespace-nowrap transition-all
                  <?= empty($_GET['category_id'])
                      ? 'bg-primary text-on-primary shadow-md shadow-primary/20'
                      : 'bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary-container' ?>">
            Tous
        </a>
        <?php foreach ($categories as $cat):
            $isActive = ($_GET['category_id'] ?? '') == $cat['id'];
            $href     = 'games?category_id=' . $cat['id'];
            if (!empty($_GET['search'])) {
                $href .= '&search=' . urlencode($_GET['search']);
            }
        ?>
            <a href="<?= $href ?>"
               class="px-6 py-2 rounded-full font-medium whitespace-nowrap transition-all
                      <?= $isActive
                          ? 'bg-primary text-on-primary shadow-md shadow-primary/20'
                          : 'bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary-container' ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Success Message -->
    <?php if (!empty($_GET['success'])): ?>
        <div class="bg-secondary-container text-on-secondary-container px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">check_circle</span>
            <span class="font-bold">
                <?= match($_GET['success']) {
                    'created' => 'Jeu ajouté avec succès!',
                    'updated' => 'Jeu modifié avec succès!',
                    'deleted' => 'Jeu supprimé avec succès!',
                    default   => 'Opération réussie!',
                } ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Games Grid -->
    <?php if (empty($games)): ?>

        <div class="flex flex-col items-center justify-center py-24 text-center">
            <span class="material-symbols-outlined text-7xl text-on-surface-variant/20 mb-4">casino</span>
            <h2 class="font-headline text-2xl font-bold mb-2">Aucun jeu trouvé</h2>
            <p class="text-on-surface-variant mb-6">
                <?= !empty($_GET['search'])
                    ? 'Aucun résultat pour "' . htmlspecialchars($_GET['search']) . '"'
                    : 'Aucun jeu dans cette catégorie.' ?>
            </p>
            <a href="games" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                Voir tous les jeux
            </a>
        </div>

    <?php else: ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($games as $game): ?>

                <div class="bg-surface-container-lowest rounded-xl overflow-hidden flex flex-col group hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md">

                    <!-- Image -->
                    <div class="relative h-64 overflow-hidden">
                        <?php
                        $gameImg = !empty($game['image_url']) ? $game['image_url'] : 'https://placehold.co/400x300/ffdcc3/8d4b00?text=' . urlencode($game['name']);
                        if (str_starts_with($gameImg, '/') && !str_starts_with($gameImg, '//')) {
                            $gameImg = ltrim($gameImg, '/');
                        }
                        ?>
                        <img alt="<?= htmlspecialchars($game['name']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             src="<?= htmlspecialchars($gameImg) ?>"
                             onerror="this.onerror=null; this.src='https://placehold.co/400x300/ffdcc3/8d4b00?text=<?= urlencode(addslashes($game['name'])) ?>';"/>

                        <!-- Status Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider
                                <?= $game['is_available'] ? 'bg-secondary' : 'bg-tertiary' ?>">
                                <?= $game['is_available'] ? 'Disponible' : 'Occupé' ?>
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="absolute top-4 right-4">
                            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <div class="flex gap-2">
                                    <a href="games/<?= $game['id'] ?>/edit"
                                       class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg hover:bg-white transition-colors">
                                        <span class="material-symbols-outlined text-primary text-xl">edit</span>
                                    </a>
                                    <form action="games/<?= $game['id'] ?>/delete" method="POST"
                                          onsubmit="return confirm('Supprimer <?= htmlspecialchars(addslashes($game['name'])) ?>?')">
                                        <button type="submit"
                                                class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg hover:bg-white transition-colors">
                                            <span class="material-symbols-outlined text-error text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg">
                                    <span class="material-symbols-outlined text-primary text-xl">favorite</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex flex-col flex-grow">

                        <!-- Category Badge -->
                        <div class="flex items-center gap-2 mb-3">
                            <?php
                            $catColors = [
                                'Stratégie' => 'bg-primary-fixed text-on-primary-fixed-variant',
                                'Strategy'  => 'bg-primary-fixed text-on-primary-fixed-variant',
                                'Famille'   => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                                'Family'    => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                                'Ambiance'  => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                                'Experts'   => 'bg-primary-fixed text-on-primary-fixed-variant',
                                'Expert'    => 'bg-primary-fixed text-on-primary-fixed-variant',
                            ];
                            $catColor = $catColors[$game['category_name'] ?? ''] ?? 'bg-surface-container text-on-surface-variant';
                            ?>
                            <span class="<?= $catColor ?> text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                <?= htmlspecialchars($game['category_name'] ?? 'Jeu') ?>
                            </span>
                            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded uppercase
                                    <?= ($game['stock'] ?? 0) > 0
                                        ? 'bg-secondary-container text-on-secondary-container'
                                        : 'bg-error-container text-on-error-container' ?>">
                                    Stock: <?= $game['stock'] ?? 0 ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Name -->
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
                                $diffMap = ['easy' => 1, 'medium' => 2, 'hard' => 3, 'expert' => 3];
                                $level   = $diffMap[strtolower($game['difficulty'] ?? 'medium')] ?? 2;
                                for ($i = 1; $i <= 3; $i++):
                                ?>
                                    <div class="w-6 h-1 rounded-full <?= $i <= $level ? 'bg-primary' : 'bg-outline-variant' ?>"></div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Action -->
                        <a href="games/<?= $game['id'] ?>"
                           class="mt-auto w-full text-center bg-surface-container-low text-primary font-bold py-4 rounded-xl hover:bg-primary hover:text-on-primary transition-all active:scale-95 block">
                            Voir Détails
                        </a>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

 
 <!-- Spacer for mobile nav handled by footer -->
 <div class="md:hidden h-20"></div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>