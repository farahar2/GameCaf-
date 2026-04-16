<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aji L3bo Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 fw-bold text-primary">Register</h3>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form action="index.php?action=register" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="06XXXXXXXX">
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Confirm</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Create Account</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="small mb-0 text-muted">Already a member? <a href="index.php?action=login" class="text-decoration-none">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>