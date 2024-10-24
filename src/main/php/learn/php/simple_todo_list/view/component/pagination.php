<div class="pagination">
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
    <?php endif; ?>

    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
        <a href="?page=<?php echo $page; ?>" class="<?php echo $page == $currentPage ? 'active' : ''; ?>">
            <?php echo $page;?>
        </a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
    <?php endif; ?>
</div>
