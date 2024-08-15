<?php

namespace FondOfKudu\Zed\Kletties\Persistence;

use DateTime;
use Exception;
use FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException;
use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\KlettiesVendorTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfKudu\Zed\Kletties\Persistence\KlettiesPersistenceFactory getFactory()
 */
class KlettiesEntityManager extends AbstractEntityManager implements KlettiesEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function createKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer
    {
        $klettiesOrderTransfer->requireVendorItems();
        $now = new DateTime();
        $entity = new FokKlettiesOrder();
        $entity->fromArray($klettiesOrderTransfer->toArray());
        $entity
            ->setFkSalesOrder($klettiesOrderTransfer->getIdSalesOrder())
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
            ->save();

        foreach ($klettiesOrderTransfer->getVendorItems() as $itemTransfer) {
            $itemTransfer->setIdKlettiesOrder($entity->getIdKlettiesOrder());
            $itemTransfer = $this->createKlettiesOrderItem($itemTransfer);
        }
        $klettiesOrderTransfer->fromArray($entity->toArray(), true);
        $klettiesOrderTransfer->setId($entity->getIdKlettiesOrder())
            ->setCreatedAt($this->convertDateTimeToTimestamp($entity->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($entity->getUpdatedAt()));

        return $klettiesOrderTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @throws \FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function updateKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer
    {
        $klettiesOrderTransfer->requireId();
        $query = $this->getFactory()->createKlettiesOrderQuery();

        $entity = $query->findOneByIdKlettiesOrder($klettiesOrderTransfer->getId());

        if ($entity === null) {
            throw new KlettiesOrderNotFoundException(sprintf('No kletties order with id %s found', $klettiesOrderTransfer->getId()));
        }
        $id = $entity->getIdKlettiesOrder();
        $createdAt = $entity->getCreatedAt();
        $updatedAt = new DateTime();
        $entity->fromArray($klettiesOrderTransfer->toArray());
        $entity->setFkSalesOrder($klettiesOrderTransfer->getIdSalesOrder())
            ->setIdKlettiesOrder($id)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);
        $entity->save();

        $klettiesOrderTransfer->fromArray($entity->toArray(), true);
        $klettiesOrderTransfer
            ->setIdSalesOrder($entity->getFkSalesOrder())
            ->setId($id)
            ->setCreatedAt($this->convertDateTimeToTimestamp($entity->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($entity->getUpdatedAt()));

        return $klettiesOrderTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderItemTransfer
     */
    public function createKlettiesOrderItem(KlettiesOrderItemTransfer $itemTransfer): KlettiesOrderItemTransfer
    {
        $now = new DateTime();
        $itemTransfer
            ->requireIdKlettiesOrder()
            ->requireSku()
            ->requireQty()
            ->requireVendor();

        $vendor = $this->createOrFindKlettiesVendor($itemTransfer->getVendor());

        $entity = new FokKlettiesOrderItem();
        $entity->fromArray($itemTransfer->toArray());
        $entity
            ->setFkKlettiesVendor($vendor->getId())
            ->setFkKlettiesOrder($itemTransfer->getIdKlettiesOrder())
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
            ->save();

        $itemTransfer->fromArray($entity->toArray(), true);
        $itemTransfer
            ->setVendor($vendor)
            ->setId($entity->getIdKlettiesOrderItem())
            ->setCreatedAt($this->convertDateTimeToTimestamp($entity->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($entity->getUpdatedAt()));

        return $itemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesVendorTransfer $vendorTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesVendorTransfer
     */
    public function createOrFindKlettiesVendor(KlettiesVendorTransfer $vendorTransfer): KlettiesVendorTransfer
    {
        $vendorTransfer->requireName();

        $query = $this->getFactory()->createKlettiesVendorQuery();
        $entity = $query->filterByName($vendorTransfer->getName())->findOneOrCreate();

        // @phpstan-ignore-next-line
        if ($entity->getIdKlettiesVendor() === null) {
            $entity->save();
        }

        $vendorTransfer->fromArray($entity->toArray(), true);
        $vendorTransfer->setId($entity->getIdKlettiesVendor());

        return $vendorTransfer;
    }

    /**
     * @param \DateTime|mixed|string|null $dateTime
     *
     * @throws \Exception
     *
     * @return int|null
     */
    protected function convertDateTimeToTimestamp($dateTime): ?int
    {
        if ($dateTime === null) {
            return null;
        }

        if ($dateTime instanceof DateTime) {
            return $dateTime->getTimestamp();
        }

        if (is_object($dateTime) === false && is_string($dateTime) === true) {
            return strtotime($dateTime);
        }

        throw new Exception('Could not convert DateTime to timestamp');
    }
}
