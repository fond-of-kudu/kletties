<?php

namespace FondOfKudu\Zed\Kletties\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\KlettiesVendorTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem;

interface KlettiesEntityMapperInterface
{
    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function mapOrderFromEntity(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer;

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem $orderItem
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesVendorTransfer
     */
    public function mapVendorFromEntity(FokKlettiesOrderItem $orderItem): KlettiesVendorTransfer;

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrderItem $orderItem
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderItemTransfer
     */
    public function mapOrderItemFromEntity(FokKlettiesOrderItem $orderItem): KlettiesOrderItemTransfer;
}
