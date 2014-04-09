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
}
