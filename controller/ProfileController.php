<?php


require_once ('ControllerBase.php');

class ProfileControler extends ControllerBase
{

    public function __construct($model) {
        parent::__construct($model);
    }

    
    public function profileHandler($name){

        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);
        $params['self_info'] = $personal_info[0];

        $profile_info = $this->model->find_InfoByPseudo($name);
        if(!isset($profile_info[0])) $this->render('404');
        $params['profile_info'] = $profile_info[0];
        
        $nbrTweet = $this->model->getNbrTweets($profile_info[0]['id']);
        $params['nombre_tweets']=$nbrTweet['NbrTweets'];

        $nbrAbonements = $this->model->getNbrAbonements($profile_info[0]['id']);
        $params['nombre_abonements'] = $nbrAbonements['nbrAbonements'];

        $nbrAbones = $this->model->getNbrAbones($profile_info[0]['id']);
        $params['nombre_abones'] = $nbrAbones['nbrAbones'];

        $nbrLikes = $this->model->getNbrLike($profile_info[0]['id']);
        $params['nombre_likes'] = $nbrLikes['likes'];




        $tweets = $this->model->getTweetsfromID($profile_info[0]['id']);
        $params['tweets']=$tweets;

        foreach ($params['tweets'] as $key => $tweet) {    //le systeme de hashtag

            $tweets[$key]['tweet_contenue'] = $this->convertHashtag($tweet['tweet_contenue']);

        }
    
        $params['tweets'] = $tweets;


        if($params['self_info']['id'] == $params['profile_info']['id']) $params['moi']=true;
        else $params['moi']=false;

        $isFollowing = $this->model->isFollowing($params['self_info']['id'],$params['profile_info']['id']);

        if(isset($isFollowing['user_follow_id'])) {   //si on follow

            $params['isFollowing']=true;

        } 
        else {    //sinon

            $params['isFollowing'] = false;

        };

        $this->render('Profile',$params);
    }


    public function profileHandlerPost($name)
    {
        
        if(isset($_POST['unfollow']))
        {
            $profile_info = $this->model->find_InfoByPseudo($_POST['unfollow']);
            if(!isset($profile_info[0])) $this->render('404');
            $this->model->unfollow($profile_info[0]['id'],$_SESSION['user']);

            $this->profileHandler($name);

        }
        else if(isset($_POST['follow']))
        {   
            $profile_info = $this->model->find_InfoByPseudo($_POST['follow']);
            if(!isset($profile_info[0])) $this->render('404');
            $this->model->follow($profile_info[0]['id'],$_SESSION['user']);
            $this->profileHandler($name);
        }
        else if(isset($_POST['edit']))
        {       
            header('Location: /phpProjet/editprofile');
        }
        else if(isset($_POST['supr'])){

            $this->model->deleteTweet($_POST['supr']);
            $this->profileHandler($name);
            
        }
        else if(isset($_POST['edit_tweet']))
        {
            header('Location: /phpProjet/editTweet/'.$_POST['edit_tweet']);
        }

    }


    public function profileAbonements($name){

        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);
        $params['self_info'] = $personal_info[0];

        $profile_info = $this->model->find_InfoByPseudo($name);
        if(!isset($profile_info[0])) $this->render('404');
        $params['profile_info'] = $profile_info[0];
        

        $abonements = $this->model->getAbonements($profile_info[0]['id']);


        $params['abonements']=$abonements;
        
        $this->render('profileAbonements',$params);
    }


    public function profileAbones($name){

        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);
        
        $params['self_info'] = $personal_info[0];
        

        $profile_info = $this->model->find_InfoByPseudo($name);
        if(!isset($profile_info[0])) $this->render('404');
        $params['profile_info'] = $profile_info[0];

        $abones = $this->model->getAbones($profile_info[0]['id']);

        $params['abones']=$abones;
        
        $this->render('profileAbones',$params);
    }


    public function profileLike($name){

        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);
        $params['self_info'] = $personal_info[0];

        $profile_info = $this->model->find_InfoByPseudo($name);
        if(!isset($profile_info[0])) $this->render('404');
        $params['profile_info'] = $profile_info[0];

        

        $likesTweet = $this->model->find_likedtweet($profile_info[0]['id']);
        $params['likedTweet']=$likesTweet;



        foreach ($params['likedTweet'] as $key => $tweet) {    //le systeme de hashtag

            $likesTweet[$key]['tweet_contenue'] = $this->convertHashtag($tweet['tweet_contenue']);

        }
    
        $params['likedTweet'] = $likesTweet;
        
        $this->render('profile_like',$params);
    }


    public function editProfile()
    {

        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_AllInfoById($personalId);
        $params['self_info'] = $personal_info[0];

        $this->render('editProfile',$params);
    }

    public function editProfilePost(){

        print_r($_POST);
        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_AllInfoById($personalId);
        $params['self_info'] = $personal_info[0];



        if(strlen($_POST['pseudo'])>=30) {
            $params['error']='Le pseudo rentré est trop long (>30)';
            $this->render('editProfile',$params);
        }
        else if(strlen($_POST['password'])>=20) {
            $params['error']='Le mot de passe rentré est trop long (>20)';
            $this->render('editProfile',$params);
        }
        else if(strlen($_POST['phone'])>=10) {
            $params['error']='Le pays rentré est trop long (>10)';
            $this->render('editProfile',$params);
        }
        else if(strlen($_POST['description'])>=300) {
            $params['error']='La description rentré est trop longue (>300)';
            $this->render('editProfile',$params);
        }
        else if(strlen($_POST['website'])>=150) {
            $params['error']='Le site internet rentré est trop long(>150)';
            $this->render('editProfile',$params);
        }

        if(strlen($_POST['pseudo'])>=1){
            $a = $this->model->changePseudo($personalId,$_POST['pseudo']);
        }

        if(strlen($_POST['password'])>=1 && $_POST['password']==$_POST['password2']){
            $a = $this->model->changePassword($personalId,$_POST['password']);
        }

        if(strlen($_POST['description'])>=1){
            $a = $this->model->changeDescription($personalId,$_POST['description']);
        }

        if(strlen($_POST['website'])>=1){
            $a = $this->model->changeWebsite($personalId,$_POST['website']);
        }

        header('Location: /phpProjet/profile/'.$params['self_info']['user_pseudo_unique']);
    }


    public function deleteProfile(){

        echo 'ici on supprime le profil du mec';
        echo $_SESSION['user'];

        $tweets = $this->model->getTweetsfromID($_SESSION['user']);
        //si le mec a deja tweeté 
        if(isset($tweets[0])){
            foreach ($tweets as $key => $value) {
                //on supprime tout ses tweets
                $this->model->deleteTweet($value['tweet_id']);   
            }
        }

        //on supprime le user
        if(!$this->model->deleteProfile($_SESSION['user'])){
            echo 'Il y a une erreur';
            return;
        }


        header('Location: /phpProjet/unload');

    }





    public function messagePage()
    {
        $this->render('messages');
    }



    private function convertHashtag($str)
    {
        $str = htmlspecialchars($str);

        $regex = "/#+([a-zA-Z0-9_]+)/";
        $str = preg_replace($regex,'<a href="/phpProjet/hashtag/$1" > $0 </a>',$str);

        $regex = "/@+([a-zA-Z0-9_]+)/";
        $str = preg_replace($regex,'<a href="/phpProjet/profile/$1" > $1 </a>',$str);

        return $str;
    }



}