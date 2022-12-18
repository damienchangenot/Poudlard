<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword(
            $admin,
            'adminpassword'
        ));
        $admin->setIsEdited(true);
        $manager->persist($admin);
        $this->addReference('adminuser', $admin);
        $manager->flush();

        for ($i = 0; $i <= 19; $i++) {
            $student = new User();
            $student->setEmail('student' . $i . '@email.com');
            $student->setRoles(['ROLE_STUDENT']);
            $student->setPassword($this->hasher->hashPassword($student, 'student'));
            $student->setIsEdited(true);
            $manager->persist($student);
            $this->addReference('student_' . $i, $student);
        }
        for ($i = 20; $i <= 40; $i++) {
            $teacher = new User();
            $teacher->setEmail('teacher' . $i . '@email.com');
            $teacher->setRoles(['ROLE_TEACHER']);
            $teacher->setPassword($this->hasher->hashPassword($teacher, 'teacher'));
            $teacher->setIsEdited(true);
            $manager->persist($teacher);
            $this->addReference('teacher_' . $i, $teacher);
        }

        $manager->flush();
    }

}
