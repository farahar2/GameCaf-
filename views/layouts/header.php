<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($pageTitle ?? 'Aji L3bo Café') ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-surface": "#51230a",
                        "on-error-container": "#93000a",
                        "surface-tint": "#904d00",
                        "inverse-on-surface": "#ffede6",
                        "on-secondary-fixed-variant": "#00513b",
                        "on-background": "#351000",
                        "surface-container-highest": "#ffdbcc",
                        "surface-variant": "#ffdbcc",
                        "tertiary-fixed-dim": "#ffb4ac",
                        "secondary-fixed-dim": "#8bd6b6",
                        "on-tertiary": "#ffffff",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#a6f2d1",
                        "primary-fixed": "#ffdcc3",
                        "tertiary-fixed": "#ffdad6",
                        "primary-fixed-dim": "#ffb77d",
                        "tertiary": "#ad2a27",
                        "primary-container": "#b15f00",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#fff1eb",
                        "background": "#fff8f6",
                        "on-tertiary-container": "#fffbff",
                        "surface-container": "#ffeae1",
                        "on-secondary-container": "#237157",
                        "secondary-container": "#a6f2d1",
                        "on-primary-container": "#fffbff",
                        "on-tertiary-fixed-variant": "#8e1214",
                        "on-secondary-fixed": "#002116",
                        "on-surface": "#351000",
                        "tertiary-container": "#cf433c",
                        "on-primary": "#ffffff",
                        "outline": "#887364",
                        "surface-dim": "#ffd0bc",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#ffe2d7",
                        "on-error": "#ffffff",
                        "on-primary-fixed-variant": "#6e3900",
                        "secondary": "#1b6b51",
                        "inverse-primary": "#ffb77d",
                        "primary": "#8d4b00",
                        "on-tertiary-fixed": "#410002",
                        "on-primary-fixed": "#2f1500",
                        "surface-bright": "#fff8f6",
                        "outline-variant": "#dbc2b0",
                        "on-surface-variant": "#554336",
                        "surface": "#fff8f6"
                    },
                    borderRadius: {
                        DEFAULT: "1rem",
                        lg: "2rem",
                        xl: "3rem",
                        full: "9999px"
                    },
                    fontFamily: {
                        headline: ["Be Vietnam Pro"],
                        body: ["Inter"],
                        label: ["Inter"]
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .zellige-pattern {
            background-color: transparent;
            background-image: radial-gradient(#8d4b00 0.5px, transparent 0.5px),
                              radial-gradient(#8d4b00 0.5px, #fff8f6 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.05;
        }
        .editorial-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body selection:bg-primary-fixed selection:text-on-primary-fixed">

<!-- TopAppBar / Navbar -->
<header class="flex justify-between items-center px-6 py-4 w-full z-50 bg-[#fff8f6] top-0 sticky">

    <!-- Logo -->
    <div class="flex items-center gap-3">
        <?php if (!empty($_SESSION['user_id'])): ?>
            <div class="w-10 h-10 rounded-full overflow-hidden bg-surface-container">
                <img alt="User profile"
                     class="w-full h-full object-cover"
                     src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=8d4b00&color=fff"/>
            </div>
        <?php endif; ?>
        <a href="/" class="text-2xl font-bold text-[#8d4b00] font-headline tracking-tight">
            Aji L3bo
        </a>
    </div>

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex gap-8 items-center">
        <?php
        // Determine current page for active state
        $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
        $navItems = [
            '/'      => 'Home',
            '/games' => 'Catalog',
            '/reservations/create' => 'Book',
        ];

        // Add admin/client specific links
        if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $navItems['/dashboard'] = 'Dashboard';
        }
        if (!empty($_SESSION['user_id'])) {
            $navItems['/reservations/my'] = 'My Bookings';
        }

        foreach ($navItems as $uri => $label):
            $isActive = ($currentUri === $uri);
        ?>
            <a href="<?= $uri ?>"
               class="<?= $isActive
                   ? 'text-[#8d4b00] font-bold'
                   : 'text-stone-500 hover:text-[#8d4b00]' ?>
                   font-headline tracking-tight hover:scale-102 transition-transform duration-200">
                <?= $label ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Right Side: Login/Profile -->
    <div class="flex items-center gap-4">
        <?php if (!empty($_SESSION['user_id'])): ?>
            <span class="hidden md:inline text-sm text-on-surface-variant">
                <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
            </span>
            <a href="/logout"
               class="text-[#8d4b00] active:scale-95 duration-150 ease-in-out">
                <span class="material-symbols-outlined text-2xl">logout</span>
            </a>
        <?php else: ?>
            <a href="/login"
               class="hidden md:inline-block text-[#8d4b00] font-bold hover:scale-102 transition-transform">
                Login
            </a>
            <a href="/register"
               class="hidden md:inline-block bg-primary text-on-primary px-6 py-2 rounded-xl font-bold hover:scale-105 transition-transform">
                Sign Up
            </a>
        <?php endif; ?>
    </div>
</header>

<main class="relative">