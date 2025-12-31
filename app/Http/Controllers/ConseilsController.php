<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConseilsController extends Controller
{
    public function index()
    {
        return view('conseils.index');
    }

    public function guide($slug)
    {
        $guides = [
            'choisir-bois-chauffage' => [
                'title' => 'Comment choisir son bois de chauffage',
                'description' => 'Guide complet pour sélectionner le meilleur bois selon vos besoins',
                'content' => 'conseils.guides.choisir-bois'
            ],
            'stocker-bois' => [
                'title' => 'Bien stocker son bois de chauffage',
                'description' => 'Conseils pour préserver la qualité de votre bois',
                'content' => 'conseils.guides.stocker-bois'
            ],
            'allumer-feu' => [
                'title' => 'Allumer un feu efficacement',
                'description' => 'Techniques pour un allumage parfait',
                'content' => 'conseils.guides.allumer-feu'
            ],
            'entretenir-poele' => [
                'title' => 'Entretenir son poêle à bois',
                'description' => 'Maintenance pour optimiser votre installation',
                'content' => 'conseils.guides.entretenir-poele'
            ]
        ];

        if (!isset($guides[$slug])) {
            abort(404);
        }

        $guide = $guides[$slug];
        
        return view($guide['content'], compact('guide'));
    }
}
