<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="../css/img/icon.png"/>
            <title>Twiblur . Hashtag</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    
    <header>
        <!--       Dans le header on vas mettre tous les boutons en haut pour naviguer dans le site           -->

        <div id='head'>
            <p>
                <a href='/phpProjet/' id='link_accueil'>  Accueil  </a>
                <a href='/phpProjet/notifications' id='link_notifications'>  Notifications  </a>
                <a href='/phpProjet/messages' id='link_messages'>  Messages  </a>

                <a href='/phpProjet/profile/<?php echo htmlspecialchars($params['self_info']['unique_pseudo']); ?>' id='link_ownProfile'>Profil  </a>
                <a href='/phpProjet/unload' id='link_unload'>Deconnexion</a>
            </p>
        </div>

    </header>


    <body>
        <div id=timeline>
        <h1>Tweets comprenants le #<?php echo $params['hashtag']; ?></h1>

            <div id='profile_likes'>
                <?php foreach ($params['tweets'] as $key => $tweet) { ?>
                    <div id='profile_like'>

                        <p>
                            <a href='/phpProjet/profile/<?php echo $tweet['user_pseudo_unique']?>' > <b><?php echo $tweet['user_pseudo_public'] ?></b> </a>
                            <span>@<?php echo $tweet['user_pseudo_unique'] ?></span>
                            <span id='tweet_date'> <?php echo $tweet['tweet_date'] ?></span>
                        </p>
                        <p>
                            <?php echo $tweet['tweet_contenue'] ?>
                        </p>
                        <br><hr>
                    </div>
                <?php }?>
            </div>
            </div>
    </body>
</html>