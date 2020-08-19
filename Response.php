<?php

    class Response {

        private $response = [];

        public function __construct($success, $data){
            $this->response['success'] = $success;
            if ($success) {
                $this->response['data'] = $data;
            } else {
                $this->response['message'] = $data;
            }

            echo json_encode( $this->response );
            
        }


    }