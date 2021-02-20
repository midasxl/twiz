<?php
/*
A class is a collection of variables and functions that work with those variables. Variables are defined by var and functions by function. A class is defined using the following syntax:
Basic class definitions begin with the keyword class, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.
Public: Public method or variable can be accessible from anywhere. Inside the class, outside the class and in child class also.
Private: Method or property with private visibility can only be accessible inside the class. You can not access private method or variable from outside of your class.
Protected: Method or variable with protected visibility can only be access in the derived class. Or in other word in child class. Protected will be used in the process of inheritance.
*/
class User // this is the object that is created throughout the logic, and values are assigned to the its properties
{
	// property declarations only available from within this class
	private 		$clean_email;
	private 		$clean_password;
	private 		$username;
	private 		$displayname;
	private 		$user_firstname;
	private 		$user_lastname;
    
	// property declarations available from anywhere
	public 			$user_active = 0;
	public 			$status = false;
	public 			$sql_failure = false;
	public 			$mail_failure = false;
	public 			$email_taken = false;
	public 			$username_taken = false;
	public 			$displayname_taken = false;
	public 			$activation_token = 0;
	public 			$success = NULL;
	
	// method declarations
	/* All objects can have a special built-in method called a ‘constructor’. Constructors allow you to initialise your object’s properties (give your properties values,) when you instantiate (create) an object */
	//function __construct($firstname,$lastname,$user,$display,$pass,$email)	
	function __construct($email,$pass)	
	{
		//$this represents the User class; displayname is one of the classes properties, and it gets set to whatever is fed into the constructor
		//$this->displayname = $display;
		
		//Sanitize
		$this->clean_email = sanitize($email);
		$this->clean_password = trim($pass);
		//$this->username = sanitize($user);
		//$this->user_firstname = sanitize($firstname);
		//$this->user_lastname = sanitize($lastname);
		
		/*if(usernameExists($this->username))
		{
			$this->username_taken = true;
		}
		else if(displayNameExists($this->displayname))
		{
			$this->displayname_taken = true;
		}*/
		if(emailExists($this->clean_email))
		{
			$this->email_taken = true;
		}
		else
		{
			//No problems have been found.
			$this->status = true;
		}
	}
	
	// method declaration
	public function twizAddUser()// called from user-register.php
	{
		global $mysqli,$emailActivation,$websiteUrl,$db_table_prefix;
		
		//Prevent this function being called if there were construction errors
		if($this->status)// if 'true' no problems have been found
		{
			//Construct a secure hash for the plain text password
			$secure_pass = generateHash($this->clean_password);
			
			//Construct a unique activation token
			$this->activation_token = generateActivationToken();
			
			//Do we need to send out an activation email?
			if($emailActivation == "true")// determined from the global $emailActivation variable
			{
				//User must activate their account first
				$this->user_active = 0;
				
				$mail = new twizMail();// calls class.mail.php to build the class and to access the class functions
				
				//Build the activation message
				$activation_message = lang("ACCOUNT_ACTIVATION_MESSAGE",array($websiteUrl,$this->activation_token));
				
				//Define more if you want to build larger structures
				$hooks = array(
					"searchStrs" => array("#ACTIVATION-MESSAGE","#ACTIVATION-KEY","#USERNAME#"),
					//"subjectStrs" => array($activation_message,$this->activation_token,$this->displayname)
					"subjectStrs" => array($activation_message,$this->activation_token)
					);
				
				/* Build the template - Optional, you can just use the sendMail function 
				Instead to pass a message. */
				
				if(!$mail->newTemplateMsg("new-registration.txt",$hooks))// class.mail.php line 11 public function
				{
					$this->mail_failure = true;
				}
				else
				{
					//Send the mail. Specify users email here and subject. 
					//SendMail can have a third parementer for message if you do not wish to build a template.
					
					if(!$mail->sendMail($this->clean_email,"New User"))// class.mail.php line 49 public function
					{
						$this->mail_failure = true;
					}
				}
				$this->success = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE2");
			}
			else
			{
				//Instant account activation
				$this->user_active = 1;
				$this->success = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE1");
			}	
			
			
			if(!$this->mail_failure)// if mail_failure is not 'true'
			{
				//Insert the user into the database providing no errors have been found.
				$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."users (
					password,
					email,
					activation_token,
					last_activation_request,
					lost_password_request, 
					active,
					title,
					sign_up_stamp,
					last_sign_in_stamp,
					pay_status,
					trial,
					stripe_id,
					plan_id,
					pass_change
					)
					VALUES (
					?,
					?,
					?,
					'".time()."',
					'0',
					?,
					'Base Member',
					'".time()."',
					'0',
					'0',
					'0',
					'0',
					'0',
					'0'
					)");
					
					// for future reference
					//<?php
					//$timestamp=1333699439;
					//echo gmdate("Y-m-d\TH:i:s\Z", $timestamp);
				
				$stmt->bind_param("sssi", $secure_pass, $this->clean_email, $this->activation_token, $this->user_active);
				$stmt->execute();
				$inserted_id = $mysqli->insert_id;
				$stmt->close();
				
				//Insert default permission into matches table; At this point they will all be base members (permission level 2)
				// At any point we can set it to 3 so that all new users get a free three day trial!!
				//A server CRON job will change their permission_id to 2 after the three day trial
				$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches  (
					user_id,
					permission_id
					)
					VALUES (
					?,
					'2'
					)");
				$stmt->bind_param("s", $inserted_id);
				$stmt->execute();
				$stmt->close();
				
				//Insert default credit tally into credits table
				$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_credits  (
					user_id,
					credits
					)
					VALUES (
					?,
					'0'
					)");
				$stmt->bind_param("s", $inserted_id);
				$stmt->execute();
				$stmt->close();
			}
		}
	}
}

?>