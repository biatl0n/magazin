<!--
<H3>Инструкция</H3>
<ol>
    <li>Перейти в WooCommerce->Настройки</li>
    <li>Перейти на вкладки API</li>
    <li>В настройках поставить галочку "Включить REST API"</li>
    <li>Перейти на вкладку "ключи/приложения"</li>
    <li>Добавить ключ</li>
    <li>Заполнить поля (права должны быть на чтение/запись) и сгенерировать ключ API</li>
    <li>Введите пользовательский ключ, секретный код, а так же URL вашего интернет магазина </li>
</ol>

<form name="magazinOptions" method="POST" action="pars.php">
    <H3>Пользовательский ключ</H3>
    <input type="text" name="userKey" value="<?php echo "$simaLand->ck";  ?>" size="40">
    <br>
    <H3>Секретный код</H3>
    <input type="text" name="secretKey" value="<?php echo "$simaLand->cs";  ?>" size="40">
    <br>
    <H3>Адрес вашего интернет магазина</H3>
    <input type="text" name="siteURL" value="<?php echo "$simaLand->siteURL";  ?>" size="40">
    <br>
    <input type="submit" value="Сохранить настройки">
</form>-->

<br>
<p>Введите название родительской категории с сайта Sima-Land.ru</p>
<form name="listCat" method="POST"  action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input type="text" name="catName" size="40">
    <input type="submit" value="Получить список">
</form>
<br>


