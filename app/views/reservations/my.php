<?php require __DIR__ . '/../layouts/header.php'; ?>

<main class="md:ml-72 min-h-screen pb-32 px-6 pt-8">
    <div class="mb-10">
        <h1 class="font-headline text-4xl font-extrabold text-on-background leading-none mb-2">
            Mes Réservations
        </h1>
        <p class="text-on-surface-variant">Gérez vos réservations passées et futures</p>
    </div>

    <?php if (empty($reservations)): ?>
        <div class="bg-surface-container-low border-2 border-dashed border-outline-variant/30 p-16 rounded-xl text-center">
            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">event_busy</span>
            <h3 class="font-headline text-xl font-bold text-on-surface-variant mb-2">Aucune réservation</h3>
            <p class="text-on-surface-variant text-sm mb-6">Vous n'avez pas encore effectué de réservation.</p>
            <a href="reservations/create" class="bg-primary text-on-primary px-8 py-3 rounded-full font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                Réserver une table
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($reservations as $res): 
                $statusBadges = [
                    'pending'   => 'bg-[#ffdbcc] text-[#8d4b00]',
                    'confirmed' => 'bg-secondary-fixed text-on-secondary-fixed',
                    'completed' => 'bg-secondary-container text-on-secondary-container',
                    'cancelled' => 'bg-error-container text-on-error-container',
                ];
                $badge = $statusBadges[$res['status']] ?? $statusBadges['pending'];
            ?>
                <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <span class="<?= $badge ?> px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                            <?= ucfirst($res['status']) ?>
                        </span>
                        <span class="text-xs text-on-surface-variant font-mono">#<?= $res['id'] ?></span>
                    </div>

                    <h3 class="font-headline font-bold text-lg mb-4">
                        <?= !empty($res['game_name']) ? htmlspecialchars($res['game_name']) : 'Pas de jeu choisi' ?>
                    </h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                            <span><?= date('d/m/Y', strtotime($res['reservation_date'])) ?> à <?= date('H:i', strtotime($res['reservation_time'])) ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-lg">chair</span>
                            <span>Table <?= $res['table_number'] ?> • <?= $res['number_of_guests'] ?> personnes</span>
                        </div>
                    </div>

                    <?php if (in_array($res['status'], ['pending', 'confirmed'])): ?>
                        <form action="reservations/<?= $res['id'] ?>/status" method="POST" onsubmit="return confirm('Annuler cette réservation ?')">
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full py-2 bg-error-container text-on-error-container rounded-xl text-sm font-bold hover:bg-error hover:text-on-error transition-colors">
                                Annuler la réservation
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
