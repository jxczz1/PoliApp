<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
	{        
        $this->assets
        ->collection('headercss')
        ->addCss('css/bootstrap.min.css')
        ->addCss('css/animate.min.css')
        ->addCss('css/light-bootstrap-dashboard.css?v=1.4.0')
        ->addCss('css/pe-icon-7-stroke.css');
        
        $this->assets
        ->collection('headerjs')	
        ->addJs('js/jquery.3.2.1.min.js')
        ->addJs('js/bootstrap.min.js')
        ->addJs('js/chartist.min.js')
        ->addJs('js/bootstrap-notify.js')
        ->addJs('js/light-bootstrap-dashboard.js?v=1.4.0')
        ;

        $mainMenuOptions = array();
        $mainMenuOptions[] = new ViewOptionModel("Inicio", "pe-7s-graph", "index");
        $mainMenuOptions[] = new ViewOptionModel("Extensión", "pe-7s-study", "extension/search");
        $mainMenuOptions[] = new ViewOptionModel("Convenios", "pe-7s-share", "agreement/search");
        $mainMenuOptions[] = new ViewOptionModel("Innovaciones", "pe-7s-rocket", "innovation/search");
        $mainMenuOptions[] = new ViewOptionModel("Visitantes", "pe-7s-users", "visitor/search");

        $mainMenuOptions[] = new ViewOptionModel("Admin", "pe-7s-user", "admin");
        
        $this->view->mainMenuOptions = $mainMenuOptions;
    
    }
}
