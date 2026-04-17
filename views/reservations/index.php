<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 min-h-screen pb-24 px-6 pt-6 md:pt-12">

    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
                ADMIN
            </span>
            <h1 class="font-headline text-4xl font-bold tracking-tight text-primary">
                Toutes les Réservations
            </h1>
        </div>
        <a href="/reservations/dashboard"
           class="flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform shadow-md shadow-primary/20 w-fit">
            <span class="material-symbols-outlined">today</span>
            Réservations du Jour
        </a>
    </div>

    <!-- Filter Tabs by Status -->
    <?php
    $currentFilter = $_GET['status'] ?? 'all';
    $filterTabs    = [
        'all'       => 'Toutes',
        'pending'   => 'En attente',
        'confirmed' => 'Confirmées',
        'completed' => 'Complétées',
        'cancelled' => 'Annulées',
    ];
    ?>
    <nav class="flex gap-2 p-1.5 bg-surface-container-low rounded-2xl mb-8 overflow-x-auto">
        <?php foreach ($filterTabs as $key => $label):
            $isActive = $currentFilter === $key;
            $count    = ($key === 'all')
                ? count($reservations)
                : count(array_filter($reservations, fn($r) => $r['status'] === $key));
        ?>
            <a href="/reservations?status=<?= $key ?>"
               class="whitespace-nowrap px-5 py-3 rounded-xl font-headline font-bold text-sm transition-all
                      <?= $isActive
                          ? 'bg-primary text-on-primary shadow-sm'
                          : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                <?= $label ?>
                <?php if ($count > 0): ?>
                    <span class="ml-1 text-xs opacity-70">(<?= $count ?>)</span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Filter Reservations -->
    <?php
    $filtered = ($currentFilter === 'all')
        ? $reservations
        : array_filter($reservations, fn($r) => $r['status'] === $currentFilter);
    ?>

    <?php if (empty($filtered)): ?>

        <div class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-16 rounded-xl text-center">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">
                event_busy
            </span>
            <h3 class="font-headline text-xl font-bold text-on-surface-variant mb-2">
                Aucune réservation trouvée
            </h3>
        </div>

    <?php else: ?>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">

            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-surface-container-low border-b border-outline-variant/10">
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">#</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Client</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Date & Heure</div>
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Table</div>
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pers.</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Jeu</div>
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Statut</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-right">Actions</div>
            </div>

            <div class="divide-y divide-outline-variant/10">
                <?php foreach ($filtered as $res):
                    $statusBadges = [
                        'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                        'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                        'completed' => 'bg-secondary-container text-on-secondary-container',
                        'cancelled' => 'bg-error-container text-on-error-container',
                    ];
                    $badge = $statusBadges[$res['status']] ?? $statusBadges['pending'];
                ?>
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-surface-container-low transition-colors items-center">

                        <div class="col-span-1">
                            <span class="text-xs text-on-surface-variant font-mono">#<?= $res['id'] ?></span>
                        </div>

                        <div class="col-span-2">
                            <p class="text-sm font-bold truncate">
                                <?= htmlspecialchars($res['client_name']) ?>
                            </p>
                            <p class="text-xs text-on-surface-variant">
                                <?= htmlspecialchars($res['client_phone'] ?? '') ?>
                            </p>
                        </div>

                        <div class="col-span-2">
                            <p class="text-sm font-bold">
                                <?= date('d/m/Y', strtotime($res['reservation_date'])) ?>
                            </p>
                            <p class="text-xs text-on-surface-variant">
                                <?= date('H:i', strtotime($res['reservation_time'])) ?>
                            </p>
                        </div>

                        <div class="col-span-1">
                            <span class="text-sm font-bold">T<?= sprintf('%02d', $res['table_number']) ?></span>
                        </div>

                        <div class="col-span-1">
                            <span class="text-sm"><?= $res['number_of_guests'] ?></span>
                        </div>

                        <div class="col-span-2">
                            <span class="text-sm text-on-surface-variant truncate block">
                                <?= !empty($res['game_name']) ? htmlspecialchars($res['game_name']) : '—' ?>
                            </span>
                        </div>

                        <div class="col-span-1">
                            <span class="<?= $badge ?> px-2 py-1 rounded-full text-[10px] font-bold uppercase whitespace-nowrap">
                                <?= ucfirst($res['status']) ?>
                            </span>
                        </div>

                        <div class="col-span-2 flex justify-end gap-1">
                            <?php if ($res['status'] === 'pending'): ?>
                                <form action="/reservations/<?= $res['id'] ?>/status" method="POST">
                                    <input type="hidden" name="status" value="confirmed"/>
                                    <button type="submit"
                                            title="Confirmer"
                                            class="w-8 h-8 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">check</span>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                                <form action="/reservations/<?= $res['id'] ?>/status" method="POST">
                                    <input type="hidden" name="status" value="cancelled"/>
                                    <button type="submit"
                                            title="Annuler"
                                            class="w-8 h-8 rounded-full bg-error-container text-on-error-container flex items-center justify-center hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </form>
                            <?php endif; ?>

                            <a href="/reservations/<?= $res['id'] ?>"
                               class="w-8 h-8 rounded-full bg-surface-container text-on-surface flex items-center justify-center hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            <?php foreach ($filtered as $res):
                $statusBadges = [
                    'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                    'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                    'completed' => 'bg-secondary-container text-on-secondary-container',
                    'cancelled' => 'bg-error-container text-on-error-container',
                ];
                $badge = $statusBadges[$res['status']] ?? $statusBadges['pending'];
            ?>
                <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="font-bold"><?= htmlspecialchars($res['client_name']) ?></p>
                            <p class="text-xs text-on-surface-variant">
                                <?= date('d/m/Y', strtotime($res['reservation_date'])) ?>
                                à <?= date('H:i', strtotime($res['reservation_time'])) ?>
                            </p>
                        </div>
                        <span class="<?= $badge ?> px-2 py-1 rounded-full text-[10px] font-bold uppercase">
                            <?= ucfirst($res['status']) ?>
                        </span>
                    </div>
                    <div class="flex gap-4 text-xs text-on-surface-variant mb-3">
                        <span>🪑 T<?= $res['table_number'] ?></span>
                        <span>👥 <?= $res['number_of_guests'] ?> pers.</span>
                        <?php if (!empty($res['game_name'])): ?>
                            <span>🎲 <?= htmlspecialchars($res['game_name']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-2">
                        <?php if ($res['status'] === 'pending'): ?>
                            <form action="/reservations/<?= $res['id'] ?>/status" method="POST" class="flex-1">
                                <input type="hidden" name="status" value="confirmed"/>
                                <button type="submit" class="w-full py-2 bg-secondary-fixed text-on-secondary-fixed rounded-lg text-xs font-bold">
                                    ✓ Confirmer
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                            <form action="/reservations/<?= $res['id'] ?>/status" method="POST" class="flex-1">
                                <input type="hidden" name="status" value="cancelled"/>
                                <button type="submit" class="w-full py-2 bg-error-container text-on-error-container rounded-lg text-xs font-bold">
                                    ✕ Annuler
                                </button>
                            </form>
                        <?php endif; ?>
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
        ['uri' => '/dashboard',    'icon' => 'dashboard', 'label' => 'Dashboard'],
        ['uri' => '/games',        'icon' => 'casino',     'label' => 'Games'],
        ['uri' => '/sessions',     'icon' => 'style',      'label' => 'Sessions'],
        ['uri' => '/reservations', 'icon' => 'event',      'label' => 'Bookings'],
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>