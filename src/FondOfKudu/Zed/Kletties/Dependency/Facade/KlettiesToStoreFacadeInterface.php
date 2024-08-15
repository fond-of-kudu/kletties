<?php

namespace FondOfKudu\Zed\Kletties\Dependency\Facade;

interface KlettiesToStoreFacadeInterface
{
    /**
     * @return string
     */
    public function getCurrentStoreName(): string;
}
