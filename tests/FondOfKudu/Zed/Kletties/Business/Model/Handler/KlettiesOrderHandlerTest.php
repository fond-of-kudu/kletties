<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Handler;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapper;
use FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriter;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

class KlettiesOrderHandlerTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderWriterMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderMapperMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $saveOrderTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Handler\KlettiesOrderHandlerInterface
     */
    protected $handler;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->orderWriterMock = $this
            ->getMockBuilder(KlettiesOrderWriter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderMapperMock = $this
            ->getMockBuilder(KlettiesOrderMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this
            ->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->saveOrderTransferMock = $this
            ->getMockBuilder(SaveOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this
            ->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->handler = new KlettiesOrderHandler(
            $this->orderMapperMock,
            $this->orderWriterMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleFromQuote(): void
    {
        $this->orderMapperMock->expects($this->once())->method('fromQuote')->willReturn($this->klettiesOrderTransferMock);
        $this->orderWriterMock->expects($this->once())->method('create')->willReturn($this->klettiesOrderTransferMock);
        $this->quoteTransferMock->expects($this->once())->method('setKlettiesOrder');

        $this->handler->handleFromQuote($this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleFromQuoteWithNoData(): void
    {
        $this->orderMapperMock->expects($this->once())->method('fromQuote');
        $this->orderWriterMock->expects($this->never())->method('create');
        $this->quoteTransferMock->expects($this->never())->method('setKlettiesOrder');

        $this->handler->handleFromQuote($this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleFromSavedOrder(): void
    {
        $this->orderMapperMock->expects($this->once())->method('fromSavedOrder')->willReturn($this->klettiesOrderTransferMock);
        $this->orderWriterMock->expects($this->once())->method('update')->willReturn($this->klettiesOrderTransferMock);

        $this->handler->handleFromSavedOrder($this->saveOrderTransferMock, $this->klettiesOrderTransferMock);
    }
}
