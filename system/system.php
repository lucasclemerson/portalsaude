<?php

    class system{

        private $url;
        private $explode;
        public $controller;
        public $action;
        public $params;
        public $autenticado = false;

        public function __construct() {
            $this->setUrl();
            $this->setExplode();
            $this->setController();
            $this->setAction();
            $this->setParams();
        }

        private function setUrl() {
            $string = str_replace(array("<", ">", "\\", "=", "?", "#"), "",  $_SERVER['REQUEST_URI']);
            $string = trim($string);
            $string = strip_tags($string);
            //$string = (get_magic_quotes_gpc()) ? $string : stripslashes($string);
            $string = ($string == null ? 'index' : $string);
            $string = ($string == 'inicial' ? 'index' : $string);
            $string = ($string == 'inicial/' ? 'index' : $string);
            $this->url = $string;
        }

        private function setExplode(){
            $this->explode = explode('/', $this->url);
        }

        private function setController(){
            $this->controller = $this->explode[2];
        }

        private function setAction(){
            $string = (!isset($this->explode[1]) || $this->explode[1] == "portalsaude" ? "inicial" : $this->explode[1]);
            $string = ($string == null ? 'inicial' : $string);
            $this->action = $string;
        }

        private function setParams(){
            unset($this->explode[0], $this->explode[1] );
            if(end($this->explode) == null ) array_pop( $this->explode );
            $i = 0;
            if( !empty($this->explode) ){
                foreach ( $this->explode as $val) {
                    if( $i % 2 == 0 ){
                        $ind[] = $val;
                    } else {
                        $value[] = $val;
                    }
                    $i++;
                }
            } else {
                $ind = array();
                $value = array();
            }
            if( isset($ind) AND isset($value) ){
                if( count($ind) == count($value) && !empty($ind) && !empty($value)){
                    $this->params = array_combine($ind, $value);
                } else {
                    $this->params = array();
                }
            } else {
                $this->params = array();
            }
        }


        public function get($name){
            if(isset($this->params[$name])){
                return $this->params[$name];
            } else {
                return '';
            }
        }

        public function post($name){
            if(isset($_POST[$name])){
                $string = str_replace(array("<", ">", "\\", "//", "#"), "", $_POST[$name]);
                $string = trim($string);
                $string = strip_tags($string);
                //$string = (get_magic_quotes_gpc()) ? $string : stripslashes($string);
                return $string;
            } else {
                return '';
            }
        }


        public function irpara($endereco, $destino = '_self'){
            echo "<script> window.open('".$endereco."', target='$destino');</script>";
            exit();
        }

        public function volta($n){
            echo "<script> history.go(-".$n."); </script>";
            exit();
        }

        public function msg($msg){
            echo "<script> alert('".$msg."'); </script>";
        }

        public function erro(){
            $this->irpara(DOMINIO.'erro');
            exit;
        }

        public function run(){
            $controllers_path = CONTROLLERS.'controller_'.$this->controller.'.php';
            if(!file_exists($controllers_path)){
                $this->erro();
            }else{
                 require_once($controllers_path);
                 $app = new $this->controller();
                 $app->init();
                 $action = $this->action;
                 if(!method_exists($app, $action) ){
                     $this->erro();
                 } else {
                     $app->$action();
                 }
            }
        }
    }