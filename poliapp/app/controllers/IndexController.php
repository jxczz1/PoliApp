<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {

        if($this->session->get('auth')){

            $extensions = Extension::find();           
            $visitors = Visitor::find();
            $agreements = Agreement::find();
            $innovation = Innovation::find();

            $_extensions = Extension::find([
                'order' => 'id desc',
                'limit' => 3
            ]);
            $_visitors = Visitor::find([
                'order' => 'id desc',
                'limit' => 3
            ]);
            $_agreements = Agreement::find([
                'order' => 'id desc',
                'limit' => 3
            ]);
            $_innovation = Innovation::find([
                'order' => 'id desc',
                'limit' => 3
            ]);

            $data = [
                'extensions' => [
                    'total' => count($extensions),
                    'data' => $_extensions
                ],
                'visitors' => [
                    'total' => count($visitors),
                    'data' => $_visitors
                ],
                'agreements' => [
                    'total' => count($agreements),
                    'data' => $_agreements
                ],
                'innovations' => [
                    'total' => count($innovation),
                    'data' => $_innovation
                ],
            ];

            $data = $this->arrToObject($data);
            $this->view->data = $data;

        }else{
          
            header("Location: session/login");
            die();
        }
    }

    private function arrToObject($arr){
        return json_decode(json_encode($arr), FALSE);
    }

}

