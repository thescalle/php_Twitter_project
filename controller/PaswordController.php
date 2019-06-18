<?php


require_once ('ControllerBase.php');

class PaswordController extends ControllerBase
{

    public function __construct($model)
    {
        parent::__construct($model);
    }





    //
    // Les fonctions suivantes testent si les informations mises dans les fomulaires sont bonne  (fonction post)
    //



    public function testregister(){   //on teste si les informations mises dans le formulaire de register son bonnes
        
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = md5(htmlspecialchars($_POST['password']));
        $password2 = md5(htmlspecialchars($_POST['password2']));



    
        //
        // on commence une serie de test pour voir si les informations sont bonne
        // si les info sont mauvaises, on render le 'register' avec en parametre le message d'erreur
        //
 
        if( strlen($nom) >= 30 ) $this->render('register',['le nom rentré comporte trop de charactère ( >30 )']);
        else if( strlen($prenom) >= 30 ) $this->render('register',['le prénom rentré comporte trop de charactère ( >30 )']); 
        else if( strlen($pseudo) >= 30 ) $this->render('register',['le pseudo rentré comporte trop de charactère ( >30 )']); 
        else if( strlen($email) >= 100 ) $this->render('register',['le mail rentré comporte trop de charactère ( >100 )']); 
        else if( strlen($password) >= 20 ) $this->render('register',['le mot de passe rentré comporte trop de charactère ( >20 )']); 
        else if( strlen($nom)<= 3) $this->render('register',['le nom rentré ne comporte pas assez de charactere']);
        else if( strlen($prenom)<= 3) $this->render('register',['le prenom rentré ne comporte pas assez de charactere']);
        else if( strlen($pseudo)<= 3) $this->render('register',['le pseudo rentré ne comporte pas assez de charactere']);
        else if( strlen($email)<= 3) $this->render('register',['le mail rentré ne comporte pas assez de charactere']);
        else if( strlen($password)<= 3) $this->render('register',['le mot de passe rentré ne comporte pas assez de charactere']);
        else if( $password != $password2 ) $this->render('register',['les deux mots de passe ne corespondent pas']);

        $testacount = $this->model->findbypseudo($pseudo);
        if(isset($testacount[0])) $this->render('register',['le pseudo rentré est deja utilisé']);
        
        $testemail = $this->model->findbyemail($email);
        if(isset($testemail[0])) $this->render('register',['le mail rentré est deja utilisé']);

        //
        //a ce stade on a effectué tous les tests
        //on vas donc mettre dans la base de donné le nouveau user et rediriger vers la page de login
        //


        $key = rand(10000000,99999999); 
        //on génere une clé aléatoire que l'on feras ensuite verifier a l'utilisateur par mail

        $param['nom'] = $nom;
        $param['prenom'] = $prenom;
        $param['pseudo'] = $pseudo;
        $param['email'] = $email;
        $param['password'] = $_POST['password'];
        $param['key'] = $key;

        $testcreate = $this->model->createUser($param);





        //les informations a envoyer dans le mail
        $sender = 'PHP.projet.noreply@gmail.com';
        $password = 'H2riRp97H';

        $subject = 'Verification du compte';
        $body = '
        <html>
            <body>
                <div align="center">
                    <p>Bonjour'.urlencode($prenom).', vous pouvez utiliser le liens ci-dessous pour valider la creation de votre compte !</p>
                    <a href="http://127.0.0.1/phpProjet/register/key/'. urlencode($key).'">Confirmez votre compte !</a>
                </div>
            </body>
        </html>
        ';
        $target = $email;

        require_once __DIR__.'/../mailer/email.php';

        //on crée une instance de email et on l'envois a $target (le mail que le mec a mis dans le form)
        $mail = new email($sender , $password , $subject , $body);
        $goodemail = $mail->sendTo($target);
        
        if($goodemail == true) $this->render('email_send');
        else echo 'Une erreur dans l envois de l email est survenue : ' . $goodemail;



    }




    public function testlogin()   //on teste si les infomations dans login sont bonne et si oui on ouvre une session
    {
        $login = htmlspecialchars($_POST['log']);
        $password = htmlspecialchars(md5($_POST['password']));
        //on stocke ce que l'utilisateur a rentré dans des variables

        $testemail = $this->model->findbyemail($login);
        
        if(!isset($testemail[0]))
        {

            $testacount = $this->model->findbypseudo($login);

            if(isset($testacount[0]))
            {

                if($testacount[0]['user_mot_de_passe'] == $password)
                {
                    $this->goodpassword($testacount[0]);
                }
                else $this->render('login',['mauvais mot de passe !']);

            }
            else $this->render('login',['le pseudo et le mail n existent pas']);
        }
        else
        {

            if($testemail[0]['user_mot_de_passe'] == $password)
            {

                $this->goodpassword($testemail[0]);

            }
            else $this->render('login',['mauvais mot de passe !']);

        }
    }




