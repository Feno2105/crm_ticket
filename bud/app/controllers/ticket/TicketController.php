<?php

namespace app\controllers\ticket;

use Exception;
use app\models\Ticket\TicketModel;
use app\models\Ticket\AssignementModel;
use app\models\Ticket\StatutTicketModel;

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
            unset($_SESSION['flash_message']);
        }

        // Initialisation des modèles
        $ticketModel = new TicketModel(Flight::db());
        $assignmentModel = new AssignementModel(Flight::db());
        $statusModel = new StatutTicketModel(Flight::db());

        // Récupération des données
        $tickets = $ticketModel->getAll(); // Supposons que cette méthode existe déjà
        $priorites = $ticketModel->getpriorite();
        $statuts = $statusModel->getAll(); // À implémenter dans StatusModel
        $agents = $assignmentModel->getAllAgents();


        // Pour chaque ticket, ajouter les informations d'assignation et de statut
        foreach ($tickets as &$ticket) {
            // Assignation
            $ticket['assignment'] = $assignmentModel->getAssignmentByTicket($ticket['id']);

            // Statut - trouve le nom du statut correspondant à l'ID
            foreach ($statuts as $statut) {
                if ($statut['id'] == $ticket['id_statut']) {
                    $ticket['statut_nom'] = $statut['desc'];
                    break;
                }
            }
        }

        $data = [
            'page' => "ticket/liste_ticket",
            'liste_reaction_model' => $tickets,
            'liste_priorite' => $priorites,
            'liste_statuts' => $statuts,
            'liste_agents' => $agents, // Ajout des agents
            'message' => $message
        ];

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
        $fichier = $_FILES['file'] ?? null;

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
            $nomFichier = null;

            // Traitement du fichier seulement si un fichier a été uploadé
            if ($fichier && $fichier['error'] === UPLOAD_ERR_OK) {
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
                'statut' => 'ouvert'
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
   public function update()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $ticketModel = new TicketModel(Flight::db());
        $id = $_POST['id'];

        // Gestion du fichier
        $file = $this->handleFileUpload(
            $_FILES['file'] ?? null, 
            $_POST['current_file'] ?? null
        );

        // Préparation des données
        $data = [
            'sujet' => $_POST['sujet'],
            'desc' => $_POST['desc'] ?? null,
            'priorite' => $_POST['priorite'],
            'file' => $file
        ];

        // Validation minimale
        if (empty($data['sujet'])) {
            throw new Exception('Le sujet est obligatoire');
        }

        // Mise à jour
        $success = $ticketModel->update($id, $data);

        if ($success) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Ticket mis à jour avec succès'
            ];
        } else {
            throw new Exception('Échec de la mise à jour');
        }

    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => 'Erreur: ' . $e->getMessage()
        ];
    }

    Flight::redirect('/ticket');
}

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id'];
        try {
            $liste_model = new TicketModel();
            $liste_model->remove($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression de l\'action effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression de l\'action!'
            ];
        }

        Flight::redirect('/ticket');
    }

private function handleFileUpload($newFile, $currentFile = null)
{
    // Aucun nouveau fichier uploadé
    if (!$newFile || $newFile['error'] !== UPLOAD_ERR_OK) {
        return $currentFile;
    }

    // Suppression de l'ancien fichier
    if ($currentFile && file_exists('uploads/' . $currentFile)) {
        unlink('uploads/' . $currentFile);
    }

    // Validation de l'extension
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
    $extension = strtolower(pathinfo($newFile['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        throw new Exception('Type de fichier non autorisé');
    }

    // Génération d'un nouveau nom de fichier
    $filename = uniqid() . '.' . $extension;
    $destination = 'uploads/' . $filename;

    if (!move_uploaded_file($newFile['tmp_name'], $destination)) {
        throw new Exception('Erreur lors de l\'enregistrement du fichier');
    }

    return $filename;
}
    public function createAssignement()
    {
        $ticketId = (string)$_POST['ticket_id'] ;
        $agentId = (string)$_POST['agent_id'] ;

        if ($ticketId && $agentId) {
            try {
                $model = new AssignementModel();
                if ($model->isTicketAlreadyAssigned($ticketId)) {
                    $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Le ticket est déjà assigné à un agent.'];
                    $assignment = $model->getAssignmentByTicket($ticketId);
                }
                else{
                $model->create($ticketId,$agentId);
                }
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Agent assigné avec succès.'];
            } catch (\Exception $e) {
                $_SESSION['flash_message'] = ['type' => 'danger', 'text' => $e->getMessage()];
            }
        }

        Flight::redirect('/ticket');
    }
}
