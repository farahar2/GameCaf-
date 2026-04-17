<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 min-h-screen pb-24 md:pb-12 px-6 pt-6 md:pt-12 zellige-pattern">

    <!-- Page Header -->
    <header class="mb-10">
        <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
            ADMIN PANEL
        </span>
        <h2 class="font-headline text-4xl font-bold tracking-tight text-primary">
            Dashboard
        </h2>
        <p class="text-on-surface-variant">
            Bienvenue, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
            — <?= date('l d F Y') ?>
        </p>
    </header>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">

        <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
            <span class="material-symbols-outlined text-primary mb-3 block">category</span>
            <p class="text-on-surface-variant text-sm font-medium">Total Jeux</p>
            <h3 class="text-2xl font-bold font-headline mt-1"><?= $totalGames ?></h3>
            <a href="games" class="text-xs text-primary font-medium mt-2 block hover:underline">
                Gérer →
            </a>
        </div>

        <div class="bg-secondary-container p-6 rounded-lg shadow-sm">
            <span class="material-symbols-outlined text-secondary mb-3 block">grid_view</span>
            <p class="text-on-secondary-container text-sm font-medium">Tables Libres</p>
            <h3 class="text-2xl font-bold font-headline mt-1">
                <?= count($availableTables) ?>
                <span class="text-sm font-normal">/ <?= count($allTables) ?></span>
            </h3>
            <a href="tables" class="text-xs text-secondary font-medium mt-2 block hover:underline">
                Voir tables →
            </a>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
            <span class="material-symbols-outlined text-tertiary mb-3 block">calendar_today</span>
            <p class="text-on-surface-variant text-sm font-medium">Réservations Jour</p>
            <h3 class="text-2xl font-bold font-headline mt-1">
                <?= count($todayReservations) ?>
            </h3>
            <a href="reservations/dashboard" class="text-xs text-primary font-medium mt-2 block hover:underline">
                Voir planning →
            </a>
        </div>

        <div class="bg-primary-container p-6 rounded-lg shadow-sm">
            <span class="material-symbols-outlined text-on-primary-container mb-3 block">play_circle</span>
            <p class="text-on-primary-container/80 text-sm font-medium">Sessions Actives</p>
            <h3 class="text-2xl font-bold font-headline mt-1 text-on-primary-container">
                <?= $activeCount ?>
            </h3>
            <a href="sessions" class="text-xs text-on-primary-container/80 font-medium mt-2 block hover:underline">
                Floor status →
            </a>
        </div>

    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

        <!-- ===== Left: Active Sessions ===== -->
        <div class="xl:col-span-2 space-y-8">

            <!-- Active Sessions -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-headline text-xl font-bold text-on-surface">
                        Sessions en Cours
                        <?php if ($activeCount > 0): ?>
                            <span class="ml-2 bg-primary text-on-primary text-xs px-2 py-0.5 rounded-full">
                                <?= $activeCount ?>
                            </span>
                        <?php endif; ?>
                    </h3>
                    <a href="sessions/start"
                       class="bg-primary text-on-primary px-4 py-2 rounded-full text-sm font-medium flex items-center gap-1 hover:scale-105 transition-transform shadow-md shadow-primary/20">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        New Session
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <?php if (empty($activeSessions)): ?>
                        <div class="md:col-span-2 bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-10 rounded-lg text-center">
                            <span class="material-symbols-outlined text-5xl text-on-surface-variant/20 mb-3 block">
                                sports_esports
                            </span>
                            <p class="font-headline font-bold text-on-surface-variant">
                                Aucune session active
                            </p>
                            <p class="text-sm text-on-surface-variant mt-1">
                                Toutes les tables sont libres!
                            </p>
                        </div>
                    <?php else: ?>

                        <?php foreach ($activeSessions as $session):
                            $elapsed  = (int) ($session['elapsed_seconds'] ?? 0);
                            $h        = floor($elapsed / 3600);
                            $m        = floor(($elapsed % 3600) / 60);
                            $s        = $elapsed % 60;
                            $timer    = sprintf('%02d:%02d:%02d', $h, $m, $s);

                            $name     = $session['client_name'] ?? 'Walk-in';
                            $parts    = explode(' ', $name);
                            $initials = strtoupper(substr($parts[0], 0, 1));
                            if (isset($parts[1])) {
                                $initials .= strtoupper(substr($parts[1], 0, 1));
                            }

                            $expectedMin = (int) ($session['expected_duration'] ?? 60);
                            $elapsedMin  = floor($elapsed / 60);
                            $progress    = min(100, ($elapsedMin / max(1, $expectedMin)) * 100);
                            $barColor    = $progress < 60
                                ? 'bg-secondary'
                                : ($progress < 90 ? 'bg-primary' : 'bg-tertiary');
                        ?>
                            <div class="bg-surface-container-lowest p-5 rounded-lg border border-outline-variant/10 shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-20 h-20 -mr-6 -mt-6 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>

                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-0.5 block">
                                            Table <?= sprintf('%02d', $session['table_number']) ?>
                                        </span>
                                        <h4 class="font-headline font-bold text-on-surface">
                                            <?= htmlspecialchars($session['game_name']) ?>
                                        </h4>
                                    </div>
                                    <div class="bg-secondary-fixed text-on-secondary-fixed px-2 py-1 rounded-full text-[10px] font-bold flex items-center gap-1 flex-shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                                        LIVE
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-on-primary-fixed text-xs flex-shrink-0">
                                        <?= $initials ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium"><?= htmlspecialchars($name) ?></p>
                                        <p class="text-xs text-on-surface-variant">
                                            <?= $session['number_of_guests'] ?? '?' ?> joueurs
                                        </p>
                                    </div>
                                </div>

                                <!-- Progress -->
                                <div class="mb-3">
                                    <div class="w-full h-1 bg-surface-container rounded-full overflow-hidden">
                                        <div class="h-full <?= $barColor ?> rounded-full"
                                             style="width: <?= $progress ?>%"></div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-3 border-t border-outline-variant/10">
                                    <p class="font-headline font-bold text-primary text-lg session-timer"
                                       data-start="<?= $session['start_time'] ?>">
                                        <?= $timer ?>
                                    </p>
                                    <form action="sessions/<?= $session['id'] ?>/end"
                                          method="POST"
                                          onsubmit="return confirm('Terminer?')">
                                        <button type="submit"
                                                class="bg-tertiary-container text-on-tertiary-container px-3 py-1.5 rounded-lg text-xs font-bold hover:scale-105 transition-transform">
                                            Terminer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>

                    <!-- Open Session Placeholder -->
                    <?php if (!empty($availableTables)): ?>
                        <a href="sessions/start"
                           class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-6 rounded-lg flex flex-col items-center justify-center text-on-surface-variant opacity-60 hover:opacity-100 transition-all cursor-pointer min-h-[160px]">
                            <span class="material-symbols-outlined text-3xl mb-2">add_circle</span>
                            <p class="font-headline font-bold text-sm">Ouvrir Session</p>
                            <p class="text-xs mt-1">
                                <?= count($availableTables) ?> table<?= count($availableTables) > 1 ? 's' : '' ?> libre<?= count($availableTables) > 1 ? 's' : '' ?>
                            </p>
                        </a>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Today's Reservations Table -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-headline text-xl font-bold text-on-surface">
                        Réservations du Jour
                    </h3>
                    <a href="reservations/dashboard"
                       class="text-sm text-primary font-bold hover:underline flex items-center gap-1">
                        Voir tout
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <?php if (empty($todayReservations)): ?>
                    <div class="bg-surface-container-low p-8 rounded-lg text-center">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 mb-2 block">
                            event_busy
                        </span>
                        <p class="text-on-surface-variant text-sm">
                            Aucune réservation aujourd'hui
                        </p>
                    </div>
                <?php else: ?>
                    <div class="bg-surface-container-lowest rounded-lg border border-outline-variant/10 overflow-hidden">

                        <!-- Header -->
                        <div class="grid grid-cols-12 gap-3 px-5 py-3 bg-surface-container-low border-b border-outline-variant/10">
                            <div class="col-span-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Client</div>
                            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Heure</div>
                            <div class="col-span-1 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Table</div>
                            <div class="col-span-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Statut</div>
                            <div class="col-span-4 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-right">Actions</div>
                        </div>

                        <!-- Rows -->
                        <?php
                        $statusBadges = [
                            'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                            'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                            'completed' => 'bg-secondary-container text-on-secondary-container',
                            'cancelled' => 'bg-error-container text-on-error-container',
                        ];
                        $shown = array_slice($todayReservations, 0, 6);
                        foreach ($shown as $res):
                            $badge = $statusBadges[$res['status']] ?? $statusBadges['pending'];
                            $rParts = explode(' ', $res['client_name'] ?? 'U N');
                            $rInit  = strtoupper(substr($rParts[0], 0, 1));
                            if (isset($rParts[1])) $rInit .= strtoupper(substr($rParts[1], 0, 1));
                        ?>
                            <div class="grid grid-cols-12 gap-3 px-5 py-3 border-b border-outline-variant/10 last:border-0 hover:bg-surface-container-low transition-colors items-center group">

                                <div class="col-span-3 flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed text-[10px] font-bold flex-shrink-0">
                                        <?= $rInit ?>
                                    </div>
                                    <span class="text-sm font-medium truncate">
                                        <?= htmlspecialchars($res['client_name']) ?>
                                    </span>
                                </div>

                                <div class="col-span-2">
                                    <span class="text-sm font-bold">
                                        <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                    </span>
                                </div>

                                <div class="col-span-1">
                                    <span class="text-sm font-bold">
                                        T<?= sprintf('%02d', $res['table_number']) ?>
                                    </span>
                                </div>

                                <div class="col-span-2">
                                    <span class="<?= $badge ?> px-2 py-0.5 rounded-full text-[10px] font-bold uppercase whitespace-nowrap">
                                        <?= ucfirst($res['status']) ?>
                                    </span>
                                </div>

                                <div class="col-span-4 flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <?php if ($res['status'] === 'pending'): ?>
                                        <form action="reservations/<?= $res['id'] ?>/status" method="POST">
                                            <input type="hidden" name="status" value="confirmed"/>
                                            <button type="submit"
                                                    class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center hover:scale-110 transition-transform"
                                                    title="Confirmer">
                                                <span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1;">check</span>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                                        <form action="reservations/<?= $res['id'] ?>/status" method="POST">
                                            <input type="hidden" name="status" value="cancelled"/>
                                            <button type="submit"
                                                    class="w-7 h-7 rounded-full bg-error-container text-on-error-container flex items-center justify-center hover:scale-110 transition-transform"
                                                    title="Annuler">
                                                <span class="material-symbols-outlined text-xs">close</span>
                                            </button>
                                        </form>
                                        <?php if ($res['status'] === 'confirmed'): ?>
                                            <a href="sessions/start?reservation_id=<?= $res['id'] ?>"
                                               class="w-7 h-7 rounded-full bg-primary text-on-primary flex items-center justify-center hover:scale-110 transition-transform"
                                               title="Démarrer session">
                                                <span class="material-symbols-outlined text-xs">play_arrow</span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>

                        <?php if (count($todayReservations) > 6): ?>
                            <a href="reservations/dashboard"
                               class="block text-center py-3 text-sm font-bold text-primary hover:bg-surface-container-low transition-colors">
                                + <?= count($todayReservations) - 6 ?> autres
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- ===== Right Column ===== -->
        <div class="space-y-6">

            <!-- Quick Stats Card -->
            <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant/10">
                <h4 class="font-headline font-bold mb-5 text-on-surface">
                    Statistiques Rapides
                </h4>
                <div class="space-y-4">
                    <?php
                    $quickStats = [
                        [
                            'label' => 'Jeux disponibles',
                            'value' => $availableGames,
                            'color' => 'text-secondary',
                            'icon'  => 'casino',
                        ],
                        [
                            'label' => 'En attente',
                            'value' => $pendingCount,
                            'color' => 'text-[#8d4b00]',
                            'icon'  => 'hourglass_empty',
                        ],
                        [
                            'label' => 'Confirmées',
                            'value' => $confirmedCount,
                            'color' => 'text-secondary',
                            'icon'  => 'event_available',
                        ],
                        [
                            'label' => 'Sessions actives',
                            'value' => $activeCount,
                            'color' => 'text-primary',
                            'icon'  => 'play_circle',
                        ],
                    ];
                    foreach ($quickStats as $stat):
                    ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm <?= $stat['color'] ?>">
                                    <?= $stat['icon'] ?>
                                </span>
                                <span class="text-sm text-on-surface-variant">
                                    <?= $stat['label'] ?>
                                </span>
                            </div>
                            <span class="font-bold <?= $stat['color'] ?>">
                                <?= $stat['value'] ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pending Reservations -->
            <?php
            $pendingList = array_filter(
                $todayReservations,
                fn($r) => $r['status'] === 'pending'
            );
            $avatarBgs = ['bg-primary-fixed', 'bg-secondary-fixed', 'bg-tertiary-fixed'];
            ?>
            <?php if (!empty($pendingList)): ?>
                <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant/10">
                    <h4 class="font-headline font-bold mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#8d4b00] animate-pulse"></span>
                        En Attente de Confirmation
                        <span class="ml-auto bg-[#ffdbcc] text-[#8d4b00] text-xs px-2 py-0.5 rounded-full font-bold">
                            <?= count($pendingList) ?>
                        </span>
                    </h4>
                    <div class="space-y-3">
                        <?php foreach (array_values($pendingList) as $i => $res):
                            $pParts = explode(' ', $res['client_name'] ?? 'U N');
                            $pInit  = strtoupper(substr($pParts[0], 0, 1));
                            if (isset($pParts[1])) $pInit .= strtoupper(substr($pParts[1], 0, 1));
                            $avBg   = $avatarBgs[$i % count($avatarBgs)];
                        ?>
                            <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-surface-container-low transition-colors group">
                                <div class="w-9 h-9 rounded-lg <?= $avBg ?> flex items-center justify-center font-bold text-xs flex-shrink-0">
                                    <?= $pInit ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold truncate">
                                        <?= htmlspecialchars($res['client_name']) ?>
                                    </p>
                                    <p class="text-xs text-on-surface-variant">
                                        <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                        • <?= $res['number_of_guests'] ?> pers.
                                    </p>
                                </div>
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="reservations/<?= $res['id'] ?>/status" method="POST">
                                        <input type="hidden" name="status" value="confirmed"/>
                                        <button type="submit"
                                                class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1;">check</span>
                                        </button>
                                    </form>
                                    <form action="reservations/<?= $res['id'] ?>/status" method="POST">
                                        <input type="hidden" name="status" value="cancelled"/>
                                        <button type="submit"
                                                class="w-7 h-7 rounded-full bg-error-container text-on-error-container flex items-center justify-center hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-xs">close</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Game of the Night -->
            <?php if (!empty($activeSessions)): ?>
                <div class="bg-[#1b6b51] p-6 rounded-lg text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="font-headline font-bold mb-1">🎲 Game of the Night</h4>
                        <p class="text-emerald-100 text-xs mb-4">Most active right now!</p>
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-2xl">casino</span>
                            </div>
                            <div>
                                <p class="font-bold">
                                    <?= htmlspecialchars($activeSessions[0]['game_name']) ?>
                                </p>
                                <p class="text-[10px] text-emerald-200">
                                    <?= $activeCount ?> session<?= $activeCount > 1 ? 's' : '' ?> active<?= $activeCount > 1 ? 's' : '' ?>
                                </p>
                                <a href="sessions"
                                   class="mt-2 inline-block text-[10px] font-bold bg-white text-[#1b6b51] px-2 py-1 rounded">
                                    FLOOR STATUS
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-28 h-28 bg-white/10 rounded-full blur-2xl"></div>
                </div>
            <?php endif; ?>

        </div>

    </div>

</main>

<!-- Live Timer -->
<script>
    function updateTimers() {
        document.querySelectorAll('.session-timer').forEach(el => {
            const start   = new Date(el.dataset.start.replace(' ', 'T'));
            const elapsed = Math.floor((Date.now() - start) / 1000);
            const h = Math.floor(elapsed / 3600);
            const m = Math.floor((elapsed % 3600) / 60);
            const s = elapsed % 60;
            el.textContent =
                String(h).padStart(2, '0') + ':' +
                String(m).padStart(2, '0') + ':' +
                String(s).padStart(2, '0');
        });
    }
    setInterval(updateTimers, 1000);
    updateTimers();
</script>

<!-- Mobile Nav -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav  = [
        ['uri' => 'dashboard',    'icon' => 'dashboard', 'label' => 'Dashboard'],
        ['uri' => 'games',        'icon' => 'casino',     'label' => 'Games'],
        ['uri' => 'sessions',     'icon' => 'style',      'label' => 'Sessions'],
        ['uri' => 'reservations', 'icon' => 'event',      'label' => 'Bookings'],
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