<footer class="bg-dark text-white mt-5">
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <p class="mb-0">
                © <?= date('Y') ?> GameCafe Management System
            </p>

            <span class="text-muted small">
                Built with PHP MVC & Bootstrap
            </span>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional scripts -->
<script>
    // Example: confirm delete globally
    function confirmDelete(message = "Are you sure you want to delete this item?") {
        return confirm(message);
    }
</script>

</body>
</html>