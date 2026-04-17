<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- Client Sidebar -->
<aside class="hidden md:flex flex-col fixed left-0 top-0 w-72 h-full rounded-r-3xl bg-[#fff8f6] pt-8 pb-12 z-40">
    <div class="px-8 mb-12">
        <a href="/" class="text-[#8d4b00] font-black text-2xl font-headline">Aji L3bo</a>
    </div>
    <div class="flex-1">
        <?php
        $clientNav  = [
            ['uri' => '/',                    'icon' => 'home',    'label' => 'Accueil'],
            ['uri' => '/games',               'icon' => 'casino',  'label' => 'Catalogue'],
            ['uri' => '/reservations/my',     'icon' => 'style',   'label' => 'Mes Réservations'],
            ['uri' => '/reservations/create', 'icon' => 'event',   'label' => 'Réserver'],
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

    <!-- User Info -->
    <div class="px-6 py-4 mx-2 flex items-center gap-4 mt-auto border-t border-surface-container">
        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-on-primary-fixed">
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

<main class="md:ml-72 min-h-screen pb-32 px-6 pt-8">

    <!-- Header -->
    <div class="mb-10">
        <a href="/reservations/my"
           class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors mb-4 text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Mes Réservations
        </a>
        <p class="text-secondary font-headline font-bold text-sm tracking-widest mb-2">
            NOUVELLE RÉSERVATION
        </p>
        <h1 class="font-headline text-4xl font-extrabold text-on-background leading-none">
            Réserver une Table
        </h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ===== FORM ===== -->
        <div class="lg:col-span-2">
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 p-8">

                <!-- Error Messages -->
                <?php if (!empty($errors)): ?>
                    <div class="bg-error-container text-on-error-container px-5 py-4 rounded-xl mb-6">
                        <div class="flex items-center gap-2 font-bold mb-2">
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

                <form action="/reservations" method="POST" class="space-y-8">

                    <!-- Step 1: Date & Time -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                1
                            </div>
                            <h3 class="font-headline text-lg font-bold">Date & Heure *</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <!-- Date -->
                            <div>
                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                                    Date
                                </label>
                                <input type="date"
                                       name="reservation_date"
                                       min="<?= date('Y-m-d') ?>"
                                       value="<?= htmlspecialchars($_POST['reservation_date'] ?? '') ?>"
                                       required
                                       class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface"/>
                            </div>

                            <!-- End Time -->
                            <div>
                                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                                    Heure de fin (optionnel)
                                </label>
                                <input type="time"
                                       name="end_time"
                                       value="<?= htmlspecialchars($_POST['end_time'] ?? '') ?>"
                                       class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface"/>
                            </div>

                        </div>

                        <!-- Time Slots -->
                        <div class="mt-4">
                            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">
                                Créneau horaire *
                            </label>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <?php
                                $timeSlots   = [
                                    '10:00', '12:00', '14:00',
                                    '16:00', '18:00', '20:00',
                                ];
                                $selectedTime = $_POST['reservation_time'] ?? '';
                                foreach ($timeSlots as $slot):
                                    $isSelected = $selectedTime === $slot;
                                ?>
                                    <label class="cursor-pointer">
                                        <input type="radio"
                                               name="reservation_time"
                                               value="<?= $slot ?>"
                                               class="sr-only"
                                               <?= $isSelected ? 'checked' : '' ?>
                                               required/>
                                        <div class="time-slot text-center px-3 py-3 rounded-xl border-2 transition-all text-sm font-bold
                                                    <?= $isSelected
                                                        ? 'border-primary bg-primary text-on-primary'
                                                        : 'border-outline-variant/20 bg-surface-container-low hover:border-primary/40 text-on-surface' ?>">
                                            <?= $slot ?>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>

                    <!-- Step 2: Guests -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                2
                            </div>
                            <h3 class="font-headline text-lg font-bold">Nombre de Personnes *</h3>
                        </div>

                        <!-- Guest Counter -->
                        <div class="flex items-center gap-6 bg-surface-container-low rounded-xl p-4 w-fit">
                            <button type="button"
                                    id="guests-minus"
                                    class="w-12 h-12 rounded-full bg-surface-container-highest text-on-surface flex items-center justify-center text-xl font-bold hover:bg-primary hover:text-on-primary transition-all active:scale-95">
                                −
                            </button>
                            <div class="text-center">
                                <span id="guests-display"
                                      class="font-headline text-4xl font-bold text-primary">
                                    <?= htmlspecialchars($_POST['number_of_guests'] ?? '2') ?>
                                </span>
                                <p class="text-xs text-on-surface-variant mt-1">personnes</p>
                            </div>
                            <button type="button"
                                    id="guests-plus"
                                    class="w-12 h-12 rounded-full bg-surface-container-highest text-on-surface flex items-center justify-center text-xl font-bold hover:bg-primary hover:text-on-primary transition-all active:scale-95">
                                +
                            </button>
                            <input type="hidden"
                                   name="number_of_guests"
                                   id="guests-input"
                                   value="<?= htmlspecialchars($_POST['number_of_guests'] ?? '2') ?>"/>
                        </div>

                    </div>

                    <!-- Step 3: Table -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                3
                            </div>
                            <h3 class="font-headline text-lg font-bold">Choisir une Table *</h3>
                        </div>

                        <?php if (empty($tables)): ?>
                            <div class="bg-error-container text-on-error-container p-4 rounded-xl text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">warning</span>
                                Aucune table disponible pour ce créneau.
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                <?php foreach ($tables as $table):
                                    $isSelected = ($_POST['table_id'] ?? '') == $table['id'];
                                ?>
                                    <label class="cursor-pointer">
                                        <input type="radio"
                                               name="table_id"
                                               value="<?= $table['id'] ?>"
                                               class="sr-only"
                                               <?= $isSelected ? 'checked' : '' ?>
                                               required/>
                                        <div class="table-card text-center p-4 rounded-xl border-2 transition-all
                                                    <?= $isSelected
                                                        ? 'border-primary bg-primary-fixed'
                                                        : 'border-outline-variant/20 bg-surface-container-low hover:border-primary/30' ?>">
                                            <p class="font-headline font-bold text-xl">
                                                T<?= sprintf('%02d', $table['table_number']) ?>
                                            </p>
                                            <p class="text-xs text-on-surface-variant mt-1">
                                                👥 <?= $table['capacity'] ?> places
                                            </p>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Step 4: Game (Optional) -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-surface-container-high text-on-surface flex items-center justify-center font-bold text-sm">
                                4
                            </div>
                            <h3 class="font-headline text-lg font-bold">
                                Choisir un Jeu
                                <span class="text-on-surface-variant text-sm font-normal ml-1">(optionnel)</span>
                            </h3>
                        </div>

                        <!-- Game Search -->
                        <div class="relative mb-4">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">
                                search
                            </span>
                            <input type="text"
                                   id="game-search"
                                   placeholder="Filtrer les jeux..."
                                   class="w-full bg-surface-container-low border-none rounded-xl py-3 pl-10 pr-4 focus:ring-2 focus:ring-primary/30 text-sm"/>
                        </div>

                        <!-- No Game Option -->
                        <div class="mb-3">
                            <label class="cursor-pointer">
                                <input type="radio"
                                       name="game_id"
                                       value=""
                                       class="sr-only"
                                       <?= empty($_POST['game_id']) ? 'checked' : '' ?>/>
                                <div class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all
                                            <?= empty($_POST['game_id'])
                                                ? 'border-primary bg-primary-fixed'
                                                : 'border-outline-variant/20 bg-surface-container-low hover:border-primary/30' ?>
                                            game-radio-card">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center">
                                        <span class="material-symbols-outlined text-on-surface-variant">do_not_disturb</span>
                                    </div>
                                    <p class="text-sm font-bold text-on-surface">Pas de préférence</p>
                                </div>
                            </label>
                        </div>

                        <!-- Game List -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-1">
                            <?php foreach ($games as $game):
                                $isSelected = ($_POST['game_id'] ?? '') == $game['id'];
                            ?>
                                <label class="cursor-pointer game-option">
                                    <input type="radio"
                                           name="game_id"
                                           value="<?= $game['id'] ?>"
                                           class="sr-only"
                                           <?= $isSelected ? 'checked' : '' ?>/>
                                    <div class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all
                                                <?= $isSelected
                                                    ? 'border-primary bg-primary-fixed'
                                                    : 'border-outline-variant/20 bg-surface-container-low hover:border-primary/30' ?>
                                                game-radio-card">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-surface-container">
                                            <?php if (!empty($game['image_url'])): ?>
                                                <img src="<?= htmlspecialchars($game['image_url']) ?>"
                                                     alt="<?= htmlspecialchars($game['name']) ?>"
                                                     class="w-full h-full object-cover"/>
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

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">event_available</span>
                        Confirmer la Réservation
                    </button>

                </form>
            </div>
        </div>

        <!-- ===== INFO SIDEBAR ===== -->
        <div class="space-y-6">

            <!-- Today's Date -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                <p class="text-xs text-on-surface-variant uppercase tracking-widest mb-2">
                    Aujourd'hui
                </p>
                <p class="font-headline text-2xl font-bold text-primary">
                    <?= date('d F Y') ?>
                </p>
                <p class="text-sm text-on-surface-variant mt-1">
                    Réservations disponibles dès maintenant
                </p>
            </div>

            <!-- Available Tables Summary -->
            <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10">
                <h4 class="font-headline font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary">chair</span>
                    Tables Disponibles
                </h4>
                <div class="space-y-2">
                    <?php foreach ($tables as $table): ?>
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/10 last:border-0">
                            <span class="font-medium text-sm">
                                Table <?= $table['table_number'] ?>
                            </span>
                            <span class="text-xs bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded-full">
                                <?= $table['capacity'] ?> places
                            </span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($tables)): ?>
                        <p class="text-sm text-on-surface-variant text-center py-2">
                            Toutes les tables sont occupées
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Opening Hours -->
            <div class="bg-[#1b6b51] p-6 rounded-xl text-white">
                <h4 class="font-headline font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">schedule</span>
                    Horaires d'ouverture
                </h4>
                <div class="space-y-2 text-sm text-emerald-100">
                    <?php
                    $hours = [
                        'Lun - Jeu' => '14:00 - 00:00',
                        'Ven - Sam' => '14:00 - 02:00',
                        'Dimanche'  => '14:00 - 00:00',
                    ];
                    foreach ($hours as $day => $time):
                    ?>
                        <div class="flex justify-between items-center">
                            <span class="text-emerald-200"><?= $day ?></span>
                            <span class="font-bold"><?= $time ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20 flex items-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-sm">location_on</span>
                    <span class="text-emerald-100">22 Rue Taha Hussein, Gauthier, Casa</span>
                </div>
            </div>

        </div>

    </div>

