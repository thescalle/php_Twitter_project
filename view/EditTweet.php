<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>

    <title>Twiblur - Login</title>

    <body>
    
        <h1>Modifier le tweet : </h1>


        <form method="POST" action="">

            <p>
                <input type="text" name="changeTweet" id="changeTweet" value="<?php echo htmlspecialchars($params['contenue']);?>" >
            </p>

            <button type="submit">Enregistrer les modifications</button>

        </form>

    </body>
</html>