<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DatabaseController extends AbstractController
{
    #[Route('/database', name: 'app_database')]
    public function index(): Response
    {
        return $this->render('database/index.html.twig', [
            'controller_name' => 'DatabaseController',
        ]);
    }

    #[Route('database/reinit', name: 'app_reinit_db')]
    public function reinit(EntityManagerInterface $entityManager) : Response
    {
        $connection = $entityManager->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $tables = $connection->getSchemaManager()->listTableNames();
        $NON_REMOVABLE = [
            'doctrine_migration_versions',
            'messenger_messages',
            'utilisateur',
        ];
        // dd($tables);
        foreach ($tables as $table) {
            if(!in_array($table, $NON_REMOVABLE)) {
                $connection->executeUpdate($platform->getTruncateTableSQL($table, true));
            }
        }
        // Delete all user unless admin
        $sql = "DELETE FROM Utilisateur WHERE id != 4";
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->executeQuery();

        $this->addFlash('success','Base de données réinitialisée');

        return $this->redirectToRoute('app_login');
    }
}
