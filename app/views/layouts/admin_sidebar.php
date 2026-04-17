<!-- Desktop Sidebar -->
<?php $hasSidebar = true; ?>
<aside class="hidden md:flex flex-col fixed left-0 top-0 w-72 h-full bg-[#fff8f6] rounded-r-3xl z-40 border-r border-outline-variant/10">

    <!-- Logo -->
    <div class="px-8 pt-8 mb-6">
        <a href="."
           class="font-headline font-black text-xl text-[#8d4b00] flex items-center gap-2">
            🎲 Aji L3bo
        </a>
    </div>

    <!-- Admin Profile -->
    <div class="mx-6 mb-8 p-4 bg-surface-container-low rounded-xl flex items-center gap-3">
        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center font-headline font-black text-on-primary-fixed text-lg flex-shrink-0">
            <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
        </div>
        <div class="min-w-0">
            <p class="font-headline font-bold text-on-surface truncate">
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
            </p>
            <p class="text-xs text-on-surface-variant">Café Manager</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
        <?php
        $currentUri = $_SERVER['REQUEST_URI'] ?? '/';

        $adminNav = [
            [
                'uri'   => 'dashboard/admin',
                'icon'  => 'dashboard',
                'label' => 'Dashboard',
            ],
            [
                'uri'   => 'games',
                'icon'  => 'casino',
                'label' => 'Jeux',
            ],
            [
                'uri'   => 'categories',
                'icon'  => 'category',
                'label' => 'Catégories',
            ],
            [
                'uri'   => 'reservations',
                'icon'  => 'event',
                'label' => 'Réservations',
            ],
            [
                'uri'   => 'tables',
                'icon'  => 'table_restaurant',
                'label' => 'Tables',
            ],
            [
                'uri'   => 'sessions',
                'icon'  => 'style',
                'label' => 'Sessions',
            ],
        ];

        foreach ($adminNav as $item):
            // Active if current URI starts with item URI
            // But avoid '/' matching everything
            $isActive = str_starts_with($currentUri, $item['uri']);
        ?>
            <a href="<?= $item['uri'] ?>"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                      <?= $isActive
                          ? 'bg-[#1b6b51] text-white translate-x-1 shadow-md shadow-secondary/20'
                          : 'text-stone-600 hover:bg-stone-100 hover:translate-x-0.5' ?>">
                <span class="material-symbols-outlined text-xl"
                      style="<?= $isActive ? "font-variation-settings:'FILL' 1;" : '' ?>">
                    <?= $item['icon'] ?>
                </span>
                <span class="font-headline font-medium"><?= $item['label'] ?></span>

                <?php if ($isActive): ?>
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Divider -->
    <div class="mx-6 border-t border-outline-variant/20 my-4"></div>

    <!-- Bottom: Settings + Logout -->
    <div class="px-4 pb-8 space-y-1">

        <a href="settings"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-stone-600 hover:bg-stone-100">
            <span class="material-symbols-outlined text-xl">settings</span>
            <span class="font-headline font-medium">Paramètres</span>
        </a>

        <a href="logout"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-stone-600 hover:bg-red-50 hover:text-red-600">
            <span class="material-symbols-outlined text-xl">logout</span>
            <span class="font-headline font-medium">Déconnexion</span>
        </a>

    </div>

</aside>