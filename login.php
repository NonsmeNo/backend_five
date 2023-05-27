<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<form action="" method="POST">

<h2>Авторизация</h2>

<div class="fields">
    <div class="item">
        <label for="name">Логин</label><br>
        <input type="text" placeholder="Введите логин" >
    </div>
    <div class="item">
            <label for="email">Пароль</label><br>
            <input type="text" placeholder="Введите пароль">     
    </div>
</div>

  <div>
    <button  type="submit">Войти</button>
  </div>
</form>
</body>


</html>
<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  try {
    $stmt = $db->prepare("SELECT * FROM users_5 where id=?");

    
    $stmt -> execute([$_POST['login']]);
    $row = $stmt->fetch();


    if(password_verify($_POST['pass'],$row["pass"]))
    {
        $_SESSION['login'] = $_POST['login'];  // Если все ок, то авторизуем пользователя.
        
        $_SESSION['uid'] =$row["id"]; // Записываем ID пользователя.
        // Делаем перенаправление.
        header('Location: ./');
    }
   
        
    }
    catch(PDOException $e){
      print('Ошибка при авторизации: ' . $e->getMessage());
      exit();

  }
 
}
