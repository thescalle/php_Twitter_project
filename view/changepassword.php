<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>

    <title>Twiblur - Login</title>

    <body>
    
        <h1>Changer le mot de passe : </h1>


        <form method="POST" action="">

            <p>
                <input type="password" name="password" id="password" placeholder="nouveau mot de passe" >
            </p>

            <p>
                <input type="password" name="password2" id="password2" placeholder="confirmez le mot de passe" >
            </p>

            <button type="submit">Changer le mot de passe</button>

        </form>

        <br><br><?php if(isset($params[0])) echo $params[0]; ?>



        

    </body>
</html>