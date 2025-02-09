<?php

declare(strict_types=1);

namespace Rector\Core\Tests\DependencyInjection\CompilerPass\Source;

use Rector\Core\Tests\DependencyInjection\CompilerPass\Source\Contract\FirstCollectedInterface;
use Rector\Core\Tests\DependencyInjection\CompilerPass\Source\Contract\SecondCollectedInterface;

final class SomeCollector
{
    /**
     * @var FirstCollectedInterface[]
     */
    private $firstCollected = [];

    /**
     * @var SecondCollectedInterface[]
     */
    private $secondCollected = [];

    /**
     * @param FirstCollectedInterface[] $firstCollected
     * @param SecondCollectedInterface[] $secondCollected
     */
    public function __construct(array $firstCollected, array $secondCollected)
    {
        $this->firstCollected = $firstCollected;
        $this->secondCollected = $secondCollected;
    }

    /**
     * @return FirstCollectedInterface[]
     */
    public function getFirstCollected(): array
    {
        return $this->firstCollected;
    }

    /**
     * @return SecondCollectedInterface[]
     */
    public function getSecondCollected(): array
    {
        return $this->secondCollected;
    }
}
