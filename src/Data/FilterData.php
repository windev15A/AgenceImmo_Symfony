<?php

namespace App\Data;


/**
 *
 */
class FilterData
{
    /**
     * @var string|null
     */
    public ?string $q = null;

    /**
     * @var string|null
     */
    public ?string $ville = null;

    /**
     * @var array
     */
    public array $categories = [];

    /**
     * @var array
     */
    public array $types = [];

    /**
     * @var int|null
     */
    public ?int $priceMin = 0;


    /**
     * @var int|null
     */
    public ?int $priceMax = 0;

    /**
     * @var int|null
     */
    public ?int $surfaceMin = 0;

    /**
     * @var int|null
     */
    public ?int $surfaceMax = 0;

}