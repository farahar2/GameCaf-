<?php require __DIR__ . '/../layouts/header.php'; ?>

<!-- ========== HERO SECTION ========== -->
<section class="relative min-h-[751px] flex items-center px-6 md:px-16 py-12 overflow-hidden">
    <div class="z-10 max-w-3xl">
        <span class="inline-block px-4 py-1 rounded-full bg-secondary-container text-on-secondary-container text-sm font-semibold mb-6">
            Casablanca's Premier Game Sanctuary
        </span>
        <h1 class="font-headline text-6xl md:text-8xl font-black text-primary leading-[0.9] tracking-tighter mb-4">
            Aji L3bo <br/>
            <span class="text-secondary italic">(اجي نلعبو)</span>
        </h1>
        <p class="text-2xl md:text-3xl font-light text-on-surface-variant mb-10 max-w-xl leading-relaxed">
            Play. Laugh. Repeat. Rediscover the joy of connection over
            Casablanca's finest tabletop collection.
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="/reservations/create"
               class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold text-lg
                      hover:scale-105 transition-transform flex items-center gap-2
                      shadow-xl shadow-primary/20">
                Book a Table
                <span class="material-symbols-outlined">calendar_month</span>
            </a>
            <a href="/games"
               class="bg-surface-container-highest text-primary px-8 py-4 rounded-xl
                      font-bold text-lg hover:bg-surface-container-high transition-colors">
                Explore Catalog
            </a>
        </div>
    </div>

    <!-- Hero Image -->
    <div class="absolute right-0 top-0 w-1/2 h-full hidden lg:block">
        <div class="relative w-full h-full p-12">
            <img alt="Board games in a cafe"
                 class="w-full h-full object-cover rounded-xl shadow-2xl"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuBBbudc9uZCfLv1Tr2o5o32QS0oE-rQzP0kt54ok-A3XP6M3AFs3MgZE4qbJXoE3-qS3dJKb-DiIZXIFZTBSFX8wdGYImzuH4NxxL8EWzu24m_ttwScKCK8zQbq6HYEMCJkyLcA3kYUVNlfWq-LR3vkfLvf3hh4OlLyklI_FleEue5U4onBDkSeQemfZld1KNvzO2vVIIM5Gw5ckx29OER-GrHAOdb-OnfBgUiM5YC6BDt5jwTSmy5rBTaM6lWh9efMidYzyjgrdUAL"/>
            <!-- Review Card -->
            <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-lg shadow-xl max-w-xs">
                <div class="flex gap-2 mb-2">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <span class="material-symbols-outlined text-primary"
                              style="font-variation-settings: 'FILL' 1;">star</span>
                    <?php endfor; ?>
                </div>
                <p class="text-sm font-medium italic">
                    "The warmest atmosphere in Casa. The tea and Catan session was unforgettable!"
                </p>
            </div>
        </div>
    </div>

    <!-- Zellige Pattern Overlay -->
    <div class="absolute top-0 left-0 w-full h-full zellige-pattern pointer-events-none"></div>
</section>