</main>

<!-- JS -->
<script>
    // Guest counter
    const guestsInput   = document.getElementById('guests-input');
    const guestsDisplay = document.getElementById('guests-display');
    const minGuests = 1;
    const maxGuests = 12;

    document.getElementById('guests-plus')?.addEventListener('click', () => {
        let val = parseInt(guestsInput.value) || 2;
        if (val < maxGuests) {
            val++;
            guestsInput.value   = val;
            guestsDisplay.textContent = val;
        }
    });

    document.getElementById('guests-minus')?.addEventListener('click', () => {
        let val = parseInt(guestsInput.value) || 2;
        if (val > minGuests) {
            val--;
            guestsInput.value   = val;
            guestsDisplay.textContent = val;
        }
    });

    // Radio card visual selection
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function () {
            // Find all radios with same name
            document.querySelectorAll(`input[name="${this.name}"]`).forEach(r => {
                const card = r.nextElementSibling;
                if (!card) return;
                card.classList.remove('border-primary', 'bg-primary-fixed', 'bg-primary', 'text-on-primary');
                card.classList.add('border-outline-variant/20', 'bg-surface-container-low');
            });
            if (this.checked) {
                const card = this.nextElementSibling;
                if (!card) return;
                // Time slots get full primary color
                if (card.classList.contains('time-slot')) {
                    card.classList.add('border-primary', 'bg-primary', 'text-on-primary');
                } else {
                    card.classList.add('border-primary', 'bg-primary-fixed');
                }
                card.classList.remove('border-outline-variant/20', 'bg-surface-container-low');
            }
        });
    });

    // Game search filter
    document.getElementById('game-search')?.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.game-option').forEach(opt => {
            const name = opt.querySelector('.game-name')?.textContent.toLowerCase() ?? '';
            opt.style.display = name.includes(query) ? 'block' : 'none';
        });
    });
</script>

<!-- Mobile Nav -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav  = [
        ['uri' => '/',                    'icon' => 'home',      'label' => 'Home'],
        ['uri' => '/games',               'icon' => 'grid_view',  'label' => 'Catalog'],
        ['uri' => '/reservations/create', 'icon' => 'event',      'label' => 'Book'],
        ['uri' => '/reservations/my',     'icon' => 'person',     'label' => 'Profile'],
    ];
    $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
    foreach ($mobileNav as $item):
        $isActive = str_starts_with($currentUri, $item['uri'])
                    && !($item['uri'] === '/' && $currentUri !== '/');
    ?>
        <a href="<?= $item['uri'] ?>"
           class="flex flex-col items-center px-4 py-1 rounded-2xl transition-all
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