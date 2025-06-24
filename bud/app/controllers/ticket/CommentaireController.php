<?php

namespace app\controllers\ticket;

use Exception;
use app\models\Ticket\TicketModel;
use Flight;

class CommentaireController
{

    public function __construct() {}

    public function listeClient()
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
    
}
