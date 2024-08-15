<?php

namespace FondOfKudu\Zed\Kletties\Business\Model\Writer;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManager;
use Generated\Shared\Transfer\KlettiesOrderTransfer;

class KlettiesOrderWriterTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Persistence\KlettiesEntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $entityManagerMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\Model\Writer\KlettiesOrderWriterInterface
     */
    protected $writer;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->entityManagerMock = $this
            ->getMockBuilder(KlettiesEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this
            ->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writer = new KlettiesOrderWriter($this->entityManagerMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->entityManagerMock->expects($this->once())->method('createKlettiesOrder')->willReturn($this->klettiesOrderTransferMock);
        $this->writer->create($this->klettiesOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->entityManagerMock->expects($this->once())->method('updateKlettiesOrder')->willReturn($this->klettiesOrderTransferMock);
        $this->writer->update($this->klettiesOrderTransferMock);
    }
}
