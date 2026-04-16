<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="createCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="/categories/store" method="POST">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control"
                            placeholder="Strategy, Party, Family..."
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            rows="3"
                            placeholder="Short description of the category"
                        ></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Save Category
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>