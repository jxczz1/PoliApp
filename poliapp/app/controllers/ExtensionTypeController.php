<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExtensionTypeController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for extension_type
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'ExtensionType', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $extension_type = ExtensionType::find();
        if (count($extension_type) == 0) {
            $this->flash->notice("The search did not find any extension_type");

            $this->dispatcher->forward([
                "controller" => "extension_type",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $extension_type,
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
     * Edits a extension_type
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $extension_type = ExtensionType::findFirstByid($id);
            if (!$extension_type) {
                $this->flash->error("extension_type was not found");

                $this->dispatcher->forward([
                    'controller' => "extension_type",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $extension_type->id;

            $this->tag->setDefault("id", $extension_type->id);
            $this->tag->setDefault("name", $extension_type->name);
            
        }
    }

    /**
     * Creates a new extension_type
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'index'
            ]);

            return;
        }

        $extension_type = new ExtensionType();
        $extension_type->name = $this->request->getPost("name");
        

        if (!$extension_type->save()) {
            foreach ($extension_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "extension_type",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a extension_type edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $extension_type = ExtensionType::findFirstByid($id);

        if (!$extension_type) {
            $this->flash->error("extension_type does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'index'
            ]);

            return;
        }

        $extension_type->name = $this->request->getPost("name");
        

        if (!$extension_type->save()) {

            foreach ($extension_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'edit',
                'params' => [$extension_type->id]
            ]);

            return;
        }

        $this->flash->success("extension_type was updated successfully");

        $this->dispatcher->forward([
            'controller' => "extension_type",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a extension_type
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $extension_type = ExtensionType::findFirstByid($id);
        if (!$extension_type) {
            $this->flash->error("extension_type was not found");

            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'index'
            ]);

            return;
        }

        if (!$extension_type->delete()) {

            foreach ($extension_type->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension_type",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("extension_type was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "extension_type",
            'action' => "index"
        ]);
    }

}
