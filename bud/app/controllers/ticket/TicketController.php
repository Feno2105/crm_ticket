<?php

namespace app\controllers\ticket;

use Exception;
use app\models\Ticket\TicketModel;
use Flight;

class TicketController
{

    public function __construct() {}
    public function entry()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = [];
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']); // Important: supprimer le message après l'avoir récupéré
        }

        $liste_tickets = new TicketModel(Flight::db());
        $data = ['page' => "ticket/liste_ticket", 'liste_reaction_model' => $liste_tickets->getAll(), 'liste_priorite' => $liste_tickets->getpriorite(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ticketModel = new TicketModel();

        // Récupération des données du formulaire
        $sujet = $_POST['sujet'] ?? '';
        $description = $_POST['desc'] ?? '';
        $priorite = $_POST['priorite'] ?? '';
        $fichier = $_FILES['file'] ?? '';

        // Validation des champs obligatoires (fichier non inclus)
        if (empty($sujet) || empty($description) || empty($priorite)) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Veuillez compléter tous les champs obligatoires (sujet, description, priorité)'
            ];
            header('Location: /tickets');
            exit();
        }

        try {
            $nomFichier = '';

            // Traitement du fichier seulement si un fichier a été uploadé
            if ($fichier != '' && $fichier['error'] === UPLOAD_ERR_OK) {
                // Vérification du type de fichier
                $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
                $extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

                if (!in_array($extension, $extensionsAutorisees)) {
                    throw new Exception("Type de fichier non autorisé. Formats acceptés: " . implode(', ', $extensionsAutorisees));
                }

                // Vérification de la taille du fichier (optionnel)
                $tailleMax = 2 * 1024 * 1024; // 2 Mo
                if ($fichier['size'] > $tailleMax) {
                    throw new Exception("Le fichier est trop volumineux (max 2 Mo)");
                }

                // Déplacement du fichier vers le dossier de stockage
                $dossierUpload = 'uploads/tickets/';
                if (!is_dir($dossierUpload)) {
                    mkdir($dossierUpload, 0755, true);
                }

                $nomFichier = uniqid() . '.' . $extension;
                $cheminFichier = $dossierUpload . $nomFichier;

                if (!move_uploaded_file($fichier['tmp_name'], $cheminFichier)) {
                    throw new Exception("Erreur lors de l'enregistrement du fichier");
                }
            }

            // Création du ticket avec ou sans fichier
            $ticketModel->create([
                'sujet' => $sujet,
                'desc' => $description,
                'priorite' => $priorite,
                'file' => $nomFichier, // Peut être null
                'date_creation' => date('Y-m-d H:i:s'),
            ]);


            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Ticket créé avec succès' . ($nomFichier ? ' (avec fichier joint)' : '')
            ];

            Flight::redirect('/ticket');
            return;
        } catch (Exception $e) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la création du ticket: ' . $e->getMessage()
            ];
            Flight::redirect('/ticket'); // Redirection même en cas d'erreur
            return;
        }
    }
}
