<?php

    namespace App\DataFixtures;

    use App\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Persistence\ObjectManager;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

    class UserFixtures extends Fixture
    {
        private $passwordHasher;

        public function __construct(UserPasswordHasherInterface $passwordHasher)
        {
            $this->passwordHasher = $passwordHasher;
        }

        public function hashPassword($user, $plainPassword): string
        {
            return $this->passwordHasher->hashPassword($user, $plainPassword);
        }

        public function load(ObjectManager $manager)
        {
            $user1 = new User();
            $user1->setUsername('TestUser1');
            $user1->setEmail('user1@test.com');
            $user1->setPassword($this->hashPassword($user1, 'test'));
            $user1->setRoles(["ROLE_ADMIN"]);
            $manager->persist($user1);
    
            $user2 = new User();
            $user2->setUsername('TestUser2');
            $user2->setEmail('user2@test.com');
            $user2->setPassword($this->hashPassword($user2, 'test'));
            $user2->setRoles(["ROLE_USER"]);
            $manager->persist($user2);
    
            $user3 = new User();
            $user3->setUsername('TestUser3');
            $user3->setEmail('user3@test.com');
            $user3->setPassword($this->hashPassword($user3, 'test'));
            $user3->setRoles(["ROLE_USER"]);
            $manager->persist($user3);

            $manager->flush();

            $this->addReference('user1', $user1);
            $this->addReference('user2', $user2);
            $this->addReference('user3', $user3);
        }
    }
