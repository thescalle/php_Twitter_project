<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="css/img/icon.png"/>
            <title>Twiblur . TimeLine</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>
    
    <header>
        <!--       Dans le header on va mettre tous les boutons en haut pour naviguer dans le site           -->

        <div id='head'>
            <p>
                <a href='/phpProjet/' id='link_accueil'>  Accueil  </a>
                <a href='/phpProjet/notifications' id='link_notifications'>  Notifications  </a>
                <a href='/phpProjet/messages' id='link_messages'>  Messages  </a>
                <a href='/phpProjet/profile/<?php echo $params['self_info']['unique_pseudo']; ?>' id='link_ownProfile'>Profil  </a>
                <a href='/phpProjet/unload' id='link_unload'>Deconnexion</a>
            </p>
        </div>

    </header>

    <body>
        <div id='timeline'>
            <div id='tweet_Area'>
                <form action="" method="POST" enctype="multipart/form-data">

                    <input type="text" name="tweet_message" placeholder="Quoi de neuf ?" >
                    <label for="file" class="label-file"><img src="css/img/galleryicon.png" height="30px"/></label>
                        <input id="file" class="input-file" type="file">
                    <button type="submit">Tweeter</button> 

                    <?php if(isset($params['tweet_error'])) echo $params['tweet_error']; ?>
                </form>
                <hr/>
            </div>
            
            <br>


            <div id='tweets'>
                <?php  foreach ($params['tweets'] as $key => $value) {?>
                <div id='tweet'>
                    <p>
                        <a href='/phpProjet/profile/<?php echo $value['pseudo_unique']?>' id='link_profile_tweet'> <b><?php echo $value['pseudo_public'] ?></b> </a>
                        <span id='tweet_pseudo_unique'>@<?php echo $value['pseudo_unique'] ?></span>
                        <span id='tweet_date'> <?php echo $value['tweet_date'] ?></span>
                    </p>
                    <p id='tweet_content'>
                        <?php echo $value['tweet_contenue'] ?>
                    </p>
                    <?php if(isset($value['image'])){ ?><img src="/phpProjet/images/<?php echo $value['image']?>"><?php } ?>
                    <p>
                        <form action="" method="POST">
                            <button type="submit" name="retweet" value="<?php echo $value['tweet_id']?>"><img src="css/img/like.png" height="17px"/></button>
                            <button type="submit" name="fav" value="<?php echo $value['tweet_id']?>"><img src="css/img/retweet.png" height="17px"/></button>
                        </form>

                        <hr/>
                    </p>
                    
                    <br>
                <?php } ?>
                </div>
            </div>
        </div>

    </body>
</html>