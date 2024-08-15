<?php

namespace FondOfKudu\Zed\Kletties\Business;

use FondOfKudu\Zed\Kletties\Business\Model\Handler\KlettiesOrderHandler;
use FondOfKudu\Zed\Kletties\Business\Model\Handler\KlettiesOrderHandlerInterface;
use FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapper;
use FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface;
use FondOfKudu\Zed\Kletties\Business\Model\Reader\KlettiesReader;
use FondOfKudu\Zed\Kletties\Business\Model\Reader\KlettiesReaderInterface;
use FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriter;
use FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface;
use FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeInterface;
use FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeInterface;
use FondOfKudu\Zed\Kletties\KlettiesDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * Class KlettiesBusinessFactory
 *
 * @package FondOfKudu\Zed\Kletties\Business
 *
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface getEntityManager()()
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface getRepository()
 */
class KlettiesBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\Kletties\Business\Model\Handler\KlettiesOrderHandlerInterface
     */
    public function createKlettiesOrderHandler(): KlettiesOrderHandlerInterface
    {
        return new KlettiesOrderHandler(
            $this->createKlettiesOrderMapper(),
            $this->createKlettiesOrderWriter(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface
     */
    public function createKlettiesOrderMapper(): KlettiesOrderMapperInterface
    {
        return new KlettiesOrderMapper($this->getConfig(), $this->getLocaleFacade(), $this->getRepository(), $this->getStoreFacade());
    }

    /**
     * @return \FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface
     */
    public function createKlettiesOrderWriter(): KlettiesOrderWriterInterface
    {
        return new KlettiesOrderWriter($this->getEntityManager());
    }

    /**
     * @return \FondOfKudu\Zed\Kletties\Business\Model\Reader\KlettiesReaderInterface
     */
    public function createKlettiesReader(): KlettiesReaderInterface
    {
        return new KlettiesReader($this->getRepository());
    }

    /**
     * @return \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeInterface
     */
    public function getLocaleFacade(): KlettiesToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(KlettiesDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeInterface
     */
    public function getStoreFacade(): KlettiesToStoreFacadeInterface
    {
        return $this->getProvidedDependency(KlettiesDependencyProvider::FACADE_STORE);
    }
}
