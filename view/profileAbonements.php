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
        <h1>Abonements : <?php echo $params['profile_info']['public_pseudo']; ?></h1>

            <div id='profile_abonements'>
                <?php foreach ($params['abonements'] as $key => $abonement) { ?>
                    <div id='profile_abonement'>

                        <p>
                            <a href='/phpProjet/profile/<?php echo $abonement['pseudo_unique']?>' > <b><?php echo $abonement['pseudo_public'] ?></b> </a>
                            <strong >@<?php echo $abonement['pseudo_unique'] ?></strong>
                        </p>
                        <p>
                            <?php echo $abonement['user_description'] ?>
                        </p>
                        <br>
                    </div>
                <?php }?>
            </div>
    </body>
</html>