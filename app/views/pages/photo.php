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
                <div class="wrap">
                    <!--Print mixin-->
                    <form action="#" id="photoLoadForm" method="post" name="photosForm" enctype="multipart/form-data">
                        <div class="upload upload">
                            <div class="upload__wrap" id="previewWrapp">
                                <div class="upload__btn">
                                    <input class="upload__input" id="uploadPhotos" type="file" name="upload[]" multiple="multiple" data-max-count="4" accept="image/*" />
                                </div>
                            </div>
                            <div class="upload__mess">
                                <!--<p class="count_img">Максимальное число фотографий:<strong class="count_img_var">8</strong></p>-->
                                <p class="size_img">Максимальный размер фотографии:<strong class="size_img_var">5 Mb</strong></p>
                                <p class="file_types">Разрешенные типы файлов:<strong class="file_types_var">jpg, png, jpeg, gif</strong></p>
                            </div>
                        </div>
                        <input type="submit" id="submitPhotos" value="Отправить" />
                    </form>
                </div>
            </section>

        </main>
        <script type="text/javascript">
             <?= file_get_contents(ROOT . '/dummyAdmin/web/js/photoredactor.js'); ?>
        </script>
    </body>
</html>