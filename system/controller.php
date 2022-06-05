<?php
    class controller extends system{

        protected $_sessao = false;

        public function base(){
            $dados = array();
            $dados['libera_views'] = true;
            $dados['logo'] = "";//$dados['imagem']['147796771992551'];
            $dados['favicon'] = "";//$dados['imagem']['147193111415927'];
            $dados['titulo_pagina'] = "Portal Saúde";//$config->titulo_pagina;
            $dados['descricao'] = "";//$config->descricao;
            return $dados;
        }


        protected function view($arquivo, $vars=null){
            if( is_array($vars) && count($vars) > 0){
                extract($vars, EXTR_PREFIX_SAME, 'htm_');
            }
            $url_view = VIEWS."htm_".$arquivo.".php";
            if(!file_exists($url_view)){
               $this->erro();
            } else {
               return require_once($url_view);
            }

        }

        public function gera_codigo(){
            return substr(time().rand(10000,99999),-15);
        }

        protected function limita_texto($var, $limite){
            if (strlen($var) > $limite)	{
                $var = substr($var, 0, $limite);
                $var = trim($var) . "...";
            }
            return $var;
        }

        public function valida($var, $msg = null){
            if(!$var){
                if($msg){
                    $this->msg($msg);
                    $this->volta(1);
                } else {
                    $this->msg('Preencha todos os campos e tente novamente!');
                    $this->volta(1);
                }
            }
        }

    }