<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>

    <title>Twiblur - Register</title>

    <body>
    
        <h1>Creer un compte</h1>


        <form action="" method="POST">

            <p>Vous y êtes presque ...</p>
            <p>Vous pouvez maintenant rentrer quelques informations non obligatoire</p>
            <br>
            <p>
                <input type="text" name="addresse" placeholder="Addresse" >
            </p>



            <p>
                <input type="text" name="postal" placeholder="Code postal" >
                <input type="text" name="country" placeholder="Pays" >
            </p>

            <p>
                <input type="text" name="phone" placeholder="Numéro de téléphone" >
            </p>


            <p>
                <input type="text" name="description" placeholder="Description" >
            </p>

            <p>
                <input type="text" name="website" placeholder="Site internet" >
            </p>



            <br>

            <button type="submit">Creer un compte</button>
        </form>
        <br><br><?php if(isset($params[0])) echo $params[0]; ?>


    </body>
</html>