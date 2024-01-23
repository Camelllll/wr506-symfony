<?php

// src/Service/RoleAssignmentService.php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;

class RoleAssignmentService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function assignRoleToUser(UserInterface $user, string $role): void
    {
        // Ajouter le rôle à l'utilisateur
        $user->addRole($role);

        // Enregistrer les modifications dans la base de données
        $this->entityManager->flush();
    }
}

?>