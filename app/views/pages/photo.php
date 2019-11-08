<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Просто админ-панель</title>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
        <style>
            <?= file_get_contents(PROJECT . '/web/css/photo.css'); ?>
        </style>
    </head>
    <body>
        <header role="banner">
            <h1>Просто админ-панель</h1>
            <ul class="utilities">
                <li class="users"><a href="#"><?= $currentUser['first_name'] . ' ' . $currentUser['second_name'] ?></a></li>
                <li class="logout warn"><a href="/index/?needlogout=1">Выход</a></li>
            </ul>
        </header>

        <nav role="navigation">
            <ul class="main">
                <li class="dashboard"><a href="/photos">Главная</a></li>
            </ul>
        </nav>

        <main role="main">

            <section class="panel important">
                <h2>Загрузить фотографии</h2>
                
            </section>

        </main>
    </body>
</html>