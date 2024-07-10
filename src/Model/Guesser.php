<?php

namespace App\Model;


use Symfony\Component\Uid\Uuid;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

class Guesser
{
    /**
     * @param string $name
     * @param array $guesses
     * @param string $id
     */
    public function __construct(public string                             $name,
                                #[LiveProp(writable: true)] public ?array $guesses = [],
                                public ?string                            $id = null

    )
    {
        if (empty($this->id)) {
            $this->id = Uuid::v7();
        }
    }

    static function fromJson(array $encoded): Guesser
    {
        return new Guesser($encoded["name"], $encoded["guesses"], $encoded["id"]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }
}