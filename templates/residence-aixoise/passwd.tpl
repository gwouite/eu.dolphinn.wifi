<?php


if (!isset($_POST['oldpass']) || !isset($_POST['newpass'])) {

?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Changement de pass</title>
</head>
<body>

<form action="passwd" method="post">
	Merci de saisir l'ancien et le nouveau mot de passe ci-dessous :<br /><br />
	Ancien mot de passe : <input type="text" name="oldpass" value="" /><br />
	Nouveau mot de passe : <input type="text" name="newpass" value="" /><br /><br />

	<input type="submit" value="Valider" />
</form>
</body>
</html>
<?php
} else {

	
	$pass = strtolower(trim(file_get_contents(__DIR__.'/passwd')));

	$oldPass = strtolower(trim($_POST['oldpass']));
	$newPass = strtolower(trim($_POST['newpass']));

	if ($oldPass != $pass) {
		exit("L'ancien mot de passe est erroné !");
	}
	if (strlen($newPass) < 1) {
		exit("Le mot de passe est trop court !");
	}

	$f = fopen(__DIR__.'/passwd', "wb");
	fputs($f, $newPass);
	fclose($f);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Changement de pass</title>

</head>
<body>
	Merci, le mot de passe est changé.
</body>
</html>

<?php


}