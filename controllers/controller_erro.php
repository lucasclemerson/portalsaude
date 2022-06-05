<?php
    class erro extends controller {
        public function init(){
        }

        public function inicial(){
            $dados = array();
            $dados['base'] = $this->base();
            $dados['objeto'] = DOMINIO.$this->controller.'/';
            $dados['controller'] = $this->controller;
            $this->view('erro', $dados);
        }
    }