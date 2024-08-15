<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Handler;

use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface KlettiesOrderHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function handleFromQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function handleFromSavedOrder(SaveOrderTransfer $saveOrderTransfer, KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer;
}
