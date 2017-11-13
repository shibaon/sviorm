<?php

namespace Svi\OrmBundle;

use Svi\OrmBundle\Service\OrmService;

trait BundleTrait
{

    /**
     * @return OrmService
     */
    public function getOrmService()
    {
        return $this->app[OrmService::class];
    }

}