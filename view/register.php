<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="css/img/icon.png"/>
            <title>Twiblur . Register</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>

    <body>

        <form action="" method="POST">

            <h1>Creer un compte</h1>

            <p>
                <input type="text" name="nom" placeholder="Nom" >
                <input type="text" name="prenom" placeholder="Prénom" >
            </p>



            <p>
                <input type="text" name="pseudo" placeholder="Pseudo" >
            </p>

            <p>
                <input type="text" name="email" placeholder="Addresse Email" >
            </p>

            <p>
                <input type="password" name="password" placeholder="Mot de passe" >
                <input type="password" name="password2" placeholder="Confirmez le mot de passe" >
            </p>

            <br>

            <button type="submit">Creer un compte</button>

            <br><br><a href="./login">Se connecter</a>

            <p class="errorregister"><?php if(isset($params[0])) echo $params[0]; ?></p>
        </form>

    </body>
</html>