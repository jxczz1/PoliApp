<?php
use Phalcon\Translate\Adapter\NativeArray;
class SessionController extends ControllerBase
{

    private function _registerSession($user)
	{
		$this->session->set(
				'auth',
				array(
						'id_user'		=> $user->id,
						'name'			=> $user->name,
						'role'          => $user->role
						//'role'	        =>Role::findFirst("id='".$user->id_role."'")->role,	
						
				)
			);
	}
	private function _unregisterSession(){
		$this->session->remove('auth');
	}
	/**
	 * This action authenticate and logs a user into the application
	 */
	public function indexAction()
	{
		if ($this->request->isPost()) {
	
			// Recibir los datos ingresados por el usuario
			$username    = $this->request->getPost('user');
			$password = $this->request->getPost('password');
			// Buscar el usuario en la base de datos
			
			if($username == 'admin' && $password == 'admin'){

				$user = array(
					'id_user' => 1,
					'name' => $username,
					'role' => 'admin'
				);

				$this->_registerSession($user);
	
				
				return $this->dispatcher->forward(
						array(
								'controller' => 'index',
								'action'     => 'index'
						)
				);
			}
			
			/*$user = User::findFirst(
                array(
                        "(email = :email:) AND password = :password:",
                        'bind' => array(
                                'email'    => $email,
                                'password' => sha1($password),
                        )
                )
            );*/
	
			/*if ($user != false){
	
				$this->_registerSession($user);
	
				
				return $this->dispatcher->forward(
						array(
								'controller' => 'index',
								'action'     => 'index'
						)
				);
			}*/
			
			$this->flash->error('Email/Password incorrectos');
			// Redireccionar a el forma de login nuevamente
			return $this->dispatcher->forward(
					array(
							'controller' => 'session',
							'action'     => 'login'
					)
			);
			
		}
	}

    public function loginAction()
    {
		
    }

    public function logoutAction(){
    	$this->_unregisterSession();
    	return $this->dispatcher->forward(
    			array(
    					'controller' => 'session',
    					'action'     => 'login'
    			)
    		);
    	
    }

}

