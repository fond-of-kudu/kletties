<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Mapper;

use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

interface KlettiesOrderMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): ?KlettiesOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function fromSavedOrder(SaveOrderTransfer $saveOrderTransfer, KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer;

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function fromEntity(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer;
}
