<?php
	require_once(dirname($_SERVER['DOCUMENT_ROOT']) . "/www/php/connect.php");

	class User{
		public $id;
		public $email;
		public $logged_in;

    	public function __construct(){
			if($this->cookie_code_is_valid()){
				$this->logged_in = true;
				$this->id = $this->get_user_id_by_cookie($_COOKIE['code']);
				$this->load_user_data_by_id($this->id);
			} else {
				$this->logged_in = false;
			}
		}

		public function load_user_data_by_id($id){
			$query = mysql_query("
				SELECT
					mail
				FROM
					user
				WHERE
					id = '" . $id . "'
			");
			$a = mysql_fetch_array($query);

			$this->email = $a[0];
		}

		public function login($email, $password){
			$login_successfull = false;
			$email = mysql_real_escape_string($email);
			$this->email = mysql_real_escape_string($email);
			$password = md5($password);

			if(!$this->logged_in){
				$query = mysql_fetch_array(mysql_query("
					SELECT
						COUNT(*),
						id
					FROM
						user
					WHERE
						mail = '" . $email . "'
					AND
						password = '" . $password . "'
				"));
				if($query[0] == 1)
				{
					$code = $this->rand_string(64);
					setcookie("code", $code, time() + (60 * 60 * 24 * 365));
					mysql_query("
						INSERT INTO session (
							userId,
							sessionCode
						) VALUES (
							" . $query[1] . ",
							'" . $code . "'
						);
					");
					$this->id = $this->get_user_id_by_email($email);
					$this->load_user_data_by_id($this->id);
					$this->logged_in = true;
					$login_successfull = true;
					return "success";
				} else {
					return "loginWrong";
				}
			} else {
				header("Location: /index.php");
			}
		}

		public static function registrieren($email, $pw1, $pw2){
			if($pw1 == $pw2){
				$query = mysql_fetch_array(mysql_query("
					SELECT
						COUNT(*)
					FROM
						user
					WHERE
						mail = '" . mysql_real_escape_string($email) . "'
				"));
				if($query[0] == 0){
					mysql_query("
						INSERT INTO user (
							mail,
							password
						)
						VALUES (
							'" . mysql_real_escape_string($email) . "',
							'" . md5($pw1) . "'
						)
					");
					return "regSuccess";
				} else {
					return "userExistsAlready";
				}
			} else {
				return "differentPWs";
			}
		}

		public function logout(){
			if($this->logged_in){
				mysql_query("
					DELETE FROM
						session
					WHERE
						session.sessionCode = '" . $_COOKIE['code'] . "'
				");
				setcookie ("code", "", time() - 3600);
				$this->logged_in = false;
			}
		}


		//private

		private function cookie_code_is_valid(){
			if(isset($_COOKIE['code'])){
				$query = mysql_query("
					SELECT
						COUNT(user.id)
					FROM
						user,
						session
					WHERE
						session.userId = user.id
					AND
						session.sessionCode = '" . $_COOKIE['code'] . "'
				");
				if(mysql_fetch_array($query)[0] == 1){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		private function get_user_id_by_cookie($str){
			$query = mysql_query("
				SELECT
					session.userID
				FROM
					user,
					session
				WHERE
					session.userId = user.id
				AND
					session.sessionCode = '" . $str . "'
			");
			return (mysql_fetch_array($query)[0]);
		}

		private function get_user_id_by_email($str){
			$query = mysql_query("
				SELECT
					user.id
				FROM
					user
				WHERE
					user.mail = '" . $str . "'
			");
			return mysql_fetch_array($query)[0];
		}

		private static function rand_string($lng)
		{
			mt_srand(crc32(microtime()));
			$buchstaben = "abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
			$str_lng = strlen($buchstaben)-1;
			$rand= "";
			for($i=0;$i<$lng;$i++){
				$rand.= $buchstaben{mt_rand(0, $str_lng)};
			}
			return $rand;
		}
	}
