<?php 

namespace Dev;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Rain\Tpl;

Class Mailer {


	const USERNAME = "gabryelghost@gmail.com";
	const PASSWORD = "25251425Aa";
	const NAME_FROM = "FirstSite";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array()){


		try {

			$config = array(
			    "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']. "/views/email/",
			    "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
			    "debug"         => false
			);
			Tpl::configure( $config );

			$tpl = new Tpl();

			foreach ($data as $key => $value) {
				$tpl->assign($key, $value);	
			}

			$html = $tpl->draw($tplName, true);

			$this->mail = new PHPMailer(true);

		    //Server settings
		    $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
		    $this->mail->isSMTP();                                            // Send using SMTP
		    $this->mail->Host       = 'smtp.gmail.com';
	   		$this->mail->SMTPDebug = 0;
			$this->mail->Debugoutput = 'html';


                    // Set the SMTP server to send through
		    $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $this->mail->Username   = Mailer::USERNAME;                     // SMTP username
		    $this->mail->Password   = Mailer::PASSWORD;                               // SMTP password
		    $this->mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $this->mail->Port       = 587;
		    $this->mail->SMTPOptions = array('ssl'=>array('verify_peer'=>false, 'verify_peer_name'=>false, 'allow_self_signed'=>true));

		    //Recipients
		    $this->mail->setFrom(Mailer::USERNAME, (Mailer::NAME_FROM));
		    $this->mail->addAddress($toAddress, $toName);     

		    // Attachments
		    //$this->mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments

		    // Content
		    $this->mail->isHTML(true);                                  // Set email format to HTML
		    $this->mail->Subject = $subject;
    		$this->mail->msgHTML($html);

		    echo 'Message has been sent';
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
		}
	}

	public function send(){
		
		return  $this->mail->send();

	}
}



?>