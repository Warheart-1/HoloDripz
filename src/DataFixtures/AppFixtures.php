<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(protected ManagerRegistry $manager, protected UserPasswordHasherInterface $passwordHasher)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('e@email.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setRoles(['ROLE_USER']);
        $user->setName('First Name');
        $user->setLastName('Last Name');
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setUpdatedAt(new DateTimeImmutable());
        $ur = $this->manager->getRepository(User::class);
        $ur->save($user);
        
        $category = new Category();
        $category->setName('Category 1');
        $cr = $this->manager->getRepository(Category::class);
        $cr->save($category);
        
        $subCategory = new SubCategory();
        $subCategory->setName('SubCategory 1');
        $sr = $this->manager->getRepository(SubCategory::class);
        $sr->save($subCategory);

        for ($i = 0; $i < 11; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setExcerpt('Excerpt lorem ' . $i);
            $product->setDescription('Description lorem ' . $i);
            $product->setPrice(rand(0, 100));
            $product->setQuantity(rand(0, 1000));
            $product->setStatus(0);
            $product->setSeller($user);
            $product->setSold(rand(0, 1000));
            $product->setCategory($category);
            $product->setSubCategory($subCategory);
            $product->setCreatedAt(new DateTimeImmutable());
            $product->setUpdatedAt(new DateTimeImmutable());
            $manager->persist($product);
        }

       
        $manager->flush();
    }
}
