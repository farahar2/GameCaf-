<!-- Create Game Modal -->
<div class="modal fade" id="createGameModal" tabindex="-1" aria-labelledby="createGameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="createGameModalLabel">Add New Game</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="/games/store" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        
                        <!-- Game Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Game Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        </div>

                        <!-- Min Players -->
                        <div class="col-md-3">
                            <label for="min_players" class="form-label">Min Players</label>
                            <input type="number" name="min_players" id="min_players" class="form-control" min="1" required>
                        </div>

                        <!-- Max Players -->
                        <div class="col-md-3">
                            <label for="max_players" class="form-label">Max Players</label>
                            <input type="number" name="max_players" id="max_players" class="form-control" min="1" required>
                        </div>

                        <!-- Duration -->
                        <div class="col-md-3">
                            <label for="duration" class="form-label">Duration (min)</label>
                            <input type="number" name="duration" id="duration" class="form-control" min="1" required>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" min="1" value="1">
                        </div>

                        <!-- Difficulty -->
                        <div class="col-md-6">
                            <label for="difficulty" class="form-label">Difficulty</label>
                            <select name="difficulty" id="difficulty" class="form-select">
                                <option value="easy">Easy</option>
                                <option value="medium" selected>Medium</option>
                                <option value="hard">Hard</option>
                                <option value="expert">Expert</option>
                            </select>
                        </div>

                        <!-- Image URL -->
                        <div class="col-md-6">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="text" name="image_url" id="image_url" class="form-control" placeholder="https://example.com/image.jpg">
                        </div>

                        <!-- Availability -->
                        <div class="col-12">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="is_available" id="is_available" checked>
                                <label class="form-check-label" for="is_available">
                                    Available
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Game</button>
                </div>
            </form>
        </div>
    </div>
</div>