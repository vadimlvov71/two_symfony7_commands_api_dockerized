<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use App\Entity\Group;
use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Validation;


/**
 * ApiController uses OpenAPI and has actions:
 * 4 ones for crud, one - for changing only one field: 'current salary'
 * used API with five entrypoints
 * create a tree of a tasks of a one
 *
 *
* @author Vadim Podolyan <vadim.podolyan@gmail.com>
*
 */
#[Route('/group')]
class ApiGroupController extends AbstractController
{

    #[Route('/new', name: 'app_api_group_new', methods: ['GET', 'POST'])]
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param validatorInterface $validator
     *
     * @return Response
     */
    public function newGroup(
        Request $request,
        EntityManagerInterface $entityManager,
       // validatorInterface $validator
    ): Response {
        //$constraints = Validation::getConstrains();
        $response = [];
        
        $name = $request->request->get('name');
        $response["name"]= $name; 

       // $validationResult = $validator->validate($postData, $constraints);
            $response[] = "validate_success";
            try {
                $group = new Group();
                $group->setName($name);
                $entityManager->persist($group);
                $entityManager->flush();
                $response[] = $group->getId();
                $response[] = "insert_success";
            } catch (\Exception $e) {
                $response['insert_errror'] = $e->getMessage();
            }
       
        return $this->json($response);
    }
    #[Route('/update', name: 'app_group_update', methods: ['GET', 'PUT'])]
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateGroup(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        //$constraints = Validation::getConstrains();
        $response = [];
        $id = $request->request->get('id');
        $name = $request->request->get('name');
       
        $group = $entityManager->getRepository(Group::class)->find($id);

        if (!$group) {
                $response["error"] = 'No product found for id '.$id;
        } else {
            try {
                $response["old_name"] = $group->getName();
                $group->setName($name); 
                $entityManager->persist($group);
                $entityManager->flush();
                $response["id"] = $group->getId();
                $response["new_name"] = $group->getName();
                $response["success"] = "update";
            } catch (\Exception $e) {
                $response['insert_error'] = $e->getMessage();
            }
        }
        return $this->json($response);
    }
    #[Route('/list', name: 'app_group_list', methods: ['GET'])]
    public function getList(): Response
    {
        $response["name"] = "test";
        return $this->json($response);
    }
    
    #[Route('/delete', name: 'app_group_delete', methods: ['DELETE'])]
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function deleteGroup(
        Request $request,
        validatorInterface $validator,
        EntityManagerInterface $entityManager
    ): Response {
        $id = $request->request->get('id');
        $group = $entityManager->getRepository(Group::class)->find($id);

        if (!$group) {
            $response["error"] = 'No product found for id '.$id;
        } else {
            try {
                $entityManager->remove($group);
                $entityManager->flush();
                $response["delete"] = 'success';
            } catch (\Exception $e) {
                $response['delete_error'] = $e->getMessage();
            }
        }
        return $this->json($response);
    }
}
