<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 min-h-screen pb-24 md:pb-12 px-6 pt-6 md:pt-12">

    <!-- Header -->
    <div class="mb-10">
        <a href="sessions"
           class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors mb-4 text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Retour aux Sessions
        </a>
        <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
            ADMIN
        </span>
        <h1 class="font-headline text-4xl font-bold tracking-tight text-primary">
            Démarrer une Session
        </h1>
        <p class="text-on-surface-variant mt-1">
            Associez une réservation, un jeu et une table
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ===== Form ===== -->
        <div class="lg:col-span-2">
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 p-8">

                <!-- Error Messages -->
                <?php if (!empty($errors)): ?>
                    <div class="bg-error-container text-on-error-container px-5 py-4 rounded-xl mb-6">
                        <div class="flex items-center gap-2 mb-2 font-bold">
                            <span class="material-symbols-outlined text-sm">error</span>
                            Erreurs détectées
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="sessions" method="POST" class="space-y-8" id="start-session-form">

                    <!-- Step 1: Reservation (Optional) -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                1
                            </div>
                            <h3 class="font-headline text-lg font-bold">
                                Réservation
                                <span class="text-on-surface-variant text-sm font-normal ml-1">(optionnel)</span>
                            </h3>
                        </div>

                        <select name="reservation_id"
                                id="reservation-select"
                                class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface">
                            <option value="">— Walk-in (sans réservation) —</option>
                            <?php foreach ($reservations as $res): ?>
                                <option value="<?= $res['id'] ?>"
                                        data-table="<?= $res['table_id'] ?>"
                                        data-guests="<?= $res['number_of_guests'] ?>"
                                        <?= ($_POST['reservation_id'] ?? '') == $res['id'] ? 'selected' : '' ?>>
                                    <?= date('H:i', strtotime($res['reservation_time'])) ?>
                                    — <?= htmlspecialchars($res['client_name']) ?>
                                    (<?= $res['number_of_guests'] ?> pers.)
                                    — Table <?= $res['table_number'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Auto-fill hint -->
                        <p class="text-xs text-on-surface-variant mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">info</span>
                            Sélectionner une réservation remplit automatiquement la table
                        </p>
                    </div>

                    <!-- Step 2: Game -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                2
                            </div>
                            <h3 class="font-headline text-lg font-bold">Choisir un Jeu *</h3>
                        </div>

                        <!-- Search Filter for Games -->
                        <div class="relative mb-4">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">
                                search
                            </span>
                            <input type="text"
                                   id="game-search"
                                   placeholder="Filtrer les jeux..."
                                   class="w-full bg-surface-container-low border-none rounded-xl py-3 pl-10 pr-4 focus:ring-2 focus:ring-primary/30 text-sm"/>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-1">
                            <?php foreach ($games as $game):
                                $isSelected = ($_POST['game_id'] ?? '') == $game['id'];
                            ?>
                                <label class="game-option cursor-pointer">
                                    <input type="radio"
                                           name="game_id"
                                           value="<?= $game['id'] ?>"
                                           class="sr-only"
                                           <?= $isSelected ? 'checked' : '' ?>
                                           required/>
                                    <div class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all
                                                <?= $isSelected
                                                    ? 'border-primary bg-primary-fixed'
                                                    : 'border-outline-variant/20 bg-surface-container-low hover:border-primary/30' ?>
                                                game-card">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-surface-container">
                                            <?php if (!empty($game['image_url'])): 
                                                $gameImg = $game['image_url'];
                                                if (str_starts_with($gameImg, '/') && !str_starts_with($gameImg, '//')) {
                                                    $gameImg = ltrim($gameImg, '/');
                                                }
                                            ?>
                                                <img src="<?= htmlspecialchars($gameImg) ?>"
                                                     alt="<?= htmlspecialchars($game['name']) ?>"
                                                     class="w-full h-full object-cover"
                                                     onerror="this.onerror=null; this.src='https://placehold.co/400x300/ffdcc3/8d4b00?text=<?= urlencode(addslashes($game['name'])) ?>';"/>
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-on-surface-variant text-sm">casino</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-on-surface truncate game-name">
                                                <?= htmlspecialchars($game['name']) ?>
                                            </p>
                                            <p class="text-xs text-on-surface-variant">
                                                👥 <?= $game['min_players'] ?>-<?= $game['max_players'] ?>
                                                • ⏱️ <?= $game['duration'] ?>min
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <!-- Step 3: Table -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                3
                            </div>
                            <h3 class="font-headline text-lg font-bold">Choisir une Table *</h3>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                            <?php foreach ($tables as $table):
                                $isSelected = ($_POST['table_id'] ?? '') == $table['id'];
                            ?>
                                <label class="cursor-pointer">
                                    <input type="radio"
                                           name="table_id"
                                           value="<?= $table['id'] ?>"
                                           class="sr-only table-radio"
                                           data-table-id="<?= $table['id'] ?>"
                                           <?= $isSelected ? 'checked' : '' ?>
                                           required/>
                                    <div class="table-card text-center p-4 rounded-xl border-2 transition-all
                                                <?= $isSelected
                                                    ? 'border-primary bg-primary-fixed'
                                                    : 'border-outline-variant/20 bg-surface-container-low hover:border-primary/30' ?>">
                                        <p class="font-headline font-bold text-lg">
                                            T<?= sprintf('%02d', $table['table_number']) ?>
                                        </p>
                                        <p class="text-xs text-on-surface-variant mt-1">
                                            👥 <?= $table['capacity'] ?>
                                        </p>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <?php if (empty($tables)): ?>
                            <div class="bg-error-container text-on-error-container p-4 rounded-xl text-sm">
                                <span class="material-symbols-outlined text-sm align-middle">warning</span>
                                Aucune table disponible en ce moment!
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            <?= empty($tables) ? 'disabled' : '' ?>>
                        <span class="material-symbols-outlined">play_circle</span>
                        Démarrer la Session
                    </button>

                </form>
            </div>
        </div>

        <!-- ===== Info Sidebar ===== -->
        <div class="space-y-6">

            <!-- Current Time -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                <p class="text-xs text-on-surface-variant uppercase tracking-widest mb-2">
                    Heure de début
                </p>
                <p class="font-headline text-3xl font-bold text-primary" id="current-time">
                    <?= date('H:i') ?>
                </p>
                <p class="text-sm text-on-surface-variant mt-1">
                    <?= date('l d F Y') ?>
                </p>
            </div>

            <!-- Available Tables Summary -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                <h4 class="font-headline font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-lg">chair</span>
                    Tables Disponibles
                </h4>
                <div class="space-y-2">
                    <?php foreach ($tables as $table): ?>
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/10 last:border-0">
                            <span class="font-medium text-sm">
                                Table <?= $table['table_number'] ?>
                            </span>
                            <span class="text-xs text-on-surface-variant bg-secondary-container px-2 py-0.5 rounded-full">
                                <?= $table['capacity'] ?> places
                            </span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($tables)): ?>
                        <p class="text-sm text-on-surface-variant text-center py-2">
                            Aucune table libre
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-[#1b6b51] p-6 rounded-xl text-white">
                <h4 class="font-headline font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">tips_and_updates</span>
                    Conseils
                </h4>
                <ul class="text-sm text-emerald-100 space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-300 mt-0.5">•</span>
                        Sélectionner une réservation remplit la table automatiquement
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-300 mt-0.5">•</span>
                        Les walk-ins n'ont pas besoin de réservation
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-300 mt-0.5">•</span>
                        La table sera marquée occupée automatiquement
                    </li>
                </ul>
            </div>

        </div>
    </div>

</main>

<!-- JavaScript -->
<script>
    // Live clock
    function updateClock() {
        const now  = new Date();
        const h    = String(now.getHours()).padStart(2, '0');
        const m    = String(now.getMinutes()).padStart(2, '0');
        const el   = document.getElementById('current-time');
        if (el) el.textContent = h + ':' + m;
    }
    setInterval(updateClock, 1000);

    // Auto-select table when reservation is chosen
    document.getElementById('reservation-select')?.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const tableId  = selected.getAttribute('data-table');

        if (tableId) {
            const radio = document.querySelector(
                `input[name="table_id"][data-table-id="${tableId}"]`
            );
            if (radio) {
                radio.checked = true;
                // Update visual selection
                document.querySelectorAll('.table-card').forEach(c => {
                    c.classList.remove('border-primary', 'bg-primary-fixed');
                    c.classList.add('border-outline-variant/20', 'bg-surface-container-low');
                });
                radio.nextElementSibling?.classList.add('border-primary', 'bg-primary-fixed');
                radio.nextElementSibling?.classList.remove('border-outline-variant/20', 'bg-surface-container-low');
            }
        }
    });

    // Game search filter
    document.getElementById('game-search')?.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.game-option').forEach(option => {
            const name = option.querySelector('.game-name')?.textContent.toLowerCase() ?? '';
            option.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    // Highlight selected radio cards
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const name = this.name;
            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                const card = r.nextElementSibling;
                if (card) {
                    card.classList.remove('border-primary', 'bg-primary-fixed');
                    card.classList.add('border-outline-variant/20', 'bg-surface-container-low');
                }
            });
            if (this.checked) {
                const card = this.nextElementSibling;
                if (card) {
                    card.classList.add('border-primary', 'bg-primary-fixed');
                    card.classList.remove('border-outline-variant/20', 'bg-surface-container-low');
                }
            }
        });
    });
</script>

    <div class="md:hidden h-20"></div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>