<!DOCTYPE html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle ?? 'Connexion — Aji L3bo') ?></title>

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
                        "tertiary":               "#ad2a27",
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
    <div class="hidden lg:flex flex-col justify-between bg-[#2f1500] text-white p-12 relative overflow-hidden zellige-bg">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center">
                <span class="text-primary font-headline font-black text-lg">A</span>
            </div>
            <span class="font-headline text-2xl font-black">Aji L3bo</span>
        </div>

        <!-- Center Content -->
        <div>
            <h1 class="font-headline text-5xl font-black leading-tight mb-6">
                Bienvenue<br/>
                <span class="text-primary-fixed">chez nous!</span>
            </h1>
            <p class="text-white/70 text-lg leading-relaxed max-w-sm">
                Connectez-vous pour réserver vos jeux préférés et vivre une expérience unique à Casablanca.
            </p>

            <!-- Feature Pills -->
            <div class="flex flex-wrap gap-3 mt-8">
                <?php
                $features = ['🎲 200+ Jeux', '☕ Thé Marocain', '🪑 Tables Confortables', '🎯 Tournois'];
                foreach ($features as $feature):
                ?>
                    <span class="bg-white/10 backdrop-blur px-4 py-2 rounded-full text-sm font-medium">
                        <?= $feature ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Testimonial -->
        <div class="bg-white/10 backdrop-blur rounded-2xl p-6">
            <div class="flex gap-1 mb-3">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <span class="material-symbols-outlined text-yellow-400 text-sm"
                          style="font-variation-settings:'FILL' 1;">star</span>
                <?php endfor; ?>
            </div>
            <p class="text-white/90 text-sm italic leading-relaxed">
                "La meilleure ambiance de jeux de société à Casa. Le thé et les jeux, un combo parfait!"
            </p>
            <p class="text-white/50 text-xs mt-3">— Yassine B., Client fidèle</p>
        </div>

        <!-- Decorative circles -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>

    </div>

    <!-- ===== Right: Login Form ===== -->
    <div class="flex flex-col justify-center px-6 py-12 lg:px-16 xl:px-24">

        <!-- Mobile Logo -->
        <div class="lg:hidden flex items-center gap-3 mb-10">
            <span class="font-headline text-2xl font-black text-primary">🎲 Aji L3bo</span>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="font-headline text-3xl font-extrabold text-on-surface mb-2">
                Bon retour! 👋
            </h2>
            <p class="text-on-surface-variant">
                Connecte-toi pour accéder à ton espace
            </p>
        </div>

        <!-- Success Message (after registration) -->
        <?php if (($success ?? null) === 'account_created'): ?>
            <div class="bg-secondary-fixed text-on-secondary-fixed px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">
                    check_circle
                </span>
                <span class="font-bold text-sm">
                    Compte créé avec succès! Connectez-vous maintenant.
                </span>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (!empty($error)): ?>
            <div class="bg-error-container text-on-error-container px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined text-sm">error</span>
                <span class="font-bold text-sm"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="login" method="POST" class="space-y-5">

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Adresse Email
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
                           autofocus
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/30 text-on-surface placeholder:text-on-surface-variant/50"/>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2">
                    Mot de Passe
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        lock
                    </span>
                    <input type="password"
                           name="password"
                           id="password-input"
                           placeholder="••••••••"
                           required
                           class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-12 focus:ring-2 focus:ring-primary/30 text-on-surface"/>
                    <button type="button"
                            id="toggle-password"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm" id="eye-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold text-lg hover:scale-[1.02] transition-transform shadow-lg shadow-primary/20 flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined">login</span>
                Se Connecter
            </button>

        </form>

        <!-- Divider -->
        <div class="flex items-center gap-4 my-6">
            <div class="flex-1 h-px bg-outline-variant"></div>
            <span class="text-xs text-on-surface-variant font-medium">OU</span>
            <div class="flex-1 h-px bg-outline-variant"></div>
        </div>

        <!-- Register Link -->
        <p class="text-center text-sm text-on-surface-variant">
            Pas encore de compte?
            <a href="register"
               class="text-primary font-bold hover:underline ml-1">
                Inscris-toi gratuitement →
            </a>
        </p>

        <!-- Footer -->
        <p class="text-center text-xs text-on-surface-variant mt-8">
            © <?= date('Y') ?> Aji L3bo Café — Casablanca
        </p>

    </div>

</div>

<script>
    // Toggle password visibility
    document.getElementById('toggle-password')?.addEventListener('click', function () {
        const input   = document.getElementById('password-input');
        const icon    = document.getElementById('eye-icon');
        const isText  = input.type === 'text';
        input.type    = isText ? 'password' : 'text';
        icon.textContent = isText ? 'visibility' : 'visibility_off';
    });
</script>

</body>
</html>