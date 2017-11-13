<?php

namespace Svi\OrmBundle\Service;

use Doctrine\DBAL\Connection;
use Svi\AppContainer;

class OrmService extends AppContainer
{

    /**
     * @param string $schema
     * @return Connection
     */
    public function getConnection($schema = 'default')
    {
        return $this->app['dbs'][$schema];
    }

}