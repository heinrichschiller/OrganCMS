<?php

declare(strict_types=1);

namespace App\Domain\Page\Service;

use App\Domain\Donation\Repository\DonationBoardReaderRepository;
use App\Domain\Post\Repository\PostFinderRepository;
use App\Domain\Supporter\Repository\SupporterFinderRepository;

final class IndexReader
{
    /**
     * @Injection
     * @var DonationBoardReaderRepository
     */
    private DonationBoardReaderRepository $reader;

    /**
     * @Injection
     * @var PostFinderRepository
     */
    private PostFinderRepository $postRepository;

    /**
     * @Injection
     * @var SupporterFinderRepository
     */
    private SupporterFinderRepository $supporterRepository;

    /**
     * The contstructor.
     *
     * @param DonationBoardReaderRepository $reader Donation board reader repository
     * @param PostFinderRepository $postRepository Post finder repository
     * @param SupporterFinderRepository $supporterRepository Supporter finder repository
     */
    public function __construct(
        DonationBoardReaderRepository $reader,
        PostFinderRepository $postRepository,
        SupporterFinderRepository $supporterRepository
    ) {
        $this->reader = $reader;
        $this->postRepository = $postRepository;
        $this->supporterRepository = $supporterRepository;
    }

    /**
     * Read all informations for the index page
     *
     * @return array<mixed>
     */
    public function read()
    {
        $donation = $this->reader->read();
        $post = $this->postRepository->findMainpagePost();
        $supporter = $this->supporterRepository->findAllPublicSupporter();

        return [
            'donation' => $donation,
            'post' => $post,
            'supporter' => $supporter
        ];
    }
}
