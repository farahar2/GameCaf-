<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Games Management</h1>
            <p class="text-muted mb-0">Manage the board games available in the café.</p>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGameModal">
            Add New Game
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="/games" class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Search by game name or description"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option
                                value="<?= htmlspecialchars($category['id']) ?>"
                                <?= (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Games Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?php if (!empty($games)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Players</th>
                                <th>Duration</th>
                                <th>Difficulty</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($games as $game): ?>
                                <tr>
                                    <td><?= htmlspecialchars($game['id']) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($game['name']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($game['category_name']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($game['min_players']) ?>
                                        -
                                        <?= htmlspecialchars($game['max_players']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($game['duration']) ?> min</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?= htmlspecialchars(ucfirst($game['difficulty'])) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($game['stock']) ?></td>
                                    <td>
                                        <?php if ($game['is_available']): ?>
                                            <span class="badge bg-success">Available</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Unavailable</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="/games/show?id=<?= htmlspecialchars($game['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editGameModal<?= $game['id'] ?>"
                                            >
                                                Edit
                                            </button>

                                            <form action="/games/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this game?');">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <?php require __DIR__ . '/edit.php'; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h5 class="mb-2">No games found</h5>
                    <p class="text-muted">Try another search or add a new game.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/create.php'; ?>