<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="css/img/icon.png"/>
            <title>Twiblur . Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>
    <body>

        <form method="POST" action="">

            <h1>Se connecter</h1>

            <p>
                <input type="text" name="log" id="log" placeholder="Identifiant ou Email" >
            </p>

            <p>
                <input type="password" name="password" id="password" placeholder="Mot de passe" >
            </p>

            <button type="submit">Se connecter</button><br>

            <br><a href="./login/resetpassword">Mot de passe oublié ?</a>
            <br><br><?php if(isset($params[0])) {echo $params[0]; echo '<br>';} ?>

            <a href="./register">Créer un compte</a>

        </form>
        
    </body>
</html>
