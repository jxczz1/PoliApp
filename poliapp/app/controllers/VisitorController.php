<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class VisitorController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $this->dispatcher->forward([
            "controller" => "visitor",
            "action" => "search"
        ]);
    }

    /**
     * Searches for visitor
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Visitor', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $visitor = Visitor::find();
      

        $paginator = new Paginator([
            'data' => $visitor,
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
     * Edits a visitor
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $visitor = Visitor::findFirstByid($id);
            if (!$visitor) {
                $this->flash->error("visitor was not found");

                $this->dispatcher->forward([
                    'controller' => "visitor",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $visitor->id;

            $this->tag->setDefault("id", $visitor->id);
            $this->tag->setDefault("objective", $visitor->objective);
            $this->tag->setDefault("arrival_date", $visitor->arrival_date);
            $this->tag->setDefault("departure_date", $visitor->departure_date);
            $this->tag->setDefault("id_visitor_person", $visitor->id_visitor_person);
            $this->tag->setDefault("id_program", $visitor->id_program);
            
        }
    }

    /**
     * Creates a new visitor
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'index'
            ]);

            return;
        }

        $visitor = new Visitor();
        $visitor->objective = $this->request->getPost("objective");
        $visitor->arrival_date = $this->request->getPost("arrival_date");
        $visitor->departure_date = $this->request->getPost("departure_date");
        $visitor->id_visitor_person = $this->request->getPost("id_visitor_person");
        
        

        if (!$visitor->save()) {
            foreach ($visitor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado con éxito");

        $this->dispatcher->forward([
            'controller' => "visitor",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a visitor edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $visitor = Visitor::findFirstByid($id);

        if (!$visitor) {
            $this->flash->error("visitor does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'index'
            ]);

            return;
        }

        $visitor->id = $this->request->getPost("id");
        $visitor->objective = $this->request->getPost("objective");
        $visitor->arrivalDate = $this->request->getPost("arrival_date");
        $visitor->departureDate = $this->request->getPost("departure_date");
        $visitor->idVisitorPerson = $this->request->getPost("id_visitor_person");
        $visitor->idProgram = $this->request->getPost("id_program");
        

        if (!$visitor->save()) {

            foreach ($visitor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'edit',
                'params' => [$visitor->id]
            ]);

            return;
        }

        $this->flash->success("visitor was updated successfully");

        $this->dispatcher->forward([
            'controller' => "visitor",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a visitor
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $visitor = Visitor::findFirstByid($id);
        if (!$visitor) {
            $this->flash->error("visitor was not found");

            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'index'
            ]);

            return;
        }

        if (!$visitor->delete()) {

            foreach ($visitor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "visitor",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("visitor was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "visitor",
            'action' => "index"
        ]);
    }

}
