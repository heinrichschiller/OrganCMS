<?php

declare(strict_types=1);

namespace App\Domain\Home\Service;

use App\Domain\Donation\Service\DonationDetailsReader;
use App\Domain\Event\Service\EventFinder;
use App\Domain\Post\Service\PostFinder;
use App\Domain\Supporter\Service\SupporterFinder;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class HomeReader
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var DonationDetailsReader
     */
    private DonationDetailsReader $reader;

    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $eventFinder;

    /**
     * @Injection
     * @var PostFinder
     */
    private PostFinder $postFinder;

    /**
     * @Injection
     * @var SupporterFinder
     */
    private SupporterFinder $supporterFinder;

    /**
     * The contstructor.
     *
     * @param LoggerFactory $loggerFactory Monolog logger factory
     * @param DonationDetailsReader $reader Donation board reader service
     * @param EventFinder $eventFinder Event finder service
     * @param PostFinder $postFinder Post finder service
     * @param SupporterFinder $supporterFinder Supporter finder service
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        DonationDetailsReader $reader,
        EventFinder $eventFinder,
        PostFinder $postFinder,
        SupporterFinder $supporterFinder
    ) {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->reader = $reader;
        $this->eventFinder = $eventFinder;
        $this->postFinder = $postFinder;
        $this->supporterFinder = $supporterFinder;
    }

    /**
     * Read all informations for the home page
     *
     * @return array<mixed>
     */
    public function read(): array
    {
        try {
            $limit = 5;

            $donation = $this->reader->read();
            $events = $this->eventFinder->findAllMainpageEvents($limit);
            $publishedPost = $this->postFinder->findMainpagePost();
            $mainpagePosts = $this->postFinder->findAllMainpagePosts($limit);
            $supporter = $this->supporterFinder->findAllPublicSupporter();

            return [
                'donation' => $donation,
                'events' => $events,
                'post' => $publishedPost,
                'mainpagepost' => $mainpagePosts,
                'supporter' => $supporter
            ];
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->reader(): %s", $e->getMessage()));
            
            return [];
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->reader(): %s", $e->getMessage()));
            
            return [];
        }
    }
}
