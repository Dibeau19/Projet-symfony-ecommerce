<?php 

namespace App\Enum;

enum Status: string {
    case Disponible = 'Disponible';
    case Rupture = 'En rupture';
    case Precommande = 'En précommande';
}