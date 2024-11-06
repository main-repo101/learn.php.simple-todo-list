<?php
$TITLE = isset($TITLE)? $TITLE : "<unknown-to-do-list>";
?>


<?php if (isset($status) && $status['code'] !== 0): ?>
    <div class="pnl-note-error">
        <h3 class="lbl-note-error connectivity">
            <?= $status['message'] ?? '' ?>
        </h3>
    </div>
<?php endif; ?>
<h1>🌱 <?=$TITLE?> 🌱</h1>