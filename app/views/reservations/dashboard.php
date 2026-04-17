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
                Réservations du Jour
            </h1>
            <p class="text-on-surface-variant mt-1">
                <?= date('l d F Y') ?>
            </p>
        </div>

        <!-- Stats Pills -->
        <div class="flex flex-wrap gap-3">
            <?php
            $statuses = [
                'pending'   => ['label' => 'En attente',  'bg' => 'bg-[#ffdbcc] text-[#8d4b00]'],
                'confirmed' => ['label' => 'Confirmées',  'bg' => 'bg-secondary-fixed text-on-secondary-fixed'],
                'completed' => ['label' => 'Complétées',  'bg' => 'bg-secondary-container text-on-secondary-container'],
                'cancelled' => ['label' => 'Annulées',    'bg' => 'bg-error-container text-on-error-container'],
            ];
            $counts = [];
            foreach ($statuses as $key => $_) {
                $counts[$key] = count(array_filter(
                    $reservations,
                    fn($r) => $r['status'] === $key
                ));
            }
            foreach ($statuses as $key => $cfg):
                if ($counts[$key] > 0):
            ?>
                <span class="<?= $cfg['bg'] ?> px-4 py-2 rounded-full text-sm font-bold">
                    <?= $counts[$key] ?> <?= $cfg['label'] ?>
                </span>
            <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>

    <!-- Empty State -->
    <?php if (empty($reservations)): ?>
        <div class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-16 rounded-xl text-center">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">
                event_busy
            </span>
            <h3 class="font-headline text-xl font-bold text-on-surface-variant mb-2">
                Aucune réservation aujourd'hui
            </h3>
            <p class="text-on-surface-variant text-sm">
                Les réservations du jour apparaîtront ici.
            </p>
        </div>

    <?php else: ?>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">

            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-surface-container-low border-b border-outline-variant/10">
                <div class="col-span-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Client</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Heure</div>
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Table</div>
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pers.</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Jeu</div>
                <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Statut</div>
                <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-right">Actions</div>
            </div>

            <!-- Table Rows -->
            <div class="divide-y divide-outline-variant/10">
                <?php foreach ($reservations as $res):

                    $statusBadges = [
                        'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                        'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                        'completed' => 'bg-secondary-container text-on-secondary-container',
                        'cancelled' => 'bg-error-container text-on-error-container',
                    ];
                    $badge = $statusBadges[$res['status']] ?? $statusBadges['pending'];

                    $parts    = explode(' ', $res['client_name'] ?? 'U N');
                    $initials = strtoupper(substr($parts[0], 0, 1));
                    if (isset($parts[1])) {
                        $initials .= strtoupper(substr($parts[1], 0, 1));
                    }
                ?>
                    <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-surface-container-low transition-colors items-center">

                        <!-- Client -->
                        <div class="col-span-3 flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-on-primary-fixed text-xs flex-shrink-0">
                                <?= $initials ?>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface">
                                    <?= htmlspecialchars($res['client_name']) ?>
                                </p>
                                <p class="text-xs text-on-surface-variant">
                                    <?= htmlspecialchars($res['client_phone'] ?? '') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Time -->
                        <div class="col-span-2">
                            <p class="text-sm font-bold">
                                <?= date('H:i', strtotime($res['reservation_time'])) ?>
                            </p>
                            <?php if (!empty($res['end_time'])): ?>
                                <p class="text-xs text-on-surface-variant">
                                    → <?= date('H:i', strtotime($res['end_time'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Table -->
                        <div class="col-span-1">
                            <span class="bg-surface-container px-2 py-1 rounded-lg text-sm font-bold">
                                T<?= sprintf('%02d', $res['table_number']) ?>
                            </span>
                        </div>

                        <!-- Guests -->
                        <div class="col-span-1">
                            <span class="text-sm font-medium">
                                <?= $res['number_of_guests'] ?>
                            </span>
                        </div>

                        <!-- Game -->
                        <div class="col-span-2">
                            <span class="text-sm text-on-surface-variant">
                                <?= !empty($res['game_name'])
                                    ? htmlspecialchars($res['game_name'])
                                    : '—' ?>
                            </span>
                        </div>

                        <!-- Status Badge -->
                        <div class="col-span-1">
                            <span class="<?= $badge ?> px-2 py-1 rounded-full text-[10px] font-bold uppercase whitespace-nowrap">
                                <?= ucfirst($res['status']) ?>
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="col-span-2 flex justify-end gap-2">
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

                                <?php if ($res['status'] === 'confirmed'): ?>
                                    <a href="/sessions/start?reservation_id=<?= $res['id'] ?>"
                                       title="Démarrer session"
                                       class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-sm">play_arrow</span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <a href="/reservations/<?= $res['id'] ?>"
                               title="Voir détails"
                               class="w-8 h-8 rounded-full bg-surface-container text-on-surface flex items-center justify-center hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            <?php foreach ($reservations as $res):
                $statusBadges = [
                    'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                    'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                    'completed' => 'bg-secondary-container text-on-secondary-container',
                    'cancelled' => 'bg-error-container text-on-error-container',
                ];
                $badge = $statusBadges[$res['status']] ?? $statusBadges['pending'];
            ?>
                <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10 shadow-sm">

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-on-surface">
                                <?= htmlspecialchars($res['client_name']) ?>
                            </h4>
                            <p class="text-xs text-on-surface-variant">
                                <?= htmlspecialchars($res['client_phone'] ?? '') ?>
                            </p>
                        </div>
                        <span class="<?= $badge ?> px-2 py-1 rounded-full text-[10px] font-bold uppercase">
                            <?= ucfirst($res['status']) ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 text-sm mb-4">
                        <div class="bg-surface-container-low p-2 rounded-lg text-center">
                            <p class="text-xs text-on-surface-variant">Heure</p>
                            <p class="font-bold"><?= date('H:i', strtotime($res['reservation_time'])) ?></p>
                        </div>
                        <div class="bg-surface-container-low p-2 rounded-lg text-center">
                            <p class="text-xs text-on-surface-variant">Table</p>
                            <p class="font-bold">T<?= sprintf('%02d', $res['table_number']) ?></p>
                        </div>
                        <div class="bg-surface-container-low p-2 rounded-lg text-center">
                            <p class="text-xs text-on-surface-variant">Pers.</p>
                            <p class="font-bold"><?= $res['number_of_guests'] ?></p>
                        </div>
                    </div>

                    <!-- Mobile Actions -->
                    <div class="flex gap-2">
                        <?php if ($res['status'] === 'pending'): ?>
                            <form action="/reservations/<?= $res['id'] ?>/status" method="POST" class="flex-1">
                                <input type="hidden" name="status" value="confirmed"/>
                                <button type="submit"
                                        class="w-full py-2 bg-secondary-fixed text-on-secondary-fixed rounded-lg text-sm font-bold">
                                    ✓ Confirmer
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                            <form action="/reservations/<?= $res['id'] ?>/status" method="POST" class="flex-1">
                                <input type="hidden" name="status" value="cancelled"/>
                                <button type="submit"
                                        class="w-full py-2 bg-error-container text-on-error-container rounded-lg text-sm font-bold">
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