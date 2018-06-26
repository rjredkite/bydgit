<?php 
    class MY_Exceptions extends CI_Exceptions {

        public function __construct()
        {
            parent::__construct();
        }

        function show_404($page = '', $log_error = TRUE)
        {

            $CI =& get_instance();
            $data['metatitle']          = 'Breed Your Dog';
            $data['metakeyword']        = 'Page Not found';
            $data['metadescription']    = 'Page Not found';
            $data['metarobots']         = 'NOINDEX, NOFOLLOW';

            $CI->load->view('templates/header',$data);
            $CI->load->view('templates/page-not-found',$data);
            $CI->load->view('templates/footer',$data);
            echo $CI->output->get_output();
            exit;
        }
    }