<?php

namespace FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper;

use DateTime;
use Exception;
use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\KlettiesVendorTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem;

class KlettiesEntityMapper implements KlettiesEntityMapperInterface
{
    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function mapOrderFromEntity(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer
    {
        $klettiesOrderTransfer = new KlettiesOrderTransfer();
        $klettiesOrderTransfer
            ->fromArray($klettiesOrder->toArray(), true)
            ->setId($klettiesOrder->getIdKlettiesOrder())
            ->setCreatedAt($this->convertDateTimeToTimestamp($klettiesOrder->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($klettiesOrder->getUpdatedAt()))
            ->setIdSalesOrder($klettiesOrder->getFkSalesOrder());

        foreach ($klettiesOrder->getFokKlettiesOrderItems() as $orderItem) {
            $klettiesOrderTransfer->addVendorItem($this->mapOrderItemFromEntity($orderItem));
        }

        return $klettiesOrderTransfer;
    }

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem $orderItem
     *
     * @return \Generated\Shared\Transfer\KlettiesVendorTransfer
     */
    public function mapVendorFromEntity(FokKlettiesOrderItem $orderItem): KlettiesVendorTransfer
    {
        $vendorTransfer = new KlettiesVendorTransfer();
        $vendor = $orderItem->getFokKlettiesVendor();
        $vendorTransfer
            ->fromArray($vendor->toArray(), true)
            ->setId($vendor->getIdKlettiesVendor());

        return $vendorTransfer;
    }

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem $orderItem
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderItemTransfer
     */
    public function mapOrderItemFromEntity(FokKlettiesOrderItem $orderItem): KlettiesOrderItemTransfer
    {
        $orderItemTransfer = new KlettiesOrderItemTransfer();
        $orderItemTransfer->fromArray($orderItem->toArray(), true);
        $orderItemTransfer
            ->setVendor($this->mapVendorFromEntity($orderItem))
            ->setId($orderItem->getIdKlettiesOrderItem())
            ->setCreatedAt($this->convertDateTimeToTimestamp($orderItem->getCreatedAt()))
            ->setUpdatedAt($this->convertDateTimeToTimestamp($orderItem->getUpdatedAt()))
            ->setIdKlettiesOrder($orderItem->getFkKlettiesOrder())
            ->setPrintjobId($orderItem->getPrintjobId());

        return $orderItemTransfer;
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
