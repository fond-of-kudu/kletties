<?php

namespace FondOfKudu\Zed\Kletties\Dependency\Facade;

use Spryker\Zed\Store\Business\StoreFacadeInterface;

class KlettiesToStoreFacadeBridge implements KlettiesToStoreFacadeInterface
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected StoreFacadeInterface $facade;

    /**
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(StoreFacadeInterface $storeFacade)
    {
        $this->facade = $storeFacade;
    }

    /**
     * @return string
     */
    public function getCurrentStoreName(): string
    {
        return $this->facade->getCurrentStore()->getName();
    }
}
