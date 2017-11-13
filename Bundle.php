<?php

namespace Svi\OrmBundle;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Svi\Application;
use Svi\ArrayAccess;
use Svi\OrmBundle\Service\OrmService;

class Bundle extends \Svi\Service\BundlesService\Bundle
{

    function __construct(Application $app)
    {
        parent::__construct($app);

        if ($app->getConfigService()->get('dbs')) {
            $app['dbs'] = new ArrayAccess();
            foreach ($app->getConfigService()->get('dbs') as $name => $db) {
                $app['dbs'][$name] = DriverManager::getConnection($db, new Configuration());
            }
        }
    }

    protected function getServices()
    {
        return [
            OrmService::class,
        ];
    }

}
