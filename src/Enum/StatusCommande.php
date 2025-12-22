<?php 

namespace App\Enum;

enum StatusCommande: string {
    case Preparation = 'En préparation';
    case Expediee = 'Expédiée';
    case Livree = 'Livrée';
    case Annulee = 'Annulée';
}