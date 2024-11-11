<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\KlettiesVendorTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer;

/**
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesBusinessFactory getFactory()
 */
class AddKlettiesDataToSalesOrderItemExpanderPreSavePluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Communication\Plugin\Sales\AddKlettiesDataToSalesOrderItemExpanderPreSavePlugin
     */
    protected $plugin;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spySalesOrderItemEntityTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesVendorTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesVendorMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderItemEntityTransferMock = $this->getMockBuilder(SpySalesOrderItemEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderItemTransferMock = $this->getMockBuilder(KlettiesOrderItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesVendorMock = $this->getMockBuilder(KlettiesVendorTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new AddKlettiesDataToSalesOrderItemExpanderPreSavePlugin();
    }

    /**
     * @return void
     */
    public function testExpandOrderItem(): void
    {
        $items = new ArrayObject();
        $items->append($this->klettiesOrderItemTransferMock);
        $this->quoteTransferMock->expects($this->once())->method('getKlettiesOrder')->willReturn($this->klettiesOrderTransferMock);
        $this->klettiesOrderTransferMock->expects($this->once())->method('getVendorItems')->willReturn($items);
        $this->spySalesOrderItemEntityTransferMock->expects($this->once())->method('getGroupKey')->willReturn('abc');
        $this->spySalesOrderItemEntityTransferMock->expects($this->once())->method('setVendor');
        $this->spySalesOrderItemEntityTransferMock->expects($this->once())->method('setVendorSku');
        $this->klettiesOrderItemTransferMock->expects($this->once())->method('getShopSku')->willReturn('abc');
        $this->klettiesOrderItemTransferMock->expects($this->once())->method('getVendor')->willReturn($this->klettiesVendorMock);
        $this->klettiesOrderItemTransferMock->expects($this->once())->method('getSku')->willReturn('test');
        $this->klettiesVendorMock->expects($this->once())->method('getName')->willReturn('vendor');

        $this->plugin->expandOrderItem($this->quoteTransferMock, $this->itemTransferMock, $this->spySalesOrderItemEntityTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderItemNoKlettiesOrder(): void
    {
        $this->quoteTransferMock->expects($this->once())->method('getKlettiesOrder');
        $this->klettiesOrderTransferMock->expects($this->never())->method('getVendorItems');

        $return = $this->plugin->expandOrderItem($this->quoteTransferMock, $this->itemTransferMock, $this->spySalesOrderItemEntityTransferMock);

        $this->assertInstanceOf(SpySalesOrderItemEntityTransfer::class, $return);
    }
}
