<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Handler;

use FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface;
use FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class KlettiesOrderHandler implements KlettiesOrderHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface
     */
    protected KlettiesOrderWriterInterface $orderWriter;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface
     */
    protected KlettiesOrderMapperInterface $orderMapper;

    /**
     * @param \FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface $orderMapper
     * @param \FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface $writer
     */
    public function __construct(KlettiesOrderMapperInterface $orderMapper, KlettiesOrderWriterInterface $writer)
    {
        $this->orderMapper = $orderMapper;
        $this->orderWriter = $writer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function handleFromQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $mappedData = $this->orderMapper->fromQuote($quoteTransfer);
        if ($mappedData !== null) {
            $quoteTransfer->setKlettiesOrder($this->orderWriter->create($mappedData));
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function handleFromSavedOrder(SaveOrderTransfer $saveOrderTransfer, KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer
    {
        $klettiesOrderTransfer = $this->orderMapper->fromSavedOrder($saveOrderTransfer, $klettiesOrderTransfer);

        return $this->orderWriter->update($klettiesOrderTransfer);
    }
}
