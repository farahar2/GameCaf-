<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 min-h-screen pb-24 md:pb-12 px-6 pt-6 md:pt-12">

    <!-- Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
                HISTORIQUE
            </span>
            <h1 class="font-headline text-4xl font-bold tracking-tight text-primary">
                Sessions Passées
            </h1>
            <p class="text-on-surface-variant mt-1">
                Toutes les sessions terminées et annulées
            </p>
        </div>
        <a href="/sessions"
           class="flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform shadow-md shadow-primary/20 w-fit">
            <span class="material-symbols-outlined">play_circle</span>
            Sessions Actives
        </a>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">

        <?php
        // Calculate stats from sessions data
        $completed = array_filter($sessions, fn($s) => $s['status'] === 'completed');
        $cancelled = array_filter($sessions, fn($s) => $s['status'] === 'cancelled');
        $totalDuration = array_sum(array_column(iterator_to_array(
            new ArrayIterator($completed)
        ), 'duration'));
        $avgDuration = count($completed) > 0
            ? round($totalDuration / count($completed))
            : 0;
        ?>

        <div class="bg-surface-container-lowest p-5 rounded-lg border border-outline-variant/10">
            <span class="material-symbols-outlined text-secondary mb-2 block">check_circle</span>
            <p class="text-xs text-on-surface-variant font-medium">Complétées</p>
            <h3 class="text-2xl font-bold font-headline"><?= count($completed) ?></h3>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-lg border border-outline-variant/10">
            <span class="material-symbols-outlined text-tertiary mb-2 block">cancel</span>
            <p class="text-xs text-on-surface-variant font-medium">Annulées</p>
            <h3 class="text-2xl font-bold font-headline"><?= count($cancelled) ?></h3>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-lg border border-outline-variant/10">
            <span class="material-symbols-outlined text-primary mb-2 block">schedule</span>
            <p class="text-xs text-on-surface-variant font-medium">Durée Moyenne</p>
            <h3 class="text-2xl font-bold font-headline"><?= $avgDuration ?> min</h3>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-lg border border-outline-variant/10">
            <span class="material-symbols-outlined text-primary mb-2 block">history</span>
            <p class="text-xs text-on-surface-variant font-medium">Total Sessions</p>
            <h3 class="text-2xl font-bold font-headline"><?= count($sessions) ?></h3>
        </div>

    </div>

    <!-- Sessions History Table -->
    <?php if (empty($sessions)): ?>

        <div class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-16 rounded-lg text-center">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">
                history
            </span>
            <h4 class="font-headline text-xl font-bold text-on-surface-variant mb-2">
                Aucune session dans l'historique
            </h4>
            <p class="text-on-surface-variant text-sm">
                Les sessions terminées apparaîtront ici.
            </p>
        </div>

    <?php else: ?>

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">

            <!-- Table Header -->
            <div class="grid grid-cols-7 gap-4 px-6 py-4 bg-surface-container-low border-b border-outline-variant/10">
                <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Date</div>
                <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Client</div>
                <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant col-span-2">Jeu</div>
                <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Table</div>
                <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Durée</div>
                <div class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Statut</div>
            </div>

            <!-- Table Rows -->
            <div class="divide-y divide-outline-variant/10">
                <?php foreach ($sessions as $session):

                    // Format duration
                    $dur = (int) $session['duration'];
                    $durText = $dur > 0
                        ? floor($dur / 60) . 'h ' . ($dur % 60) . 'min'
                        : '—';

                    // Format date
                    $dateText = date('d/m/Y', strtotime($session['start_time']));
                    $timeText = date('H:i', strtotime($session['start_time']));

                    // Status
                    $isCompleted = $session['status'] === 'completed';
                ?>
                    <div class="grid grid-cols-7 gap-4 px-6 py-4 hover:bg-surface-container-low transition-colors items-center">

                        <!-- Date -->
                        <div>
                            <p class="text-sm font-medium"><?= $dateText ?></p>
                            <p class="text-xs text-on-surface-variant"><?= $timeText ?></p>
                        </div>

                        <!-- Client -->
                        <div>
                            <?php
                            $cParts    = explode(' ', $session['client_name'] ?? 'Walk In');
                            $cInitials = strtoupper(substr($cParts[0], 0, 1));
                            if (isset($cParts[1])) {
                                $cInitials .= strtoupper(substr($cParts[1], 0, 1));
                            }
                            ?>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-xs font-bold text-on-primary-fixed flex-shrink-0">
                                    <?= $cInitials ?>
                                </div>
                                <span class="text-sm font-medium truncate">
                                    <?= htmlspecialchars($session['client_name'] ?? 'Walk-in') ?>
                                </span>
                            </div>
                        </div>

                        <!-- Game -->
                        <div class="col-span-2">
                            <p class="text-sm font-medium">
                                <?= htmlspecialchars($session['game_name']) ?>
                            </p>
                            <p class="text-xs text-on-surface-variant">
                                <?= $session['number_of_guests'] ?? '?' ?> joueurs
                            </p>
                        </div>

                        <!-- Table -->
                        <div>
                            <span class="bg-surface-container px-3 py-1 rounded-full text-sm font-bold">
                                T<?= sprintf('%02d', $session['table_number']) ?>
                            </span>
                        </div>

                        <!-- Duration -->
                        <div>
                            <span class="text-sm font-medium"><?= $durText ?></span>
                        </div>

                        <!-- Status -->
                        <div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                <?= $isCompleted
                                    ? 'bg-secondary-container text-on-secondary-container'
                                    : 'bg-error-container text-on-error-container' ?>">
                                <?= $isCompleted ? '✓ Complétée' : '✕ Annulée' ?>
                            </span>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            <?php foreach ($sessions as $session):
                $dur = (int) $session['duration'];
                $durText = $dur > 0
                    ? floor($dur / 60) . 'h ' . ($dur % 60) . 'min'
                    : '—';
                $isCompleted = $session['status'] === 'completed';
            ?>
                <div class="bg-surface-container-lowest p-5 rounded-lg border border-outline-variant/10 shadow-sm">

                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-on-surface">
                                <?= htmlspecialchars($session['game_name']) ?>
                            </h4>
                            <p class="text-xs text-on-surface-variant">
                                <?= date('d/m/Y H:i', strtotime($session['start_time'])) ?>
                            </p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                            <?= $isCompleted
                                ? 'bg-secondary-container text-on-secondary-container'
                                : 'bg-error-container text-on-error-container' ?>">
                            <?= $isCompleted ? 'Complétée' : 'Annulée' ?>
                        </span>
                    </div>

                    <div class="flex gap-6 text-sm text-on-surface-variant">
                        <span>👤 <?= htmlspecialchars($session['client_name'] ?? 'Walk-in') ?></span>
                        <span>🪑 Table <?= $session['table_number'] ?></span>
                        <span>⏱️ <?= $durText ?></span>
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