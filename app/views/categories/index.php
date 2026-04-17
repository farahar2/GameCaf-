<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-5xl">

    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
                ADMIN
            </span>
            <h1 class="font-headline text-4xl font-extrabold text-on-background tracking-tight">
                Catégories
            </h1>
            <p class="text-on-surface-variant mt-1">
                Gérez les catégories de jeux du catalogue
            </p>
        </div>

        <a href="categories/create"
           class="bg-primary text-on-primary px-6 py-4 rounded-full font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-lg shadow-primary/20 whitespace-nowrap w-fit">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Nouvelle Catégorie
        </a>
    </div>

    <!-- Success Message -->
    <?php if (!empty($_GET['success'])): ?>
        <div class="bg-secondary-container text-on-secondary-container px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">
                check_circle
            </span>
            <span class="font-bold">
                <?= match($_GET['success']) {
                    'created' => 'Catégorie créée avec succès!',
                    'updated' => 'Catégorie modifiée avec succès!',
                    'deleted' => 'Catégorie supprimée avec succès!',
                    default   => 'Opération réussie!',
                } ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if (!empty($_GET['error'])): ?>
        <div class="bg-error-container text-on-error-container px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            <span class="font-bold">
                <?= match($_GET['error']) {
                    'has_games' => 'Impossible de supprimer: des jeux utilisent cette catégorie!',
                    'not_found' => 'Catégorie introuvable.',
                    default     => 'Une erreur est survenue.',
                } ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10 text-center">
            <p class="text-3xl font-bold font-headline text-primary"><?= count($categories) ?></p>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Total Catégories</p>
        </div>
        <?php
        // Count games per category
        $totalGamesInCats = 0;
        foreach ($categories as $cat) {
            $totalGamesInCats += (int)($cat['games_count'] ?? 0);
        }
        ?>
        <div class="bg-secondary-container p-5 rounded-xl text-center">
            <p class="text-3xl font-bold font-headline text-secondary"><?= $totalGamesInCats ?></p>
            <p class="text-xs text-on-secondary-container mt-1 font-medium">Jeux Catalogués</p>
        </div>
        <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10 text-center">
            <?php
            $withGames = count(array_filter($categories, fn($c) => ($c['games_count'] ?? 0) > 0));
            ?>
            <p class="text-3xl font-bold font-headline text-on-surface"><?= $withGames ?></p>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Avec des Jeux</p>
        </div>
        <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10 text-center">
            <?php
            $empty = count(array_filter($categories, fn($c) => ($c['games_count'] ?? 0) === 0));
            ?>
            <p class="text-3xl font-bold font-headline text-on-surface"><?= $empty ?></p>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Vides</p>
        </div>
    </div>

    <!-- Categories List -->
    <?php if (empty($categories)): ?>

        <div class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-16 rounded-xl text-center">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">
                category
            </span>
            <h3 class="font-headline text-xl font-bold text-on-surface-variant mb-2">
                Aucune catégorie créée
            </h3>
            <p class="text-on-surface-variant text-sm mb-6">
                Créez des catégories pour organiser votre catalogue de jeux.
            </p>
            <a href="categories/create"
               class="inline-block bg-primary text-on-primary px-8 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                Créer une Catégorie
            </a>
        </div>

    <?php else: ?>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">

            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-surface-container-low border-b border-outline-variant/10">
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">#</div>
                <div class="col-span-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Nom</div>
                <div class="col-span-4 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Description</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Jeux</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-right">Actions</div>
            </div>

            <!-- Table Rows -->
            <div class="divide-y divide-outline-variant/10">
                <?php foreach ($categories as $cat): ?>
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-surface-container-low transition-colors items-center group">

                        <!-- ID -->
                        <div class="col-span-1">
                            <span class="text-xs text-on-surface-variant font-mono">
                                #<?= $cat['id'] ?>
                            </span>
                        </div>

                        <!-- Name -->
                        <div class="col-span-3">
                            <p class="font-headline font-bold text-on-surface">
                                <?= htmlspecialchars($cat['name']) ?>
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="col-span-4">
                            <p class="text-sm text-on-surface-variant truncate">
                                <?= !empty($cat['description'])
                                    ? htmlspecialchars(substr($cat['description'], 0, 60)) . '...'
                                    : '—' ?>
                            </p>
                        </div>

                        <!-- Games Count -->
                        <div class="col-span-2">
                            <a href="games?category_id=<?= $cat['id'] ?>"
                               class="inline-flex items-center gap-1 text-sm font-bold
                                      <?= ($cat['games_count'] ?? 0) > 0
                                          ? 'text-secondary hover:underline'
                                          : 'text-on-surface-variant' ?>">
                                <span class="material-symbols-outlined text-sm">casino</span>
                                <?= $cat['games_count'] ?? 0 ?> jeu<?= ($cat['games_count'] ?? 0) > 1 ? 'x' : '' ?>
                            </a>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-2 flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">

                            <a href="categories/<?= $cat['id'] ?>/edit"
                               title="Modifier"
                               class="w-8 h-8 rounded-full bg-surface-container text-on-surface flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>

                            <?php if (($cat['games_count'] ?? 0) === 0): ?>
                                <form action="categories/<?= $cat['id'] ?>/delete"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer la catégorie &quot;<?= htmlspecialchars(addslashes($cat['name'])) ?>&quot;?')">
                                    <button type="submit"
                                            title="Supprimer"
                                            class="w-8 h-8 rounded-full bg-error-container text-on-error-container flex items-center justify-center hover:bg-error hover:text-on-error transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <div title="Impossible de supprimer: contient des jeux"
                                     class="w-8 h-8 rounded-full bg-surface-container text-on-surface-variant/30 flex items-center justify-center cursor-not-allowed">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            <?php foreach ($categories as $cat): ?>
                <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10 shadow-sm">

                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-headline font-bold text-on-surface text-lg">
                                <?= htmlspecialchars($cat['name']) ?>
                            </h3>
                            <?php if (!empty($cat['description'])): ?>
                                <p class="text-xs text-on-surface-variant mt-1">
                                    <?= htmlspecialchars(substr($cat['description'], 0, 80)) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <span class="bg-surface-container px-3 py-1 rounded-full text-xs font-bold">
                            <?= $cat['games_count'] ?? 0 ?> jeux
                        </span>
                    </div>

                    <div class="flex gap-2">
                        <a href="categories/<?= $cat['id'] ?>/edit"
                           class="flex-1 text-center py-2 bg-surface-container-high text-on-surface rounded-lg text-sm font-bold hover:bg-surface-variant transition-colors">
                            ✏️ Modifier
                        </a>

                        <?php if (($cat['games_count'] ?? 0) === 0): ?>
                            <form action="categories/<?= $cat['id'] ?>/delete"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Supprimer cette catégorie?')">
                                <button type="submit"
                                        class="w-full py-2 bg-error-container text-on-error-container rounded-lg text-sm font-bold">
                                    🗑️ Supprimer
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="games?category_id=<?= $cat['id'] ?>"
                               class="flex-1 text-center py-2 bg-secondary-container text-on-secondary-container rounded-lg text-sm font-bold">
                                🎲 Voir Jeux
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

 
 <!-- Spacer for mobile nav handled by footer -->
 <div class="md:hidden h-20"></div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>