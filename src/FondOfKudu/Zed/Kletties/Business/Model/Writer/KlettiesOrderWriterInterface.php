<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Writer;

use Generated\Shared\Transfer\KlettiesOrderTransfer;

interface KlettiesOrderWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $orderTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function create(KlettiesOrderTransfer $orderTransfer): KlettiesOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $orderTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function update(KlettiesOrderTransfer $orderTransfer): KlettiesOrderTransfer;
}
