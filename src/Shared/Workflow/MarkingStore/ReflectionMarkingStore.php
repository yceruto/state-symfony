<?php

declare(strict_types=1);

/*
 * This file is part of the Second package.
 *
 * © Second <contact@scnd.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Shared\Workflow\MarkingStore;

use BackedEnum;
use ReflectionObject;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

class ReflectionMarkingStore implements MarkingStoreInterface
{
    public function __construct(
        private readonly string $property = 'status',
    ) {
    }

    public function getMarking(object $subject): Marking
    {
        $value = (new ReflectionObject($subject))
            ->getProperty($this->property)
            ->getValue($subject);

        if ($value instanceof BackedEnum) {
            return new Marking([$value->name => 1]);
        }

        return new Marking([$value => 1]);
    }

    public function setMarking(object $subject, Marking $marking, array $context = []): void
    {
        $value = key($marking->getPlaces());

        $rp = (new ReflectionObject($subject))
            ->getProperty($this->property);

        $type = $rp->getType()?->getName();

        if (null !== $type && is_subclass_of($type, BackedEnum::class)) {
            $rp->setValue($subject, $type::from($value));
        } else {
            $rp->setValue($subject, $value);
        }
    }
}
