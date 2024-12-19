<?php
declare(strict_types=1);

namespace Niji\AdManager\Test\Unit\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Niji\AdManager\Model\AdRepository;
use PHPUnit\Framework\TestCase;
use Niji\AdManager\Model\AdFactory;
use Niji\AdManager\Model\Ad;
use Niji\AdManager\Model\ResourceModel\Ad as AdResource;
use Psr\Log\LoggerInterface;

class AdRepositoryTest extends TestCase
{
    private $adFactoryMock = null;
    private $adResourceMock = null;
    private $loggerMock = null;
    private $adMock = null;
    private $adRepository = null;

    /**
     * @inheirtDoc
     */
    protected function setUp(): void
    {
        $this->adFactoryMock = $this->createMock(AdFactory::class);
        $this->adResourceMock = $this->createMock(AdResource::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->adMock = $this->createMock(Ad::class);

        $this->adRepository = new AdRepository(
            $this->adFactoryMock,
            $this->adResourceMock,
            $this->loggerMock
        );
    }

    /**
     * @return void
     * @throws NoSuchEntityException
     */
    public function testGetByIdThrowsNoSuchEntityExceptionWhenAdNotFound()
    {
        $adId = 123;

        $this->adFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->adMock);

        $this->adResourceMock->expects($this->once())
            ->method('load')
            ->with($this->adMock, $adId);

        $this->adMock->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->expectException(NoSuchEntityException::class);
        $this->expectExceptionMessage("The ad that was requested doesn't exist. Verify the ad and try again.");

        $this->adRepository->getById($adId);
    }

    /**
     * @return void
     * @throws NoSuchEntityException
     */
    public function testGetByIdReturnsAdWhenFound()
    {
        $adId = 123;

        $this->adFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->adMock);

        $this->adResourceMock->expects($this->once())
            ->method('load')
            ->with($this->adMock, $adId);

        $this->adMock->expects($this->once())
            ->method('getId')
            ->willReturn($adId);

        $result = $this->adRepository->getById($adId);

        $this->assertSame($this->adMock, $result);
    }

    /**
     * @return void
     * @throws CouldNotSaveException
     */
    public function testSave()
    {
        $ad = $this->createMock(Ad::class);

        $this->adResourceMock->expects($this->once())
            ->method('save')
            ->with($ad);

        $result = $this->adRepository->save($ad);

        $this->assertSame($ad, $result);
    }

    /**
     * @return void
     * @throws CouldNotSaveException
     */
    public function testSaveThrowsCouldNotSaveException()
    {
        $ad = $this->createMock(Ad::class);

        $this->adResourceMock->expects($this->once())
            ->method('save')
            ->with($ad)
            ->willThrowException(new \Exception('Save failed'));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($this->isInstanceOf(\Exception::class));

        $this->expectException(CouldNotSaveException::class);
        $this->expectExceptionMessage('Could not save the ad: Something went wrong while saving the ad.');

        $this->adRepository->save($ad);
    }

    /**
     * @return void
     * @throws CouldNotDeleteException
     */
    public function testDelete()
    {
        $ad = $this->createMock(Ad::class);

        $this->adResourceMock->expects($this->once())
            ->method('delete')
            ->with($ad)
            ->willReturn(true);

        $result = $this->adRepository->delete($ad);

        $this->assertTrue($result);
    }

    /**
     * @return void
     * @throws CouldNotDeleteException
     */
    public function testDeleteThrowsCouldNotDeleteException()
    {
        $ad = $this->createMock(Ad::class);

        $this->adResourceMock->expects($this->once())
            ->method('delete')
            ->with($ad)
            ->willThrowException(new \Exception('Delete failed'));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($this->isInstanceOf(\Exception::class));

        $this->expectException(CouldNotDeleteException::class);
        $this->expectExceptionMessage('Cannot delete ad with id ' . $ad->getId());

        $this->adRepository->delete($ad);
    }
}
