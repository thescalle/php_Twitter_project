<?php


require_once ('ControllerBase.php');

class TweetController extends ControllerBase
{
    public function __construct($model) {
        parent::__construct($model);
    }




    //la page principale avec tous les tweets 
    public function timeLineHandler()
    {
        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);

        
        $params['self_info'] = $personal_info[0];


        //on doit recuperer la liste des tweets que les gens qu'on suis on tweet
        //attention : on doit aussi recuperer ceux qu'ils on retweet et les mettre dans l'ordre en fonction de leurs date 

        $tweets = $this->model->getTweets($_SESSION['user']);
        //print_r($tweets);



        $params['tweets'] = $tweets;
        

        foreach ($params['tweets'] as $key => $tweet) {

            $tweets[$key]['tweet_contenue'] = $this->convertHashtag($tweet['tweet_contenue']);

        }
    
        $params['tweets'] = $tweets;
    

        $this->render('Tweettimeline',$params);
        
    }



    public function timeLineHandler_post()
    {
        
        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);
        $params['self_info'] = $personal_info[0];

        $tweets = $this->model->getTweets($_SESSION['user']);
        $params['tweets'] = $tweets;
        //on stocke les tweets dans le parametre passé a la view

        foreach ($params['tweets'] as $key => $tweet) {

            $tweets[$key]['tweet_contenue'] = $this->convertHashtag($tweet['tweet_contenue']);

        }
    
        $params['tweets'] = $tweets;

        if(isset($_POST['tweet_message']))   //si le post proviens du form pour remplir le tweet
        {   


            if(strlen($_POST['tweet_message'])==0)
            {
                $params['tweet_error']='Votre tweet ne comporte aucun charactere !';
                $this->render('Tweettimeline',$params);
            }
            else if(strlen($_POST['tweet_message'])>300)
            {
                $params['tweet_error']='Votre tweet contient trop de charactères ( '. strlen($_POST['tweet_message']).' ) !';
                $this->render('Tweettimeline',$params);
            }
            else
            {



                if(strlen($_FILES['file']['name'])!=0) {   //si il y'a un fichier image selectioné
                    
                    

                    $check = getimagesize($_FILES["file"]["tmp_name"]);
                    if($check !== false) {
                        $store_name = "../images/".$_FILES['file']['name'];

                        move_uploaded_file($_FILES['file']['tmp_name'],$store_name);

                        $this->model->newTweetImg($_POST['tweet_message'],$_SESSION['user'],$_FILES['file']['name']);
                    
                    } 
                    else {
                        $params['tweet_error']="Le fichier inséré n'est pas une image !";
                        $this->render('Tweettimeline',$params);
                    }

                }
                else{
                    $this->model->newTweet($_POST['tweet_message'],$_SESSION['user']);
                    
                }
                $this->render('Tweettimeline',$params);
            } 

            
            










        }
        else if(isset($_POST['retweet']))
        {
            $retweetExist = $this->model->isRetweet($_SESSION['user'],$_POST['retweet']);
            if(!isset($retweetExist[0]['user_retweet_id']))
            {
                $this->model->addRetweet($_SESSION['user'],$_POST['retweet']);
            }
        }
        else if(isset($_POST['fav']))
        {
            $favExist = $this->model->isFav($_SESSION['user'],$_POST['fav']);
            if(!isset($favExist[0]['user_fav_id']))
            {   
                $this->model->addFav($_SESSION['user'],$_POST['fav']);
            }
        }
        $this->render('Tweettimeline',$params);
    }


    public function hashtagHandler($str)
    {
        $personalId = $_SESSION['user'];
        $personal_info = $this->model->find_InfoById($personalId);

        
        $params['self_info'] = $personal_info[0];
        $tweets=$this->model->getHashtags($str);
        

        $params['tweets'] = $tweets;
        //on stocke les tweets dans le parametre passé a la view

        foreach ($params['tweets'] as $key => $tweet) {

            $tweets[$key]['tweet_contenue'] = $this->convertHashtag($tweet['tweet_contenue']);

        }
    
        $params['tweets'] = $tweets;
        $params['hashtag'] = $str;

        $this->render('hashtag',$params);
    }


    public function editTweet($id){

        $tweet = $this->model->getTweet($id);

        if(!$tweet[0]['tweet_owner'] == $_SESSION['user']){
            echo 'le tweet ne vous appartiens pas !';
            return;
        }

        $params['contenue'] =  $tweet[0]['tweet_contenue'];
        $params['id'] = $tweet[0]['tweet_id'];

        $this->render('EditTweet',$params);
    }


    public function editTweetPost($id){
        print_r($_POST);
        $this->model->updateTweet($id,$_POST['changeTweet']);
        header('Location: /phpProjet');
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