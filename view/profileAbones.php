<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>

    <title>Twiblur</title>

    
    <header>
        <!--       Dans le header on vas mettre tous les boutons en haut pour naviguer dans le site           -->

        <div id='head'>
            <p>
                <a href='/phpProjet/' id='link_accueil'>  Accueil  </a>
                <a href='/phpProjet/notifications' id='link_notifications'>  Notifications  </a>
                <a href='/phpProjet/messages' id='link_messages'>  Messages  </a>

                <a href='/phpProjet/profile/<?php echo $params['self_info']['unique_pseudo']; ?>' id='link_ownProfile'>Profil  </a>
                <a href='/phpProjet/unload' id='link_unload'>Se deconecter</a>
            </p>
        </div>

    </header>


    <body>
        <h1>Abonés : <?php echo $params['profile_info']['public_pseudo']; ?></h1>

            <div id='profile_abones'>
                <?php foreach ($params['abones'] as $key => $abone) { ?>

                    <div id='profile_abone'>
                        <p>
                            <a href='/phpProjet/profile/<?php echo $abone['pseudo_unique']?>' > <b><?php echo $abone['pseudo_public'] ?></b> </a>
                            <strong ><?php echo $abone['pseudo_unique'] ?></strong>
                        </p>
                        <p>
                            <?php echo $abone['user_description'] ?>
                        </p>
                        <br>

                    </div>
                <?php }?>
            </div>
    </body>
</html>