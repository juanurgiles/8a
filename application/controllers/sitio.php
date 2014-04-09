<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sitio
 *
 * @author Angela
 */
class sitio extends CI_Controller {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    public function index(){
        $this->load->view('index');
    }
    public function inicio1(){
        $this->load->view('inicio1');
    }
    public function quienes(){
        $this->load->view('quienes');
    }
    public function servicio(){
        $this->load->view('servicio');
    }
    public function simulador(){
        $this->load->database();
        $this->load->model('opcion','opcion');
        $arr['interes']=$this->opcion->get_opcion(1);
        $this->load->view('simulador',$arr);
    }
    public function contactos(){
        $this->load->view('contactos');
    }
    public function login(){
        $this->load->view('login');
    }
}
