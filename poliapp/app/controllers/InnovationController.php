<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class InnovationController extends ControllerBase
{
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $this->dispatcher->forward([
            "controller" => "innovation",
            "action" => "search"
        ]);
    }

   
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Innovation', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $innovation = Innovation::find();
        
        $paginator = new Paginator([
            'data' => $innovation,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    
    public function newAction()
    {

    }

    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $innovation = Innovation::findFirstByid($id);
            if (!$innovation) {
                $this->flash->error("innovation was not found");

                $this->dispatcher->forward([
                    'controller' => "innovation",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $innovation->id;

            $this->tag->setDefault("id", $innovation->id);
            $this->tag->setDefault("name", $innovation->name);
            $this->tag->setDefault("description", $innovation->description);
            $this->tag->setDefault("date", $innovation->date);
            $this->tag->setDefault("id_performed_by", $innovation->id_performed_by);
            $this->tag->setDefault("id_beneficiary_entity", $innovation->id_beneficiary_entity);
            
        }
    }

    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'index'
            ]);

            return;
        }

        $innovation = new Innovation();
        $innovation->name = $this->request->getPost("name");
        $innovation->description = $this->request->getPost("description");
        $innovation->date = $this->request->getPost("date");
        $innovation->id_performed_by = $this->request->getPost("id_performed_by");
        $innovation->id_beneficiary_entity = $this->request->getPost("id_beneficiary_entity");
        

        if (!$innovation->save()) {
            foreach ($innovation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "innovation",
            'action' => 'index'
        ]);
    }

    
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $innovation = Innovation::findFirstByid($id);

        if (!$innovation) {
            $this->flash->error("innovation does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'index'
            ]);

            return;
        }

        $innovation->name = $this->request->getPost("name");
        $innovation->description = $this->request->getPost("description");
        $innovation->date = $this->request->getPost("date");
        $innovation->idPerformedBy = $this->request->getPost("id_performed_by");
        $innovation->idBeneficiaryEntity = $this->request->getPost("id_beneficiary_entity");
        

        if (!$innovation->save()) {

            foreach ($innovation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'edit',
                'params' => [$innovation->id]
            ]);

            return;
        }

        $this->flash->success("innovation was updated successfully");

        $this->dispatcher->forward([
            'controller' => "innovation",
            'action' => 'index'
        ]);
    }

    
    public function deleteAction($id)
    {
        $innovation = Innovation::findFirstByid($id);
        if (!$innovation) {
            $this->flash->error("innovation was not found");

            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'index'
            ]);

            return;
        }

        if (!$innovation->delete()) {

            foreach ($innovation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "innovation",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("innovation was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "innovation",
            'action' => "index"
        ]);
    }

}
