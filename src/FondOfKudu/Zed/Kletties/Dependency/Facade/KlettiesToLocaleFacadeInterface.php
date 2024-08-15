<?php

namespace FondOfKudu\Zed\Kletties\Dependency\Facade;

interface KlettiesToLocaleFacadeInterface
{
    /**
     * @return string
     */
    public function getCurrentLocaleName(): string;
}
