<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Session\Adapter\Files as Session;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    $di->set(
        'flash',
        function () {
            $flash = new FlashDirect(
                [
                    'error' => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice' => 'alert alert-info',
                    'warning' => 'alert alert-warning',
                ]
            );

            return $flash;
        }
    );

    $di->set(
        'flashSession',
        function () {
            $flash = new FlashSession(
                [
                    'error' => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice' => 'alert alert-info',
                    'warning' => 'alert alert-warning',
                ]
            );

            return $flash;
        }
    );

    $di->setShared(
        'session',
        function () {
            $session = new Session();
            $session->start();
            return $session;
        }
    );

    $di->set('dispatcher', function () {
        $eventsManager = new \Phalcon\Events\Manager();

        $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {

            if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index404'
                ));
                return false;
            }

            $dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index503'
            ));

            return false;
        });

        $dispatcher = new \Phalcon\Mvc\Dispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
