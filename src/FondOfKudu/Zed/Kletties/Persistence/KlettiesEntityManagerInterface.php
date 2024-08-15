<?php

namespace FondOfKudu\Zed\Kletties\Persistence;

use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\KlettiesVendorTransfer;

interface KlettiesEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function createKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @throws \FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function updateKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderItemTransfer
     */
    public function createKlettiesOrderItem(KlettiesOrderItemTransfer $itemTransfer): KlettiesOrderItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\KlettiesVendorTransfer $vendorTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\KlettiesVendorTransfer
     */
    public function createOrFindKlettiesVendor(KlettiesVendorTransfer $vendorTransfer): KlettiesVendorTransfer;
}
