<?php

require_once("TweetInterface.php");


class ProfileModel implements TweetInterface {

    private $conn;

    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }

    public function find_InfoById($id){

        $query = $this->conn->prepare('SELECT `user_id` as id, `user_nom` as nom, `user_prenom` as prenom, `user_pseudo_public`as public_pseudo, `user_pseudo_unique` as unique_pseudo, `user_description` as description, `user_site_internet` as site_internet, `user_date_inscription`as date FROM `user` WHERE user_id = :id'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':id' => $id ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function find_AllInfoById($id){

        $query = $this->conn->prepare('SELECT * FROM `user` WHERE user_id = :id'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':id' => $id ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find_InfoByPseudo($name){

        $query = $this->conn->prepare('SELECT `user_id` as id, `user_nom` as nom, `user_prenom` as prenom, `user_pseudo_public`as public_pseudo, `user_pseudo_unique` as unique_pseudo, `user_description` as description, `user_site_internet` as site_internet, `user_date_inscription`as date FROM `user` WHERE user_pseudo_unique = :name'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':name' => $name ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getNbrTweets($id){
        $query = $this->conn->prepare('SELECT COUNT(`tweet_owner`) as NbrTweets FROM `tweet` WHERE `tweet_owner`=:id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetch(\PDO::FETCH_ASSOC);  
    }

    public function getNbrAbonements($id){
        $query = $this->conn->prepare('SELECT COUNT(`user_follow_suiveur`) as nbrAbonements FROM `user_follow` WHERE `user_follow_suiveur`= :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getNbrAbones($id){
        $query = $this->conn->prepare('SELECT COUNT(`user_follow_suivi`) as nbrAbones FROM `user_follow` WHERE `user_follow_suivi`= :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function getNbrLike($id){
        $query = $this->conn->prepare('SELECT COUNT(`user_fav_user`) as likes FROM `user_fav` WHERE `user_fav_user`= :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    
    public function getAbonements($id){
        $query = $this->conn->prepare('SELECT `user_follow_suivi`,user.user_pseudo_public as pseudo_public,user.user_pseudo_unique as pseudo_unique,user.user_description as user_description, user.user_date_inscription FROM `user_follow` 
        INNER JOIN user ON `user_follow_suivi` = user.user_id
        WHERE `user_follow_suiveur`= :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getAbones($id){
        $query = $this->conn->prepare('SELECT `user_follow_suiveur`,user.user_pseudo_public as pseudo_public,user.user_pseudo_unique as pseudo_unique,user.user_description as user_description, user.user_date_inscription FROM `user_follow` 
        INNER JOIN user ON `user_follow_suiveur` = user.user_id
        WHERE `user_follow_suivi`= :id');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function find_likedtweet($id){

        $query = $this->conn->prepare('SELECT `user_fav_tweet`,tweet.tweet_owner,tweet.tweet_date,tweet.image as image,tweet.tweet_contenue,tweet.tweet_date,user.user_pseudo_public,user.user_pseudo_unique FROM `user_fav` 
        INNER JOIN tweet on `user_fav_tweet` = tweet.tweet_id 
        INNER JOIN user on tweet.tweet_owner = user.user_id 
        WHERE `user_fav_user`= :id
        ORDER BY tweet.tweet_date DESC');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
        
    }


    public function getTweetsfromID($id)
    {
        $query = $this->conn->prepare('SELECT `tweet_id`, `tweet_owner`, `tweet_contenue`,`image`, `tweet_date`,user.user_pseudo_public,user.user_pseudo_unique FROM `tweet`
        INNER JOIN user on tweet_owner = user.user_id
        WHERE `tweet_owner`=:id
        ORDER BY `tweet_date` DESC');
        $query->execute([':id' => $id]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);

    }


    public function isFollowing($idMoi,$idMec){
        $query = $this->conn->prepare('SELECT `user_follow_id` FROM `user_follow` 
        WHERE `user_follow_suiveur` = :idMoi AND `user_follow_suivi`= :idMec');
        $query->execute([':idMoi' => $idMoi,':idMec' => $idMec]); // Exécution de la requête
        return $query->fetch(\PDO::FETCH_ASSOC);
    }



    public function unfollow($idUnfollow,$idMoi){
        $query = $this->conn->prepare('DELETE FROM `user_follow` 
        WHERE `user_follow_suiveur` = :idMoi AND `user_follow_suivi` = :idUnfollow');
        $query->execute([':idMoi' => $idMoi,':idUnfollow' => $idUnfollow]); // Exécution de la requête        

    }

    public function follow($idfollow,$idMoi){
        $query = $this->conn->prepare('INSERT INTO `user_follow`VALUES (NULL, :idMoi,:idfollow)');
        $query->execute([':idMoi' => $idMoi,':idfollow' => $idfollow]); // Exécution de la requête 
    }
    
    public function changePseudo($id,$name)
    {
        $query = $this->conn->prepare('UPDATE `user` SET `user_pseudo_public`= :name WHERE `user_id`=:id');
        return $query->execute([':name' => $name,':id' => $id]); // Exécution de la requête 
    }

    public function changePassword($id,$name)
    {
        $query = $this->conn->prepare('UPDATE `user` SET `user_mot_de_passe`= :name WHERE `user_id`=:id');
        return $query->execute([':name' => $name,':id' => $id]); // Exécution de la requête 
    }

    public function changePhone($id,$name)
    {
        $query = $this->conn->prepare('UPDATE `user` SET `user_telephone`= :name WHERE `user_id`=:id');
        return $query->execute([':name' => $name,':id' => $id]); // Exécution de la requête 
    }

    public function changeDescription($id,$name)
    {
        $query = $this->conn->prepare('UPDATE `user` SET `user_description`= :name WHERE `user_id`=:id');
        return $query->execute([':name' => $name,':id' => $id]); // Exécution de la requête 
    }

    public function changeWebsite($id,$name)
    {
        $query = $this->conn->prepare('UPDATE `user` SET `user_site_internet`= :name WHERE `user_id`=:id');
        return $query->execute([':name' => $name,':id' => $id]); // Exécution de la requête 
    }


    public function deleteTweet($id){

        $query = $this->conn->prepare('DELETE FROM `tweet` WHERE `tweet_id`= :id');
        $query->execute([':id' => $id]); // Exécution de la requête 

        $query2 = $this->conn->prepare('DELETE FROM `user_fav` WHERE `user_fav_tweet`= :id');
        $query2->execute([':id' => $id]); // Exécution de la requête 

        $query3 = $this->conn->prepare('DELETE FROM `user_retweet` WHERE `user_retweet_tweet`=:id');
        $query3->execute([':id' => $id]); // Exécution de la requête 

    }


    public function deleteProfile($id){
        // on supprime le user
        $query = $this->conn->prepare('DELETE FROM user WHERE `user_id` = :id');
        return $query->execute([':id' => $id]); // Exécution de la requête 
    }



    public function findAll() : Array {}

    public function save(Array $city) : Bool {}
}