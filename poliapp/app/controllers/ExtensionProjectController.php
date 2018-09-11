<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ExtensionProjectController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for extension_project
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'ExtensionProject', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $extension_project = ExtensionProject::find($parameters);
        if (count($extension_project) == 0) {
            $this->flash->notice("The search did not find any extension_project");

            $this->dispatcher->forward([
                "controller" => "extension_project",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $extension_project,
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
     * Edits a extension_project
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $extension_project = ExtensionProject::findFirstByid($id);
            if (!$extension_project) {
                $this->flash->error("extension_project was not found");

                $this->dispatcher->forward([
                    'controller' => "extension_project",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $extension_project->id;

            $this->tag->setDefault("id", $extension_project->id);
            $this->tag->setDefault("date", $extension_project->date);
            $this->tag->setDefault("id_financing", $extension_project->id_financing);
            $this->tag->setDefault("id_extension", $extension_project->id_extension);
            
        }
    }

    /**
     * Creates a new extension_project
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'index'
            ]);

            return;
        }

        $extension_project = new ExtensionProject();
        $extension_project->date = $this->request->getPost("date");
        $extension_project->idFinancing = $this->request->getPost("id_financing");
        $extension_project->idExtension = $this->request->getPost("id_extension");
        

        if (!$extension_project->save()) {
            foreach ($extension_project->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("extension_project was created successfully");

        $this->dispatcher->forward([
            'controller' => "extension_project",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a extension_project edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $extension_project = ExtensionProject::findFirstByid($id);

        if (!$extension_project) {
            $this->flash->error("extension_project does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'index'
            ]);

            return;
        }

        $extension_project->date = $this->request->getPost("date");
        $extension_project->idFinancing = $this->request->getPost("id_financing");
        $extension_project->idExtension = $this->request->getPost("id_extension");
        

        if (!$extension_project->save()) {

            foreach ($extension_project->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'edit',
                'params' => [$extension_project->id]
            ]);

            return;
        }

        $this->flash->success("extension_project was updated successfully");

        $this->dispatcher->forward([
            'controller' => "extension_project",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a extension_project
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $extension_project = ExtensionProject::findFirstByid($id);
        if (!$extension_project) {
            $this->flash->error("extension_project was not found");

            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'index'
            ]);

            return;
        }

        if (!$extension_project->delete()) {

            foreach ($extension_project->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "extension_project",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("extension_project was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "extension_project",
            'action' => "index"
        ]);
    }

}
