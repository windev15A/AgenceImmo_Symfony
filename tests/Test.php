<?php

namespace App\Tests;



use App\Entity\Type;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{

    public function testTypeCreate(): void
    {
        $bien = new Type();
        $bien->setLibelle("koko");

        $this->assertEquals("koko", $bien->getLibelle());


    }

}
