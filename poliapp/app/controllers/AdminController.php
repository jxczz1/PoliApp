<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class AdminController extends ControllerBase
{
   
    public function indexAction()
    {
        $options[] = new ViewOptionModel("Convenios", "pe-7s-share", "agreement/search");       
        $options[] = new ViewOptionModel("Paises", "pe-7s-global", "country/search");
        $options[] = new ViewOptionModel("Entidades", "pe-7s-culture", "entity/search");
        $options[] = new ViewOptionModel("Tipo de entidades", "pe-7s-map-marker", "entity_type/search");
       
        
        $options[] = new ViewOptionModel("Extension", "pe-7s-study", "extension/search");
        $options[] = new ViewOptionModel("Proyectos de extensión", "pe-7s-network", "extension_project/search");
        $options[] = new ViewOptionModel("Tipos de extensión", "pe-7s-portfolio", "extension_type/search");
        $options[] = new ViewOptionModel("Tipos de financiación", "pe-7s-cash", "financing_type/search");
        $options[] = new ViewOptionModel("Innovaciones", "pe-7s-rocket", "innovation/search");
        $options[] = new ViewOptionModel("Personas", "pe-7s-user", "person/search");
        $options[] = new ViewOptionModel("Roles[personas]", "pe-7s-add-user", "person_role/search");
        $options[] = new ViewOptionModel("Programas", "pe-7s-box2", "program/search");
        $options[] = new ViewOptionModel("Visitantes", "pe-7s-users", "visitor/search");
       
        
         
        $this->view->options = $options;
        $this->persistent->parameters = null;
    }

   

}

?>