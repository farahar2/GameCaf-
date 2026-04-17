<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-6xl">

    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
                ADMIN
            </span>
            <h1 class="font-headline text-4xl font-extrabold text-on-background tracking-tight">
                Gestion des Tables
            </h1>
            <p class="text-on-surface-variant mt-1">
                Vue d'ensemble des tables du café
            </p>
        </div>

        <!-- Quick Actions -->
        <div class="flex gap-3">
            <a href="/sessions/start"
               class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:scale-105 transition-transform shadow-md shadow-primary/20">
                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                Démarrer Session
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (!empty($_GET['success'])): ?>
        <div class="bg-secondary-container text-on-secondary-container px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">check_circle</span>
            <span class="font-bold">Statut de la table mis à jour!</span>
        </div>
    <?php endif; ?>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">

        <!-- Total -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 text-center">
            <span class="material-symbols-outlined text-primary mb-2 block text-3xl">
                table_restaurant
            </span>
            <p class="text-3xl font-bold font-headline text-on-surface">
                <?= count($tables) ?>
            </p>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Total Tables</p>
        </div>

        <!-- Available -->
        <div class="bg-secondary-container p-6 rounded-xl text-center">
            <?php
            $availableCount = count(array_filter($tables, fn($t) => $t['is_available'] == true));
            ?>
            <span class="material-symbols-outlined text-secondary mb-2 block text-3xl"
                  style="font-variation-settings:'FILL' 1;">
                check_circle
            </span>
            <p class="text-3xl font-bold font-headline text-secondary">
                <?= $availableCount ?>
            </p>
            <p class="text-xs text-on-secondary-container mt-1 font-medium">Disponibles</p>
        </div>

        <!-- Occupied -->
        <div class="bg-tertiary-fixed p-6 rounded-xl text-center">
            <?php
            $occupiedCount = count(array_filter($tables, fn($t) => $t['is_available'] == false));
            ?>
            <span class="material-symbols-outlined text-tertiary mb-2 block text-3xl"
                  style="font-variation-settings:'FILL' 1;">
                people
            </span>
            <p class="text-3xl font-bold font-headline text-tertiary">
                <?= $occupiedCount ?>
            </p>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Occupées</p>
        </div>

        <!-- Occupancy Rate -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 text-center">
            <?php
            $rate = count($tables) > 0
                ? round(($occupiedCount / count($tables)) * 100)
                : 0;
            ?>
            <span class="material-symbols-outlined text-primary mb-2 block text-3xl">
                percent
            </span>
            <p class="text-3xl font-bold font-headline text-on-surface">
                <?= $rate ?>%
            </p>
            <p class="text-xs text-on-surface-variant mt-1 font-medium">Taux d'Occupation</p>
        </div>

    </div>

    <!-- Visual Floor Map -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 shadow-sm p-6 mb-8">

        <div class="flex items-center justify-between mb-6">
            <h3 class="font-headline text-lg font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">map</span>
                Plan du Café
            </h3>
            <!-- Legend -->
            <div class="flex gap-4 text-xs font-medium">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-secondary inline-block"></span>
                    Disponible
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-tertiary inline-block"></span>
                    Occupée
                </span>
            </div>
        </div>

        <!-- Tables Grid (Visual) -->
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
            <?php foreach ($tables as $table): ?>
                <a href="/tables/<?= $table['id'] ?>"
                   class="group flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:scale-105
                          <?= $table['is_available']
                              ? 'bg-secondary-container hover:bg-secondary/20'
                              : 'bg-tertiary-fixed hover:bg-tertiary/20' ?>">

                    <!-- Table Icon -->
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-headline font-black text-lg
                                <?= $table['is_available']
                                    ? 'bg-secondary text-white'
                                    : 'bg-tertiary text-white' ?>">
                        <?= $table['table_number'] ?>
                    </div>

                    <!-- Capacity -->
                    <div class="text-center">
                        <p class="text-xs font-bold text-on-surface">
                            T<?= sprintf('%02d', $table['table_number']) ?>
                        </p>
                        <p class="text-[10px] text-on-surface-variant">
                            👥 <?= $table['capacity'] ?>
                        </p>
                    </div>

                    <!-- Status Dot -->
                    <span class="w-2 h-2 rounded-full
                        <?= $table['is_available'] ? 'bg-secondary' : 'bg-tertiary animate-pulse' ?>">
                    </span>

                </a>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Detailed Table List -->
    <h3 class="font-headline text-xl font-bold text-on-surface mb-4">
        Détail des Tables
    </h3>

    <?php if (empty($tables)): ?>

        <div class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-12 rounded-xl text-center">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/30 mb-3 block">
                table_restaurant
            </span>
            <h3 class="font-headline text-lg font-bold text-on-surface-variant">
                Aucune table configurée
            </h3>
        </div>

    <?php else: ?>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">

            <!-- Header -->
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-surface-container-low border-b border-outline-variant/10">
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Table</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Capacité</div>
                <div class="col-span-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Statut</div>
                <div class="col-span-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Occupation</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-right">Actions</div>
            </div>

            <!-- Rows -->
            <div class="divide-y divide-outline-variant/10">
                <?php foreach ($tables as $table): ?>
                    <div class="grid grid-cols-12 gap-4 px-6 py-5 hover:bg-surface-container-low transition-colors items-center">

                        <!-- Table Number -->
                        <div class="col-span-2 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-headline font-bold
                                        <?= $table['is_available']
                                            ? 'bg-secondary text-white'
                                            : 'bg-tertiary text-white' ?>">
                                <?= $table['table_number'] ?>
                            </div>
                            <span class="font-bold text-on-surface">
                                Table <?= $table['table_number'] ?>
                            </span>
                        </div>

                        <!-- Capacity -->
                        <div class="col-span-2">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-primary text-lg">group</span>
                                <span class="font-medium text-sm">
                                    <?= $table['capacity'] ?> places
                                </span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="col-span-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold
                                <?= $table['is_available']
                                    ? 'bg-secondary-container text-on-secondary-container'
                                    : 'bg-tertiary-fixed text-tertiary' ?>">
                                <span class="w-1.5 h-1.5 rounded-full
                                    <?= $table['is_available']
                                        ? 'bg-secondary'
                                        : 'bg-tertiary animate-pulse' ?>">
                                </span>
                                <?= $table['is_available'] ? 'Disponible' : 'Occupée' ?>
                            </span>
                        </div>

                        <!-- Occupancy Visual -->
                        <div class="col-span-3">
                            <?php if ($table['is_available']): ?>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-surface-container rounded-full">
                                        <div class="h-full w-0 bg-secondary rounded-full"></div>
                                    </div>
                                    <span class="text-xs text-on-surface-variant">Libre</span>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-surface-container rounded-full overflow-hidden">
                                        <div class="h-full w-full bg-tertiary rounded-full"></div>
                                    </div>
                                    <span class="text-xs text-tertiary font-bold">En cours</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-2 flex justify-end gap-2">

                            <!-- View -->
                            <a href="/tables/<?= $table['id'] ?>"
                               title="Voir détails"
                               class="w-8 h-8 rounded-full bg-surface-container text-on-surface flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>

                            <!-- Toggle Availability -->
                            <form action="/tables/<?= $table['id'] ?>/availability" method="POST">
                                <button type="submit"
                                        title="<?= $table['is_available'] ? 'Marquer Occupée' : 'Marquer Disponible' ?>"
                                        class="w-8 h-8 rounded-full flex items-center justify-center transition-colors
                                            <?= $table['is_available']
                                                ? 'bg-tertiary-fixed text-tertiary hover:bg-tertiary hover:text-white'
                                                : 'bg-secondary-container text-secondary hover:bg-secondary hover:text-white' ?>">
                                    <span class="material-symbols-outlined text-sm">
                                        <?= $table['is_available'] ? 'lock' : 'lock_open' ?>
                                    </span>
                                </button>
                            </form>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php foreach ($tables as $table): ?>
                <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 shadow-sm overflow-hidden">

                    <!-- Color Top Bar -->
                    <div class="h-1.5 <?= $table['is_available'] ? 'bg-secondary' : 'bg-tertiary' ?>"></div>

                    <div class="p-5">

                        <!-- Header -->
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl font-headline font-black text-xl flex items-center justify-center
                                            <?= $table['is_available'] ? 'bg-secondary text-white' : 'bg-tertiary text-white' ?>">
                                    <?= $table['table_number'] ?>
                                </div>
                                <div>
                                    <p class="font-headline font-bold text-on-surface">
                                        Table <?= $table['table_number'] ?>
                                    </p>
                                    <p class="text-xs text-on-surface-variant">
                                        👥 <?= $table['capacity'] ?> places
                                    </p>
                                </div>
                            </div>

                            <span class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                                <?= $table['is_available']
                                    ? 'bg-secondary-container text-on-secondary-container'
                                    : 'bg-tertiary-fixed text-tertiary' ?>">
                                <span class="w-1.5 h-1.5 rounded-full
                                    <?= $table['is_available'] ? 'bg-secondary' : 'bg-tertiary animate-pulse' ?>">
                                </span>
                                <?= $table['is_available'] ? 'Libre' : 'Occupée' ?>
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="/tables/<?= $table['id'] ?>"
                               class="flex-1 text-center py-2.5 bg-surface-container text-on-surface rounded-lg text-sm font-bold hover:bg-surface-container-high transition-colors">
                                Détails
                            </a>
                            <form action="/tables/<?= $table['id'] ?>/availability" method="POST" class="flex-1">
                                <button type="submit"
                                        class="w-full py-2.5 rounded-lg text-sm font-bold transition-colors
                                            <?= $table['is_available']
                                                ? 'bg-tertiary-fixed text-tertiary hover:bg-tertiary hover:text-white'
                                                : 'bg-secondary-container text-secondary hover:bg-secondary hover:text-white' ?>">
                                    <?= $table['is_available'] ? '🔒 Occuper' : '🔓 Libérer' ?>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

<!-- Mobile Nav -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav  = [
        ['uri' => '/dashboard',  'icon' => 'dashboard',       'label' => 'Dashboard'],
        ['uri' => '/games',      'icon' => 'casino',            'label' => 'Games'],
        ['uri' => '/tables',     'icon' => 'table_restaurant',  'label' => 'Tables'],
        ['uri' => '/sessions',   'icon' => 'style',             'label' => 'Sessions'],
    ];
    $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
    foreach ($mobileNav as $item):
        $isActive = str_starts_with($currentUri, $item['uri']);
    ?>
        <a href="<?= $item['uri'] ?>"
           class="flex flex-col items-center px-3 py-1 rounded-2xl transition-all
                  <?= $isActive ? 'bg-[#ffdbcc] text-[#8d4b00]' : 'text-stone-500' ?>">
            <span class="material-symbols-outlined"
                  style="<?= $isActive ? "font-variation-settings:'FILL' 1;" : '' ?>">
                <?= $item['icon'] ?>
            </span>
            <span class="text-xs font-medium"><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<div class="md:hidden h-20"></div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>