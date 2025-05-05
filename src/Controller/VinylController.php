<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $tracks = [
            'Gangsta\'s Paradise - Coolio',
            'Waterfalls - TLC',
            'Creep - Radiohead',
            'Kiss from a Rose - Seal',
            'On Bended Knee - Boyz II Men',
            'Fantasy - Mariah Carey',
        ];
        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
    }


    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(HttpClientInterface $httpClient, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
        $mixes = $response->toArray();

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }
}