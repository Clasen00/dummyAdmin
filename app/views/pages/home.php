<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>DummyAdmin</title>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
        <style>
            <?= file_get_contents(PROJECT . '/web/css/main.css'); ?>
        </style>
    </head>
    <body>
        <div class="form-wrap">
            <div class="tabs">
                <h3 class="signup-tab"><a class="active" href="#signup-tab-content">Регистрация</a></h3>
                <h3 class="login-tab"><a href="#login-tab-content">Авторизация</a></h3>
            </div><!--.tabs-->

            <div class="tabs-content">
                <div id="signup-tab-content" class="active">
                    <form class="auth-form" id="regForm" method="post" name="reg-form">
                        <input type="email" required="" autocomplete="on" class="input" id="user_email" placeholder="Эл. адрес" name="email">
                        <input type="text" required autocomplete="on" class="input" id="first-name" placeholder="Имя" name="firstName">
                        <input type="text" class="input" autocomplete="on" id="second-name" placeholder="Фамилия" name="secondName">
                        <input type="checkbox" class="checkbox hidden" id="need-show-pass-reg" class="need-show-pass">
                        <label class="show-pass-reg" data-show='true' for="need-show-pass-reg" title="Показать пароль"></label>
                        <input type="password" required class="input password" id="password" autocomplete="off" placeholder="Пароль" name="password">
                        
                        <input id="regUser" type="submit" class="button" value="Регистрация">
                    </form><!--.login-form-->
                    <div id="regFormEmpty" class="form-warning hidden">Пожалуйста, заполните форму регистрации!</div>
                    <div id="regFormNotFull" class="form-warning hidden"></div>
                    <?php if($dontRegisterd): ?>
                        <div class="form-warning">Что то пошло не так во время регистрации, попробуйте еще раз!</div>
                    <?php endif; ?>
                </div><!--.signup-tab-content-->

                <div id="login-tab-content">
                    <form class="login-form" id="authForm" method="post" name="login-form">
                        <input type="text" autocomplete="on" required class="input" id="user_login" placeholder="Эл. адрес" name="email">
                        <input type="checkbox" class="checkbox hidden" id="need-show-pass-auth" class="need-show-pass">
                        <label class="show-pass-auth" data-show='true' for="need-show-pass-auth" title="Показать пароль"></label>
                        <input type="password" required autocomplete="on" class="input password" id="user_pass" placeholder="Пароль" name="password">
                        <input type="checkbox" class="checkbox" id="remember_me" name='remember'>
                        <label for="remember_me">Запомнить меня</label>

                        <input id="authUser" type="submit" class="button" value="Авторизация">
                    </form><!--.login-form-->
                </div><!--.login-tab-content-->
            </div><!--.tabs-content-->
            <div id="authFormEmpty" class="form-warning hidden">Пожалуйста, заполните форму авторизации!</div>
            <div id="authFormNotFull" class="form-warning hidden"></div>
        </div><!--.form-wrap-->
         <script type="text/javascript">
             <?= file_get_contents(ROOT . '/dummyAdmin/web/js/auth.js'); ?>
         </script>
    </body>
</html>