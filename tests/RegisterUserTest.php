<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        // 1.
        $client = static::createClient();
        $client->request('GET', '/inscription');

        // 2. (firstname, lastname, email, password, confirmation du password)
        $client->submitForm('Valider', [
            'register_user[email]' => 'julie@exemple.fr',
            'register_user[plainPassword][first]' => '123456',
            'register_user[plainPassword][second]' => '123456',
            'register_user[firstname]' => 'Julie',
            'register_user[lastname]' => 'Doe'
        ]);

        // FOLLOW
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();

        // 3.
        $this->assertSelectorExists('div:contains("Votre compte est correctement créé, veuillez vous connecter.")');
    }
}
