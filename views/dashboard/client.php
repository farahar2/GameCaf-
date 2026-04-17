<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Client Sidebar -->
<aside class="hidden md:flex flex-col fixed left-0 top-0 w-72 h-full rounded-r-3xl bg-[#fff8f6] pt-8 pb-12 z-40">
    <div class="px-8 mb-10">
        <a href="/" class="text-[#8d4b00] font-black text-2xl font-headline">🎲 Aji L3bo</a>
    </div>
    <div class="flex-1">
        <?php
        $clientNav  = [
            ['uri' => '/dashboard/client',    'icon' => 'dashboard',  'label' => 'Mon Dashboard'],
            ['uri' => '/games',               'icon' => 'casino',      'label' => 'Catalogue'],
            ['uri' => '/reservations/create', 'icon' => 'event',       'label' => 'Réserver'],
            ['uri' => '/reservations/my',     'icon' => 'style',       'label' => 'Mes Réservations'],
        ];
        $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
        foreach ($clientNav as $item):
            $isActive = str_starts_with($currentUri, $item['uri'])
                        && !($item['uri'] === '/' && $currentUri !== '/');
        ?>
            <a href="<?= $item['uri'] ?>"
               class="flex items-center gap-4 px-6 py-4 mx-2 rounded-xl transition-all
                      <?= $isActive
                          ? 'bg-[#1b6b51] text-white translate-x-1 shadow-md'
                          : 'text-stone-600 hover:bg-stone-100' ?>">
                <span class="material-symbols-outlined"
                      style="<?= $isActive ? "font-variation-settings:'FILL' 1;" : '' ?>">
                    <?= $item['icon'] ?>
                </span>
                <span class="font-headline font-medium"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- User Profile -->
    <div class="px-6 py-4 mx-2 flex items-center gap-4 mt-auto border-t border-surface-container">
        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center font-headline font-bold text-on-primary-fixed text-lg">
            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
        </div>
        <div>
            <p class="font-headline font-bold text-on-surface">
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Client') ?>
            </p>
            <p class="text-xs text-on-surface-variant">Client</p>
        </div>
        <a href="/logout"
           class="material-symbols-outlined ml-auto text-stone-400 hover:text-error transition-colors">
            logout
        </a>
    </div>
</aside>

