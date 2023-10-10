<?php

namespace app\core;
use app\core\db\Database;

  /**
   * Summary of Application
   * @author CoderShani
   * @package app\core
   * @copyright (c) 2023
   */

Class Application
{
    public string $layout = 'main';
    public string $userClass;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;

    public static Application $app;
    public ?Controller $controller = null;

    /**
     * Summary of __construct
     * @param mixed $rootPath
     */
    public function __construct($rootPath, array $config)
    {
        $this->user = null;
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request,$this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } 
    }

    /**
     * Summary of getController
     * @return \app\core\Controller
     */
    public function getController(): Controller 
    {
        return $this->controller;
    }

    /**
     * Summary of setController
     * @param \app\core\Controller $controller
     * @return void
     */
    public function setController(Controller $controller):void
    {
        $this->controller = $controller;
    }

    /**
     * Summary of login
     * @param \app\core\UserModel $user
     * @return bool
     */
    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    /**
     * Summary of logout
     * @return void
     */
    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /**
     * Summary of run
     * @return void
     */
    public function run() {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * Summary of isGuest
     * @return bool
     */
    public static function isGuest()
    {
        return !self::$app->user;
    }
}