<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AgreementHistoryController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for agreement_history
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, '\poliapp\AgreementHistory', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $agreement_history = AgreementHistory::find($parameters);
        if (count($agreement_history) == 0) {
            $this->flash->notice("The search did not find any agreement_history");

            $this->dispatcher->forward([
                "controller" => "agreement_history",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $agreement_history,
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
     * Edits a agreement_history
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $agreement_history = AgreementHistory::findFirstByid($id);
            if (!$agreement_history) {
                $this->flash->error("agreement_history was not found");

                $this->dispatcher->forward([
                    'controller' => "agreement_history",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $agreement_history->id;

            $this->tag->setDefault("id", $agreement_history->id);
            $this->tag->setDefault("date", $agreement_history->date);
            $this->tag->setDefault("achievement", $agreement_history->achievement);
            $this->tag->setDefault("id_agreement", $agreement_history->id_agreement);
            
        }
    }

    /**
     * Creates a new agreement_history
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'index'
            ]);

            return;
        }

        $agreement_history = new AgreementHistory();
        $agreement_history->date = $this->request->getPost("date");
        $agreement_history->achievement = $this->request->getPost("achievement");
        $agreement_history->idAgreement = $this->request->getPost("id_agreement");
        

        if (!$agreement_history->save()) {
            foreach ($agreement_history->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("agreement_history was created successfully");

        $this->dispatcher->forward([
            'controller' => "agreement_history",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a agreement_history edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $agreement_history = AgreementHistory::findFirstByid($id);

        if (!$agreement_history) {
            $this->flash->error("agreement_history does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'index'
            ]);

            return;
        }

        $agreement_history->date = $this->request->getPost("date");
        $agreement_history->achievement = $this->request->getPost("achievement");
        $agreement_history->idAgreement = $this->request->getPost("id_agreement");
        

        if (!$agreement_history->save()) {

            foreach ($agreement_history->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'edit',
                'params' => [$agreement_history->id]
            ]);

            return;
        }

        $this->flash->success("agreement_history was updated successfully");

        $this->dispatcher->forward([
            'controller' => "agreement_history",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a agreement_history
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $agreement_history = AgreementHistory::findFirstByid($id);
        if (!$agreement_history) {
            $this->flash->error("agreement_history was not found");

            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'index'
            ]);

            return;
        }

        if (!$agreement_history->delete()) {

            foreach ($agreement_history->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "agreement_history",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("agreement_history was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "agreement_history",
            'action' => "index"
        ]);
    }

}
