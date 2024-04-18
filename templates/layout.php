<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv=content-type>
        <title><?= isset($title) ? $title : 'Pitchgolf' ?></title>

        <link href="css/style.css" rel="stylesheet"  type="text/css" />
        <link href="css/menu.css" rel="stylesheet"  type="text/css" />
        <?= isset($lienCss) ? $lienCss : "" ?>

<!-- https://www.w3.org/Style/Examples/007/menus.fr.html -->
    </head>

    <header>
        <?= isset($header) ? $header : "" ?>
    </header>

    <nav>
<?= isset($nav) ? $nav : "" ?>
    </nav>

    <body>
        <?= $content ?>
    </body>

</html>
