<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Article FRUCTCODE.COM. How to send html-form with Ajax.</title>
  <meta name="description" content="Article FRUCTCODE.COM. How to send ajax form.">
  <meta name="author" content="fructcode.com">

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="ajax.js"></script>

</head>

<body>
    <form method="post" id="ajax_form" action="" >
        <input type="text" name="name" placeholder="Имя" /><br>
        <input type="text" name="phonenumber" placeholder="Ваш номер" /><br>
        <input type="text" name="email" placeholder="Ваша почта" /><br>
        <input type="text" name="city" placeholder="Город" /><br>
        <p>Услуга
				 <select name="taskOption">
				  <option>Диагностика</option>
				  <option>Ремонт</option>
				</select></p>
		<input type="text" name="comment" placeholder="Комментарий" /><br>
        <input type="button" id="btn" value="Отправить" />
    </form>
    
    

    <br>

    <div id="result_form"></div> 
</body>
</html>
