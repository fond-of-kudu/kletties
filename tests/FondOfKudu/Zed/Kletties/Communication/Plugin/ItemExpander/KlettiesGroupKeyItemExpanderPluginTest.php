<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\ItemExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\CartExtension\Dependency\Plugin\ItemExpanderPluginInterface;

class KlettiesGroupKeyItemExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CartChangeTransfer
     */
    protected MockObject|CartChangeTransfer $cartChangeTransferMock;

    /**
     * @var \Spryker\Zed\CartExtension\Dependency\Plugin\ItemExpanderPluginInterface
     */
    protected ItemExpanderPluginInterface $klettiesGroupKeyItemExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->itemTransferMock = $this->createMock(ItemTransfer::class);
        $this->cartChangeTransferMock = $this->createMock(CartChangeTransfer::class);
        $this->klettiesGroupKeyItemExpanderPlugin = new KlettiesGroupKeyItemExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandItemsWithPrintjobId(): void
    {
        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getPrintjobId')
            ->willReturn('123');

        $this->itemTransferMock->expects($this->once())
            ->method('getGroupKey')
            ->willReturn('group-key');

        $this->itemTransferMock->expects($this->once())
            ->method('setGroupKey')
            ->with('group-key-printjobid-123');

        $this->cartChangeTransferMock->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->itemTransferMock]);

        $this->klettiesGroupKeyItemExpanderPlugin->expandItems($this->cartChangeTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandItemsWithoutPrintjobId(): void
    {
        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getPrintjobId')
            ->willReturn(null);

        $this->itemTransferMock->expects($this->never())
            ->method('setGroupKey');

        $this->cartChangeTransferMock->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->itemTransferMock]);

        $this->klettiesGroupKeyItemExpanderPlugin->expandItems($this->cartChangeTransferMock);
    }
}
