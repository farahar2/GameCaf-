<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="md:ml-72 px-6 pt-8 pb-32 max-w-2xl">

    <!-- Header -->
    <div class="mb-10">
        <a href="/categories"
           class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors mb-4 text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Retour aux Catégories
        </a>
        <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-2 block">
            ADMIN
        </span>
        <h1 class="font-headline text-4xl font-extrabold text-on-background tracking-tight">
            <?= isset($category) ? 'Modifier la Catégorie' : 'Nouvelle Catégorie' ?>
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

        <form action="<?= isset($category) ? '/categories/' . $category['id'] . '/update' : '/categories' ?>"
              method="POST"
              class="space-y-6">

            <!-- Name -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Nom de la Catégorie *
                </label>
                <input type="text"
                       name="name"
                       value="<?= htmlspecialchars($_POST['name'] ?? $category['name'] ?? '') ?>"
                       placeholder="Ex: Stratégie, Famille, Ambiance..."
                       required
                       class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface text-lg"/>
                <p class="text-xs text-on-surface-variant mt-1">
                    Le nom doit être unique dans le catalogue.
                </p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Description
                    <span class="text-on-surface-variant font-normal normal-case tracking-normal ml-1">
                        (optionnel)
                    </span>
                </label>
                <textarea name="description"
                          rows="4"
                          placeholder="Décrivez cette catégorie de jeux..."
                          class="w-full bg-surface-container-low border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary/30 font-body text-on-surface resize-none"
                ><?= htmlspecialchars($_POST['description'] ?? $category['description'] ?? '') ?></textarea>
            </div>

            <!-- Preview Card -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Aperçu
                </label>
                <div class="bg-surface-container-low rounded-xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">
                            category
                        </span>
                    </div>
                    <div>
                        <p class="font-headline font-bold text-on-surface" id="preview-name">
                            <?= htmlspecialchars($category['name'] ?? 'Nom de la catégorie') ?>
                        </p>
                        <p class="text-xs text-on-surface-variant" id="preview-desc">
                            <?= !empty($category['description'])
                                ? htmlspecialchars(substr($category['description'], 0, 50))
                                : 'Description de la catégorie' ?>
                        </p>
                    </div>
                    <div class="ml-auto">
                        <span class="bg-secondary-fixed text-on-secondary-fixed px-3 py-1 rounded-full text-xs font-bold">
                            0 jeux
                        </span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-2">
                <a href="/categories"
                   class="flex-1 text-center py-4 bg-surface-container-high text-on-surface rounded-xl font-bold hover:bg-surface-variant transition-colors">
                    Annuler
                </a>
                <button type="submit"
                        class="flex-1 bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">
                        <?= isset($category) ? 'save' : 'add_circle' ?>
                    </span>
                    <?= isset($category) ? 'Sauvegarder' : 'Créer la Catégorie' ?>
                </button>
            </div>

        </form>

        <!-- Danger Zone (Edit only) -->
        <?php if (isset($category) && ($category['games_count'] ?? 0) === 0): ?>
            <div class="mt-8 pt-8 border-t border-outline-variant/20">
                <h3 class="font-headline font-bold text-error mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">warning</span>
                    Zone Dangereuse
                </h3>
                <form action="/categories/<?= $category['id'] ?>/delete"
                      method="POST"
                      onsubmit="return confirm('Supprimer définitivement la catégorie &quot;<?= htmlspecialchars(addslashes($category['name'])) ?>&quot;?')">
                    <button type="submit"
                            class="w-full py-3 bg-error-container text-on-error-container rounded-xl font-bold hover:bg-error hover:text-on-error transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">delete_forever</span>
                        Supprimer cette Catégorie
                    </button>
                </form>
            </div>
        <?php elseif (isset($category) && ($category['games_count'] ?? 0) > 0): ?>
            <div class="mt-8 pt-8 border-t border-outline-variant/20">
                <div class="bg-surface-container-low p-4 rounded-xl flex items-center gap-3 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm">info</span>
                    <p class="text-sm">
                        Cette catégorie contient <strong><?= $category['games_count'] ?> jeu(x)</strong>.
                        Supprimez d'abord les jeux pour pouvoir la supprimer.
                    </p>
                </div>
            </div>
        <?php endif; ?>

    </div>

</main>

<!-- Live Preview JS -->
<script>
    const nameInput = document.querySelector('input[name="name"]');
    const descInput = document.querySelector('textarea[name="description"]');
    const previewName = document.getElementById('preview-name');
    const previewDesc = document.getElementById('preview-desc');

    nameInput?.addEventListener('input', function () {
        previewName.textContent = this.value || 'Nom de la catégorie';
    });

    descInput?.addEventListener('input', function () {
        previewDesc.textContent = this.value
            ? this.value.substring(0, 50) + (this.value.length > 50 ? '...' : '')
            : 'Description de la catégorie';
    });
</script>

<!-- Mobile Nav -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav  = [
        ['uri' => '/dashboard',  'icon' => 'dashboard', 'label' => 'Dashboard'],
        ['uri' => '/games',      'icon' => 'casino',     'label' => 'Games'],
        ['uri' => '/categories', 'icon' => 'category',   'label' => 'Categories'],
        ['uri' => '/sessions',   'icon' => 'style',      'label' => 'Sessions'],
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