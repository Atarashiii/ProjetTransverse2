<?php include 'header.php'; ?>

    <main>
        <ul>
            <?php foreach ($endpoints as $name => $url): ?>
                <li><strong><?= $name ?>:</strong> <a href="<?= $url ?>" target="_blank"><?= $url ?></a></li>
            <?php endforeach; ?>
        </ul>
    </main>

<?php include 'footer.php'; ?>