<?php

require APPPATH . 'libraries/REST_Controller.php';


class Devops extends REST_Controller
{




    public function __construct()
    {

        parent::__construct();

        $this->load->database();
        $this->lang->load('response', 'english');
    }



    /**

     * Get All Data from this method.

     *

     * @return Response

    */

    public function index_get()
    {
        $query = "SELECT c.* FROM candidate_form_lists c, bizform_candidates.status as candidate_status 
                LEFT JOIN bizform_candidates ON bizform_candidates.candidate_id = candidate_data_table.candidate_id WHERE candidate_id= '9wIDli4gPyTfj' AND status = 75 ORDER BY template_order, status ASC LIMIT 1";
        print_r($this->db->query($query));
        exit();

    }
}