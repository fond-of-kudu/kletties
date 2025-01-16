<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Expander;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\Expander\OrderItemPrintjobIdExpander;
use FondOfKudu\Zed\Kletties\Business\Expander\OrderItemPrintjobIdExpanderInterface;
use FondOfKudu\Zed\Kletties\Persistence\KlettiesRepository;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OrderItemPrintjobIdExpanderTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesRepository|MockObject $klettiesRepositoryMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ItemTransfer|MockObject $itemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesOrderItemTransfer|MockObject $klettiesOrderItemTransferMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Expander\OrderItemPrintjobIdExpanderInterface
     */
    protected OrderItemPrintjobIdExpanderInterface $orderItemPrintjobIdExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->klettiesRepositoryMock = $this->createMock(KlettiesRepository::class);
        $this->itemTransferMock = $this->createMock(ItemTransfer::class);
        $this->klettiesOrderItemTransferMock = $this->createMock(KlettiesOrderItemTransfer::class);
        $this->orderItemPrintjobIdExpander = new OrderItemPrintjobIdExpander($this->klettiesRepositoryMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderItemsWithPrintjobIdSuccess(): void
    {
        $this->klettiesRepositoryMock->expects(static::atLeastOnce())
            ->method('findKlettiesOrderItemByShopSku')
            ->with('groupKey')
            ->willReturn($this->klettiesOrderItemTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn('groupKey');

        $this->klettiesOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getPrintjobId')
            ->willReturn('printjobId');

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setPrintjobId')
            ->with('printjobId')
            ->willReturnSelf();

        $itemTransfers = $this->orderItemPrintjobIdExpander->expandOrderItemsWithPrintjobId([$this->itemTransferMock]);

        static::assertEquals($itemTransfers[0], $this->itemTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderItemsWithPrintjobIdEntityNotFound(): void
    {
        $this->klettiesRepositoryMock->expects(static::atLeastOnce())
            ->method('findKlettiesOrderItemByShopSku')
            ->with('groupKey')
            ->willReturn(null);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn('groupKey');

        $this->itemTransferMock->expects(static::never())
            ->method('setPrintjobId');

        $itemTransfers = $this->orderItemPrintjobIdExpander->expandOrderItemsWithPrintjobId([$this->itemTransferMock]);

        static::assertEquals($itemTransfers[0], $this->itemTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderItemsWithPrintjobIdNoPrintjobId(): void
    {
        $this->klettiesRepositoryMock->expects(static::atLeastOnce())
            ->method('findKlettiesOrderItemByShopSku')
            ->with('groupKey')
            ->willReturn($this->klettiesOrderItemTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn('groupKey');

        $this->klettiesOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getPrintjobId')
            ->willReturn('');

        $this->itemTransferMock->expects(static::never())
            ->method('setPrintjobId');

        $itemTransfers = $this->orderItemPrintjobIdExpander->expandOrderItemsWithPrintjobId([$this->itemTransferMock]);

        static::assertEquals($itemTransfers[0], $this->itemTransferMock);
    }
}
