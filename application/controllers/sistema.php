<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sistema
 *
 * @author Angela
 */
class sistema extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }

    public function main0() {
        $this->load->view('main0');
    }

    public function main1() {
        $this->load->view('main1');
    }

    public function main2() {
        $this->load->view('main2');
    }

    public function inicio() {
        $this->load->view('inicio');
    }

    public function socio($id = null) {
        $arr['id'] = $id;
        $crud = new grocery_CRUD();

        $crud->set_theme('datatables');
        $crud->set_table('personal');
        $crud->where('socio', $id);
        $crud->columns('idPersonal', 'nombrePersonal');
        $crud->set_subject('Personal');
        $crud->add_action('', '', 'sistema/socioConsolidado', 'ui-icon-plus');

        $arr['tabla'] = $crud->render();


        $this->load->view('Paginas/socio', $arr);
    }

    public function socioConsolidado($id = null) {
        $this->load->model('socio', 'socio');
        $arr['socio'] = $this->socio->get_socio($id);
        $this->load->model('aporte', 'aporte');
        $arr['aportes'] = $this->aporte->get_aportes($id);
        $this->load->model('cuenta', 'cuenta');
        $arr['cuentas'] = $this->cuenta->get_cuentas($id);
        $this->load->model('credito', 'credito');
        $arr['creditos'] = $this->credito->get_creditos($id);
        $this->load->view('Paginas/socioConsolidado', $arr);
    }

}
