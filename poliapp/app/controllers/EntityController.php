<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class EntityController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
  
    }

    /**
     * Searches for entity
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Entity', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $entity = Entity::find();
        if (count($entity) == 0) {
            $this->flash->notice("The search did not find any entity");

            $this->dispatcher->forward([
                "controller" => "entity",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $entity,
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
     * Edits a entity
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $entity = Entity::findFirstByid($id);
            if (!$entity) {
                $this->flash->error("entity was not found");

                $this->dispatcher->forward([
                    'controller' => "entity",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $entity->id;

            $this->tag->setDefault("id", $entity->id);
            $this->tag->setDefault("name", $entity->name);
            $this->tag->setDefault("id_type", $entity->id_type);
            $this->tag->setDefault("id_country", $entity->id_country);
            
        }
    }

    /**
     * Creates a new entity
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'index'
            ]);

            return;
        }

        $entity = new Entity();
        $entity->name = $this->request->getPost("name");
        $entity->id_type = $this->request->getPost("id_type");
        $entity->id_country = $this->request->getPost("id_country");
        

        if (!$entity->save()) {
            foreach ($entity->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "entity",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a entity edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $entity = Entity::findFirstByid($id);

        if (!$entity) {
            $this->flash->error("entity does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'index'
            ]);

            return;
        }

        $entity->name = $this->request->getPost("name");
        $entity->id_type = $this->request->getPost("id_type");
        $entity->id_country = $this->request->getPost("id_country");
        

        if (!$entity->save()) {

            foreach ($entity->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'edit',
                'params' => [$entity->id]
            ]);

            return;
        }

        $this->flash->success("entity was updated successfully");

        $this->dispatcher->forward([
            'controller' => "entity",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a entity
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $entity = Entity::findFirstByid($id);
        if (!$entity) {
            $this->flash->error("entity was not found");

            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'index'
            ]);

            return;
        }

        if (!$entity->delete()) {

            foreach ($entity->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entity",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("entity was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "entity",
            'action' => "index"
        ]);
    }

}
