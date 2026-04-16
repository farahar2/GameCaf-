<div class="container py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-1">Game Details</h1>
            <p class="text-muted mb-0">View full information about this board game.</p>
        </div>

        <a href="/games" class="btn btn-outline-secondary">
            Back to Games
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="row g-0">
            <div class="col-md-4">
                <?php if (!empty($game['image_url'])): ?>
                    <img 
                        src="<?= htmlspecialchars($game['image_url']) ?>" 
                        alt="<?= htmlspecialchars($game['name']) ?>" 
                        class="img-fluid rounded-start w-100 h-100 object-fit-cover"
                        style="min-height: 300px;"
                    >
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center bg-light text-muted h-100" style="min-height: 300px;">
                        No Image Available
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-8">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="card-title mb-1"><?= htmlspecialchars($game['name']) ?></h2>
                            <p class="text-muted mb-0">
                                Category: <strong><?= htmlspecialchars($game['category_name']) ?></strong>
                            </p>
                        </div>

                        <?php if ($game['is_available']): ?>
                            <span class="badge bg-success fs-6">Available</span>
                        <?php else: ?>
                            <span class="badge bg-danger fs-6">Unavailable</span>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Players</h6>
                            <p class="mb-0">
                                <?= htmlspecialchars($game['min_players']) ?> - <?= htmlspecialchars($game['max_players']) ?> players
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Duration</h6>
                            <p class="mb-0"><?= htmlspecialchars($game['duration']) ?> minutes</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Difficulty</h6>
                            <p class="mb-0">
                                <span class="badge bg-info text-dark">
                                    <?= htmlspecialchars(ucfirst($game['difficulty'])) ?>
                                </span>
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Stock</h6>
                            <p class="mb-0"><?= htmlspecialchars($game['stock']) ?></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted">Description</h6>
                        <p class="mb-0">
                            <?= !empty($game['description']) ? nl2br(htmlspecialchars($game['description'])) : 'No description available.' ?>
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="/games" class="btn btn-secondary">
                            Back
                        </a>

                        <button
                            type="button"
                            class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editGameModal<?= $game['id'] ?>"
                        >
                            Edit
                        </button>

                        <form action="/games/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this game?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/edit.php'; ?>