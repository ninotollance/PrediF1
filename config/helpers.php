<!-- Traduit le status d'une course en français  -->
<?php  
    function translateStatus(string $status): string {
        $statusLabels = [
            'finished' => 'Terminée',
            'scheduled' => 'À venir',
            'cancelled' => 'Annulée'
        ];
        return $statusLabels[$status] ?? $status; // Si statut inconnu, retourne la valeur brute
    }

    function translateBetStatus(string $status, int $won): string {
        if($status === 'finished') {
            if($won === 1) {
                return '🏆 Gagné';
            }
            return 'Perdu ';
            
        }
        $betStatus = [
            'scheduled' => 'En cours',
            'cancelled' => 'Annulée'
        ];
        return $betStatus[$status] ?? $status;
    }
?>