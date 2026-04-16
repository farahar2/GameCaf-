<!-- Sidebar for Desktop -->
<aside class="hidden md:flex flex-col fixed left-0 top-0 bg-[#fff8f6] w-72 h-full rounded-r-3xl z-40 p-6 border-r border-outline-variant/20">

    <!-- Logo -->
    <div class="text-[#8d4b00] font-black text-xl font-headline mb-8">
        🎲 Aji L3bo
    </div>

    <!-- Admin Info -->
    <div class="flex items-center gap-4 mb-10 p-2">
        <img alt="Admin"
             class="w-12 h-12 rounded-full object-cover"
             src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'Admin') ?>&background=8d4b00&color=fff"/>
        <div>
            <p class="font-headline font-bold text-on-surface">
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>
            </p>
            <p class="text-sm text-on-surface-variant">Café Manager</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="space-y-2 flex-1">
        <?php
        $currentUri = $_SERVER['REQUEST_URI'] ?? '/';

        $navItems = [
            [
                'uri'   => '/dashboard',
                'icon'  => 'dashboard',
                'label' => 'Dashboard',
            ],
            [
                'uri'   => '/games',
                'icon'  => 'casino',
                'label' => 'Inventory',
            ],
            [
                'uri'   => '/sessions',
                'icon'  => 'style',
                'label' => 'Sessions',
            ],
            [
                'uri'   => '/reservations',
                'icon'  => 'event',
                'label' => 'Réservations',
            ],
            [
                'uri'   => '/tables',
                'icon'  => 'chair',
                'label' => 'Tables',
            ],
            [
                'uri'   => '/users',
                'icon'  => 'group',
                'label' => 'Customers',
            ],
        ];

        foreach ($navItems as $item):
            $isActive = str_starts_with($currentUri, $item['uri']);
        ?>
            <a href="<?= $item['uri'] ?>"
               class="flex items-center gap-4 px-4 py-3 mx-2 rounded-xl transition-all duration-200
                      <?= $isActive
                          ? 'bg-[#1b6b51] text-white shadow-lg translate-x-1'
                          : 'text-stone-600 hover:bg-stone-100' ?>">
                <span class="material-symbols-outlined"
                      style="<?= $isActive ? "font-variation-settings: 'FILL' 1;" : '' ?>">
                    <?= $item['icon'] ?>
                </span>
                <span class="font-headline font-medium"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Logout at Bottom -->
    <a href="/logout"
       class="flex items-center gap-4 px-4 py-3 mx-2 rounded-xl text-stone-600 hover:bg-red-50 hover:text-red-600 transition-all duration-200 mt-4">
        <span class="material-symbols-outlined">logout</span>
        <span class="font-headline font-medium">Déconnexion</span>
    </a>

</aside>