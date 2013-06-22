<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		//$this->setState('roles', $record->roles);
		// using ldap bind
		$ldapuser  = $this->username;     // ldap rdn or dn
		$ldappass = $this->password;  // associated password
	
		// connect to ldap server
		$ldapconn = ldap_connect("localhost")
		    or die("Could not connect to LDAP server.");

		// Set some ldap options for talking to
    	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
		
		try{
			$result=@ldap_search($ldapconn,"dc=unl,dc=edu,dc=ec",'cn='.$ldapuser,array('cn','sn', 'title', 'telephoneNumber'));
			$se = @ldap_get_entries($ldapconn,$result);
		}catch (Exception $e){
			echo $e.get_current_user();
		}

		if ($ldapconn) {
		    
			try{ 
		    // binding to ldap server
		    @$ldapbind = ldap_bind($ldapconn, $se[0]['dn'], $ldappass);
			}catch(Exception $e){
				$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
				return !$this->errorCode;
			}
		    // verify binding
		    if ($ldapbind) {
				Yii::app()->getSession()->add('ldap', $se);
			$this->errorCode=self::ERROR_NONE;
			return !$this->errorCode;
		    } else {
		    	Yii::app()->getSession()->remove('ldap');
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
			return !$this->errorCode;
		    }

		}
	
	}
}