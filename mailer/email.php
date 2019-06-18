<?php

require_once __DIR__. '/PHPMailer/PHPMailerAutoload.php';




//Cette classe simplifie la creation des mails

class email
{
    private $mail;



    public function __construct($sender,$password,$subject,$body)
    {
        $this->mail = new PHPMailer;
        //on crés une instance de PHPMailer dans mail pour l'utiliser en suite



        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->isHTML();
        //on initialise les parametres de securité et de connection
        
        $this->mail->Username = $sender;
        $this->mail->Password = $password;
        $this->mail->setFrom($sender, 'PHP Projet');
        //on initialise le compte qui vas envoyer le mail

        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        //on initialise le message à envoyer

    }


    public function sendTo($target)
    {
        $this->mail->AddAddress($target);

        if (!$this->mail->send()) {
            return $mail->ErrorInfo . ' \n Note : la solution que j ai rencontré pour fixer ce probleme etais que mon anti virus/pare feu me bloquais la sortie des emails non verifiés : https://image.noelshack.com/fichiers/2019/18/3/1556717320-fix.png';
        } else {
            return true;
        }
    }

}