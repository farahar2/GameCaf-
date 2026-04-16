</main>

<!-- Footer -->
<footer class="bg-inverse-surface text-inverse-on-surface py-16 px-6 md:px-16">
    <div class="max-w-6xl mx-auto grid md:grid-cols-4 gap-12">

        <!-- Brand -->
        <div class="col-span-2">
            <h2 class="font-headline text-3xl font-black mb-6">Aji L3bo</h2>
            <p class="text-inverse-on-surface/70 max-w-sm mb-8">
                Bringing the classic majlis into the 21st century.
                Join Casablanca's growing tabletop community.
            </p>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                    <span class="material-symbols-outlined text-sm">share</span>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                    <span class="material-symbols-outlined text-sm">photo_camera</span>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                    <span class="material-symbols-outlined text-sm">location_on</span>
                </a>
            </div>
        </div>

        <!-- Visit Us -->
        <div>
            <h4 class="font-bold mb-6 text-primary-fixed">Visit Us</h4>
            <address class="not-italic text-sm space-y-4 text-inverse-on-surface/80">
                <p>22 Rue Taha Hussein<br/>Gauthier, Casablanca<br/>Morocco</p>
                <p>+212 522-123456</p>
                <p>hello@ajil3bo.ma</p>
            </address>
        </div>

        <!-- Quick Links -->
        <div>
            <h4 class="font-bold mb-6 text-primary-fixed">Quick Links</h4>
            <ul class="text-sm space-y-4 text-inverse-on-surface/80">
                <li><a href="/games" class="hover:text-white transition-colors">Game Library</a></li>
                <li><a href="/reservations/create" class="hover:text-white transition-colors">Book a Table</a></li>
                <li><a href="/tables" class="hover:text-white transition-colors">Our Tables</a></li>
            </ul>
        </div>

    </div>

    <div class="mt-16 pt-8 border-t border-white/10 text-center text-xs text-inverse-on-surface/40">
        © <?= date('Y') ?> Aji L3bo Café. Made with passion in Casablanca.
    </div>
</footer>

<!-- Bottom NavBar (Mobile only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-white/80 backdrop-blur-xl shadow-[0_-4px_30px_rgba(53,16,0,0.05)] rounded-t-3xl">
    <?php
    $mobileNav = [
        ['uri' => '/',      'icon' => 'home',      'label' => 'Home'],
        ['uri' => '/games', 'icon' => 'grid_view',  'label' => 'Catalog'],
        ['uri' => '/reservations/create', 'icon' => 'event', 'label' => 'Book'],
        ['uri' => '/reservations/my',     'icon' => 'person', 'label' => 'Profile'],
    ];

    foreach ($mobileNav as $item):
        $isActive = ($currentUri ?? '/') === $item['uri'];
    ?>
        <a href="<?= $item['uri'] ?>"
           class="flex flex-col items-center justify-center px-4 py-1 transition-all duration-200
                  <?= $isActive
                      ? 'bg-[#ffdbcc] text-[#8d4b00] rounded-2xl'
                      : 'text-stone-500 hover:bg-[#fff1eb]' ?>">
            <span class="material-symbols-outlined"><?= $item['icon'] ?></span>
            <span class="font-body text-xs font-medium"><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<!-- Add bottom padding for mobile nav -->
<div class="md:hidden h-20"></div>

</body>
</html>