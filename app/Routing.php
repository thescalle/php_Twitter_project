<?php



require_once __DIR__. '/../controller/PaswordController.php';
require_once __DIR__. '/../controller/TweetController.php';
require_once __DIR__. '/../controller/ProfileController.php';

require_once __DIR__. '/../model/Tweet.php';
require_once __DIR__. '/../model/password.php';
require_once __DIR__. '/../model/Profile.php';
require_once __DIR__. '/../database/db.php';

class Routing
{


    private $app;
    


    //constructeur du routing
    public function __construct(App $app)
    {
        $this->app = $app;
    }



    public function setup(){

        if(isset($_SESSION['user']))
        {


            $this->app->get('/',function(){   //lapage de redirection vers login / register
                $controller =  new TweetController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->timeLineHandler();
            });
            $this->app->post('/',function(){   //lapage de redirection vers login / register
                $controller =  new TweetController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->timeLineHandler_post(); 
            });
            $this->app->get('/hashtag/(\w+)',function($str){
                $controller =  new TweetController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->hashtagHandler($str);
            });
            $this->app->get('/profile/(\w+)',function($name){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->profileHandler($name);
            });
            $this->app->post('/profile/(\w+)',function($name){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->profileHandlerPost($name);
            });
            $this->app->get('/profile/(\w+)/abonements',function($name){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->profileAbonements($name);
            });
            $this->app->get('/profile/(\w+)/abones',function($name){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->profileAbones($name);
            });
            $this->app->get('/profile/(\w+)/likes',function($name){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->profileLike($name);
            });
            $this->app->get('/editprofile',function(){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->editProfile();
            });
            $this->app->post('/editprofile',function(){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->editProfilePost();
            });
            $this->app->get('/delete',function(){
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->deleteProfile();
            });
            $this->app->get('/editTweet/(\d+)',function($id){
                $controller =  new TweetController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->editTweet($id);
            });
            $this->app->post('/editTweet/(\d+)',function($id){
                $controller =  new TweetController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->editTweetPost($id);
            });



            
            $this->app->get('/messages',function(){   //lapage de redirection vers login / register
                $controller =  new ProfileControler($this->setModel('ProfileModel' ,$this->setupDatabase()));
                $controller->messagePage();
            });

            $this->app->get('/notifications',function(){
                echo 'Page Construction Area';
            });


            $this->app->get('/login',function(){header('Location: /phpProjet');});   //si on assaye de repartir sur login ou register, on load la page de base
            $this->app->get('/register',function(){header('Location: /phpProjet');});

            $this->app->get('/unload',function(){    //si on veut se deconecter manuelement
                session_destroy();
                header('Location: /phpProjet');
            });


        }
        else{     //  si il n'y a pas de session active, on doit donc se connecter


            $this->app->get('/',function(){   //lapage de redirection vers login / register
                $controller =  new PaswordController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->logRegister();
            });

            $this->app->get('/login',function(){    //on load le formulaire de login
                $controller =  new PaswordController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->login();
            });
            $this->app->post('/login',function(){    //une fois que le formulaire a été envoyé
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->testlogin();
            });

            $this->app->get('/register',function(){   //on load le form de register
                $controller =  new PaswordController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->register();
            });
            $this->app->post('/register',function(){   //quand le formulaire
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->testregister();
            });

            $this->app->get('/login/resetpassword',function(){    //on load le reset password
                $controller =  new PaswordController($this->setModel('TweetModel' ,$this->setupDatabase()));
                $controller->resetpassword();
            });
            $this->app->post('/login/resetpassword',function(){    //une fois que le form reset password a été envoyé
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->resetpassworddo();
            });

            $this->app->get('/login/resetpassword/key/(\d+)',function($key){    //on recupere la confirmation key de l'email
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->changepassword($key);
            });
            $this->app->post('/login/resetpassword/key/(\d+)',function($key){    //on recupere la confirmation key de l'email
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->changepassworddo($key);
            });

            $this->app->get('/register/key/(\d+)',function($key){    //on recupere la confirmation key de l'email
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->register_continue($key);
            });

            $this->app->post('/register/key/(\d+)',function($key){    //on recupere la confirmation key de l'email
                $controller =  new PaswordController($this->setModel('PaswordModel' ,$this->setupDatabase()));
                $controller->register_continueDO($key);
            });

            
        }
    }


    private function setupDatabase():Database{

        return new Database(
            "127.0.0.1",
            "php_projet",
            "root",
            "",
            "3306"
        );
    }


    private function setModel(string $ModelName, Database $database){
        return new $ModelName($database);
    }

}