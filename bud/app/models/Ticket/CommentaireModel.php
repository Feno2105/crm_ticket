<?php
namespace App\Models\Ticket;

use Flight;

class CommentaireModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    
}