<?php namespace App\Listeners;

class Route {

    /**
     * Sets `controller` and `action` application global and view variables, with the names, without affixes/verbs.
     * @param \Illuminate\Routing\Route $route
     */
    public function handle(\Illuminate\Routing\Route $route/*, $request*/) {
        $view = view();

        $controller = explode('\\', strtok($route->getAction()['controller'], '@'));
        $controller = end($controller);
        $controller = strtolower(substr($controller, 0, strpos($controller, 'Controller')));
        $action     = camel_case(preg_replace('/^(get|post|put|delete|patch)/', '', strtok('')));

        $view->share('action', app()['action'] = $action);
        $view->share('controller', app()['controller'] = $controller);
    }

}
