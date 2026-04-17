<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-4xl">

    <!-- Header -->
    <div class="mb-10">
        <a href="/games/<?= $game['id'] ?>"
           class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors mb-4 text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Retour au Jeu
        </a>
        <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
            ADMIN — MODIFIER
        </span>
        <h1 class="font-headline text-4xl font-extrabold text-on-background tracking-tight">
            <?= htmlspecialchars($game['name']) ?>
        </h1>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 p-8">

        <!-- Errors -->
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

        <form action="/games/<?= $game['id'] ?>/update"
              method="POST"
              class="space-y-6">

            <!-- Game Name -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Nom du Jeu *
                </label>
                <input type="text"
                       name="name"
                       value="<?= htmlspecialchars($_POST['name'] ?? $game['name']) ?>"
                       required
                       class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface"/>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Description
                </label>
                <textarea name="description"
                          rows="3"
                          class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface resize-none"
                ><?= htmlspecialchars($_POST['description'] ?? $game['description'] ?? '') ?></textarea>
            </div>

            <!-- Category + Difficulty -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Catégorie *
                    </label>
                    <select name="category_id"
                            required
                            class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= ($_POST['category_id'] ?? $game['category_id']) == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Difficulté *
                    </label>
                    <select name="difficulty"
                            required
                            class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface">
                        <?php
                        $difficulties = ['easy' => 'Facile', 'medium' => 'Moyen', 'hard' => 'Difficile', 'expert' => 'Expert'];
                        foreach ($difficulties as $val => $label):
                        ?>
                            <option value="<?= $val ?>"
                                <?= ($_POST['difficulty'] ?? $game['difficulty']) === $val ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <!-- Players + Duration + Stock -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Min Joueurs
                    </label>
                    <input type="number"
                           name="min_players"
                           value="<?= htmlspecialchars($_POST['min_players'] ?? $game['min_players']) ?>"
                           min="1" max="20"
                           required
                           class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 text-center font-bold text-on-surface"/>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Max Joueurs
                    </label>
                    <input type="number"
                           name="max_players"
                           value="<?= htmlspecialchars($_POST['max_players'] ?? $game['max_players']) ?>"
                           min="1" max="20"
                           required
                           class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 text-center font-bold text-on-surface"/>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Durée (min)
                    </label>
                    <input type="number"
                           name="duration"
                           value="<?= htmlspecialchars($_POST['duration'] ?? $game['duration']) ?>"
                           min="5" max="600"
                           required
                           class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 text-center font-bold text-on-surface"/>
                </div>

                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Stock
                    </label>
                    <input type="number"
                           name="stock"
                           value="<?= htmlspecialchars($_POST['stock'] ?? $game['stock']) ?>"
                           min="0" max="99"
                           class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 text-center font-bold text-on-surface"/>
                </div>

            </div>

            <!-- Image URL -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Image URL
                </label>
                <input type="url"
                       name="image_url"
                       id="image-url-input"
                       value="<?= htmlspecialchars($_POST['image_url'] ?? $game['image_url'] ?? '') ?>"
                       placeholder="https://example.com/image.jpg"
                       class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface"/>
            </div>

            <!-- Current Image Preview -->
            <?php if (!empty($game['image_url'])): ?>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                        Image Actuelle
                    </label>
                    <div class="w-full h-48 rounded-xl overflow-hidden bg-surface-container">
                        <img id="preview-img"
                             src="<?= htmlspecialchars($game['image_url']) ?>"
                             alt="<?= htmlspecialchars($game['name']) ?>"
                             class="w-full h-full object-cover"/>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Availability Toggle -->
            <div class="flex items-center justify-between bg-surface-container-low rounded-xl p-4">
                <div>
                    <p class="font-bold text-on-surface">Disponible</p>
                    <p class="text-xs text-on-surface-variant">
                        Le jeu est visible et réservable par les clients
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox"
                           name="is_available"
                           value="1"
                           <?= ($_POST['is_available'] ?? $game['is_available']) ? 'checked' : '' ?>
                           class="sr-only peer"/>
                    <div class="w-11 h-6 bg-outline-variant rounded-full peer peer-checked:bg-secondary peer-focus:ring-2 peer-focus:ring-secondary/30 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-2">
                <a href="/games/<?= $game['id'] ?>"
                   class="flex-1 text-center py-4 bg-surface-container-high text-on-surface rounded-xl font-bold hover:bg-surface-variant transition-colors">
                    Annuler
                </a>
                <button type="submit"
                        class="flex-1 bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Sauvegarder
                </button>
            </div>

        </form>

        <!-- Danger Zone -->
        <div class="mt-8 pt-8 border-t border-outline-variant/20">
            <h3 class="font-headline font-bold text-error mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">warning</span>
                Zone Dangereuse
            </h3>
            <form action="/games/<?= $game['id'] ?>/delete"
                  method="POST"
                  onsubmit="return confirm('Supprimer définitivement <?= htmlspecialchars(addslashes($game['name'])) ?>? Cette action est irréversible!')">
                <button type="submit"
                        class="w-full py-3 bg-error-container text-on-error-container rounded-xl font-bold hover:bg-error hover:text-on-error transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">delete_forever</span>
                    Supprimer ce Jeu
                </button>
            </form>
        </div>

    </div>

</main>

<script>
    // Live image preview on URL change
    document.getElementById('image-url-input')?.addEventListener('input', function () {
        const img = document.getElementById('preview-img');
        if (img && this.value.startsWith('http')) {
            img.src = this.value;
        }
    });
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

<div class="md:hidden h-20"></div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>