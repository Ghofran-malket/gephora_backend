<?php

namespace App\Controller;

use App\Entity\Store;
use App\Repository\StoreRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/store', name: 'app_api_store_')]
class StoreController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager,
        private StoreRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    #[Route('/', name: 'create', methods: 'POST')]
    public function create(Request $request): Response
    {
        
        $store = $this->serializer->deserialize($request->getContent(), Store::class, 'json');
        $store->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($store);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($store, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_store_read',
            ['id' => $store->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/{id}', name: 'read', methods: 'GET')]
    public function read(int $id): Response
    {
        // ... read les informations du store
        $store = $this->repository->findOneBy(['id' => $id]);
        if ($store) {
            $responseData = $this->serializer->serialize($store, format:'json');
            return new JsonResponse($responseData, Response::HTTP_OK, [], json:true);
        }
        return new JsonResponse(data:null, status: Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        // … Edite le store et le sauvegarde en base de données (par admin)
        $store = $this->repository->findOneBy(['id' => $id]);
        if ($store) {
            $store = $this->serializer->deserialize(
                $request->getContent(),
                Store::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $store]
            );
            $store->setUpdatedAt(new DateTimeImmutable());
        }

        $this->manager->flush();

        return new JsonResponse(data:null, status: Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        // ... Supprime le store de la base de données
        $store = $this->repository->findOneBy(['id' => $id]);
        if (!$store) {
            return new JsonResponse(data:null, status: Response::HTTP_NO_CONTENT);
        }
        $this->manager->remove($store);
        $this->manager->flush();
        return new JsonResponse(data:null, status: Response::HTTP_NO_CONTENT);
    }
}
