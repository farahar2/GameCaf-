<!-- Edit Game Modal -->
<div class="modal fade" id="editGameModal<?= $game['id'] ?>" tabindex="-1" aria-labelledby="editGameModalLabel<?= $game['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editGameModalLabel<?= $game['id'] ?>">Edit Game</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="/games/update" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($game['id']) ?>">

                    <div class="row g-3">

                        <!-- Game Name -->
                        <div class="col-md-6">
                            <label for="name<?= $game['id'] ?>" class="form-label">Game Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name<?= $game['id'] ?>"
                                class="form-control"
                                value="<?= htmlspecialchars($game['name']) ?>"
                                required
                            >
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="category_id<?= $game['id'] ?>" class="form-label">Category</label>
                            <select name="category_id" id="category_id<?= $game['id'] ?>" class="form-select" required>
                                <option value="">Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option
                                        value="<?= htmlspecialchars($category['id']) ?>"
                                        <?= $game['category_id'] == $category['id'] ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description<?= $game['id'] ?>" class="form-label">Description</label>
                            <textarea
                                name="description"
                                id="description<?= $game['id'] ?>"
                                class="form-control"
                                rows="4"
                            ><?= htmlspecialchars($game['description']) ?></textarea>
                        </div>

                        <!-- Min Players -->
                        <div class="col-md-3">
                            <label for="min_players<?= $game['id'] ?>" class="form-label">Min Players</label>
                            <input
                                type="number"
                                name="min_players"
                                id="min_players<?= $game['id'] ?>"
                                class="form-control"
                                min="1"
                                value="<?= htmlspecialchars($game['min_players']) ?>"
                                required
                            >
                        </div>

                        <!-- Max Players -->
                        <div class="col-md-3">
                            <label for="max_players<?= $game['id'] ?>" class="form-label">Max Players</label>
                            <input
                                type="number"
                                name="max_players"
                                id="max_players<?= $game['id'] ?>"
                                class="form-control"
                                min="1"
                                value="<?= htmlspecialchars($game['max_players']) ?>"
                                required
                            >
                        </div>

                        <!-- Duration -->
                        <div class="col-md-3">
                            <label for="duration<?= $game['id'] ?>" class="form-label">Duration (min)</label>
                            <input
                                type="number"
                                name="duration"
                                id="duration<?= $game['id'] ?>"
                                class="form-control"
                                min="1"
                                value="<?= htmlspecialchars($game['duration']) ?>"
                                required
                            >
                        </div>

                        <!-- Stock -->
                        <div class="col-md-3">
                            <label for="stock<?= $game['id'] ?>" class="form-label">Stock</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock<?= $game['id'] ?>"
                                class="form-control"
                                min="1"
                                value="<?= htmlspecialchars($game['stock']) ?>"
                            >
                        </div>

                        <!-- Difficulty -->
                        <div class="col-md-6">
                            <label for="difficulty<?= $game['id'] ?>" class="form-label">Difficulty</label>
                            <select name="difficulty" id="difficulty<?= $game['id'] ?>" class="form-select">
                                <option value="easy" <?= $game['difficulty'] === 'easy' ? 'selected' : '' ?>>Easy</option>
                                <option value="medium" <?= $game['difficulty'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                                <option value="hard" <?= $game['difficulty'] === 'hard' ? 'selected' : '' ?>>Hard</option>
                                <option value="expert" <?= $game['difficulty'] === 'expert' ? 'selected' : '' ?>>Expert</option>
                            </select>
                        </div>

                        <!-- Image URL -->
                        <div class="col-md-6">
                            <label for="image_url<?= $game['id'] ?>" class="form-label">Image URL</label>
                            <input
                                type="text"
                                name="image_url"
                                id="image_url<?= $game['id'] ?>"
                                class="form-control"
                                value="<?= htmlspecialchars($game['image_url'] ?? '') ?>"
                                placeholder="https://example.com/image.jpg"
                            >
                        </div>

                        <!-- Availability -->
                        <div class="col-12">
                            <div class="form-check mt-2">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="is_available"
                                    id="is_available<?= $game['id'] ?>"
                                    <?= $game['is_available'] ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="is_available<?= $game['id'] ?>">
                                    Available
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Game</button>
                </div>
            </form>
        </div>
    </div>
</div>