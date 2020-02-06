<?php

namespace Barcodes\Bundle\AppBundle\Controller;

use Barcodes\Bundle\AppBundle\Entity\Pricingrule;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Akeneo\Tool\Component\StorageUtils\Exception\PropertyException;
use Akeneo\Tool\Component\StorageUtils\Factory\SimpleFactoryInterface;
use Akeneo\Tool\Component\StorageUtils\Remover\RemoverInterface;
use Akeneo\Tool\Component\StorageUtils\Saver\SaverInterface;
use InvalidArgumentException;
use LogicException;
use Barcodes\Bundle\AppBundle\Structure\Doctrine\ORM\PricingruleUpdater;
use Barcodes\Bundle\AppBundle\Repository\PricingruleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Barcodes\Bundle\AppBundle\Structure\Component\Normalizer\Standard\PricingruleNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Pricingrule controller.
 *
 */
class PricingruleController extends Controller
{
    /** @var PricingruleRepository */
    protected $pricingruleRepository;

    /** @var NormalizerInterface */
    protected $normalizer;

    /** @var RemoverInterface */
    protected $remover;

    /** @var PricingruleUpdater */
    protected $updater;

    /** @var SaverInterface */
    protected $saver;

    /** @var SimpleFactoryInterface  */
    protected $pricingruleFactory;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param PricingruleRepository     $pricingruleRepository
     * @param PricingruleNormalizer       $normalizer
     * @param RemoverInterface          $remover
     * @param PricingruleUpdater              $updater
     * @param SaverInterface            $saver
     * @param SimpleFactoryInterface    $pricingruleFactory
     * @param ValidatorInterface        $validator
     */
    public function __construct(
        PricingruleRepository $pricingruleRepository, 
        PricingruleNormalizer $normalizer, 
        RemoverInterface $remover, 
        PricingruleUpdater $updater, 
        SaverInterface $saver, 
        SimpleFactoryInterface $pricingruleFactory,
        ValidatorInterface $validator
    ) {
        $this->pricingruleRepository = $pricingruleRepository;
        $this->normalizer = $normalizer;
        $this->remover = $remover;
        $this->updater = $updater;
        $this->saver = $saver;
        $this->pricingruleFactory = $pricingruleFactory;
        $this->validator = $validator;
    }

    /**
     * Lists all pricingrule entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pricingrules = $em->getRepository('BarcodesAppBundle:Pricingrule')->findAll();

        return $this->render('pricingrule/index.html.twig', array(
            'pricingrules' => $pricingrules,
        ));
    }

    /**
     * Gets pricingrule by id
     *
     * @param Request $request
     * @param int $identifier
     *
     * @return JsonResponse
     */
    public function getAction(Request $request, $identifier)
    {
        $pricingrule = $this->getPricingruleOr404($identifier);

        return new JsonResponse(
            $this->normalizer->normalize(
                $pricingrule,
                'internal_api'
            )
        );
    }

