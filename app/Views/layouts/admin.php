<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameCafé Admin</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    <footer>
        <p>© GameCafé Admin</p>
    </footer>
    <script src="/js/app.js"></script>
</body>
</html>
