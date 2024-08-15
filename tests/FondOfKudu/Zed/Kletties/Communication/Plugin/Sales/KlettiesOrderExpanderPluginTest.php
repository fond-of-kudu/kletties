<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacade;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesBusinessFactory getFactory()
 */
class KlettiesOrderExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Communication\Plugin\Sales\KlettiesOrderExpanderPlugin
     */
    protected $plugin;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\SpySalesOrderEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spySalesOrderEntityTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(KlettiesFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderEntityTransferMock = $this->getMockBuilder(SpySalesOrderEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new class ($this->facadeMock) extends KlettiesOrderExpanderPlugin {
            /**
             * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface
             */
            public $facade;

            /**
             *  constructor.
             *
             * @param \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface $klettiesFacade
             */
            public function __construct(KlettiesFacadeInterface $klettiesFacade)
            {
                $this->facade = $klettiesFacade;
            }

            /**
             * @return \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface|\Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->facade;
            }
        };
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock->expects($this->once())->method('createKlettiesOrderFromQuote')->willReturn($this->quoteTransferMock);
        $this->quoteTransferMock->expects($this->once())->method('getKlettiesOrder')->willReturn($this->klettiesOrderTransferMock);
        $this->klettiesOrderTransferMock->expects($this->once())->method('getId')->willReturn(1);
        $this->spySalesOrderEntityTransferMock->expects($this->once())->method('setFkFokKlettiesOrder');
        $this->plugin->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandKlettiesUpOrder(): void
    {
        $this->facadeMock->expects($this->once())->method('createKlettiesOrderFromQuote')->willReturn($this->quoteTransferMock);
        $this->quoteTransferMock->expects($this->once())->method('getKlettiesOrder');
        $this->spySalesOrderEntityTransferMock->expects($this->never())->method('setFkFokKlettiesOrder');
        $this->plugin->expand($this->spySalesOrderEntityTransferMock, $this->quoteTransferMock);
    }
}