<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CountryController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for country
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Country', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $country = Country::find();
        if (count($country) == 0) {
            $this->flash->notice("The search did not find any country");

            $this->dispatcher->forward([
                "controller" => "country",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $country,
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
     * Edits a country
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $country = Country::findFirstByid($id);
            if (!$country) {
                $this->flash->error("country was not found");

                $this->dispatcher->forward([
                    'controller' => "country",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $country->id;

            $this->tag->setDefault("id", $country->id);
            $this->tag->setDefault("name", $country->name);
            
        }
    }

    /**
     * Creates a new country
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'search'
            ]);

            return;
        }

        $country = new Country();
        $country->name = $this->request->getPost("name");
        

        if (!$country->save()) {
            foreach ($country->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Registro creado correctamente");

        $this->dispatcher->forward([
            'controller' => "country",
            'action' => 'search'
        ]);
    }

    /**
     * Saves a country edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $country = Country::findFirstByid($id);

        if (!$country) {
            $this->flash->error("country does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'index'
            ]);

            return;
        }

        $country->name = $this->request->getPost("name");
        

        if (!$country->save()) {

            foreach ($country->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'edit',
                'params' => [$country->id]
            ]);

            return;
        }

        $this->flash->success("country was updated successfully");

        $this->dispatcher->forward([
            'controller' => "country",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a country
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $country = Country::findFirstByid($id);
        if (!$country) {
            $this->flash->error("country was not found");

            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'index'
            ]);

            return;
        }

        if (!$country->delete()) {

            foreach ($country->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "country",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("country was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "country",
            'action' => "index"
        ]);
    }

}
