<?php

namespace App\Controller;

use App\Entity\Indikator1;
use App\Entity\CovidDeaths;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Indikator1Repository;
use App\Repository\CovidDeathsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function proj(
        Indikator1Repository $indikator1Repository,
        CovidDeathsRepository $covidDeathsRepository
    ): Response {
        $indikator1 = $indikator1Repository
            ->findAll();
        $covidDeaths = $covidDeathsRepository
            ->findAll();

        $globalaMal = [
            "1" => "Ingen fattigdom",
            "2" => "Ingen hunger",
            "3" => "God hälsa och välbefinnande",
            "4" => "God utbildning för alla",
            "5" => "Jämställdhet",
            "6" => "Rent vatten och sanitet",
            "7" => "Hållbar energi för alla",
            "8" => "Anständiga arbetsvillkor och ekonomisk tillväxt",
            "9" => "Hållbar industri, innovationer och infrastruktur",
            "10" => "Minskad ojämlikhet",
            "11" => "Hållbara städer och samhällen",
            "12" => "Hållbar konsumtion och produktion",
            "13" => "Bekämpa klimatförändringarna",
            "14" => "Hav och marina resurser",
            "15" => "Ekosystem och biologisk mångfald",
            "16" => "Fredliga och inkluderande samhällen",
            "17" => "Genomförande och globalt partnerskap"
        ];

        $listDelmal = [
            "3.1" => "Minska mödradödligheten",
            "3.2" => "Förhindra alla dödsfall som hade kunnat förebyggas bland barn under fem år",
            "3.3" => "Bekämpa smittsamma sjukdomar",
            "3.4" => "Minska antalet dödsfall till följd av icke smittsamma sjukdomar och främja mental hälsa",
            "3.5" => "Förebygg och behandla drogmissbruk",
            "3.6" => "Minska antalet dödsfall och skador i vägtrafiken",
            "3.7" => "Tillgängliggör reproduktiv hälsovård, familjeplanering och utbildning för alla",
            "3.8" => "Tillgängliggör sjukvård för alla",
            "3.9" => "Minska antalet sjukdoms- och dödsfall till följd av skadliga kemikalier och föroreningar",
            "3.A" => "Genomför Världshälsoorganisationens ramkonvention om tobakskontroll",
            "3.B" => "Stöd forskning, utveckling och tillgängliggör vaccin och läkemedel för alla",
            "3.C" => "Öka finansiering och personal till utvecklingsländers hälso- och sjukvård",
            "3.D" => "Förbättra tidiga varningssystem för globala hälsorisker"
        ];

        $indikator1Table = [];

        foreach ($indikator1 as $indikatorColumn) {

            $indikator1Table[] =
            [
            'year' => $indikatorColumn->getYear(),
            'deaths' => $indikatorColumn->getDeaths(),
            ];
        }

        $covidDeathsTable = [];

        foreach ($covidDeaths as $covidDeath) {

            $covidDeathsTable[] =
            [
            'age' => $covidDeath->getAge(),
            'deaths' => $covidDeath->getDeaths(),
            'total' => $covidDeath->getTotal(),
            'totalPercentage' => $covidDeath->getTotalPercentage(),
            'men' => $covidDeath->getMen(),
            'menPercentage' => $covidDeath->getMenPercentage(),
            'women' => $covidDeath->getWomen(),
            'womenPercentage' => $covidDeath->getWomenPercentage()
            ];
        }

        return $this->render('project/proj.html.twig', [
            'delmål' => $listDelmal,
            'globala' => $globalaMal,
            'indikator1' => $indikator1Table,
            'covid' => $covidDeathsTable
        ]);
    }

    #[Route('/proj_about', name: 'proj_about')]
    public function proj_about(): Response
    {
        return $this->render('project/proj_about.html.twig');
    }

    #[Route('proj/api', name: 'proj_api')]
    public function proj_api(): Response
    {
        return $this->render('project/proj_api.html.twig');
    }

    //JSON

    #[Route('proj/api/globala', name: 'api_globala')]
    public function api_globala(): Response
    {
        $globalaMal = [
            "1" => "Ingen fattigdom",
            "2" => "Ingen hunger",
            "3" => "God hälsa och välbefinnande",
            "4" => "God utbildning för alla",
            "5" => "Jämställdhet",
            "6" => "Rent vatten och sanitet",
            "7" => "Hållbar energi för alla",
            "8" => "Anständiga arbetsvillkor och ekonomisk tillväxt",
            "9" => "Hållbar industri, innovationer och infrastruktur",
            "10" => "Minskad ojämlikhet",
            "11" => "Hållbara städer och samhällen",
            "12" => "Hållbar konsumtion och produktion",
            "13" => "Bekämpa klimatförändringarna",
            "14" => "Hav och marina resurser",
            "15" => "Ekosystem och biologisk mångfald",
            "16" => "Fredliga och inkluderande samhällen",
            "17" => "Genomförande och globalt partnerskap"
        ];

        $response = $this->json($globalaMal);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('proj/api/delmal', name: 'api_delmal')]
    public function api_delmal(): Response
    {
        $listDelmal = [
            "3.1" => "Minska mödradödligheten",
            "3.2" => "Förhindra alla dödsfall som hade kunnat förebyggas bland barn under fem år",
            "3.3" => "Bekämpa smittsamma sjukdomar",
            "3.4" => "Minska antalet dödsfall till följd av icke smittsamma sjukdomar och främja mental hälsa",
            "3.5" => "Förebygg och behandla drogmissbruk",
            "3.6" => "Minska antalet dödsfall och skador i vägtrafiken",
            "3.7" => "Tillgängliggör reproduktiv hälsovård, familjeplanering och utbildning för alla",
            "3.8" => "Tillgängliggör sjukvård för alla",
            "3.9" => "Minska antalet sjukdoms- och dödsfall till följd av skadliga kemikalier och föroreningar",
            "3.A" => "Genomför Världshälsoorganisationens ramkonvention om tobakskontroll",
            "3.B" => "Stöd forskning, utveckling och tillgängliggör vaccin och läkemedel för alla",
            "3.C" => "Öka finansiering och personal till utvecklingsländers hälso- och sjukvård",
            "3.D" => "Förbättra tidiga varningssystem för globala hälsorisker"
        ];

        $response = $this->json($listDelmal);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('proj/api/indikator1', name: 'api_indikator1')]
    public function api_indikator1(
        Indikator1Repository $indikator1Repository
    ): Response {
        $indikator1 = $indikator1Repository
            ->findAll();

        $response = $this->json($indikator1);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('proj/api/covid', name: 'api_covid')]
    public function api_covid(
        CovidDeathsRepository $covidDeathsRepository
    ): Response {
        $covid = $covidDeathsRepository
            ->findAll();

        $response = $this->json($covid);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('proj/api/indikator1/{year}', name: 'indikator1_year', methods: ['POST'])]
    public function indikator1_year(
        Indikator1Repository $indikator1Repository,
        int $year
    ): Response {
        $indikator1Year = $indikator1Repository->findOneBy(['year' => $year]);

        $response = $this->json($indikator1Year);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
