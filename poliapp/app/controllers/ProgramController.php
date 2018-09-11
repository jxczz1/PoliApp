<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ProgramController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for program
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Program', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $program = Program::find($parameters);
        if (count($program) == 0) {
            $this->flash->notice("The search did not find any program");

            $this->dispatcher->forward([
                "controller" => "program",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $program,
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
     * Edits a program
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $program = Program::findFirstByid($id);
            if (!$program) {
                $this->flash->error("program was not found");

                $this->dispatcher->forward([
                    'controller' => "program",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $program->id;

            $this->tag->setDefault("id", $program->id);
            $this->tag->setDefault("name", $program->name);
            $this->tag->setDefault("id_university", $program->id_university);
            
        }
    }

    /**
     * Creates a new program
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'index'
            ]);

            return;
        }

        $program = new Program();
        $program->name = $this->request->getPost("name");
        $program->id_university = $this->request->getPost("id_university");
        

        if (!$program->save()) {
            foreach ($program->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("program was created successfully");

        $this->dispatcher->forward([
            'controller' => "program",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a program edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $program = Program::findFirstByid($id);

        if (!$program) {
            $this->flash->error("program does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'index'
            ]);

            return;
        }

        $program->name = $this->request->getPost("name");
        $program->idUniversity = $this->request->getPost("id_university");
        

        if (!$program->save()) {

            foreach ($program->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'edit',
                'params' => [$program->id]
            ]);

            return;
        }

        $this->flash->success("program was updated successfully");

        $this->dispatcher->forward([
            'controller' => "program",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a program
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $program = Program::findFirstByid($id);
        if (!$program) {
            $this->flash->error("program was not found");

            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'index'
            ]);

            return;
        }

        if (!$program->delete()) {

            foreach ($program->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "program",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("program was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "program",
            'action' => "index"
        ]);
    }

}
