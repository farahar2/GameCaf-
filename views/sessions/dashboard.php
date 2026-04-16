<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 min-h-screen pb-24 md:pb-12 px-6 pt-6 md:pt-12">

    <!-- Page Header -->
    <header class="mb-10">
        <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
            ADMIN
        </span>
        <h2 class="font-headline text-4xl font-bold tracking-tight text-primary">
            Sessions Actives
        </h2>
        <p class="text-on-surface-variant">Real-time gaming floor management</p>
    </header>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">

        <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
            <span class="material-symbols-outlined text-primary mb-3 block">category</span>
            <p class="text-on-surface-variant text-sm font-medium">Total Games</p>
            <h3 class="text-2xl font-bold font-headline mt-1">
                <?= $totalGames ?>
            </h3>
        </div>

        <div class="bg-secondary-container p-6 rounded-lg shadow-sm">
            <span class="material-symbols-outlined text-secondary mb-3 block">grid_view</span>
            <p class="text-on-secondary-container text-sm font-medium">Tables Libres</p>
            <h3 class="text-2xl font-bold font-headline mt-1">
                <?= count($availableTables) ?>
                <span class="text-sm font-normal">/ <?= count($allTables) ?></span>
            </h3>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">
            <span class="material-symbols-outlined text-tertiary mb-3 block">calendar_today</span>
            <p class="text-on-surface-variant text-sm font-medium">Réservations Aujourd'hui</p>
            <h3 class="text-2xl font-bold font-headline mt-1">
                <?= $reservationCount ?>
            </h3>
        </div>

        <div class="bg-primary-container p-6 rounded-lg shadow-sm">
            <span class="material-symbols-outlined text-on-primary-container mb-3 block">play_circle</span>
            <p class="text-on-primary-container/80 text-sm font-medium">Sessions Actives</p>
            <h3 class="text-2xl font-bold font-headline mt-1 text-on-primary-container">
                <?= $activeCount ?>
            </h3>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

        <!-- ===== Sessions Column ===== -->
        <div class="xl:col-span-2 space-y-6">

            <!-- Section Header -->
            <div class="flex items-center justify-between">
                <h3 class="font-headline text-xl font-bold text-on-surface">
                    Floor Status
                </h3>
                <div class="flex gap-2">
                    <a href="/sessions/history"
                       class="bg-surface-container-high px-4 py-2 rounded-full text-sm font-medium hover:bg-surface-variant transition-colors">
                        Historique
                    </a>
                    <a href="/sessions/start"
                       class="bg-primary text-on-primary px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 hover:scale-105 transition-transform shadow-md shadow-primary/20">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        New Session
                    </a>
                </div>
            </div>

            <!-- Sessions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <?php if (empty($activeSessions)): ?>

                    <!-- Empty State -->
                    <div class="md:col-span-2 bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-16 rounded-lg text-center">
                        <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">
                            sports_esports
                        </span>
                        <h4 class="font-headline text-xl font-bold text-on-surface-variant mb-2">
                            Aucune session en cours
                        </h4>
                        <p class="text-on-surface-variant text-sm mb-6">
                            Toutes les tables sont libres!
                        </p>
                        <a href="/sessions/start"
                           class="inline-block bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                            Démarrer une Session
                        </a>
                    </div>

                <?php else: ?>

                    <?php foreach ($activeSessions as $session):

                        // Calculate elapsed time
                        $elapsed  = (int) $session['elapsed_seconds'];
                        $hours    = floor($elapsed / 3600);
                        $minutes  = floor(($elapsed % 3600) / 60);
                        $seconds  = $elapsed % 60;
                        $timer    = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

                        // Progress bar
                        $expectedMin = (int) ($session['expected_duration'] ?? 60);
                        $elapsedMin  = floor($elapsed / 60);
                        $progress    = min(100, ($elapsedMin / max(1, $expectedMin)) * 100);

                        // Color based on progress
                        if ($progress < 60) {
                            $barColor = 'bg-secondary';
                        } elseif ($progress < 90) {
                            $barColor = 'bg-primary';
                        } else {
                            $barColor = 'bg-tertiary';
                        }

                        // Client initials
                        $name     = $session['client_name'] ?? 'Walk-in';
                        $parts    = explode(' ', $name);
                        $initials = strtoupper(substr($parts[0], 0, 1));
                        if (isset($parts[1])) {
                            $initials .= strtoupper(substr($parts[1], 0, 1));
                        }
                    ?>

                        <!-- Session Card -->
                        <div class="bg-surface-container-lowest p-6 rounded-lg border border-outline-variant/10 shadow-sm relative overflow-hidden">

                            <!-- Decorative Blur -->
                            <div class="absolute top-0 right-0 w-24 h-24 -mr-8 -mt-8 bg-secondary/10 rounded-full blur-2xl pointer-events-none"></div>

                            <!-- Header -->
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-1 block">
                                        Table <?= sprintf('%02d', $session['table_number']) ?>
                                    </span>
                                    <h4 class="font-headline text-lg font-bold text-on-surface">
                                        <?= htmlspecialchars($session['game_name']) ?>
                                    </h4>
                                </div>
                                <div class="bg-secondary-fixed text-on-secondary-fixed px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                                    IN PLAY
                                </div>
                            </div>

                            <!-- Client -->
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center font-headline font-bold text-on-primary-fixed text-sm flex-shrink-0">
                                    <?= $initials ?>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-on-surface">
                                        <?= htmlspecialchars($name) ?>
                                    </p>
                                    <p class="text-xs text-on-surface-variant">
                                        <?= $session['number_of_guests'] ?? '?' ?> Players
                                    </p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-on-surface-variant mb-1">
                                    <span>Progress</span>
                                    <span><?= $expectedMin ?> min expected</span>
                                </div>
                                <div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
                                    <div class="h-full <?= $barColor ?> rounded-full transition-all"
                                         style="width: <?= $progress ?>%">
                                    </div>
                                </div>
                            </div>

                            <!-- Timer + End Button -->
                            <div class="flex items-center justify-between pt-4 border-t border-outline-variant/10">
                                <div>
                                    <p class="text-xs text-on-surface-variant mb-1">Time Elapsed</p>
                                    <p class="font-headline font-bold text-primary text-xl session-timer"
                                       data-start="<?= $session['start_time'] ?>">
                                        <?= $timer ?>
                                    </p>
                                </div>
                                <form action="/sessions/<?= $session['id'] ?>/end"
                                      method="POST"
                                      onsubmit="return confirm('Terminer la session de <?= htmlspecialchars(addslashes($name)) ?>?')">
                                    <button type="submit"
                                            class="bg-tertiary-container text-on-tertiary-container px-4 py-2 rounded-lg text-sm font-bold hover:scale-105 transition-transform active:scale-95 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">stop_circle</span>
                                        Terminer
                                    </button>
                                </form>
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

                <!-- Add Session Placeholder -->
                <?php if (!empty($availableTables)): ?>
                    <a href="/sessions/start"
                       class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-6 rounded-lg flex flex-col items-center justify-center text-on-surface-variant opacity-70 hover:opacity-100 transition-all hover:border-primary/30 cursor-pointer min-h-[200px]">
                        <span class="material-symbols-outlined text-4xl mb-2">add_circle</span>
                        <p class="font-headline font-bold">Ouvrir Session</p>
                        <p class="text-xs mt-1">
                            <?php
                            $freeNumbers = array_map(
                                fn($t) => 'T' . $t['table_number'],
                                $availableTables
                            );
                            $shown = array_slice($freeNumbers, 0, 4);
                            echo implode(', ', $shown);
                            if (count($freeNumbers) > 4) {
                                echo ' +' . (count($freeNumbers) - 4) . ' more';
                            }
                            ?> free
                        </p>
                    </a>
                <?php endif; ?>

            </div>
        </div>

        <!-- ===== Reservations Sidebar ===== -->
        <div class="space-y-6">

            <h3 class="font-headline text-xl font-bold text-on-surface">
                Réservations du Jour
            </h3>

            <div class="bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10">

                <?php if (empty($todayReservations)): ?>
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 mb-2 block">
                            event_busy
                        </span>
                        <p class="text-on-surface-variant text-sm">
                            Aucune réservation aujourd'hui
                        </p>
                    </div>
                <?php else: ?>

                    <div class="flex flex-col gap-3">
                        <?php
                        $avatarBgs = [
                            'bg-primary-fixed',
                            'bg-secondary-fixed',
                            'bg-tertiary-fixed',
                        ];

                        $statusBadges = [
                            'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                            'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                            'completed' => 'bg-surface-container text-on-surface-variant',
                            'cancelled' => 'bg-error-container text-on-error-container',
                        ];

                        foreach ($todayReservations as $i => $res):
                            $rParts    = explode(' ', $res['client_name'] ?? 'U N');
                            $rInitials = strtoupper(substr($rParts[0], 0, 1));
                            if (isset($rParts[1])) {
                                $rInitials .= strtoupper(substr($rParts[1], 0, 1));
                            }
                            $avatarBg  = $avatarBgs[$i % count($avatarBgs)];
                            $badgeCss  = $statusBadges[$res['status']] ?? $statusBadges['pending'];
                        ?>

                            <div class="flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">

                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg <?= $avatarBg ?> flex items-center justify-center font-headline font-bold text-sm flex-shrink-0">
                                        <?= $rInitials ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-on-surface">
                                            <?= htmlspecialchars($res['client_name']) ?>
                                        </p>
                                        <p class="text-xs text-on-surface-variant">
                                            <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                            • <?= $res['number_of_guests'] ?> pers.
                                            <?php if (!empty($res['table_number'])): ?>
                                                • T<?= $res['table_number'] ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    <span class="<?= $badgeCss ?> px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">
                                        <?= ucfirst($res['status']) ?>
                                    </span>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <?php if ($res['status'] === 'pending'): ?>
                                            <form action="/reservations/<?= $res['id'] ?>/status" method="POST">
                                                <input type="hidden" name="status" value="confirmed"/>
                                                <button type="submit"
                                                        title="Confirmer"
                                                        class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center hover:scale-110 transition-transform">
                                                    <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">check</span>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                                            <form action="/reservations/<?= $res['id'] ?>/status" method="POST">
                                                <input type="hidden" name="status" value="cancelled"/>
                                                <button type="submit"
                                                        title="Annuler"
                                                        class="w-7 h-7 rounded-full bg-error-container text-on-error-container flex items-center justify-center hover:scale-110 transition-transform">
                                                    <span class="material-symbols-outlined text-xs">close</span>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>

                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>

                <a href="/reservations"
                   class="block w-full mt-6 py-3 bg-surface-container text-on-surface-variant text-sm font-bold rounded-xl hover:bg-surface-container-high transition-colors text-center">
                    Voir Tout le Planning
                </a>

            </div>

        </div>

    </div>

</main>

<!-- Live Timer Script -->
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
        ['uri' => '/dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
        ['uri' => '/games',     'icon' => 'casino',     'label' => 'Games'],
        ['uri' => '/sessions',  'icon' => 'style',      'label' => 'Sessions'],
        ['uri' => '/reservations', 'icon' => 'event',   'label' => 'Bookings'],
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