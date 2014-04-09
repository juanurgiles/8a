<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of opcion
 *
 * @author Angela
 */
class cuenta extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_cuenta($id = null) {
        $this->db->select();
        $this->db->from('cuenta');
        $this->db->where('idCuenta', $id);

        $query = $this->db->get();
        return $query->result()[0];
    }
    public function get_cuentas($id = null) {
        $this->db->select();
        $this->db->from('cuenta');
        $this->db->where('idP', $id);

        $query = $this->db->get();
        return $query->result();
    }

}
