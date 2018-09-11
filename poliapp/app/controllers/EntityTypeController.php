<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class EntityTypeController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for entity_type
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'EntityType', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $entity_type = EntityType::find();
        if (count($entity_type) == 0) {
            $this->flash->notice("The search did not find any entity_type");

            $this->dispatcher->forward([
                "controller" => "entity_type",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $entity_type,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a entity_type
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $entity_type = EntityType::findFirstByid($id);
            if (!$entity_type) {
                $this->flash->error("entity_type was not found");

                $this->dispatcher->forward([
                    'controller' => "entity_type",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $entity_type->id;

            $this->tag->setDefault("id", $entity_type->id);
            $this->tag->setDefault("name", $entity_type->name);
            
        }
    }

    /**
     * Creates a new entity_type
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'index'
            ]);

            return;
        }

        $entity_type = new EntityType();
        $entity_type->name = $this->request->getPost("name");
        

        if (!$entity_type->save()) {
            foreach ($entity_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "entity_type",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a entity_type edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $entity_type = EntityType::findFirstByid($id);

        if (!$entity_type) {
            $this->flash->error("entity_type does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'index'
            ]);

            return;
        }

        $entity_type->name = $this->request->getPost("name");
        

        if (!$entity_type->save()) {

            foreach ($entity_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'edit',
                'params' => [$entity_type->id]
            ]);

            return;
        }

        $this->flash->success("entity_type was updated successfully");

        $this->dispatcher->forward([
            'controller' => "entity_type",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a entity_type
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $entity_type = EntityType::findFirstByid($id);
        if (!$entity_type) {
            $this->flash->error("entity_type was not found");

            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'index'
            ]);

            return;
        }

        if (!$entity_type->delete()) {

            foreach ($entity_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entity_type",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("entity_type was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "entity_type",
            'action' => "index"
        ]);
    }

}
