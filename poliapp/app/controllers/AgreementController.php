<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AgreementController extends ControllerBase
{
    
    public function indexAction()
    {
        $this->persistent->parameters = null;
        
        $entity = Country::find();

        foreach($entity as $entity){
            print_r($entity->name);
            print_r("<br>");
        }
    }

    
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Agreement', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $agreement = Agreement::find();
        if (count($agreement) == 0) {
            $this->flash->notice("The search did not find any agreement");

            $this->dispatcher->forward([
                "controller" => "agreement",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $agreement,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

   
    public function newAction()
    {

    }

    /**
     * Edits a agreement
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $agreement = Agreement::findFirstByid($id);
            if (!$agreement) {
                $this->flash->error("agreement was not found");

                $this->dispatcher->forward([
                    'controller' => "agreement",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $agreement->id;

            $this->tag->setDefault("id", $agreement->id);
            $this->tag->setDefault("name", $agreement->name);
            $this->tag->setDefault("objective", $agreement->objective);
            $this->tag->setDefault("valid_to", $agreement->valid_to);
            $this->tag->setDefault("id_entity_from", $agreement->id_entity_from);
            $this->tag->setDefault("id_entity_with", $agreement->id_entity_with);
            
        }
    }

    /**
     * Creates a new agreement
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'index'
            ]);

            return;
        }

        $agreement = new Agreement();
        $agreement->name = $this->request->getPost("name");
        $agreement->objective = $this->request->getPost("objective");
        $agreement->valid_to = $this->request->getPost("valid_to");
        $agreement->id_entity_from = 1;
        $agreement->id_entity_with = $this->request->getPost("id_entity_with");
        

        if (!$agreement->save()) {
            foreach ($agreement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "agreement",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a agreement edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $agreement = Agreement::findFirstByid($id);

        if (!$agreement) {
            $this->flash->error("agreement does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'index'
            ]);

            return;
        }

        $agreement->name = $this->request->getPost("name");
        $agreement->objective = $this->request->getPost("objective");
        $agreement->validTo = $this->request->getPost("valid_to");
        $agreement->idEntityFrom = $this->request->getPost("id_entity_from");
        $agreement->idEntityWith = $this->request->getPost("id_entity_with");
        

        if (!$agreement->save()) {

            foreach ($agreement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'edit',
                'params' => [$agreement->id]
            ]);

            return;
        }

        $this->flash->success("agreement was updated successfully");

        $this->dispatcher->forward([
            'controller' => "agreement",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a agreement
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $agreement = Agreement::findFirstByid($id);
        if (!$agreement) {
            $this->flash->error("agreement was not found");

            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'index'
            ]);

            return;
        }

        if (!$agreement->delete()) {

            foreach ($agreement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "agreement",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("agreement was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "agreement",
            'action' => "index"
        ]);
    }

}
