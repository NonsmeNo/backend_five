<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  
   $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);//удаление
    $messages[] = '<div class="saves">Спасибо, результаты сохранены!</div>';
  }

  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['agree'] = !empty($_COOKIE['agree_error']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);
  $errors['birth'] = !empty($_COOKIE['birth_error']);

  
  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Имя не может быть пустым, должно содержать только буквы, начинаться с заглавной буквы и не должнно содержать пробелы</div>';
  }
  
  if ($errors['email']) {
    setcookie('email_error', '', 100000);

    $messages[] = '<div class="error">Введен пустой или некорректный E-mail. E-mail может содержать только латинские буквы, цифры, а также символы - _ .</div>';
  }

  if ($errors['biography']) {
    setcookie('biography_error', '', 100000);

    $messages[] = '<div class="error">Добавьте вашу биографию</div>';
  }

  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);

    $messages[] = '<div class="error">Выберите пол</div>';
  }

  if ($errors['birth']) {
    setcookie('birth_error', '', 100000);

    $messages[] = '<div class="error">Дата рождения не может быть пустой, она должна быть меньше нынешней даты, и год должен быть не меньше 1900</div>';
  }

  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100000);

    $messages[] = '<div class="error">Выберите число конечностей</div>';
  }

  if ($errors['ability']) {
    setcookie('ability_error', '', 100000);

    $messages[] = '<div class="error">Выберите сверхспособности</div>';
  }

  if ($errors['agree']) {

    $messages[] = '<div class="error">Вы не ознакомились с контрактом</div>';
    setcookie('agree_error', '', 100000);

  }

  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];
  $values['birth'] = empty($_COOKIE['birth_value']) ? '' : ($_COOKIE['birth_value']);


  $values['ability'] = empty($_COOKIE['ability_value']) ?  array() : unserialize($_COOKIE['ability_value']);



  include('form.php');
}

//-----------------------------------------------------------------------------------------
// Иначе если POST (нужно проверить данные на пустоту или правильный ввод и сохранить их в файл)

else {

  // 1) Проверяем ошибки

  $errors = FALSE;
  if (empty($_POST['name']) || !preg_match('/^[A-ZЁА-Я][a-zа-яёъ]+$/u', $_POST['name'])) {

    setcookie('name_error', '1', time() + 86400); 
    $errors = TRUE;
  }
  else {
    setcookie('name_value', $_POST['name'], time() + 86400 * 30); 
  }



  if (empty($_POST['email']) || !preg_match('/^[A-Z0-9a-z-_.]+[@][a-z]+[.][a-z]+$/', $_POST['email'])) {
    setcookie('email_error', '1', time() + 86400);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 86400);
  }

  $today = date('Y-m-d');
  if (!empty($_POST['birth'])) {
    $expire = $_POST['birth'];
  }

  $today_dt = new DateTime($today);
  $expire_dt = new DateTime($expire);

  if (empty($_POST['birth']) || !preg_match('/[12][90][0-9][0-9][-][0-1][0-9]-[0-3][0-9]/', $_POST['birth']) || ($today_dt < $expire_dt) ) {
    setcookie('birth_error', '1', time() + 86400);
    $errors = TRUE;
  }
  else {
    setcookie('birth_value', $_POST['birth'], time() + 30 * 86400);
  }


  if (empty($_POST['biography'])) {
    setcookie('biography_error', '1', time() + 86400);
    $errors = TRUE;
  }
  else {
    setcookie('biography_value', $_POST['biography'], time() + 30 * 86400);
  }



  if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 86400);
    $errors = TRUE;
  }
  else {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 86400);
  }



  if (empty($_POST['limbs'])) {
    setcookie('limbs_error', '1', time() + 86400);
    $errors = TRUE;
  }
  else {
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 86400);
  }




  if (empty($_POST['agree'])) {
    setcookie('agree_error', '1', time() + 86400);
    setcookie('agree_value', '0', time() + 30 * 86400);
    $errors = TRUE;
  }
  else {
    setcookie('agree_value', '1', time() + 30 * 86400);
  }


  

  if (empty($_POST['ability'])) {
    setcookie('ability_error', '1', time() + 86400);
    $errors = TRUE;
  }
  else {
    $array = array();
    foreach ($_POST['ability'] as $ability)
    {
      switch ($ability) {
        case "immortality":
            $array[0] = $ability;
            break;
        case "passingWalls":
            $array[1] = $ability;
            break;
        case "levitation":
            $array[2] = $ability;
            break;
    }
    }   

    setcookie('ability_value', serialize($array), time() + 30 * 86400);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('agree_error', '', 100000);
    setcookie('ability_error', '', 100000);
    setcookie('birth_error', '', 100000);
  }



   //-------------------------------Сохранение в базу данных.----------------------
  $db = new PDO('mysql:host=localhost;dbname=u52945', 'u52945', '3219665',
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  try {
    $stmt = $db->prepare("INSERT INTO application (name, email, biography, gender, limbs, birth) 
    VALUES (:name, :email, :biography, :gender, :limbs, :birth)");
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':biography', $_POST['biography']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':limbs', $_POST['limbs']);
    $stmt->bindParam(':birth', $_POST['birth']);
    $stmt->execute();
    $application_id = $db->lastInsertId();

    foreach ($_POST['ability'] as $ability)
    {
      $stmt = $db->prepare("INSERT INTO application_ability (application_id, ability_id)
      VALUES (:application_id, (SELECT id FROM ability WHERE name=:ability_name))");
      $stmt->bindParam(':application_id', $application_id);
      $stmt->bindParam(':ability_name', $ability);
      $stmt->execute();
    }   

  }

  catch(PDOException $e) {
    print('ошибка при отправке данных: ' .$e->getMessage());
    exit();
  }

  //--------------------------------------------------------------------------

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');

}