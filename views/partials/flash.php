<?php
$app = $GLOBALS['app'] ?? null;

$flash = $app?->flash->pull();

if ($flash):
?>
    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> shadow-sm" role="alert">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>
