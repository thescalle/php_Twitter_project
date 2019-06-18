<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="css/img/icon.png"/>
            <title>Twiblur . Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>

    <body>
            
        <form action="" method="POST">

            <h1>Editer le profil</h1>

            <p>
                <b>Pseudo : </b>
                <input type="text" name="pseudo" placeholder="pseudo public" value="<?php if(strlen($params['self_info']['user_pseudo_public'])>1)echo$params['self_info']['user_pseudo_public'];?>">
            </p>


            <p>
                <b>Mot de passe : </b>
                <input type="password" name="password" placeholder="mot de passe" >
                <input type="password" name="password2" placeholder="confirmez le mot de passe" >
            </p>

            <br>

            
            <p>
                <b>Numéro de téléphone : </b>
                <input type="text" name="phone" placeholder="numéro de telephone" value="<?php if(strlen($params['self_info']['user_telephone'])>1)echo htmlspecialchars($params['self_info']['user_telephone']);?>">
            </p>


            <p>
                <b>Description : </b>
                <input type="text" name="description" placeholder="Description personelle" value="<?php if(strlen($params['self_info']['user_description'])>1)echo htmlspecialchars($params['self_info']['user_description']);?>">
            </p>

            <p>
                <b>Site internet : </b>
                <input type="text" name="website" placeholder="Site internet personnel" value="<?php if(strlen($params['self_info']['user_site_internet'])>1)echo htmlspecialchars($params['self_info']['user_site_internet']);?>">
            </p>
            <a href="/phpProjet/delete">Supprimer le pofil</a>

            <p><?php if(isset($params['error'])) echo $params['error']; ?></p><br>
            <button type="submit">Enregistrer les modifications</button><br>
            
            <a href="/phpProjet/profile/<?php echo $params['self_info']['user_pseudo_unique'];?>">Retourner sur le profil</a>

            <br><br>

            

        </form>


    </body>
</html>




