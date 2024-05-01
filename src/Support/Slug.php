<?php declare(strict_types=1);

namespace App\Support;

use Cocur\Slugify\Slugify;

final class Slug
{
    /**
     * @var Slugify
     */
    private Slugify $slugify;

    public function __construct(string $ruleSet)
    {
        $this->slugify = new Slugify;

        $this->slugify->activateRuleSet($ruleSet);
    }

    public function slugify(string $string): string
    {
        
        $slug = $this->slugify->slugify($string);

        return $slug;
    }
}
