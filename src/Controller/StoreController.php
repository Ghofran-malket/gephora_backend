<?php

namespace App\Controller;

use App\Entity\Store;
use App\Repository\StoreRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/store', name: 'app_api_store_')]
class StoreController extends AbstractController
{

    public function __construct(private EntityManagerInterface $manager, private StoreRepository $repository)
    {
    }

    #[Route('/', name:'create', methods:'POST')]
    public function create(): Response{
        // ... create le store dans la base de données
        $store = new Store();
        $store->setName('Gephora');
        $store->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry.
         Lorem Ipsum has been the industrys standard dummy text ever since the 1500s');
        $store->setEmail('gephora@store.fr');
        $store->setAddress('Amiens 80000');
        $store->setCreatedAt(new DateTimeImmutable());

        // Tell Doctrine you want to (eventually) save the store (no queries yet)
        $this->manager->persist($store);
        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->json(
            ['message' => "Store resource created with {$store->getId()} id"],
            Response::HTTP_CREATED,
        );
    }

    #[Route('/{id}', name:'read', methods:'GET')]
    public function read(int $id): Response{
        // ... read les informations du store
        $store = $this->repository->findOneBy(['id'=> $id]);
        if(!$store){
            throw $this->createNotFoundException("No Store found for {$id} id");
        }
        
        return $this->json([
            'message' => "A Store was found : {$store->getName()} for {$store->getId()} id"
        ]);

    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id): Response
    {
        // … Edite le store et le sauvegarde en base de données (par admin)
        $store = $this->repository->findOneBy(['id'=> $id]);
        if(!$store){
            throw $this->createNotFoundException("No Store found for {$id} id");
        }
        $store->setName('Gephora 2');
        $store->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry.
         Lorem Ipsum has been the industrys standard dummy text ever since the 1500s');
        $store->setEmail('gephora@store.fr');
        $store->setAddress('Amiens 80000');
        $store->setUpdatedAt(new DateTimeImmutable());

        // Actually executes the queries (i.e. the INSERT query)
        $this->manager->flush();

        return $this->redirectToRoute('app_api_store_read', ['id' => $store->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        // ... Supprime le store de la base de données
        $store = $this->repository->findOneBy(['id'=> $id]);
        if(!$store){
            throw $this->createNotFoundException("No Store found for {$id} id");
        }
        $this->manager->remove($store);
        $this->manager->flush();
        return $this->json([
            'message' => "Restaurant resource deleted"],
            Response::HTTP_NO_CONTENT
        );
    }
}
