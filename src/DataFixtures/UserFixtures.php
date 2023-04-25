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
            $admin = new User();
            $admin->setUsername('Admin');
            $admin->setEmail('Admmin@app.com');
            $admin->setPassword($this->hashPassword($admin, 'admin'));
            $admin->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);

            $user1 = new User();
            $user1->setUsername('John');
            $user1->setEmail('john@doe.com');
            $user1->setPassword($this->hashPassword($user1, 'password'));
            $user1->setRoles(["ROLE_USER"]);
            $manager->persist($user1);

            $manager->flush();
        }
    }
