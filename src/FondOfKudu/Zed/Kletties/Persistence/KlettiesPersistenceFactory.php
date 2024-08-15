<?php

namespace FondOfKudu\Zed\Kletties\Persistence;

use FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper\KlettiesEntityMapper;
use FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper\KlettiesEntityMapperInterface;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderItemQuery;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Orm\Zed\Kletties\Persistence\FokKlettiesVendorQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfKudu\Zed\Kletties\KlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface getEntityManager()
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface getRepository()
 */
class KlettiesPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper\KlettiesEntityMapperInterface
     */
    public function createKlettiesEntityMapper(): KlettiesEntityMapperInterface
    {
        return new KlettiesEntityMapper();
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    public function createKlettiesOrderQuery(): FokKlettiesOrderQuery
    {
        return FokKlettiesOrderQuery::create();
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesOrderItemQuery
     */
    public function createKlettiesOrderItemQuery(): FokKlettiesOrderItemQuery
    {
        return FokKlettiesOrderItemQuery::create();
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesVendorQuery
     */
    public function createKlettiesVendorQuery(): FokKlettiesVendorQuery
    {
        return FokKlettiesVendorQuery::create();
    }
}
