<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aji L3bo Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 fw-bold text-primary">Login</h3>

                    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'account_created'): ?>
                        <div class="alert alert-success py-2 small">Account created! Please log in.</div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form action="index.php?action=login" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                    </form>

                    <hr class="my-4 text-muted">

                    <div class="text-center">
                        <p class="small mb-0">Don't have an account? <a href="index.php?action=register" class="text-decoration-none">Create one</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>