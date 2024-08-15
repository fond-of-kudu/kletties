<?php

namespace FondOfKudu\Zed\Kletties\Communication\Plugin\Sales;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacade;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Kletties\Business\KlettiesBusinessFactory getFactory()
 */
class PatchKlettiesOrderAfterSalesOrderWasSavedOrderPostSavePluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Communication\Plugin\Sales\PatchKlettiesOrderAfterSalesOrderWasSavedOrderPostSavePlugin
     */
    protected $plugin;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $saveOrderTransferMock;

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

        $this->saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new class ($this->facadeMock) extends PatchKlettiesOrderAfterSalesOrderWasSavedOrderPostSavePlugin {
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
    public function testExecute(): void
    {
        $this->facadeMock->expects($this->once())->method('addAndSaveOrderDataFromSaveOrderTransfer');
        $this->quoteTransferMock->expects($this->once())->method('getKlettiesOrder')->willReturn($this->klettiesOrderTransferMock);
        $return = $this->plugin->execute($this->saveOrderTransferMock, $this->quoteTransferMock);

        $this->assertInstanceOf(SaveOrderTransfer::class, $return);
    }

    /**
     * @return void
     */
    public function testExecuteKlettiesUpOrder(): void
    {
        $this->facadeMock->expects($this->never())->method('addAndSaveOrderDataFromSaveOrderTransfer');
        $this->quoteTransferMock->expects($this->once())->method('getKlettiesOrder');
        $return = $this->plugin->execute($this->saveOrderTransferMock, $this->quoteTransferMock);

        $this->assertInstanceOf(SaveOrderTransfer::class, $return);
    }
}
