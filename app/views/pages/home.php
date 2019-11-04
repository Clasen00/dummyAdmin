<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>DummyAdmin</title>
        <link rel="stylesheet" href="/web/css/main.css">
    </head>
    <body>
        <div class="form-wrap">
            <div class="tabs">
                <h3 class="signup-tab"><a class="active" href="#signup-tab-content">Регистрация</a></h3>
                <h3 class="login-tab"><a href="#login-tab-content">Авторизация</a></h3>
            </div><!--.tabs-->

            <div class="tabs-content">
                <div id="signup-tab-content" class="active">
                    <form class="signup-form" action="" method="post" name="reg-form">
                        <input type="email" class="input" id="user_email" autocomplete="off" placeholder="Эл. адрес">
                        <input type="text" class="input" id="first-name" autocomplete="off" placeholder="Имя">
                        <input type="text" class="input" id="second-name" autocomplete="off" placeholder="Фамилия">
                        <input type="password" class="input" id="password" autocomplete="off" placeholder="Пароль">
                        <input type="submit" class="button" value="Регистрация">
                    </form><!--.login-form-->
                </div><!--.signup-tab-content-->

                <div id="login-tab-content">
                    <form class="login-form" action="" method="post" name="login-form">
                        <input type="text" class="input" id="user_login" autocomplete="off" placeholder="Эл. адрес" name="email">
                        <input type="password" class="input" id="user_pass" autocomplete="off" placeholder="Пароль" name="password">
                        <input type="checkbox" class="checkbox" id="remember_me" name='remember'>
                        <label for="remember_me">Запомнить меня</label>

                        <input type="submit" class="button" value="Авторизация">
                    </form><!--.login-form-->
                </div><!--.login-tab-content-->
            </div><!--.tabs-content-->
        </div><!--.form-wrap-->
    </body>
</html>