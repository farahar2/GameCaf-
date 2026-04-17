<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-5xl">

    <!-- Back -->
    <a href="games"
       class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors mb-8 text-sm font-medium">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Retour au Catalogue
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- ===== Image Column ===== -->
        <div class="space-y-4">

            <!-- Main Image -->
            <div class="w-full h-80 rounded-xl overflow-hidden bg-surface-container shadow-md">
                <?php
                $gameImg = !empty($game['image_url']) ? $game['image_url'] : 'https://placehold.co/600x400/ffdcc3/8d4b00?text=' . urlencode($game['name']);
                if (str_starts_with($gameImg, '/') && !str_starts_with($gameImg, '//')) {
                    $gameImg = ltrim($gameImg, '/');
                }
                ?>
                <img alt="<?= htmlspecialchars($game['name']) ?>"
                     class="w-full h-full object-cover"
                     src="<?= htmlspecialchars($gameImg) ?>"
                     onerror="this.onerror=null; this.src='https://placehold.co/600x400/ffdcc3/8d4b00?text=<?= urlencode(addslashes($game['name'])) ?>';"/>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-3 gap-3">

                <div class="bg-surface-container-lowest p-4 rounded-xl text-center border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary mb-1 block">group</span>
                    <p class="text-xs text-on-surface-variant mb-1">Joueurs</p>
                    <p class="font-headline font-bold text-on-surface">
                        <?= $game['min_players'] ?>-<?= $game['max_players'] ?>
                    </p>
                </div>

                <div class="bg-surface-container-lowest p-4 rounded-xl text-center border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary mb-1 block">schedule</span>
                    <p class="text-xs text-on-surface-variant mb-1">Durée</p>
                    <p class="font-headline font-bold text-on-surface">
                        <?= $game['duration'] ?>min
                    </p>
                </div>

                <div class="bg-surface-container-lowest p-4 rounded-xl text-center border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary mb-1 block">inventory_2</span>
                    <p class="text-xs text-on-surface-variant mb-1">Stock</p>
                    <p class="font-headline font-bold text-on-surface">
                        <?= $game['stock'] ?? 1 ?>
                    </p>
                </div>

            </div>

        </div>

        <!-- ===== Info Column ===== -->
        <div class="space-y-6">

            <!-- Header -->
            <div>
                <div class="flex items-center gap-2 mb-3 flex-wrap">
                    <?php
                    $catColors = [
                        'Stratégie' => 'bg-primary-fixed text-on-primary-fixed-variant',
                        'Famille'   => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                        'Ambiance'  => 'bg-secondary-fixed text-on-secondary-fixed-variant',
                        'Experts'   => 'bg-primary-fixed text-on-primary-fixed-variant',
                    ];
                    $catColor = $catColors[$game['category_name'] ?? ''] ?? 'bg-surface-container text-on-surface-variant';
                    ?>
                    <span class="<?= $catColor ?> text-xs font-bold px-3 py-1 rounded-full uppercase">
                        <?= htmlspecialchars($game['category_name'] ?? 'Jeu') ?>
                    </span>

                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                        <?= $game['is_available']
                            ? 'bg-secondary text-white'
                            : 'bg-tertiary text-white' ?>">
                        <?= $game['is_available'] ? '✓ Disponible' : '✕ Occupé' ?>
                    </span>
                </div>

                <h1 class="font-headline text-4xl font-extrabold text-on-background tracking-tight mb-2">
                    <?= htmlspecialchars($game['name']) ?>
                </h1>

                <!-- Difficulty -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-on-surface-variant uppercase tracking-widest font-bold">
                        Difficulté:
                    </span>
                    <div class="flex gap-1">
                        <?php
                        $diffMap = ['easy' => 1, 'medium' => 2, 'hard' => 3, 'expert' => 3];
                        $level   = $diffMap[strtolower($game['difficulty'] ?? 'medium')] ?? 2;
                        for ($i = 1; $i <= 3; $i++):
                        ?>
                            <div class="w-6 h-1.5 rounded-full <?= $i <= $level ? 'bg-primary' : 'bg-outline-variant' ?>"></div>
                        <?php endfor; ?>
                    </div>
                    <span class="text-xs text-on-surface-variant capitalize">
                        <?= htmlspecialchars($game['difficulty'] ?? 'Medium') ?>
                    </span>
                </div>
            </div>

            <!-- Description -->
            <?php if (!empty($game['description'])): ?>
                <div class="bg-surface-container-low rounded-xl p-5">
                    <h3 class="font-headline font-bold text-on-surface mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">info</span>
                        Description
                    </h3>
                    <p class="text-on-surface-variant leading-relaxed text-sm">
                        <?= nl2br(htmlspecialchars($game['description'])) ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="space-y-3">

                <?php if ($game['is_available']): ?>
                    <a href="reservations/create?game_id=<?= $game['id'] ?>"
                       class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2 block text-center">
                        <span class="material-symbols-outlined">event_available</span>
                        Réserver avec ce Jeu
                    </a>
                <?php else: ?>
                    <div class="w-full bg-surface-container text-on-surface-variant py-4 rounded-xl font-bold text-center">
                        <span class="material-symbols-outlined align-middle mr-2">event_busy</span>
                        Jeu actuellement occupé
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="games/<?= $game['id'] ?>/edit"
                           class="py-3 bg-surface-container-high text-on-surface rounded-xl font-bold text-center hover:bg-surface-variant transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">edit</span>
                            Modifier
                        </a>
                        <form action="games/<?= $game['id'] ?>/delete"
                              method="POST"
                              onsubmit="return confirm('Supprimer <?= htmlspecialchars(addslashes($game['name'])) ?>?')">
                            <button type="submit"
                                    class="w-full py-3 bg-error-container text-on-error-container rounded-xl font-bold hover:bg-error hover:text-on-error transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">delete</span>
                                Supprimer
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Game Added Date -->
            <p class="text-xs text-on-surface-variant text-center">
                Ajouté le <?= date('d/m/Y', strtotime($game['created_at'])) ?>
            </p>

        </div>

    </div>

</main>

 
 <!-- Spacer for mobile nav handled by footer -->
 <div class="md:hidden h-20"></div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>