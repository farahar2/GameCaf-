<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameCafé</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <header>
        <h1>GameCafé</h1>
    </header>
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    <footer>
        <p>© GameCafé</p>
    </footer>
    <script src="/js/app.js"></script>
</body>
</html>
