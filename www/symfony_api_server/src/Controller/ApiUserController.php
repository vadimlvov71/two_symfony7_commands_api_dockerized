<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use App\Entity\User;
use App\Entity\Group;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Validations\Validation;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
//use "Symfony\Component\Messenger\Transport\Serialization\Serializer";

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
#[Route('/user')]
class ApiUserController extends AbstractController
{

    #[Route('/new', name: 'app_api_user_new', methods: ['GET', 'POST'])]
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param validatorInterface $validator
     *
     * @return Response
     */
    public function newUser(
        Request $request,
        EntityManagerInterface $entityManager,
        validatorInterface $validator
    ): Response {
        $data = [];
        $response = [];
        
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $group_name = $request->request->get('group_name');
        $group_id = 1;
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($user) {
            $response["error_email_exists"] = true;
        } else {
            $group = $entityManager->getRepository(Group::class)->findOneBy(['name' => $group_name]);

            if (!$group) {
                $response["group_error"] = true;
            } else {

                $data["name"] = $name;
                $data["email"] = $email;
                $data["group_name"] = $group_name;

                /* validation */
                $constraints = Validation::getConstrains("new");
                $validationResult = $validator->validate($data, $constraints);
                if (count($validationResult) > 0) {
                    foreach ($validationResult as $result) {
                        $responseItem[$result->getPropertyPath()] = $result->getMessage();
                    }
                   // $response['validate_error'] = $responseItem;
                } else {
                /* /validation */
    
                    try {
                        $user = new User();
                        $user->setName($name);
                        $user->setEmail($email);
                        $user->setGroup($group);
                        $entityManager->persist($user);
                        $entityManager->flush();
                    } catch (\Exception $e) {
                        $response['insert_error'] = $e->getMessage();
                    }
                }
            }
        }
        return $this->json($response);
    }
    #[Route('/update', name: 'app_user_update', methods: ['GET', 'PATCH'])]
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateUser(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        //$constraints = Validation::getConstrains();
        $response = [];
        $id = $request->request->get('id_user');
        
        $action = $request->request->get('action');
        $user = $entityManager->getRepository(User::class)->find($id);
        
        if (!$user) {
            $response["error"]["no_user"] = true;
        } else {
            try {
                if ($action == "user") {
                    $name = $request->request->get('name');
                    $user->setName($name);
                    $response["success_update"] = "name"; 
                } else {
                    $id_group = $request->request->get('id_group');
                    $group = $entityManager->getRepository(Group::class)->find($id_group); 
                    if (!$group) {
                        $response["error"]["no_group"] = true;
                    } else {
                        $user->setGroup($group->getId());;
                        $response["success_update"] = "id_group"; 
                    }
                }
                
                $entityManager->persist($user);
                $entityManager->flush();
                
            } catch (\Exception $e) {
                $response['insert_error'] = $e->getMessage();
            }

        }
       
        return $this->json($response);
    }
    #[Route('/list', name: 'app_api_user_list', methods: ['GET'])]
    public function getList(
        EntityManagerInterface $em,
    ): Response
    {
        $groups = $em->getRepository(Group::class)->findAll();
        //$users = $em->getRepository(User::class)->findAll();
        //$query = $em->createQuery('SELECT u.id, u.name, u.email, u.group_id, g.name FROM App\Entity\Group g JOIN g.user u ORDER BY g.name ASC');
        //$response["groups"] = $groups;
        //$response["users"] = $users;
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($groups, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
]);

        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
}