<!-- ========== HOW IT WORKS ========== -->
<section class="py-24 px-6 md:px-16 bg-surface-container-low">
    <div class="text-center mb-16">
        <h2 class="font-headline text-4xl font-bold text-primary mb-4">The Aji L3bo Experience</h2>
        <div class="h-1 w-24 bg-tertiary mx-auto rounded-full"></div>
    </div>

    <div class="grid md:grid-cols-3 gap-12 max-w-6xl mx-auto">
        <?php
        $steps = [
            [
                'icon'  => 'chair',
                'color' => 'primary',
                'bg'    => 'primary-fixed',
                'title' => '1. Grab a Seat',
                'text'  => 'Walk in or reserve a cozy spot in our modern majlis. Comfortable seating designed for long strategy sessions.'
            ],
            [
                'icon'  => 'casino',
                'color' => 'secondary',
                'bg'    => 'secondary-fixed',
                'title' => '2. Pick Your Game',
                'text'  => "Browse our game library. Our 'Game Gurus' are on hand to explain the rules so you can skip the manual."
            ],
            [
                'icon'  => 'coffee',
                'color' => 'tertiary',
                'bg'    => 'tertiary-fixed',
                'title' => '3. Sip & Play',
                'text'  => 'Order artisan Moroccan tea or specialty coffee while you dominate the board. Repeat as needed.'
            ],
        ];

        foreach ($steps as $step):
        ?>
            <div class="text-center group">
                <div class="w-20 h-20 bg-<?= $step['bg'] ?> rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-4xl text-<?= $step['color'] ?>">
                        <?= $step['icon'] ?>
                    </span>
                </div>
                <h3 class="font-headline text-xl font-bold mb-3"><?= $step['title'] ?></h3>
                <p class="text-on-surface-variant"><?= $step['text'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ========== GAMES COLLECTION ========== -->
<section class="py-24 px-6 md:px-16">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
        <div>
            <h2 class="font-headline text-5xl font-black text-primary tracking-tight">Our Collection</h2>
            <p class="text-on-surface-variant mt-2">Curated titles from across the globe</p>
        </div>

        <!-- Category Filters -->
        <div class="flex flex-wrap gap-3">
            <?php
            $categories = ['All Games', 'Strategy', 'Party', 'Family', 'Expert'];
            $currentCategory = $_GET['category'] ?? 'All Games';

            foreach ($categories as $cat):
                $isActive = ($currentCategory === $cat);
                $href = ($cat === 'All Games') ? '/games' : '/games?category=' . urlencode($cat);
            ?>
                <a href="<?= $href ?>"
                   class="px-6 py-2 rounded-full font-medium text-sm transition-colors
                          <?= $isActive
                              ? 'bg-primary text-on-primary'
                              : 'bg-surface-container-highest text-on-surface-variant hover:bg-primary-fixed' ?>">
                    <?= $cat ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Games Grid (Dynamic from Controller) -->
    <?php if (!empty($featuredGames)): ?>
        <div class="editorial-grid">

            <!-- Featured Game (First game, large card) -->
            <?php $featured = $featuredGames[0]; ?>
            <div class="col-span-12 md:col-span-8 group relative overflow-hidden rounded-xl bg-surface-container-lowest h-96">
                <img alt="<?= htmlspecialchars($featured['name']) ?>"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                     src="<?= htmlspecialchars($featured['image_url'] ?? 'https://placehold.co/800x400?text=' . urlencode($featured['name'])) ?>"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-8">
                    <span class="text-secondary-fixed font-bold text-sm tracking-widest uppercase mb-2">
                        <?= htmlspecialchars($featured['category_name'] ?? 'Featured') ?>
                    </span>
                    <h3 class="text-white text-3xl font-black font-headline">
                        <?= htmlspecialchars($featured['name']) ?>
                    </h3>
                    <p class="text-white/80 max-w-md mt-2">
                        <?= htmlspecialchars(substr($featured['description'] ?? '', 0, 120)) ?>...
                    </p>
                    <a href="/games/<?= $featured['id'] ?>"
                       class="inline-block mt-4 bg-white/20 backdrop-blur text-white px-6 py-2 rounded-lg hover:bg-white/30 transition-colors w-fit">
                        View Details →
                    </a>
                </div>
            </div>

            <!-- Other Games (Small cards) -->
            <?php
            $otherGames = array_slice($featuredGames, 1, 3);
            foreach ($otherGames as $game):
            ?>
                <div class="col-span-12 md:col-span-4 bg-surface-container-lowest p-6 rounded-xl flex flex-col justify-between">
                    <div>
                        <div class="w-full aspect-square rounded-lg overflow-hidden mb-6">
                            <img alt="<?= htmlspecialchars($game['name']) ?>"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                 src="<?= htmlspecialchars($game['image_url'] ?? 'https://placehold.co/400x400?text=' . urlencode($game['name'])) ?>"/>
                        </div>

                        <!-- Category Badge -->
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-2
                            <?php
                            $catColors = [
                                'Strategy' => 'bg-blue-100 text-blue-800',
                                'Ambiance' => 'bg-pink-100 text-pink-800',
                                'Family'   => 'bg-green-100 text-green-800',
                                'Expert'   => 'bg-purple-100 text-purple-800',
                            ];
                            echo $catColors[$game['category_name'] ?? ''] ?? 'bg-gray-100 text-gray-800';
                            ?>">
                            <?= htmlspecialchars($game['category_name'] ?? 'Game') ?>
                        </span>

                        <h3 class="font-headline font-bold text-xl">
                            <?= htmlspecialchars($game['name']) ?>
                        </h3>
                        <p class="text-on-surface-variant text-sm mt-2">
                            <?= htmlspecialchars(substr($game['description'] ?? '', 0, 80)) ?>...
                        </p>
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <div class="flex gap-3 text-sm text-on-surface-variant">
                            <span>👥 <?= $game['min_players'] ?>-<?= $game['max_players'] ?></span>
                            <span>⏱️ <?= $game['duration'] ?>min</span>
                        </div>
                        <a href="/games/<?= $game['id'] ?>"
                           class="w-10 h-10 rounded-full bg-primary-fixed text-primary flex items-center justify-center hover:bg-primary hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="/games"
               class="inline-block bg-surface-container-highest text-primary px-8 py-3 rounded-xl font-bold hover:bg-primary-fixed transition-colors">
                View Full Catalog →
            </a>
        </div>
    <?php endif; ?>
</section>

<!-- ========== RESERVATION SECTION ========== -->
<section class="py-24 px-6 md:px-16 bg-surface-container relative overflow-hidden">
    <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-16 items-center">

        <!-- Left: Info -->
        <div>
            <h2 class="font-headline text-5xl font-black text-primary mb-6">Join the Table</h2>
            <p class="text-xl text-on-surface-variant mb-8">
                Our weekends get busy! Secure your spot in the sanctuary
                and we'll have your favorite game waiting.
            </p>

            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Opening Hours</h4>
                        <p class="text-sm text-on-surface-variant">
                            Daily: 14:00 - 00:00 (Weekends until 02:00)
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Location</h4>
                        <p class="text-sm text-on-surface-variant">
                            22 Rue Taha Hussein, Gauthier, Casablanca
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Quick Booking Form -->
        <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl shadow-primary/5">

            <!-- Show errors if any -->
            <?php if (!empty($errors)): ?>
                <div class="bg-error-container text-on-error-container px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/reservations" method="POST" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Date</label>
                        <input type="date"
                               name="reservation_date"
                               min="<?= date('Y-m-d') ?>"
                               value="<?= htmlspecialchars($_POST['reservation_date'] ?? '') ?>"
                               required
                               class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-primary"/>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Time</label>
                        <select name="reservation_time" required
                                class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-primary">
                            <option value="">Select time...</option>
                            <?php
                            $timeSlots = ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00'];
                            foreach ($timeSlots as $slot):
                            ?>
                                <option value="<?= $slot ?>"
                                    <?= ($_POST['reservation_time'] ?? '') === $slot ? 'selected' : '' ?>>
                                    <?= $slot ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Table</label>
                        <select name="table_id" required
                                class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-primary">
                            <option value="">Select table...</option>
                            <?php if (!empty($tables)):
                                foreach ($tables as $table): ?>
                                    <option value="<?= $table['id'] ?>">
                                        Table <?= $table['table_number'] ?> (<?= $table['capacity'] ?> seats)
                                    </option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Guests</label>
                        <input type="number"
                               name="number_of_guests"
                               min="1" max="12"
                               value="<?= htmlspecialchars($_POST['number_of_guests'] ?? '2') ?>"
                               required
                               class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-primary"/>
                    </div>
                </div>

                <!-- Optional Game Selection -->
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        Game (Optional)
                    </label>
                    <select name="game_id"
                            class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-primary">
                        <option value="">No game preference</option>
                        <?php if (!empty($games)):
                            foreach ($games as $game): ?>
                                <option value="<?= $game['id'] ?>">
                                    <?= htmlspecialchars($game['name']) ?>
                                    (👥 <?= $game['min_players'] ?>-<?= $game['max_players'] ?>)
                                </option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-lg
                               hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20">
                    Confirm Reservation
                </button>
            </form>
        </div>

    </div>
</section>

<!-- ========== TESTIMONIALS ========== -->
<section class="py-24 px-6 md:px-16">
    <h2 class="font-headline text-center text-4xl font-bold mb-16">Stories from the Table</h2>

    <div class="flex flex-col md:flex-row gap-8 overflow-x-auto pb-8 snap-x">
        <?php
        $testimonials = [
            [
                'name'  => 'Yassine B.',
                'role'  => 'Regular Strategist',
                'text'  => "The best board game selection in Morocco. The atmosphere is quiet enough to concentrate but lively enough to have a great time.",
                'image' => 'https://ui-avatars.com/api/?name=YB&background=8d4b00&color=fff'
            ],
            [
                'name'  => 'Sofia M.',
                'role'  => 'Tea & Board Game Lover',
                'text'  => "Love the editorial feel of the space. It's a real community hub where you meet new people over games.",
                'image' => 'https://ui-avatars.com/api/?name=SM&background=1b6b51&color=fff'
            ],
            [
                'name'  => 'Omar T.',
                'role'  => 'Expert Player',
                'text'  => "The staff really know their games. They taught us a complex expert game in 10 minutes. Also, the mint tea is top-tier!",
                'image' => 'https://ui-avatars.com/api/?name=OT&background=ad2a27&color=fff'
            ],
        ];

        foreach ($testimonials as $review):
        ?>
            <div class="min-w-[300px] md:min-w-[400px] flex-1 bg-surface-container-lowest p-8 rounded-xl shadow-sm snap-center">
                <div class="flex items-center gap-4 mb-6">
                    <img alt="<?= $review['name'] ?>"
                         class="w-12 h-12 rounded-full object-cover"
                         src="<?= $review['image'] ?>"/>
                    <div>
                        <h4 class="font-bold"><?= $review['name'] ?></h4>
                        <p class="text-xs text-on-surface-variant"><?= $review['role'] ?></p>
                    </div>
                </div>
                <p class="italic text-on-surface-variant leading-relaxed">
                    "<?= $review['text'] ?>"
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>