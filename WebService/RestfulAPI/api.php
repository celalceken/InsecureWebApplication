<?php
    
	/* 
		RestAPI
 	*/
	
require_once("Rest.inc.php");
require_once(__DIR__.'/../../Model/Ogrenci.class.php');

//require_once("Ogrenci.class.php");
require_once (__DIR__.'/../../Model/OgrenciGoruntuleJSON.class.php');

	class API extends REST {
	
		private $data = array();

		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			include(__DIR__.'/../../Include/DatabaseConnection.php');
			$this->db=$veritabaniBaglantisi;// Initiate Database connection
		}
		

		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			//echo $_REQUEST['request'];
                                /*$func = strtolower(trim(str_replace("/",".",$_SERVER['REQUEST_URI'])));
                                $func=explode(".",$func);
                                $func=end($func);*/
			//if((int)method_exists($func) > 0)

            $urlParts = parse_url($_SERVER['REQUEST_URI']);
            /*
            foreach($parts as $part)
                echo $part."-";*/
            parse_str($urlParts['query'], $query);
            $this->data=array('param1'=> $query['id']);




            parse_str($urlParts['path'], $path);




            $func=key($path);

            $func=explode("/",$func);
            $func=end($func);

            $this->$func();
			//else
			//	$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
		}
		
		/* 
		 *	For Authentication
		 */
		
		private function login()
        {

		}
		
		private function getStudents() //﻿curl --request GET "localhost/SecureSoftwareDevelopment/Lecture5WebService/RestfulAPI/api.php/getStudents"
        {
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$sql="SELECT \"ogrenciNo\", \"adi\", \"soyadi\" FROM \"Ogrenci\"";
			$query = $this->db->prepare($sql);
			if($query->execute()> 0)
			{
				$query->setFetchMode(PDO::FETCH_CLASS, "\cc\Ogrenci");
				$ogrenciler=$query->fetchAll();
				$jsonGoruntuleyici= new \cc\OgrenciGoruntuleJSON();
				$str='[';
				foreach($ogrenciler as $ogrenci)
					$str.=$jsonGoruntuleyici->getKisi($ogrenci).',';
				$str=$str.']';

				//echo $str;
				$this->response($str, 200);
			} else
			$this->response('',204);	// If no records "No Content" status*/
		}


        private function getStudent()
        {

		    //﻿curl --request GET "localhost/SecureSoftwareDevelopment/Lecture5WebService/RestfulAPI/api.php/user?id='1'"


            if($this->get_request_method() != "GET")
            {
                $this->response('',406);
            }


            $id = $this->data["param1"];


            $sql="SELECT \"ogrenciNo\", \"adi\", \"soyadi\" FROM \"Ogrenci\" WHERE \"ogrenciNo\"=$id ";
            $query = $this->db->prepare($sql);
            if($query->execute()> 0)
            {
                $query->setFetchMode(PDO::FETCH_CLASS, "\cc\Ogrenci");
                $ogrenciler=$query->fetchAll();
                $jsonGoruntuleyici= new \cc\OgrenciGoruntuleJSON();

                    $str=$jsonGoruntuleyici->getKisi($ogrenciler[0]);

                $this->response($str, 200);
            } else
                $this->response('',204);	// If no records "No Content" status
        }


		
		private function deleteStudent()
        {

		}

        private function insertStudent()
        {

        }
		


	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();