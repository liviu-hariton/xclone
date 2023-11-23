<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    private function dummyData(): array
    {
        return [
            [
                'title' => 'Lorem ipsum',
                'text' => 'Vestibulum egestas maximus justo, ut lacinia ipsum eleifend a.',
            ],
            [
                'title' => 'Nunc tincidunt pharetra bibendum',
                'text' => 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.',
            ],
            [
                'title' => 'Phasellus imperdiet arcu',
                'text' => 'Ut non tortor ut quam volutpat gravida nec vitae lacus.',
            ],
            [
                'title' => 'Phasellus vitae porta tortor',
                'text' => 'Cras facilisis sem sed metus feugiat, vitae hendrerit dolor gravida.',
            ]
        ];
    }

    private function dummyUsers(): array
    {
        return [
            [
                'email' => 'test1@test.com',
                'password' => 'Pa$$w0rd!',
            ],
            [
                'email' => 'test2@test.com',
                'password' => 'Pa$$w0rd!',
            ],
            [
                'email' => 'test3@test.com',
                'password' => 'Pa$$w0rd!',
            ],
            [
                'email' => 'test4@test.com',
                'password' => 'Pa$$w0rd!',
            ]
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        /*foreach($this->dummyData() as $data) {
            $microPost = new MicroPost();

            $microPost->setTitle($data['title']);
            $microPost->setText($data['text']);
            $microPost->setCreated(new \DateTime());

            $manager->persist($microPost);
        }*/

        foreach($this->dummyUsers() as $udata) {
            $user = new User();

            $user->setEmail($udata['email']);
            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $udata['password'])
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
