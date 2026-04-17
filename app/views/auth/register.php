<!DOCTYPE html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle ?? 'Inscription — Aji L3bo') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary":                "#8d4b00",
                        "on-primary":             "#ffffff",
                        "primary-fixed":          "#ffdcc3",
                        "on-primary-fixed":       "#2f1500",
                        "secondary":              "#1b6b51",
                        "secondary-fixed":        "#a6f2d1",
                        "on-secondary-fixed":     "#002116",
                        "secondary-container":    "#a6f2d1",
                        "on-secondary-container": "#237157",
                        "surface-container-low":  "#fff1eb",
                        "surface-container":      "#ffeae1",
                        "surface-container-high": "#ffe2d7",
                        "on-surface":             "#351000",
                        "on-surface-variant":     "#554336",
                        "background":             "#fff8f6",
                        "error":                  "#ba1a1a",
                        "error-container":        "#ffdad6",
                        "on-error-container":     "#93000a",
                        "outline-variant":        "#dbc2b0",
                    },
                    fontFamily: {
                        headline: ["Be Vietnam Pro"],
                        body:     ["Inter"],
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
        .zellige-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 0l5 15h15l-12 9 5 16-13-10-13 10 5-16-12-9h15z' fill='%238d4b00' fill-opacity='0.04'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body class="bg-background font-body text-on-surface min-h-screen">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- ===== Left: Decorative Panel ===== -->
    <div class="hidden lg:flex flex-col justify-between bg-[#1b6b51] text-white p-12 relative overflow-hidden zellige-bg">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                <span class="font-headline font-black text-lg">A</span>
            </div>
            <span class="font-headline text-2xl font-black">Aji L3bo</span>
        </div>

        <!-- Center Content -->
        <div>
            <h1 class="font-headline text-5xl font-black leading-tight mb-6">
                Rejoins<br/>
                <span class="text-secondary-fixed">la communauté!</span>
            </h1>
            <p class="text-white/70 text-lg leading-relaxed max-w-sm">
                Crée ton compte et commence à explorer notre catalogue de plus de 200 jeux de société.
            </p>

            <!-- Benefits -->
            <div class="space-y-4 mt-8">
                <?php
                $benefits = [
                    ['icon' => 'event_available', 'text' => 'Réservez vos tables en ligne'],
                    ['icon' => 'casino',          'text' => 'Accès au catalogue complet'],
                    ['icon' => 'history',         'text' => 'Historique de vos sessions'],
                    ['icon' => 'recommend',       'text' => 'Suggestions personnalisées'],
                ];
                foreach ($benefits as $benefit):
                ?>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-sm"
                                  style="font-variation-settings:'FILL' 1;">
                                <?= $benefit['icon'] ?>
                            </span>
                        </div>
                        <span class="text-white/90 text-sm"><?= $benefit['text'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-3 gap-4">
            <?php
            $stats = [
                ['value' => '200+', 'label' => 'Jeux'],
                ['value' => '6',    'label' => 'Tables'],
                ['value' => '500+', 'label' => 'Membres'],
            ];
            foreach ($stats as $stat):
            ?>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4 text-center">
                    <p class="font-headline text-2xl font-black"><?= $stat['value'] ?></p>
                    <p class="text-white/60 text-xs mt-1"><?= $stat['label'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Decorative -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>

    </div>

    <!-- ===== Right: Register Form ===== -->
    <div class="flex flex-col justify-center px-6 py-12 lg:px-16 xl:px-20 overflow-y-auto">

        <!-- Mobile Logo -->
        <div class="lg:hidden flex items-center gap-3 mb-8">
            <span class="font-headline text-2xl font-black text-primary">🎲 Aji L3bo</span>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="font-headline text-3xl font-extrabold text-on-surface mb-2">
                Rejoins-nous! 🎲
            </h2>
            <p class="text-on-surface-variant">
                Crée ton compte en quelques secondes
            </p>
        </div>

        <!-- Error Message -->
        <?php if (!empty($error)): ?>
            <div class="bg-error-container text-on-error-container px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-sm">error</span>
                <span class="font-bold text-sm"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="register" method="POST" class="space-y-4">

            <!-- Full Name -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Nom Complet *
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        person
                    </span>
                    <input type="text"
                           name="name"
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                           placeholder="Khalid El Amrani"
                           required
                           autofocus
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/30 text-on-surface placeholder:text-on-surface-variant/50"/>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Adresse Email *
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        mail
                    </span>
                    <input type="email"
                           name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           placeholder="khalid@example.com"
                           required
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/30 text-on-surface placeholder:text-on-surface-variant/50"/>
                </div>
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Téléphone
                    <span class="normal-case tracking-normal font-normal text-on-surface-variant ml-1">
                        (optionnel)
                    </span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        phone
                    </span>
                    <input type="tel"
                           name="phone"
                           value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                           placeholder="+212 6XX-XXXXXX"
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/30 text-on-surface placeholder:text-on-surface-variant/50"/>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Mot de Passe *
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        lock
                    </span>
                    <input type="password"
                           name="password"
                           id="password-input"
                           placeholder="Minimum 6 caractères"
                           required
                           minlength="6"
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-12 focus:ring-2 focus:ring-primary/30 text-on-surface"/>
                    <button type="button"
                            id="toggle-password"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm" id="eye-icon">visibility</span>
                    </button>
                </div>

                <!-- Password Strength -->
                <div class="mt-2">
                    <div class="flex gap-1">
                        <div class="h-1 flex-1 rounded-full bg-outline-variant" id="str-1"></div>
                        <div class="h-1 flex-1 rounded-full bg-outline-variant" id="str-2"></div>
                        <div class="h-1 flex-1 rounded-full bg-outline-variant" id="str-3"></div>
                        <div class="h-1 flex-1 rounded-full bg-outline-variant" id="str-4"></div>
                    </div>
                    <p class="text-xs text-on-surface-variant mt-1" id="str-text">
                        Entrez votre mot de passe
                    </p>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Confirmer le Mot de Passe *
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        lock_reset
                    </span>
                    <input type="password"
                           name="confirm_password"
                           id="confirm-input"
                           placeholder="Répétez le mot de passe"
                           required
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/30 text-on-surface"/>
                </div>
                <!-- Match indicator -->
                <p class="text-xs mt-1 hidden" id="match-msg"></p>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined">person_add</span>
                Créer mon Compte
            </button>

        </form>

        <!-- Divider -->
        <div class="flex items-center gap-4 my-6">
            <div class="flex-1 h-px bg-outline-variant"></div>
            <span class="text-xs text-on-surface-variant font-medium">OU</span>
            <div class="flex-1 h-px bg-outline-variant"></div>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-on-surface-variant">
            Déjà un compte?
            <a href="login"
               class="text-primary font-bold hover:underline ml-1">
                Connecte-toi →
            </a>
        </p>

        <!-- Footer -->
        <p class="text-center text-xs text-on-surface-variant mt-6">
            © <?= date('Y') ?> Aji L3bo Café — Casablanca
        </p>

    </div>

</div>

<script>
    // Toggle password visibility
    document.getElementById('toggle-password')?.addEventListener('click', function () {
        const input  = document.getElementById('password-input');
        const icon   = document.getElementById('eye-icon');
        input.type   = input.type === 'password' ? 'text' : 'password';
        icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
    });

    // Password strength meter
    document.getElementById('password-input')?.addEventListener('input', function () {
        const val    = this.value;
        const bars   = [
            document.getElementById('str-1'),
            document.getElementById('str-2'),
            document.getElementById('str-3'),
            document.getElementById('str-4'),
        ];
        const text   = document.getElementById('str-text');

        // Reset
        bars.forEach(b => {
            b.className = 'h-1 flex-1 rounded-full bg-outline-variant';
        });

        let strength = 0;
        if (val.length >= 6)                         strength++;
        if (val.length >= 10)                        strength++;
        if (/[A-Z]/.test(val) && /[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val))               strength++;

        const configs = [
            { color: 'bg-error',     label: 'Très faible',  n: 1 },
            { color: 'bg-yellow-400', label: 'Faible',      n: 2 },
            { color: 'bg-primary',   label: 'Moyen',        n: 3 },
            { color: 'bg-secondary', label: 'Fort 💪',       n: 4 },
        ];

        if (strength > 0) {
            const cfg = configs[strength - 1];
            for (let i = 0; i < cfg.n; i++) {
                bars[i].className = `h-1 flex-1 rounded-full ${cfg.color}`;
            }
            text.textContent = cfg.label;
        } else {
            text.textContent = 'Trop court';
        }
    });

    // Password match indicator
    document.getElementById('confirm-input')?.addEventListener('input', function () {
        const pw  = document.getElementById('password-input').value;
        const msg = document.getElementById('match-msg');
        msg.classList.remove('hidden');

        if (this.value === pw) {
            msg.textContent  = '✓ Les mots de passe correspondent';
            msg.className    = 'text-xs mt-1 text-secondary font-medium';
        } else {
            msg.textContent  = '✗ Les mots de passe ne correspondent pas';
            msg.className    = 'text-xs mt-1 text-error font-medium';
        }
    });
</script>

</body>
</html>