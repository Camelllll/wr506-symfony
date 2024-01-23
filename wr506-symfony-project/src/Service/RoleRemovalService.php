<?php

// src/Service/RoleRemovalService.php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;

class RoleRemovalService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function removeRoleFromUser(UserInterface $user, string $role): void
    {
        // Supprimer le rôle de l'utilisateur
        $user->removeRole($role);

        // Enregistrer les modifications dans la base de données
        $this->entityManager->flush();
    }
}


?>