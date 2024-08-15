<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Reader;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Persistence\KlettiesRepository;
use Generated\Shared\Transfer\KlettiesOrderTransfer;

class KlettiesReaderTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Reader\KlettiesReaderInterface
     */
    protected $reader;

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

        $this->klettiesOrderTransferMock = $this
            ->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reader = new KlettiesReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderByOrderReference(): void
    {
        $this->repositoryMock->expects($this->once())->method('findKlettiesOrderByKlettiesReference')->willReturn($this->klettiesOrderTransferMock);
        $this->assertInstanceOf(KlettiesOrderTransfer::class, $this->reader->findKlettiesOrderByOrderReference('test'));
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderByOrderReferenceReturnNull(): void
    {
        $this->repositoryMock->expects($this->once())->method('findKlettiesOrderByKlettiesReference');
        $this->assertNull($this->reader->findKlettiesOrderByOrderReference('test'));
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderByKlettiesReference(): void
    {
        $this->repositoryMock->expects($this->once())->method('findKlettiesOrderByOrderReference')->willReturn($this->klettiesOrderTransferMock);
        $this->assertInstanceOf(KlettiesOrderTransfer::class, $this->reader->findKlettiesOrderByKlettiesReference('test'));
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderByKlettiesReferenceReturnNull(): void
    {
        $this->repositoryMock->expects($this->once())->method('findKlettiesOrderByOrderReference');
        $this->assertNull($this->reader->findKlettiesOrderByKlettiesReference('test'));
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderById(): void
    {
        $this->repositoryMock->expects($this->once())->method('findKlettiesOrderById')->willReturn($this->klettiesOrderTransferMock);
        $this->assertInstanceOf(KlettiesOrderTransfer::class, $this->reader->findKlettiesOrderById(1));
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderByIdReturnNull(): void
    {
        $this->repositoryMock->expects($this->once())->method('findKlettiesOrderById');
        $this->assertNull($this->reader->findKlettiesOrderById(1));
    }
}
