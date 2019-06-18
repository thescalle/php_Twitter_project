<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="icon" type="image/png" href="../css/img/icon.png"/>
            <title>Twiblur . Profile</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    </head>
    
    <header>
        <!--       Dans le header on vas mettre tous les boutons en haut pour naviguer dans le site           -->

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
    <div id=timeline>
        <h1>Profil : <?php echo $params['profile_info']['public_pseudo']; ?></h1>

        <h3>Tweets : <?php echo $params['nombre_tweets']; ?></h3>
        <a href='/phpProjet/profile/<?php echo $params['profile_info']['unique_pseudo']; ?>/abonements'> <h3>Abonements : <?php echo $params['nombre_abonements']; ?></h3></a>
        <a href='/phpProjet/profile/<?php echo $params['profile_info']['unique_pseudo']; ?>/abones'><h3>Abonnés : <?php echo $params['nombre_abones']; ?></h3></a>
        <a href='/phpProjet/profile/<?php echo $params['profile_info']['unique_pseudo']; ?>/likes'><h3>J'aime : <?php echo $params['nombre_likes']; ?></h3></a>
        <?php if(strlen($params['profile_info']['description'])>0 ){ ?> <h3>Description : <?php echo htmlspecialchars($params['profile_info']['description']); ?> </h3> <?php } ?>
        <?php if(strlen($params['profile_info']['site_internet'])>0 ){ ?> <b>Site internet : </b> <a href="<?php echo $params['profile_info']['site_internet']; ?>"><?php echo $params['profile_info']['site_internet']; ?></a>  <?php } ?> 
        <?php if($params['moi']==true){  //Si le mec c'est nous?>
            <form action="" method="POST">
                <button type="submit" name="edit" value="edit_profile">Editer le profil</button>
            </form>
            <hr/>
        <?php } else if($params['isFollowing']==true){?>
            <form action="" method="POST">
                <button type="submit" name="unfollow" value="<?php echo $params['profile_info']['unique_pseudo']; ?>">Se désabonner</button>
            </form>
        <?php } else if($params['isFollowing']==false){ ?>
            <form action="" method="POST">
                <button type="submit" name="follow" value="<?php echo $params['profile_info']['unique_pseudo']; ?>">S'abonner</button>
            </form>
        <?php }?>
        <br><br><br>
        <div id=tweets>
            <?php  foreach ($params['tweets'] as $key => $value) {?>
                <div id='tweet'>
                    <p>
                        <a href='/phpProjet/profile/<?php echo $value['user_pseudo_unique']?>' id='link_profile_tweet'> <b><?php echo $value['user_pseudo_public'] ?></b> </a>
                        <span id='tweet_pseudo_unique'>@<?php echo $value['user_pseudo_unique'] ?></span>
                        <span id='tweet_date'> <?php echo $value['tweet_date'] ?></span>
                    </p>
                    <p id='tweet_content'>
                        <?php echo $value['tweet_contenue'] ?>
                    </p>
                    <?php if(isset($value['image'])){ ?><img src="/phpProjet/images/<?php echo $value['image']?>"><?php } ?>
                    <?php if($params['moi']==true){  //Si le mec c'est nous?>
                        <form action="" method="POST">
                            <button type="submit" name="supr" value="<?php echo $value['tweet_id'] ?>">Supprimer le tweet</button>
                            <button type="submit" name="edit_tweet" value="<?php echo $value['tweet_id'] ?>">Editer le tweet</button>
                        </form>
                        <hr/>
                    <?php }?>
                    <br>
                </div>    
            <?php } ?>
        </div>
        </div>
    </body>
</html>



