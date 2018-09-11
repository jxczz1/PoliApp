<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PersonRoleController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for person_role
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'PersonRole', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $person_role = PersonRole::find();
        if (count($person_role) == 0) {
            $this->flash->notice("The search did not find any person_role");

            $this->dispatcher->forward([
                "controller" => "person_role",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $person_role,
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
     * Edits a person_role
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $person_role = PersonRole::findFirstByid($id);
            if (!$person_role) {
                $this->flash->error("person_role was not found");

                $this->dispatcher->forward([
                    'controller' => "person_role",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $person_role->id;

            $this->tag->setDefault("id", $person_role->id);
            $this->tag->setDefault("name", $person_role->name);
            
        }
    }

    /**
     * Creates a new person_role
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'index'
            ]);

            return;
        }

        $person_role = new PersonRole();
        $person_role->name = $this->request->getPost("name");
        

        if (!$person_role->save()) {
            foreach ($person_role->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "person_role",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a person_role edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $person_role = PersonRole::findFirstByid($id);

        if (!$person_role) {
            $this->flash->error("person_role does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'index'
            ]);

            return;
        }

        $person_role->name = $this->request->getPost("name");
        

        if (!$person_role->save()) {

            foreach ($person_role->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'edit',
                'params' => [$person_role->id]
            ]);

            return;
        }

        $this->flash->success("person_role was updated successfully");

        $this->dispatcher->forward([
            'controller' => "person_role",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a person_role
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $person_role = PersonRole::findFirstByid($id);
        if (!$person_role) {
            $this->flash->error("person_role was not found");

            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'index'
            ]);

            return;
        }

        if (!$person_role->delete()) {

            foreach ($person_role->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "person_role",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("person_role was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "person_role",
            'action' => "index"
        ]);
    }

}
