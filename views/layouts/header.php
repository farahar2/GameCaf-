<!DOCTYPE html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle ?? 'Aji L3bo Café') ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,700;0,800;0,900;1,400&family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
          rel="stylesheet"/>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-surface":              "#51230a",
                        "on-error-container":           "#93000a",
                        "surface-tint":                 "#904d00",
                        "inverse-on-surface":           "#ffede6",
                        "on-secondary-fixed-variant":   "#00513b",
                        "on-background":                "#351000",
                        "surface-container-highest":    "#ffdbcc",
                        "surface-variant":              "#ffdbcc",
                        "tertiary-fixed-dim":           "#ffb4ac",
                        "secondary-fixed-dim":          "#8bd6b6",
                        "on-tertiary":                  "#ffffff",
                        "error":                        "#ba1a1a",
                        "secondary-fixed":              "#a6f2d1",
                        "primary-fixed":                "#ffdcc3",
                        "tertiary-fixed":               "#ffdad6",
                        "primary-fixed-dim":            "#ffb77d",
                        "tertiary":                     "#ad2a27",
                        "primary-container":            "#b15f00",
                        "error-container":              "#ffdad6",
                        "surface-container-low":        "#fff1eb",
                        "background":                   "#fff8f6",
                        "on-tertiary-container":        "#fffbff",
                        "surface-container":            "#ffeae1",
                        "on-secondary-container":       "#237157",
                        "secondary-container":          "#a6f2d1",
                        "on-primary-container":         "#fffbff",
                        "on-tertiary-fixed-variant":    "#8e1214",
                        "on-secondary-fixed":           "#002116",
                        "on-surface":                   "#351000",
                        "tertiary-container":           "#cf433c",
                        "on-primary":                   "#ffffff",
                        "outline":                      "#887364",
                        "surface-dim":                  "#ffd0bc",
                        "on-secondary":                 "#ffffff",
                        "surface-container-lowest":     "#ffffff",
                        "surface-container-high":       "#ffe2d7",
                        "on-error":                     "#ffffff",
                        "on-primary-fixed-variant":     "#6e3900",
                        "secondary":                    "#1b6b51",
                        "inverse-primary":              "#ffb77d",
                        "primary":                      "#8d4b00",
                        "on-tertiary-fixed":            "#410002",
                        "on-primary-fixed":             "#2f1500",
                        "surface-bright":               "#fff8f6",
                        "outline-variant":              "#dbc2b0",
                        "on-surface-variant":           "#554336",
                        "surface":                      "#fff8f6",
                    },
                    borderRadius: {
                        DEFAULT: "1rem",
                        lg:      "2rem",
                        xl:      "3rem",
                        full:    "9999px",
                    },
                    fontFamily: {
                        headline: ["Be Vietnam Pro"],
                        body:     ["Inter"],
                        label:    ["Inter"],
                    },
                },
            },
        }
    </script>

    <style>
        /* Material Symbols */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        /* Zellige Pattern */
        .zellige-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 0l5 15h15l-12 9 5 16-13-10-13 10 5-16-12-9h15z' fill='%238d4b00' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        /* Hide scrollbar but keep scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body selection:bg-primary-fixed selection:text-on-primary-fixed">

<!-- ============================================================
     TOP APP BAR
     ============================================================ -->
<header class="sticky top-0 z-50 bg-[#fff8f6]/95 backdrop-blur-md border-b border-outline-variant/10">
    <div class="flex justify-between items-center px-6 py-4">

        <!-- Left: Logo -->
        <div class="flex items-center gap-3">

            <?php if (!empty($_SESSION['user_id'])): ?>
                <!-- User Avatar -->
                <div class="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center font-headline font-bold text-on-primary-fixed text-sm flex-shrink-0">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
            <?php endif; ?>

            <a href="/"
               class="font-headline text-xl font-bold text-[#8d4b00] tracking-tight leading-tight">
                Aji L3bo
            </a>

        </div>

        <!-- Center: Desktop Navigation (Public only) -->
        <?php if (empty($_SESSION['user_id'])): ?>
            <nav class="hidden md:flex gap-8 items-center">
                <?php
                $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
                $publicNav  = [
                    '/'      => 'Accueil',
                    '/games' => 'Catalogue',
                ];
                foreach ($publicNav as $uri => $label):
                    $isActive = ($currentUri === $uri);
                ?>
                    <a href="<?= $uri ?>"
                       class="font-headline tracking-tight transition-all duration-200 hover:scale-102
                              <?= $isActive
                                  ? 'text-[#8d4b00] font-bold'
                                  : 'text-stone-500 hover:text-[#8d4b00]' ?>">
                        <?= $label ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

        <!-- Right: Auth / User Actions -->
        <div class="flex items-center gap-3">

            <?php if (!empty($_SESSION['user_id'])): ?>

                <!-- Logged In -->
                <span class="hidden md:inline text-sm text-on-surface-variant font-medium">
                    <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
                </span>

                <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/dashboard/admin"
                       class="hidden md:inline-block bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-bold hover:scale-105 transition-transform">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="/reservations/my"
                       class="hidden md:inline-block text-primary text-sm font-bold hover:underline">
                        Mes Réservations
                    </a>
                <?php endif; ?>

                <a href="/logout"
                   class="text-on-surface-variant hover:text-error transition-colors"
                   title="Déconnexion">
                    <span class="material-symbols-outlined text-2xl">logout</span>
                </a>

            <?php else: ?>

                <!-- Not Logged In -->
                <a href="/login"
                   class="hidden md:inline-block text-[#8d4b00] font-bold text-sm hover:underline">
                    Connexion
                </a>
                <a href="/register"
                   class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-bold text-sm hover:scale-105 transition-transform shadow-md shadow-primary/20">
                    S'inscrire
                </a>

            <?php endif; ?>

        </div>

    </div>
</header>

<main class="relative">