<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        foreach($this->dummyData() as $data) {
            $microPost = new MicroPost();

            $microPost->setTitle($data['title']);
            $microPost->setText($data['text']);
            $microPost->setCreated(new \DateTime());

            $manager->persist($microPost);
        }

        $manager->flush();
    }
}