    public function resetpassworddo()
    {
        
        $testemail = $this->model->findbyemail($_POST['mail']);

        if(!isset($testemail[0]))   //on teste si le mail est enregistré
        {
            $this->render('resetpassword',['Il n y a aucun compte enregistré avec cet email !']);
        }
        
        $key = rand(10000000,99999999); 
        //on génere une clé aléatoire que l'on feras ensuite verifier a l'utilisateur par mail

        $this->model->setKey($testemail[0]['user_id'] , $key);


        //les informations a envoyer dans le mail
        $sender = 'PHP.projet.noreply@gmail.com';
        $password = 'H2riRp97H';

        $subject = 'Verification du compte';
        $body = '
        <html>
            <body>
                <div align="center">
                    <a href="http://127.0.0.1/phpProjet/login/resetpassword/key/'. urlencode($key).'">Confirmez votre compte !</a>
                </div>
            </body>
        </html>
        ';
        $target = $_POST['mail'];

        require_once __DIR__.'/../mailer/email.php';

        //on crée une instance de email et on l'envois a $target (le mail que le mec a mis dans le form)
        $mail = new email($sender , $password , $subject , $body);
        $goodemail = $mail->sendTo($target);
        
        if($goodemail == true){
            $this->render('email_send');
        } 
        else echo 'Une erreur dans l envois de l email est survenue : ' . $goodemail;

    }






    public function changepassword($key)
    {
        $user = $this->model->userFromKey($key);
        
        if(!isset($user['user_id'])){
            //si quelqu'un assaye de mettre une clée au hazzard
            $this->render('404');
        }
        else
        {
            $this->render('changepassword');
        }
    }



    public function changepassworddo($key)
    {
        $user = $this->model->userFromKey($key);
        
        if(!isset($user['user_id']))
        {
            //si quelqu'un assaye de mettre une clée au hazzard
            $this->render('404');
        }
        else
        {

            if($_POST['password'] != $_POST['password2']){
                $this->render('changepassword',['les deux mots de passe ne corespondent pas !']);
            }
            else
            {
                $this->model->resetpassword($user['user_id'],$_POST['password']);

                //on remet la key a 0 pour eviter que les gens ne se reconnectent sans arret sur cette page
                $this->model->setKey($user['user_id'] , null);
                header('Location: /phpProjet/login');
            }
        }
    }



    public function register_continue($key)
    {
        $user = $this->model->userFromKey($key);
        if(!isset($user['user_id']))
        {
            //si quelqu'un assaye de mettre une clée au hazzard
            $this->render('404');
        }
        else {
            $this->render('register_continue');
        }
    }

    public function register_continueDO($key)
    {
        $user = $this->model->userFromKey($key);
        if(!isset($user['user_id']))
        {
            //si quelqu'un assaye de mettre une clée au hazzard
            $this->render('404');
        }
        else {

            $address = htmlspecialchars($_POST['addresse']);
            $postal = htmlspecialchars($_POST['postal']);
            $country = htmlspecialchars($_POST['country']);
            $phone = htmlspecialchars($_POST['phone']);
            $description = htmlspecialchars($_POST['description']);
            $website = htmlspecialchars($_POST['website']);


            //on fais une serie de test pour voir si les characteres sont bon
            if( strlen($address) >= 150 ) $this->render('register_continue',['l addresse rentrée comporte trop de charactère ( >150 )']);
            else if( strlen($postal) >= 6 ) $this->render('register_continue',['le code postal rentré comporte trop de charactère ( >5 )']);
            else if( strlen($country) >= 30 ) $this->render('register_continue',['le pays rentré comporte trop de charactère ( >30 )']);
            else if( strlen($phone) >= 11 ) $this->render('register_continue',['le numéro de telephone rentré comporte trop de charactère ( >10 )']);
            else if( strlen($description) >= 300 ) $this->render('register_continue',['la description rentrée comporte trop de charactère ( >300 )']);
            else if( strlen($website) >= 300 ) $this->render('register_continue',['le site internet rentrée comporte trop de charactère ( >150 )']);
            

            if(strlen($address>0)) $this->model->insertAddress($user['user_id'] , $address);

            if(strlen($postal>0)) $this->model->insertPostal($user['user_id'] , $postal);

            if(strlen($country>0)) $this->model->insertCountry($user['user_id'] , $country);

            if(strlen($phone>0)) $this->model->insertPhone($user['user_id'] , $phone);

            if(strlen($description>0)) $this->model->insertDescription($user['user_id'] , $description);

            if(strlen($website>0)) $this->model->insertWebsite($user['user_id'] , $website);

            //a cette étape, toutes les donnés on étés rentrés dans la base de donnée



            //on remet la key a 0 pour eviter que les gens ne se reconnectent sans arret sur cette page
            $this->model->setKey($user['user_id'] , null);
            header('Location: /phpProjet/login');
        }
    }




    //
    // Les fonctions suivantes redirigent le mec avec les liens (fonction get)
    //


    public function resetpassword()  //load la vue pour remettre a zero le mot de passe 
    {
        $this->render('resetpassword');
    }

    public function logRegister()
    {
        $this->render('logRegister');
    }

    public function login()
    {
        $this->render('login');
    }

    public function register()
    {   
        $this->render('register');
    } 




    private function goodpassword($log)   //la fonction quand le mot de passe est le bon pour simplifier
    {
        $_SESSION['user'] = $log['user_id'];
        //on met dans la session actuelle l'id de l'user avec lequel on est connecté
        header('Location: /phpProjet');
        //on redirige vers la page de pase
    }



}