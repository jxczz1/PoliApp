<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PersonController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for person
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Person', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $person = Person::find();
        if (count($person) == 0) {
            $this->flash->notice("The search did not find any person");

            $this->dispatcher->forward([
                "controller" => "person",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $person,
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
     * Edits a person
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $person = Person::findFirstByid($id);
            if (!$person) {
                $this->flash->error("person was not found");

                $this->dispatcher->forward([
                    'controller' => "person",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $person->id;

            $this->tag->setDefault("id", $person->id);
            $this->tag->setDefault("name", $person->name);
            $this->tag->setDefault("id_role", $person->id_role);
            $this->tag->setDefault("id_program", $person->id_program);
            
        }
    }

    /**
     * Creates a new person
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'index'
            ]);

            return;
        }

        $person = new Person();
        $person->name = $this->request->getPost("name");
        $person->id_role = $this->request->getPost("id_role");
        $person->id_program = $this->request->getPost("id_program");
        

        if (!$person->save()) {
            foreach ($person->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "person",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a person edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $person = Person::findFirstByid($id);

        if (!$person) {
            $this->flash->error("person does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'index'
            ]);

            return;
        }

        $person->name = $this->request->getPost("name");
        $person->idRole = $this->request->getPost("id_role");
        $person->idProgram = $this->request->getPost("id_program");
        

        if (!$person->save()) {

            foreach ($person->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'edit',
                'params' => [$person->id]
            ]);

            return;
        }

        $this->flash->success("person was updated successfully");

        $this->dispatcher->forward([
            'controller' => "person",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a person
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $person = Person::findFirstByid($id);
        if (!$person) {
            $this->flash->error("person was not found");

            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'index'
            ]);

            return;
        }

        if (!$person->delete()) {

            foreach ($person->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "person",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("person was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "person",
            'action' => "index"
        ]);
    }

}
