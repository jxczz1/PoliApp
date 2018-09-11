<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class FinancingTypeController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for financing_type
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'FinancingType', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $financing_type = FinancingType::find($parameters);
        if (count($financing_type) == 0) {
            $this->flash->notice("The search did not find any financing_type");

            $this->dispatcher->forward([
                "controller" => "financing_type",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $financing_type,
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
     * Edits a financing_type
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $financing_type = FinancingType::findFirstByid($id);
            if (!$financing_type) {
                $this->flash->error("financing_type was not found");

                $this->dispatcher->forward([
                    'controller' => "financing_type",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $financing_type->id;

            $this->tag->setDefault("id", $financing_type->id);
            $this->tag->setDefault("name", $financing_type->name);
            
        }
    }

    /**
     * Creates a new financing_type
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'index'
            ]);

            return;
        }

        $financing_type = new FinancingType();
        $financing_type->name = $this->request->getPost("name");
        

        if (!$financing_type->save()) {
            foreach ($financing_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("financing_type was created successfully");

        $this->dispatcher->forward([
            'controller' => "financing_type",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a financing_type edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $financing_type = FinancingType::findFirstByid($id);

        if (!$financing_type) {
            $this->flash->error("financing_type does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'index'
            ]);

            return;
        }

        $financing_type->name = $this->request->getPost("name");
        

        if (!$financing_type->save()) {

            foreach ($financing_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'edit',
                'params' => [$financing_type->id]
            ]);

            return;
        }

        $this->flash->success("financing_type was updated successfully");

        $this->dispatcher->forward([
            'controller' => "financing_type",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a financing_type
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $financing_type = FinancingType::findFirstByid($id);
        if (!$financing_type) {
            $this->flash->error("financing_type was not found");

            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'index'
            ]);

            return;
        }

        if (!$financing_type->delete()) {

            foreach ($financing_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "financing_type",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("financing_type was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "financing_type",
            'action' => "index"
        ]);
    }

}
