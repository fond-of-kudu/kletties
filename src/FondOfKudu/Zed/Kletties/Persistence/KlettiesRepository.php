<?php

namespace FondOfKudu\Zed\Kletties\Persistence;

use FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper\KlettiesEntityMapperInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesPersistenceFactory getFactory()
 */
class KlettiesRepository extends AbstractRepository implements KlettiesRepositoryInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper\KlettiesEntityMapperInterface
     */
    protected $mapper;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    protected $orderQuery;

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByOrderReference(string $orderReference): ?KlettiesOrderTransfer
    {
        $entity = $this->getOrderQuery()->findOneByOrderReference($orderReference);

        if ($entity === null) {
            return null;
        }

        return $this->convertOrderEntityToTransfer($entity);
    }

    /**
     * @param string $klettiesReference
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderByKlettiesReference(string $klettiesReference): ?KlettiesOrderTransfer
    {
        $entity = $this->getOrderQuery()->findOneByOrderReference($klettiesReference);

        if ($entity === null) {
            return null;
        }

        return $this->convertOrderEntityToTransfer($entity);
    }

    /**
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderById(int $id): ?KlettiesOrderTransfer
    {
        $entity = $this->getOrderQuery()->findOneByIdKlettiesOrder($id);

        if ($entity === null) {
            return null;
        }

        return $this->convertOrderEntityToTransfer($entity);
    }

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function convertOrderEntityToTransfer(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer
    {
        return $this->getMapper()->mapOrderFromEntity($klettiesOrder);
    }

    /**
     * @return \FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper\KlettiesEntityMapperInterface
     */
    protected function getMapper(): KlettiesEntityMapperInterface
    {
        if ($this->mapper === null) {
            $this->mapper = $this->getFactory()->createKlettiesEntityMapper();
        }

        return $this->mapper;
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    protected function getOrderQuery(): FokKlettiesOrderQuery
    {
        if ($this->orderQuery === null) {
            $this->orderQuery = $this->getFactory()->createKlettiesOrderQuery();
        }

        return $this->orderQuery;
    }
}
