<?php

require_once("TweetInterface.php");

class TweetModel implements TweetInterface {

    private $conn;

    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }


    public function find_InfoById($id){

        $query = $this->conn->prepare('SELECT `user_id` as id, `user_nom` as nom, `user_prenom` as prenom, `user_pseudo_public`as public_pseudo, `user_pseudo_unique` as unique_pseudo, `user_description` as description, `user_site_internet` as site_internet, `user_date_inscription`as date FROM `user` WHERE user_id = :id'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':id' => $id ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find_InfoByPseudo($name){

        $query = $this->conn->prepare('SELECT `user_id` as id, `user_nom` as nom, `user_prenom` as prenom, `user_pseudo_public`as public_pseudo, `user_pseudo_unique` as unique_pseudo, `user_description` as description, `user_site_internet` as site_internet, `user_date_inscription`as date FROM `user` WHERE user_pseudo_unique = :name'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':name' => $name ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }




    public function find_conversations($id){

        $query = $this->conn->prepare('SELECT  `message_from` as user_message FROM `message` WHERE `message_to` = :id UNION SELECT  `message_to` as user_message FROM `message` WHERE `message_from` = :id2 group by user_message');
        $query->execute([':id' => $id , ':id2' => $id]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
        
    }

    public function newTweet($message,$id){

        $query = $this->conn->prepare('INSERT INTO `tweet` VALUES (NULL,:id, :message,NOW(),NULL)');
        $query->execute([
            ':id' =>  $id,
            ':message' => $message
        ]); // Exécution de la requête
        
    }

    public function newTweetImg($message,$id,$img){

        $query = $this->conn->prepare('INSERT INTO `tweet` VALUES (NULL,:id, :message,NOW(),:img)');
        $query->execute([
            ':id' =>  $id,
            ':message' => $message,
            ':img' => $img
        ]); // Exécution de la requête
        
    }



    public function getTweets($id)
    {
        $query = $this->conn->prepare('SELECT `tweet_id`, `tweet_owner`, `tweet_contenue`, `tweet_date`,`image`,user.user_pseudo_unique as "pseudo_unique",user.user_pseudo_public as "pseudo_public" FROM `tweet` 
        INNER JOIN user_follow on `tweet_owner`= user_follow.user_follow_suivi
        INNER JOIN user on `tweet_owner` = user.user_id
        where user_follow.user_follow_suiveur = :id
        ORDER by `tweet_date` DESC');
        $query->execute([
            ':id' =>  $id,
        ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    



    public function addRetweet($id,$tweetid){
        $query=$this->conn->prepare('INSERT INTO `user_retweet` VALUES ( NULL , :tweetid , :id )');
        $query->execute([
            ':tweetid' => $tweetid,
            ':id' =>  $id
        ]);
    }

    public function isRetweet($id,$tweetid){
        $query = $this->conn->prepare('SELECT `user_retweet_id` FROM `user_retweet` WHERE `user_retweet_tweet`=:tweetid AND `user_retweet_user`=:id');
        $query->execute([
            ':tweetid' => $tweetid,
            ':id' =>  $id
        ]);
        return $query->fetchALL(\PDO::FETCH_ASSOC);
    }


    public function isFav($id,$tweetid){
        $query = $this->conn->prepare('SELECT `user_fav_id` FROM `user_fav` WHERE `user_fav_tweet`=:tweetid AND `user_fav_user`=:id');
        $query->execute([
            ':tweetid' => $tweetid,
            ':id' =>  $id
        ]);
        return $query->fetchALL(\PDO::FETCH_ASSOC);
    }


    public function addFav($id,$tweetid){
        $query=$this->conn->prepare('INSERT INTO `user_fav` VALUES (NULL ,:tweetid , :id )');
        $query->execute([
            ':tweetid' => $tweetid,
            ':id' =>  $id
        ]);
    }


    public function getTweet($id){

        $query = $this->conn->prepare('SELECT `tweet_id`, `tweet_owner`, `tweet_contenue`, `tweet_date`, `image` FROM `tweet` WHERE `tweet_id` = :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);

    }



    public function getHashtags($str){
        $query=$this->conn->prepare('SELECT `tweet_id`,`tweet_owner`,`tweet_contenue`,`tweet_date`,user.user_pseudo_public,user.user_pseudo_unique FROM `tweet`
        INNER JOIN user on tweet_owner = user.user_id
        WHERE `tweet_contenue` REGEXP :string
        ORDER BY `tweet_date` DESC');

        $query->execute([':string' => $str]);
        return $query->fetchALL(\PDO::FETCH_ASSOC);

    }



    public function updateTweet($id,$message){
        $query=$this->conn->prepare('UPDATE `tweet` SET `tweet_contenue`=:str WHERE `tweet_id` = :id');
        return $query->execute([
            ':id' => $id,
            ':str' =>  $message
        ]);
    }


    public function findAll() : Array {}

    public function save(Array $city) : Bool {}

}