    /**
     * Updates Procingrule
     *
     *
     * @param Request $request
     * @param string $identifier
     *
     * @return Response
     * @throws PropertyException
     * @throws LogicException
     * @throws InvalidArgumentException
     *
     * @AclAncestor("barcodes_pricingrule_edit")
     *
     * @throws HttpExceptionInterface
     */
    public function putAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new RedirectResponse('/');
        }
        $data = json_decode($request->getContent(), true);
        $identifier = $data['id'];
        $pricingrule = $this->getPricingruleOr404($identifier);

        return $this->savePricingrule($pricingrule, $request);
    }

     /**
     * @param object $pricingrule
     * @param Request $request
     *
     * @return JsonResponse
     * @throws PropertyException
     * @throws InvalidArgumentException
     *
     * @throws LogicException
     */
    protected function savePricingrule($pricingrule, $request)
    {
        $data = json_decode($request->getContent(), true);
        $this->updater->update($pricingrule, $data);

        $violations = $this->validator->validate($pricingrule);

        if (0 < $violations->count()) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = [
                    'message' => $violation->getMessage()
                ];
            }

            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->saver->save($pricingrule);

        return new JsonResponse(
            $this->normalizer->normalize($pricingrule, 'internal_api')
        );
    }

    /**
     * Finds pricingrule by id or throws not found exception
     *
     * @param int $id
     *
     * @return object|null
     *
     * @throws NotFoundHttpException
     */
    protected function getPricingruleOr404(int $id) : ?object
    {
        $pricingrule = $this->pricingruleRepository->findOneByIdentifier($id);
        if (null === $pricingrule) {
            throw new NotFoundHttpException(
                sprintf('Pricingrule with id "%s" not found', $id)
            );
        }

        return $pricingrule;
    }

    /**
     * Creates a new pricingrule entity.
     *
     */
    public function newAction(Request $request) : JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return new RedirectResponse('/');
        }
        $data = json_decode($request->getContent(), true);
        $pricingrule = $this->pricingruleFactory->create();
        $this->updater->update($pricingrule, $data);
        $this->saver->save($pricingrule);

        return new JsonResponse(
            $this->normalizer->normalize($pricingrule, 'internal_api')
        );


  
        if ($form->isSubmitted() && $form->isValid()) {
            $post = '';
            foreach ($_POST as $key => $value) {
                $post = $key;
            }
            print_r(json_decode($post));
            $post = json_decode($post);
            $pricingrule->setManufacturer($post->manufacturer);
            $pricingrule->setCategory($post->category);
            $pricingrule->setProduct($post->product);
            $pricingrule->setPricetype('PRICE');
            $pricingrule->setOperator($post->operator);
            $pricingrule->setValue($post->value);
            $pricingrule->setChannel($post->channel);
            $pricingrule->setCreatedAt();
            $pricingrule->setUpdatedAt();
            $em = $this->getDoctrine()->getManager();
            $em->persist($pricingrule);
            $em->flush();

            return $this->redirectToRoute('barcodes_pricingrules_show', array('id' => $pricingrule->getId()));
        }elseif($form->isSubmitted()) {
            echo 'form submitted';
            if(!$form->isValid()){
                die('invalid form');
            }
            die();
        }

        if($form->isSubmitted()){
            die('Form is submitted');
        }


        return $this->render('pricingrule/new.html.twig', array(
            'pricingrule' => $pricingrule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pricingrule entity.
     *
     */
    public function showAction(Pricingrule $pricingrule)
    {
        $deleteForm = $this->createDeleteForm($pricingrule);

        return $this->render('pricingrule/show.html.twig', array(
            'pricingrule' => $pricingrule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pricingrule entity.
     *
     */
    public function editAction(Request $request, Pricingrule $pricingrule)
    {
        $deleteForm = $this->createDeleteForm($pricingrule);
        $editForm = $this->createForm('Barcodes\Bundle\AppBundle\Form\PricingruleType', $pricingrule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('barcodes_pricingrules_edit', array('id' => $pricingrule->getId()));
        }

        return $this->render('pricingrule/edit.html.twig', array(
            'pricingrule' => $pricingrule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Remove action
     *
     * @param Request $request
     * 
     * @param Int $id
     *
     * @return JsonResponse|RedirectResponse
     *
     * @AclAncestor("barcodes_pricingrule_remove")
     */
    public function deleteAction(Request $request, int $id) : JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return new RedirectResponse('/');
        }
        
        $pricingrule = $this->getPricingruleOr404($id);

        $this->remover->remove($pricingrule);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Deletes a pricingrule entity.
     *
     */
    /*public function deleteAction(Request $request, Pricingrule $pricingrule)
    {
        $form = $this->createDeleteForm($pricingrule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pricingrule);
            $em->flush();
        }

        return $this->redirectToRoute('barcodes_pricingrules_index');
    }*/

    /**
     * Creates a form to delete a pricingrule entity.
     *
     * @param Pricingrule $pricingrule The pricingrule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pricingrule $pricingrule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('barcodes_pricingrules_delete', array('id' => $pricingrule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
