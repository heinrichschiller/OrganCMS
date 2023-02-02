<?php

declare(strict_types=1);

namespace App\Domain\Home\Service;

use App\Domain\Donation\Service\DonationDetailsReader;
use App\Domain\Post\Service\PostFinder;
use App\Domain\Supporter\Service\SupporterFinder;

final class HomeReader
{
    /**
     * @Injection
     * @var DonationBoardReaderRepository
     */
    private DonationDetailsReader $reader;

    /**
     * @Injection
     * @var PostFinderRepository
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
     * @param DonationDetailsReader $reader Donation board reader service
     * @param PostFinder $postFinder Post finder service
     * @param SupporterFinderRepository $supporterRepository Supporter finder repository
     */
    public function __construct(
        DonationDetailsReader $reader,
        PostFinder $postFinder,
        SupporterFinder $supporterFinder
    ) {
        $this->reader = $reader;
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
        $donation = $this->reader->read();
        $publishedPost = $this->postFinder->findMainpagePost();
        $supporter = $this->supporterFinder->findAllPublicSupporter();

        return [
            'donation' => $donation,
            'post' => $publishedPost,
            'supporter' => $supporter
        ];
    }
}
