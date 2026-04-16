<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Categories Management</h1>
            <p class="text-muted mb-0">Manage game categories for the café.</p>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createCategoryModal"
        >
            Add Category
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?php if (!empty($categories)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['id']) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($category['name']) ?></strong>
                                    </td>
                                    <td>
                                        <?php if (!empty($category['description'])): ?>
                                            <?= htmlspecialchars($category['description']) ?>
                                        <?php else: ?>
                                            <span class="text-muted">No description</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($category['created_at']) ?></td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a
                                                href="/categories/show?id=<?= htmlspecialchars($category['id']) ?>"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="/categories/edit?id=<?= htmlspecialchars($category['id']) ?>"
                                                class="btn btn-sm btn-warning"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="/categories/delete"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');"
                                            >
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h5 class="mb-2">No categories found</h5>
                    <p class="text-muted">Start by adding your first category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/create.php'; ?>