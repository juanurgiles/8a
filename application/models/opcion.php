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
class opcion extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_opcion($id = null) {
        $this->db->select();
        $this->db->from('opciones');
        $this->db->where('idO', $id);

        $query = $this->db->get();
        return $query->result()[0];
    }

}
