<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ExtensionController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $this->dispatcher->forward([
            "controller" => "extension",
            "action" => "search"
        ]);
    }

    /**
     * Searches for extension
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Extension', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }

        $extension = Extension::find();

       
        if (count($extension) == 0) {
            $this->flash->notice("No se encontraron resultados");

            $this->dispatcher->forward([
                "controller" => "extension",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $extension,
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
     * Edits a extension
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $extension = Extension::findFirstByid($id);
            if (!$extension) {
                $this->flash->error("extension was not found");

                $this->dispatcher->forward([
                    'controller' => "extension",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $extension->id;

            $this->tag->setDefault("id", $extension->id);
            $this->tag->setDefault("name", $extension->name);
            $this->tag->setDefault("id_coordinator", $extension->id_coordinator);
            $this->tag->setDefault("id_type", $extension->id_type);
            $this->tag->setDefault("id_program", $extension->id_program);
            $this->tag->setDefault("users", $extension->users);
            
        }
    }

    /**
     * Creates a new extension
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'index'
            ]);

            return;
        }

        $extension = new Extension();
        $extension->name = $this->request->getPost("name");
        $extension->id_coordinator = $this->request->getPost("id_coordinator");
        $extension->id_type = $this->request->getPost("id_type");
        $extension->id_program = $this->request->getPost("id_program");
        $extension->users = $this->request->getPost("users");
        

        if (!$extension->save()) {
            foreach ($extension->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "extension",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a extension edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'search'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $extension = Extension::findFirstByid($id);

        if (!$extension) {
            $this->flash->error("No se encontró resultado " . $id);

            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'search'
            ]);

            return;
        }

        $extension->name = $this->request->getPost("name");
        $extension->id_coordinator = $this->request->getPost("id_coordinator");
        $extension->id_type = $this->request->getPost("id_type");
        $extension->id_program = $this->request->getPost("id_program");
        $extension->users = $this->request->getPost("users");
        
        

        if (!$extension->save()) {

            foreach ($extension->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'edit',
                'params' => [$extension->id]
            ]);

            return;
        }

        $this->flash->success("Registro editado correctamente");

        $this->dispatcher->forward([
            'controller' => "extension",
            'action' => 'search'
        ]);
    }

    /**
     * Deletes a extension
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $extension = Extension::findFirstByid($id);
        if (!$extension) {
            $this->flash->error("extension was not found");

            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'index'
            ]);

            return;
        }

        if (!$extension->delete()) {

            foreach ($extension->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("extension was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "extension",
            'action' => "index"
        ]);
    }

}
