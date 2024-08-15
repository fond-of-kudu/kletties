<?php

namespace FondOfKudu\Zed\Kletties\Dependency\Facade;

use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

class KlettiesToLocaleFacadeBridge implements KlettiesToLocaleFacadeInterface
{
    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected LocaleFacadeInterface $facade;

    /**
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     */
    public function __construct(LocaleFacadeInterface $localeFacade)
    {
        $this->facade = $localeFacade;
    }

    /**
     * @return string
     */
    public function getCurrentLocaleName(): string
    {
        return $this->facade->getCurrentLocaleName();
    }
}
