<?php

namespace app\controllers\ticket;

use Exception;
use app\models\Ticket\AssignementModel;
use app\models\Ticket\TicketModel;
use app\models\Ticket\HoraireModel;
use app\models\Ticket\PayementTicketModel;

use Flight;

class PayementController
{

    public function __construct() {}
    public function stock_temp(int $ticketId, float $hours): array
{
    try {
        // 1. Récupérer le taux horaire actuel
        $horaireModel = new HoraireModel(Flight::db());
        $horaire = $horaireModel->getCurrentRate();
        
        if (!$horaire) {
            throw new Exception("Aucun taux horaire configuré");
        }

        // 2. Calculer le montant
        $amount = ($hours * $horaire['argent']) / $horaire['horaire'];
        
        // 3. Récupérer l'agent assigné
        $assignmentModel = new AssignementModel(Flight::db());
        $assignment = $assignmentModel->getAssignmentByTicket($ticketId);
        $agentId = $assignment['agent_id'] ?? null;
        
        if (!$agentId) {
            throw new Exception("Aucun agent assigné à ce ticket");
        }

        // 4. Préparer les données pour l'historique
        $paymentData = [
            'ticket_id' => $ticketId,
            'dure' => $hours,
            'agent_id' => $agentId,
            'amount' => $amount,
            'calculated_at' => date('Y-m-d H:i:s')
        ];

        return [
            'success' => true,
            'data' => $paymentData,
            'calculation' => [
                'rate' => $horaire['argent'] / $horaire['horaire'],
                'total_hours' => $hours,
                'total_amount' => $amount
            ]
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
public function calculate()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        if (empty($_POST['ticket_id']) || empty($_POST['hours'])) {
            throw new Exception("Données manquantes");
        }

        $ticketId = (int)$_POST['ticket_id'];
        $hours = (float)$_POST['hours'];

        // Utilisation de stock_temp
        $calculation = $this->stock_temp($ticketId, $hours);
        
        if (!$calculation['success']) {
            throw new Exception($calculation['error']);
        }

        // Enregistrement en base
        $paymentModel = new PayementTicketModel(Flight::db());
        $paymentId = $paymentModel->create($calculation['data']);

        // Mise à jour du statut du ticket
        $ticketModel = new TicketModel(Flight::db());
        $ticketModel->updateStatut($ticketId, 3); // Remplacez par votre constante/id

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => sprintf(
                "Ticket fermé. %.2f heures x %.2f €/h = %.2f €",
                $hours,
                $calculation['calculation']['rate'],
                $calculation['data']['amount']
            )
        ];

    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => 'Erreur: ' . $e->getMessage()
        ];
    }

    Flight::redirect('/ticket');
}
    
}
