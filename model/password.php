<?php

require_once("TweetInterface.php");

class PaswordModel implements TweetInterface {

    private $conn;

    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }


    public function findbyemail($mail){
        //on recupere le mot de passe et l'id du mec a partir de son mail
        $query = $this->conn->prepare('SELECT `user_id`, `user_mot_de_passe` FROM `user` WHERE user_email = :mail'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':mail' =>  $mail ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findbypseudo($login)
    {
        //on recupere le mot de passe et l'id du mec a partir de son pseudo
        $query = $this->conn->prepare('SELECT `user_id`, `user_mot_de_passe` FROM `user` WHERE user_pseudo_unique = :log'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':log' =>  $login ]); // Exécution de la requête
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function resetpassword($id,$mdp){
        $query = $this->conn->prepare('UPDATE user SET `user_mot_de_passe` = :mdp where `user_id` = :id'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        return $query->execute([':mdp' =>  $mdp , ':id' =>  $id ]); // Exécution de la requête
    }


    public function createUser($param){

        $query = $this->conn->prepare('INSERT INTO `user` VALUES (NULL, :nom , :prenom , :pseudo , :pseudob, :email , NULL , NULL , NULL , NULL , :passworld,NULL , NULL, NULL,:keya)');    
        
        return $query->execute([
        ':nom' =>  $param['nom'],
        ':prenom' => $param['prenom'],
        ':pseudo' => $param['pseudo'],
        ':pseudob' => $param['pseudo'],
        ':email' => $param['email'],
        ':passworld' => md5( $param['password']),
        ':keya' => $param['key']
        ]); // Exécution de la requête
    }




    public function setKey($userid , $key)
    {
        $query = $this->conn->prepare('UPDATE `user` SET `confirmationKey`= :key WHERE `user_id` = :id');    
        $query->execute([
            ':key' =>  $key,
            ':id' => $userid
            ]); // Exécution de la requête

    }



    public function userFromKey($key){

        //on recupere le mot de passe et l'id du mec a partir de son pseudo
        $query = $this->conn->prepare('SELECT `user_id` FROM `user` WHERE confirmationKey = :key'); // Création de la requête + utilisation order by pour ne pas utiliser sort
        $query->execute([':key' =>  $key ]); // Exécution de la requête
        return $query->fetch(\PDO::FETCH_ASSOC);

    }
    





    public function insertAddress($id , $address){
        $query = $this->conn->prepare('UPDATE `user` SET `user_addresse`=:address WHERE `user_id` = :id');
        $query->execute([
            ':id' =>  $id,
            ':address' => $address
        ]); // Exécution de la requête
    }

    public function insertPostal($id , $postal){ 
        $query = $this->conn->prepare('UPDATE `user` SET `user_code_postal`=:postal WHERE `user_id` = :id');
        $query->execute([
            ':id' =>  $id,
            ':postal' => $postal
        ]); // Exécution de la requête
    }

    public function insertCountry($id , $country){ 
        $query = $this->conn->prepare('UPDATE `user` SET `user_pays`=:country WHERE `user_id` = :id');
        $query->execute([
            ':id' =>  $id,
            ':country' => $country
        ]); // Exécution de la requête
    }

    public function insertPhone($id , $phone){ 
        $query = $this->conn->prepare('UPDATE `user` SET `user_telephone`=:phone WHERE `user_id` = :id');
        $query->execute([
            ':id' =>  $id,
            ':phone' => $phone
        ]); // Exécution de la requête
    }

    public function insertDescription($id , $description){ 
        $query = $this->conn->prepare('UPDATE `user` SET `user_description`=:description WHERE `user_id` = :id');
        $query->execute([
            ':id' =>  $id,
            ':description' => $description
        ]); // Exécution de la requête
    }

    public function insertWebsite($id , $website){ 
        $query = $this->conn->prepare('UPDATE `user` SET `user_site_internet`=:website WHERE `user_id` = :id');
        $query->execute([
            ':id' =>  $id,
            ':website' => $website
        ]); // Exécution de la requête
    }












    public function findAll() : Array {}

    public function save(Array $city) : Bool {}

}