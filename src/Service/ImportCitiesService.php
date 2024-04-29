<?php
namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCitiesService
{

    public function __construct(
        private CityRepository $cityRepository,
        private EntityManagerInterface $em
    ){
    }

    public function importCities(SymfonyStyle $io): void
    {
        $io->title('Importation des villes');

        $cities = $this->readCsvFile();

        $io->progressStart(count($cities));

        foreach ($cities as $arrayCity) {
            $io->progressAdvance();
            $city = $this->createOrUpdateCity($arrayCity);
            $this->em->persist($city);
        }

        $this->em->flush();

        $io->progressFinish();

        $io->success('Importation terminée');
    }

    private function readCsvFile()
    {
        $csv = Reader::createFromPath('%kernel.root_dir%/../import/cities.csv', 'r');
        $csv->setHeaderOffset(0);

        return $csv;

    }

    private function createOrUpdateCity(array $arrayCity): City
    {
        $city = $this->cityRepository->findOneBy(['inseeCode' => $arrayCity['insee_code']]);

        if (!$city) {
            $city = new City();
        }

        $city->setInseeCode($arrayCity['insee_code']);
        $city->setCityCode($arrayCity['city_code']);
        $city->setZipCode($arrayCity['zip_code']);
        $city->setLabel($arrayCity['label']);
        $city->setLatitude($arrayCity['latitude']);
        $city->setLongitude($arrayCity['longitude']);
        $city->setDepartmentName($arrayCity['department_name']);
        $city->setDepartmentNumber($arrayCity['department_number']);
        $city->setRegionName($arrayCity['region_name']);
        $city->setRegionGeoJsonName($arrayCity['region_geojson_name']);

        return $city;
    }
}