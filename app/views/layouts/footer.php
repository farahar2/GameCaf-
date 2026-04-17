</main>

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="bg-inverse-surface text-inverse-on-surface py-16 px-6 md:px-16 mt-auto">
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            <!-- Brand Column -->
            <div class="md:col-span-2">
                <h2 class="font-headline text-2xl font-black mb-3">
                    🎲 Aji L3bo Café
                </h2>
                <p class="text-inverse-on-surface/70 max-w-sm text-sm leading-relaxed mb-6">
                    Casablanca's premier board game café. Join our growing tabletop community
                    and rediscover the joy of play over Moroccan tea.
                </p>

                <!-- Social Links -->
                <div class="flex gap-3">
                    <?php
                    $socials = [
                        ['icon' => 'photo_camera', 'label' => 'Instagram'],
                        ['icon' => 'share',         'label' => 'Facebook'],
                        ['icon' => 'location_on',   'label' => 'Maps'],
                    ];
                    foreach ($socials as $social):
                    ?>
                        <a href="#"
                           title="<?= $social['label'] ?>"
                           class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-sm"><?= $social['icon'] ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Visit Us -->
            <div>
                <h4 class="font-bold mb-5 text-primary-fixed text-sm uppercase tracking-wider">
                    Nous Trouver
                </h4>
                <address class="not-italic text-sm space-y-3 text-inverse-on-surface/70">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-sm mt-0.5 flex-shrink-0">location_on</span>
                        <p>22 Rue Taha Hussein<br/>Gauthier, Casablanca<br/>Maroc</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">phone</span>
                        <a href="tel:+212522123456" class="hover:text-white transition-colors">
                            +212 522-123456
                        </a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">mail</span>
                        <a href="mailto:hello@ajil3bo.ma" class="hover:text-white transition-colors">
                            hello@ajil3bo.ma
                        </a>
                    </div>
                </address>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-bold mb-5 text-primary-fixed text-sm uppercase tracking-wider">
                    Navigation
                </h4>
                <ul class="text-sm space-y-3 text-inverse-on-surface/70">
                    <?php
                    $footerLinks = [
                        '/games'               => 'Catalogue de Jeux',
                        '/reservations/create' => 'Réserver une Table',
                        '/login'               => 'Connexion',
                        '/register'            => 'Créer un Compte',
                    ];

                    // Adjust links if logged in
                    if (!empty($_SESSION['user_id'])) {
                        $footerLinks = [
                            '/games'             => 'Catalogue de Jeux',
                            '/reservations/create' => 'Réserver une Table',
                            '/reservations/my'   => 'Mes Réservations',
                            '/logout'            => 'Déconnexion',
                        ];
                    }

                    foreach ($footerLinks as $uri => $label):
                    ?>
                        <li>
                            <a href="<?= $uri ?>"
                               class="hover:text-white transition-colors flex items-center gap-1 group">
                                <span class="material-symbols-outlined text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                    arrow_forward
                                </span>
                                <?= $label ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Opening Hours -->
                <div class="mt-6 pt-5 border-t border-white/10">
                    <h5 class="font-bold text-xs uppercase tracking-wider text-primary-fixed mb-3">
                        Horaires
                    </h5>
                    <div class="space-y-1 text-xs text-inverse-on-surface/60">
                        <div class="flex justify-between">
                            <span>Lun - Jeu</span>
                            <span>14:00 - 00:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ven - Sam</span>
                            <span>14:00 - 02:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Dimanche</span>
                            <span>14:00 - 00:00</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-inverse-on-surface/40">
                © <?= date('Y') ?> Aji L3bo Café. Fait avec ❤️ à Casablanca.
            </p>
            <div class="flex gap-4 text-xs text-inverse-on-surface/40">
                <a href="#" class="hover:text-white transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-white transition-colors">Conditions</a>
                <a href="#" class="hover:text-white transition-colors">Contact</a>
            </div>
        </div>

    </div>
</footer>

<!-- ============================================================
     MOBILE BOTTOM NAVIGATION
     ============================================================ -->
<?php
// Determine which mobile nav to show
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
$isAdmin    = !empty($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isLoggedIn = !empty($_SESSION['user_id']);

if ($isAdmin):
    $mobileNav = [
        ['uri' => '/dashboard/admin', 'icon' => 'dashboard',      'label' => 'Dashboard'],
        ['uri' => '/games',           'icon' => 'casino',           'label' => 'Jeux'],
        ['uri' => '/sessions',        'icon' => 'style',            'label' => 'Sessions'],
        ['uri' => '/reservations',    'icon' => 'event',            'label' => 'Réservations'],
    ];
elseif ($isLoggedIn):
    $mobileNav = [
        ['uri' => '/',                    'icon' => 'home',      'label' => 'Accueil'],
        ['uri' => '/games',               'icon' => 'grid_view',  'label' => 'Catalogue'],
        ['uri' => '/reservations/create', 'icon' => 'event',      'label' => 'Réserver'],
        ['uri' => '/reservations/my',     'icon' => 'person',     'label' => 'Mes Rés.'],
    ];
else:
    $mobileNav = [
        ['uri' => '/',        'icon' => 'home',      'label' => 'Accueil'],
        ['uri' => '/games',   'icon' => 'grid_view',  'label' => 'Catalogue'],
        ['uri' => '/login',   'icon' => 'login',      'label' => 'Connexion'],
        ['uri' => '/register','icon' => 'person_add', 'label' => 'Inscription'],
    ];
endif;
?>

<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php foreach ($mobileNav as $item):
        $isActive = str_starts_with($currentUri, $item['uri'])
                    && !($item['uri'] === '/' && $currentUri !== '/');
    ?>
        <a href="<?= $item['uri'] ?>"
           class="flex flex-col items-center justify-center px-3 py-1 rounded-2xl transition-all duration-200
                  <?= $isActive
                      ? 'bg-[#ffdbcc] text-[#8d4b00]'
                      : 'text-stone-500 hover:bg-[#fff1eb]' ?>">
            <span class="material-symbols-outlined"
                  style="<?= $isActive ? "font-variation-settings:'FILL' 1;" : '' ?>">
                <?= $item['icon'] ?>
            </span>
            <span class="text-xs font-medium"><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<!-- Spacer for mobile nav -->
<div class="md:hidden h-20"></div>

</body>
</html>