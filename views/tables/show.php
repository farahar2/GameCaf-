<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-3xl">

    <!-- Back -->
    <a href="/tables"
       class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors mb-8 text-sm font-medium">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Retour aux Tables
    </a>

    <!-- Header -->
    <div class="mb-8">
        <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
            ADMIN — TABLE
        </span>
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl font-headline font-black text-3xl flex items-center justify-center flex-shrink-0
                        <?= $table['is_available'] ? 'bg-secondary text-white' : 'bg-tertiary text-white' ?>">
                <?= $table['table_number'] ?>
            </div>
            <div>
                <h1 class="font-headline text-4xl font-extrabold text-on-background">
                    Table <?= $table['table_number'] ?>
                </h1>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold mt-1
                    <?= $table['is_available']
                        ? 'bg-secondary-container text-on-secondary-container'
                        : 'bg-tertiary-fixed text-tertiary' ?>">
                    <span class="w-1.5 h-1.5 rounded-full
                        <?= $table['is_available'] ? 'bg-secondary' : 'bg-tertiary animate-pulse' ?>">
                    </span>
                    <?= $table['is_available'] ? 'Disponible' : 'Occupée' ?>
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- Info Card -->
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 p-6 space-y-5">

            <h3 class="font-headline font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">info</span>
                Informations
            </h3>

            <div class="space-y-4">

                <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                        <span class="material-symbols-outlined text-sm">tag</span>
                        Numéro
                    </div>
                    <span class="font-headline font-bold text-on-surface">
                        #<?= sprintf('%02d', $table['table_number']) ?>
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                        <span class="material-symbols-outlined text-sm">group</span>
                        Capacité
                    </div>
                    <span class="font-headline font-bold text-on-surface">
                        <?= $table['capacity'] ?> personnes
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-outline-variant/10">
                    <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                        <span class="material-symbols-outlined text-sm">circle</span>
                        Statut
                    </div>
                    <span class="font-bold text-sm
                        <?= $table['is_available'] ? 'text-secondary' : 'text-tertiary' ?>">
                        <?= $table['is_available'] ? '✅ Disponible' : '🔴 Occupée' ?>
                    </span>
                </div>

                <div class="flex justify-between items-center py-3">
                    <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                        Ajoutée le
                    </div>
                    <span class="font-medium text-sm text-on-surface">
                        <?= date('d/m/Y', strtotime($table['created_at'])) ?>
                    </span>
                </div>

            </div>

        </div>

        <!-- Actions Card -->
        <div class="space-y-4">

            <!-- Toggle Availability -->
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 p-6">
                <h3 class="font-headline font-bold text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">toggle_on</span>
                    Disponibilité
                </h3>

                <p class="text-sm text-on-surface-variant mb-5">
                    <?php if ($table['is_available']): ?>
                        La table est actuellement <strong class="text-secondary">libre</strong>.
                        Vous pouvez la marquer comme occupée si besoin.
                    <?php else: ?>
                        La table est actuellement <strong class="text-tertiary">occupée</strong>.
                        Libérez-la une fois la session terminée.
                    <?php endif; ?>
                </p>

                <form action="/tables/<?= $table['id'] ?>/availability" method="POST">
                    <button type="submit"
                            class="w-full py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform
                                <?= $table['is_available']
                                    ? 'bg-tertiary-fixed text-tertiary hover:bg-tertiary hover:text-white'
                                    : 'bg-secondary-container text-secondary hover:bg-secondary hover:text-white' ?>">
                        <span class="material-symbols-outlined">
                            <?= $table['is_available'] ? 'lock' : 'lock_open' ?>
                        </span>
                        <?= $table['is_available'] ? 'Marquer comme Occupée' : 'Marquer comme Disponible' ?>
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 p-6">
                <h3 class="font-headline font-bold text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">bolt</span>
                    Actions Rapides
                </h3>

                <div class="space-y-3">

                    <?php if ($table['is_available']): ?>
                        <a href="/sessions/start?table_id=<?= $table['id'] ?>"
                           class="w-full py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform shadow-md shadow-primary/20">
                            <span class="material-symbols-outlined">play_circle</span>
                            Démarrer une Session
                        </a>
                    <?php endif; ?>

                    <a href="/reservations?table_id=<?= $table['id'] ?>"
                       class="w-full py-3 bg-surface-container text-on-surface rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">event</span>
                        Voir les Réservations
                    </a>

                    <a href="/sessions"
                       class="w-full py-3 bg-surface-container text-on-surface rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">history</span>
                        Voir les Sessions
                    </a>

                </div>
            </div>

        </div>
    </div>

    <!-- Visual Capacity Bar -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/10 p-6">
        <h3 class="font-headline font-bold text-on-surface mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-lg">people</span>
            Capacité d'Accueil
        </h3>

        <div class="flex items-center gap-4 mb-3">
            <span class="font-headline text-4xl font-black text-primary">
                <?= $table['capacity'] ?>
            </span>
            <span class="text-on-surface-variant text-sm">
                personnes maximum
            </span>
        </div>

        <!-- Seat Icons -->
        <div class="flex flex-wrap gap-2">
            <?php for ($i = 1; $i <= $table['capacity']; $i++): ?>
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-sm font-bold
                            <?= $table['is_available']
                                ? 'bg-secondary-container text-on-secondary-container'
                                : 'bg-tertiary-fixed text-tertiary' ?>">
                    <span class="material-symbols-outlined text-sm"
                          style="font-variation-settings:'FILL' 1;">
                        person
                    </span>
                </div>
            <?php endfor; ?>
        </div>

        <p class="text-xs text-on-surface-variant mt-3">
            Table idéale pour des groupes de <?= $table['capacity'] <= 2 ? 'petite taille' : ($table['capacity'] <= 4 ? 'taille moyenne' : 'grande taille') ?>.
        </p>
    </div>

</main>

<!-- Mobile Nav -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav  = [
        ['uri' => '/dashboard', 'icon' => 'dashboard',       'label' => 'Dashboard'],
        ['uri' => '/games',     'icon' => 'casino',            'label' => 'Games'],
        ['uri' => '/tables',    'icon' => 'table_restaurant',  'label' => 'Tables'],
        ['uri' => '/sessions',  'icon' => 'style',             'label' => 'Sessions'],
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