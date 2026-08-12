<?php

declare(strict_types=1);

use AFPA\Entity\Personne;
use PHPUnit\Framework\TestCase;

final class PersonneTest extends TestCase
{

    public function testPersonneEnMajuscule(): void
    {
        $personne = new Personne(1, 'jhon', 'doe', 'jhon@doe.fr', "male");

        $maj = $personne->majuscule();

        $this->assertEquals($maj, "JHON DOE", "Correspondance exact");
    }

    public function testPersonneEnMajusculeAvecErreur(): void
    {
        $personne = new Personne(1, 'jhon', 'doe', 'jhon@doe.fr', "male");

        $maj = $personne->majuscule();

        $this->assertNotEquals($maj, "JHONDOE", "Correspondance non exact");
    }
}
