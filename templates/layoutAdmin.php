<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv=content-type>
        <title><?= isset($title) ? $title : 'Pitch & Put' ?></title>

        <link rel="stylesheet" href="css/styleAdmin.css"  type="text/css" />

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
