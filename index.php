<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"><title>Container Interop Experiments</title>
</head>
<body style="margin: 30px;">
<ul>
    <?php foreach (glob('experiment-*', GLOB_ONLYDIR) as $dir) : ?>
    <li><a href="/<?= $dir ?>/"><?= ucwords(str_replace('-', ' ', $dir)) ?></a></li>
    <?php endforeach ?>
</ul>
</body>
</html>
