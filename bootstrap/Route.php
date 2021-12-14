<?php

namespace Bootstrap;

class Route
{
    private $getActions;
    private $postActions;

    public function __construct()
    {
        $routeFiles = scandir("../router");
        foreach ($routeFiles as $routeFile) {
            if (strpos($routeFile, '.php')) {
                $routes = include("../router/$routeFile");

                $this->getActions = array_map($this->getActions, $routes['GET'] ?? []);
                $this->postActions = array_map($this->postActions, $routes['POST'] ?? []);
            }
        }
    }

    public function getAction($patch, $request)
    {
        if ($request['method'] === 'GET') {
            if (in_array($patch, array_keys($this->getActions))) {
                $action = $this->getActions[$patch];

                if (isset($action[0]) && file_exists('../app/controller/' . $action[0] . '.php')) {
                    $className = "App\controller\\" . $action[0];
                    $methodName = $action[1];
                    
                    $class = new $className();

                    return $class->$methodName();
                } else {
                    throw new \Exception("Not found exception");
                }
            } else {
                throw new \Exception("Not found exception");
            }
        }

        if ($request['method'] === 'POST') {
            if (in_array($patch, $this->postActions)) {
                $action = $this->getActions[$patch];
                if (isset($action[0]) && file_exists('../app/controller/' . $action[0] . '.php')) {
                    $className = "App\controller\\" . $action[0];
                    $methodName = $action[1];

                    $class = new $className();

                    return $class->$methodName($request['data']);
                } else {
                    throw new \Exception("Not found exception");
                }
            } else {
                throw new \Exception("Not found exception");
            }
        }
    }
}