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

                <a href='/phpProjet/profile/<?php echo htmlspecialchars($params['self_info']['unique_pseudo']); ?>' id='link_ownProfile'>Profil  </a>
                <a href='/phpProjet/unload' id='link_unload'>Se deconecter</a>
            </p>
        </div>

    </header>


    <body>
        <h1>Tweets aimés : <?php echo $params['profile_info']['public_pseudo']; ?></h1>

            <div id='profile_likes'>
                <?php foreach ($params['likedTweet'] as $key => $like) { ?>
                    <div id='profile_like'>

                        <p>
                            <a href='/phpProjet/profile/<?php echo $like['user_pseudo_unique']?>' > <b><?php echo $like['user_pseudo_public'] ?></b> </a>
                            <strong >@<?php echo $like['user_pseudo_unique'] ?></strong>
                            <b id='tweet_date'> <?php echo $like['tweet_date'] ?></b>
                        </p>
                        <p>
                            <?php echo $like['tweet_contenue'] ?>
                        </p>
                        <?php if(isset($like['image'])){ ?><img src="/phpProjet/images/<?php echo $like['image']?>"><?php } ?>
                        <br><br>
                    </div>
                <?php }?>
            </div>
    </body>
</html>