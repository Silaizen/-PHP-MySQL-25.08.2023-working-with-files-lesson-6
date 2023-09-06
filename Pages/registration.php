<form method="POST" action="index.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <input type="password" name="password" required minlength="6">
    <label>Repeat Password:</label>
    <input type="password" name="repeat_password" required minlength="6">
    <button type="submit" name="action" value="registerUser">Регистрация</button>
</form>