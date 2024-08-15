<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeBridge;
use FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeBridge;
use FondOfKudu\Zed\Kletties\KlettiesConfig;
use FondOfKudu\Zed\Kletties\Persistence\KlettiesRepository;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderItemTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

class KlettiesOrderMapperTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToLocaleFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localeFacadeMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Dependency\Facade\KlettiesToStoreFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\KlettiesConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

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
     * @var \Generated\Shared\Transfer\KlettiesOrderItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderItemTransferMock;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderEntityMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Mapper\KlettiesOrderMapperInterface
     */
    protected $mapper;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this
            ->getMockBuilder(KlettiesRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeFacadeMock = $this
            ->getMockBuilder(KlettiesToLocaleFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this
            ->getMockBuilder(KlettiesToStoreFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this
            ->getMockBuilder(KlettiesConfig::class)
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

        $this->klettiesOrderEntityMock = $this
            ->getMockBuilder(FokKlettiesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderItemTransferMock = $this
            ->getMockBuilder(KlettiesOrderItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this
            ->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new KlettiesOrderMapper(
            $this->configMock,
            $this->localeFacadeMock,
            $this->repositoryMock,
            $this->storeFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $currentLocale = 'de_DE';
        $suffix = 'Sku';
        $abstractAttributes = [
            $currentLocale => [
                sprintf('caseable%s', $suffix) => 'lalalasku',
            ],
        ];
        $knownVendor = ['caseable'];
        $items = new ArrayObject();
        $items->append($this->itemTransferMock);
        $this->configMock->expects($this->once())->method('getKnownVendor')->willReturn($knownVendor);
        $this->configMock->expects($this->atLeastOnce())->method('getAttributeSkuSuffix')->willReturn($suffix);
        $this->localeFacadeMock->expects($this->once())->method('getCurrentLocaleName')->willReturn($currentLocale);
        $this->quoteTransferMock->expects($this->once())->method('getItems')->willReturn($items);
        $this->itemTransferMock->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getSku')->willReturn('123');
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getFkSalesOrderItem')->willReturn(1);
        $this->storeFacadeMock->expects($this->once())->method('getCurrentStoreName')->willReturn('testStore');
        $this->itemTransferMock->expects($this->never())->method('setQuantity');

        $transfer = $this->mapper->fromQuote($this->quoteTransferMock);

        $this->assertInstanceOf(KlettiesOrderTransfer::class, $transfer);
        $this->assertInstanceOf(KlettiesOrderItemTransfer::class, $transfer->getVendorItems()[0]);
        $this->assertSame('testStore', $transfer->getStore());
    }

    /**
     * @return void
     */
    public function testFromQuoteMoreItems(): void
    {
        $currentLocale = 'de_DE';
        $suffix = 'Sku';
        $abstractAttributes = [
            $currentLocale => [
                sprintf('caseable%s', $suffix) => 'lalalasku',
            ],
        ];
        $knownVendor = ['caseable'];
        $items = new ArrayObject();
        $items->append($this->itemTransferMock);
        $itemClone = clone $this->itemTransferMock;
        $items->append($itemClone);
        $this->configMock->expects($this->once())->method('getKnownVendor')->willReturn($knownVendor);
        $this->configMock->expects($this->atLeastOnce())->method('getAttributeSkuSuffix')->willReturn($suffix);
        $this->localeFacadeMock->expects($this->once())->method('getCurrentLocaleName')->willReturn($currentLocale);
        $this->quoteTransferMock->expects($this->once())->method('getItems')->willReturn($items);
        $this->itemTransferMock->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getSku')->willReturn('123');
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getFkSalesOrderItem')->willReturn(1);
        $this->storeFacadeMock->expects($this->once())->method('getCurrentStoreName')->willReturn('testStore');
        $this->itemTransferMock->expects($this->never())->method('setQuantity');

        $itemClone->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $itemClone->expects($this->atLeastOnce())->method('getSku')->willReturn('456');
        $itemClone->expects($this->atLeastOnce())->method('getFkSalesOrderItem')->willReturn(2);

        $transfer = $this->mapper->fromQuote($this->quoteTransferMock);

        $this->assertInstanceOf(KlettiesOrderTransfer::class, $transfer);
        $this->assertCount(2, $transfer->getVendorItems());
        $this->assertInstanceOf(KlettiesOrderItemTransfer::class, $transfer->getVendorItems()[0]);
        $this->assertInstanceOf(KlettiesOrderItemTransfer::class, $transfer->getVendorItems()[1]);
        $this->assertSame('testStore', $transfer->getStore());
    }

    /**
     * @return void
     */
    public function testFromQuoteKlettiesUpItemAvailable(): void
    {
        $currentLocale = 'de_DE';
        $suffix = 'Sku';
        $abstractAttributes = [
            $currentLocale => [
                'lalala' => 'lalalasku',
            ],
        ];
        $knownVendor = ['caseable'];
        $items = new ArrayObject();
        $items->append($this->itemTransferMock);
        $this->configMock->expects($this->once())->method('getKnownVendor')->willReturn($knownVendor);
        $this->configMock->expects($this->atLeastOnce())->method('getAttributeSkuSuffix')->willReturn($suffix);
        $this->localeFacadeMock->expects($this->once())->method('getCurrentLocaleName')->willReturn($currentLocale);
        $this->quoteTransferMock->expects($this->once())->method('getItems')->willReturn($items);
        $this->itemTransferMock->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getSku')->willReturn('123');
        $this->itemTransferMock->expects($this->never())->method('getFkSalesOrderItem')->willReturn(1);
        $this->storeFacadeMock->expects($this->never())->method('getCurrentStoreName')->willReturn('testStore');
        $this->itemTransferMock->expects($this->never())->method('setQuantity');

        $transfer = $this->mapper->fromQuote($this->quoteTransferMock);

        $this->assertNull($transfer);
    }

    /**
     * @return void
     */
    public function testFromQuoteWithFallbackLocale(): void
    {
        $currentLocale = '_';
        $suffix = 'Sku';
        $abstractAttributes = [
            $currentLocale => [
                sprintf('caseable%s', $suffix) => 'lalalasku',
            ],
        ];
        $knownVendor = ['caseable'];
        $items = new ArrayObject();
        $items->append($this->itemTransferMock);
        $this->configMock->expects($this->once())->method('getKnownVendor')->willReturn($knownVendor);
        $this->configMock->expects($this->atLeastOnce())->method('getAttributeSkuSuffix')->willReturn($suffix);
        $this->localeFacadeMock->expects($this->once())->method('getCurrentLocaleName')->willReturn($currentLocale);
        $this->quoteTransferMock->expects($this->once())->method('getItems')->willReturn($items);
        $this->itemTransferMock->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getSku')->willReturn('123');
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getFkSalesOrderItem')->willReturn(1);
        $this->storeFacadeMock->expects($this->once())->method('getCurrentStoreName')->willReturn('testStore');
        $this->itemTransferMock->expects($this->never())->method('setQuantity');

        $transfer = $this->mapper->fromQuote($this->quoteTransferMock);

        $this->assertInstanceOf(KlettiesOrderTransfer::class, $transfer);
        $this->assertInstanceOf(KlettiesOrderItemTransfer::class, $transfer->getVendorItems()[0]);
        $this->assertSame('testStore', $transfer->getStore());
    }

    /**
     * @return void
     */
    public function testFromQuoteWithGroupedItems(): void
    {
        $currentLocale = 'de_DE';
        $suffix = 'Sku';
        $abstractAttributes = [
            $currentLocale => [
                sprintf('caseable%s', $suffix) => 'lalalasku',
            ],
        ];
        $knownVendor = ['caseable'];
        $items = new ArrayObject();
        $items->append($this->itemTransferMock);
        $itemClone = clone $this->itemTransferMock;
        $items->append($itemClone);
        $this->configMock->expects($this->once())->method('getKnownVendor')->willReturn($knownVendor);
        $this->configMock->expects($this->atLeastOnce())->method('getAttributeSkuSuffix')->willReturn($suffix);
        $this->localeFacadeMock->expects($this->once())->method('getCurrentLocaleName')->willReturn($currentLocale);
        $this->quoteTransferMock->expects($this->once())->method('getItems')->willReturn($items);
        $this->itemTransferMock->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getSku')->willReturn('123');
        $this->itemTransferMock->expects($this->atLeastOnce())->method('getFkSalesOrderItem')->willReturn(1);
        $this->storeFacadeMock->expects($this->once())->method('getCurrentStoreName')->willReturn('testStore');
        $this->itemTransferMock->expects($this->once())->method('setQuantity');

        $itemClone->expects($this->once())->method('getAbstractAttributes')->willReturn($abstractAttributes);
        $itemClone->expects($this->atLeastOnce())->method('getSku')->willReturn('123');
        $itemClone->expects($this->atLeastOnce())->method('getFkSalesOrderItem')->willReturn(1);

        $transfer = $this->mapper->fromQuote($this->quoteTransferMock);

        $this->assertInstanceOf(KlettiesOrderTransfer::class, $transfer);
        $this->assertInstanceOf(KlettiesOrderItemTransfer::class, $transfer->getVendorItems()[0]);
        $this->assertCount(1, $transfer->getVendorItems());
        $this->assertSame('testStore', $transfer->getStore());
    }

    /**
     * @return void
     */
    public function testFromSavedOrder(): void
    {
        $this->saveOrderTransferMock->expects($this->once())->method('getOrderReference')->willReturn('123');
        $this->saveOrderTransferMock->expects($this->once())->method('getIdSalesOrder')->willReturn(1);
        $this->storeFacadeMock->expects($this->once())->method('getCurrentStoreName')->willReturn('testStore');
        $this->klettiesOrderTransferMock->expects($this->once())->method('setOrderReference')->willReturn($this->klettiesOrderTransferMock);
        $this->klettiesOrderTransferMock->expects($this->once())->method('setStore')->willReturn($this->klettiesOrderTransferMock);
        $this->klettiesOrderTransferMock->expects($this->once())->method('setIdSalesOrder')->willReturn($this->klettiesOrderTransferMock);

        $this->mapper->fromSavedOrder($this->saveOrderTransferMock, $this->klettiesOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testFromEntity(): void
    {
        $this->repositoryMock->expects($this->once())->method('convertOrderEntityToTransfer')->willReturn($this->klettiesOrderTransferMock);

        $this->mapper->fromEntity($this->klettiesOrderEntityMock);
    }
}