<main class="md:ml-72 min-h-screen pb-32 px-6">

    <!-- Header -->
    <section class="pt-8 pb-6">
        <p class="text-secondary font-headline font-bold text-sm tracking-widest mb-2">
            TABLEAU DE BORD
        </p>
        <h1 class="font-headline text-4xl font-extrabold text-on-background leading-none mb-1">
            Bonjour, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Client')[0]) ?>! 👋
        </h1>
        <p class="text-on-surface-variant">
            <?= date('l d F Y') ?>
        </p>
    </section>

    <!-- Quick Action Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">

        <!-- Upcoming Reservations -->
        <?php
        $upcoming  = array_filter(
            $myReservations,
            fn($r) => in_array($r['status'], ['pending', 'confirmed'])
        );
        $completed = array_filter(
            $myReservations,
            fn($r) => $r['status'] === 'completed'
        );
        ?>

        <div class="bg-primary text-on-primary p-5 rounded-xl shadow-md shadow-primary/20">
            <span class="material-symbols-outlined mb-2 block" style="font-variation-settings:'FILL' 1;">event</span>
            <h3 class="text-2xl font-bold font-headline"><?= count($upcoming) ?></h3>
            <p class="text-on-primary/80 text-xs font-medium mt-1">Réservations à venir</p>
        </div>

        <div class="bg-secondary-container p-5 rounded-xl">
            <span class="material-symbols-outlined text-secondary mb-2 block" style="font-variation-settings:'FILL' 1;">check_circle</span>
            <h3 class="text-2xl font-bold font-headline"><?= count($completed) ?></h3>
            <p class="text-on-secondary-container text-xs font-medium mt-1">Sessions complétées</p>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
            <span class="material-symbols-outlined text-primary mb-2 block">casino</span>
            <h3 class="text-2xl font-bold font-headline"><?= $totalGames ?></h3>
            <p class="text-on-surface-variant text-xs font-medium mt-1">Jeux disponibles</p>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
            <span class="material-symbols-outlined text-secondary mb-2 block">chair</span>
            <h3 class="text-2xl font-bold font-headline"><?= count($availableTables) ?></h3>
            <p class="text-on-surface-variant text-xs font-medium mt-1">Tables libres</p>
        </div>

    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ===== Left: Upcoming Reservations ===== -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Upcoming Reservations -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-headline text-xl font-bold text-on-surface">
                        Prochaines Réservations
                    </h3>
                    <a href="/reservations/my"
                       class="text-sm text-primary font-bold hover:underline">
                        Voir tout →
                    </a>
                </div>

                <?php if (empty($upcoming)): ?>

                    <div class="bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl p-10 flex flex-col items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-surface-container-highest flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-primary text-3xl">event_busy</span>
                        </div>
                        <h4 class="font-headline font-bold text-lg mb-2">Aucune réservation</h4>
                        <p class="text-sm text-on-surface-variant mb-6">
                            Réservez votre table maintenant!
                        </p>
                        <a href="/reservations/create"
                           class="bg-primary text-on-primary px-8 py-3 rounded-full font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                            Réserver maintenant
                        </a>
                    </div>

                <?php else: ?>

                    <div class="space-y-4">
                        <?php foreach (array_slice(array_values($upcoming), 0, 3) as $res):

                            $statusConfig = [
                                'pending'   => [
                                    'bg'    => 'bg-[#ffdbcc] text-[#8d4b00]',
                                    'icon'  => 'hourglass_empty',
                                    'label' => 'EN ATTENTE',
                                ],
                                'confirmed' => [
                                    'bg'    => 'bg-secondary-fixed text-on-secondary-fixed',
                                    'icon'  => 'event_available',
                                    'label' => 'CONFIRMÉ',
                                ],
                            ];
                            $badge = $statusConfig[$res['status']] ?? $statusConfig['pending'];

                            $day   = date('d', strtotime($res['reservation_date']));
                            $month = strtoupper(date('M', strtotime($res['reservation_date'])));
                        ?>

                            <div class="relative bg-surface-container-lowest rounded-xl p-5 shadow-sm overflow-hidden hover:scale-[1.01] transition-transform group">

                                <!-- Date accent -->
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary rounded-l-xl"></div>

                                <div class="flex gap-4 items-center">

                                    <!-- Date Block -->
                                    <div class="text-center bg-primary-fixed rounded-lg p-3 flex-shrink-0 w-16">
                                        <p class="font-headline font-black text-2xl text-primary leading-none">
                                            <?= $day ?>
                                        </p>
                                        <p class="text-xs font-bold text-on-surface-variant mt-0.5">
                                            <?= $month ?>
                                        </p>
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="<?= $badge['bg'] ?> px-2 py-0.5 rounded-full text-[10px] font-bold uppercase flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[12px]"><?= $badge['icon'] ?></span>
                                                <?= $badge['label'] ?>
                                            </span>
                                        </div>
                                        <h4 class="font-headline font-bold text-on-surface">
                                            <?= !empty($res['game_name'])
                                                ? htmlspecialchars($res['game_name'])
                                                : 'Pas de jeu choisi' ?>
                                        </h4>
                                        <div class="flex gap-3 text-xs text-on-surface-variant mt-1">
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">chair</span>
                                                Table <?= $res['table_number'] ?>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">group</span>
                                                <?= $res['number_of_guests'] ?> pers.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Cancel -->
                                    <form action="/reservations/<?= $res['id'] ?>/status"
                                          method="POST"
                                          onsubmit="return confirm('Annuler cette réservation?')"
                                          class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <input type="hidden" name="status" value="cancelled"/>
                                        <button type="submit"
                                                class="p-2 bg-error-container text-on-error-container rounded-lg hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                        </button>
                                    </form>

                                </div>
                            </div>

                        <?php endforeach; ?>

                        <!-- New Reservation CTA -->
                        <a href="/reservations/create"
                           class="block bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl p-5 text-center hover:border-primary/30 transition-colors group">
                            <span class="material-symbols-outlined text-primary text-2xl mb-1 block group-hover:scale-110 transition-transform">add_circle</span>
                            <p class="font-headline font-bold text-sm text-on-surface">
                                Ajouter une réservation
                            </p>
                        </a>

                    </div>

                <?php endif; ?>
            </div>

            <!-- Suggested Games -->
            <?php if (!empty($suggestedGames)): ?>
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-headline text-xl font-bold text-on-surface">
                            Jeux Recommandés
                        </h3>
                        <a href="/games" class="text-sm text-primary font-bold hover:underline">
                            Voir tout →
                        </a>
                    </div>
                    <div class="flex gap-4 overflow-x-auto pb-3">
                        <?php foreach ($suggestedGames as $game): ?>
                            <a href="/games/<?= $game['id'] ?>"
                               class="min-w-[220px] bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:-translate-y-1 transition-all group">
                                <div class="h-28 relative">
                                    <img src="<?= htmlspecialchars($game['image_url'] ?? 'https://placehold.co/300x150/ffdcc3/8d4b00?text=' . urlencode($game['name'])) ?>"
                                         alt="<?= htmlspecialchars($game['name']) ?>"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    <span class="absolute bottom-2 left-3 bg-secondary-fixed text-on-secondary-fixed text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                        <?= htmlspecialchars($game['category_name'] ?? 'Jeu') ?>
                                    </span>
                                    <?php if (!$game['is_available']): ?>
                                        <span class="absolute top-2 right-2 bg-black/50 text-white text-[10px] font-bold px-2 py-0.5 rounded">
                                            Occupé
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="p-3">
                                    <h4 class="font-headline font-bold text-sm truncate">
                                        <?= htmlspecialchars($game['name']) ?>
                                    </h4>
                                    <p class="text-xs text-on-surface-variant mt-0.5">
                                        👥 <?= $game['min_players'] ?>-<?= $game['max_players'] ?>
                                        • ⏱️ <?= $game['duration'] ?>min
                                    </p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- ===== Right: Quick Actions ===== -->
        <div class="space-y-6">

            <!-- Quick Book Card -->
            <div class="bg-[#1b6b51] p-6 rounded-xl text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-headline font-bold text-lg mb-1">
                        Réserver Maintenant
                    </h4>
                    <p class="text-emerald-100 text-sm mb-4">
                        <?= count($availableTables) ?> table<?= count($availableTables) > 1 ? 's' : '' ?> disponible<?= count($availableTables) > 1 ? 's' : '' ?> maintenant
                    </p>
                    <a href="/reservations/create"
                       class="inline-block bg-white text-[#1b6b51] font-bold px-6 py-2 rounded-xl text-sm hover:scale-105 transition-transform">
                        Réserver →
                    </a>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute top-2 right-4 text-4xl opacity-20">🎲</div>
            </div>

            <!-- Available Tables -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                <h4 class="font-headline font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">chair</span>
                    Tables Disponibles
                </h4>
                <?php if (empty($availableTables)): ?>
                    <p class="text-sm text-on-surface-variant text-center py-4">
                        Toutes les tables sont occupées
                    </p>
                <?php else: ?>
                    <div class="grid grid-cols-3 gap-2">
                        <?php foreach (array_slice($availableTables, 0, 6) as $table): ?>
                            <div class="text-center p-3 bg-secondary-container rounded-lg">
                                <p class="font-headline font-bold text-secondary">
                                    T<?= sprintf('%02d', $table['table_number']) ?>
                                </p>
                                <p class="text-[10px] text-on-secondary-container">
                                    <?= $table['capacity'] ?> pl.
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($availableTables) > 6): ?>
                        <p class="text-xs text-on-surface-variant text-center mt-3">
                            +<?= count($availableTables) - 6 ?> autres tables disponibles
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Profile Summary -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full bg-primary-fixed flex items-center justify-center font-headline font-bold text-on-primary-fixed text-xl">
                        <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div>
                        <h4 class="font-headline font-bold">
                            <?= htmlspecialchars($_SESSION['user_name'] ?? 'Client') ?>
                        </h4>
                        <p class="text-xs text-on-surface-variant">
                            <?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>
                        </p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Total réservations</span>
                        <span class="font-bold"><?= count($myReservations) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">À venir</span>
                        <span class="font-bold text-primary"><?= count($upcoming) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Complétées</span>
                        <span class="font-bold text-secondary"><?= count($completed) ?></span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</main>

<!-- Mobile Nav -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav  = [
        ['uri' => '/dashboard/client',    'icon' => 'dashboard',  'label' => 'Home'],
        ['uri' => '/games',               'icon' => 'grid_view',   'label' => 'Catalog'],
        ['uri' => '/reservations/create', 'icon' => 'event',       'label' => 'Book'],
        ['uri' => '/reservations/my',     'icon' => 'person',      'label' => 'Mes Rés.'],
    ];
    $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
    foreach ($mobileNav as $item):
        $isActive = str_starts_with($currentUri, $item['uri'])
                    && !($item['uri'] === '/' && $currentUri !== '/');
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