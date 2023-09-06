
<h1>Заполните форму</h1>
<form action="process_form.php" method="post">
    <label for="fio">ФИО:</label>
    <input type="text" name="fio" required><br><br>
    
    <label for="password">Пароль:</label>
    <input type="password" name="password" required><br><br>
    
    <label for="disk">Выберите тип диска:</label>
    <select name="disk">
        <option value="CD">CD</option>
        <option value="DVD">DVD</option>
    </select><br><br>
    
    <label>Выберите курсы:</label><br>
    <input type="checkbox" name="courses[]" value="Курсы по фотошопу">Курсы по фотошопу<br>
    <input type="checkbox" name="courses[]" value="Курсы по PHP">Курсы по PHP<br>
    <input type="checkbox" name="courses[]" value="Курсы по Adobe Dreamweaver">Курсы по Adobe Dreamweaver<br><br>
    
    <label for="delivery">Выберите способ доставки:</label><br>
    <input type="radio" name="delivery" value="Самовывоз">Самовывоз<br>
    <input type="radio" name="delivery" value="Доставка">Доставка<br><br>
    
    <label for="address">Адрес доставки:</label>
    <input type="text" name="address"><br><br>
    
    <label for="email">Email:</label>
    <input type="email" name="email" required><br><br>
    
    <input type="submit" value="Отправить">
</form>