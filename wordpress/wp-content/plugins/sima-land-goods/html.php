<?php
if (isset($_POST['magazinOptions'])){
    $file = __DIR__."/options.ini";
    $current=json_encode($_POST);
    file_put_contents($file, $current);
    header("Location: ".$_SERVER['REQUEST_URI']);
}
?>

<form name="magazinOptions" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>">
    <H3>Пользовательский ключ</H3>
    <input type="text" name="userKey" value="<?php echo "$simaLand->ck";  ?>" size="40">
    <br>
    <H3>Секретный код</H3>
    <input type="text" name="secretKey" value="<?php echo "$simaLand->cs";  ?>" size="40">
    <br>
    <H3>Адрес вашего интернет магазина</H3>
    <input type="text" name="siteURL" value="<?php echo "$simaLand->siteURL";  ?>" size="40">
    <br>
    <input type="submit" value="Сохранить настройки" name="magazinOptions">
</form>

<br>
<H3>Выберите категорию</H3>
<form name="listCat" method="POST"  action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <select name='catName'>
        <option>&nbsp;</option>
    <?php
    foreach ($parentCatsArray as $key => $value){
       echo "<option value='$value->id'>$value->name</option>";
    }?>
    </select><br>
    <input type="submit" value="Получить список">
</form>
<br>


