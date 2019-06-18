<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="../css/img/icon.png"/>
            <title>Twiblur . Reset Password</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>

    <body>
        
        <form action="" method="POST">

            <h1>Réinitialiser le mot de passe</h1>

            <p>
                <input type="text" name="mail" placeholder="Addresse Email" >
            </p>

            <button type="submit">Envoyer un mail</button>

            <br><?php if(isset($params[0])) {echo $params[0]; echo '<br>';} ?>

            <a href="../login">Se connecter</a>
        </form>
    

    </body>
</html>