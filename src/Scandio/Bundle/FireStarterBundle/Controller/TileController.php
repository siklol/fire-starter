<?php

namespace Scandio\Bundle\FireStarterBundle\Controller;

use Scandio\Bundle\FireStarterBundle\Entity\Link;
use Scandio\Bundle\FireStarterBundle\Entity\TileRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Scandio\Bundle\FireStarterBundle\Entity\Tile;
use Scandio\Bundle\FireStarterBundle\Form\TileType;

/**
 * Tile controller.
 *
 * @Route("/")
 */
class TileController extends Controller
{

    /**
     * Lists all Tile entities.
     *
     * @Route("/", name="tiles")
     * @Route("/display:{type}", name="tiles_type")
     * @Method("GET")
     */
    public function indexAction(Request $request, $type = 'tiles')
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScandioFireStarterBundle:Tile')->getAll();
        $type = in_array($type, ['list', 'tiles']) ? $type : '';

        if ($type == 'tiles') {
            $entities = array_chunk($entities, 4);
        }

        return $this->render("ScandioFireStarterBundle:Tile:index.$type.html.twig", [
            'entities' => $entities,
            'form' => $this->createForm(new TileType())->createView(),
            'type' => $type
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/new", name="tiles_add")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $tile = new Tile();

        $title = $request->get('title', '');
        $description = $request->get('description', '');
        $image = $request->files->get('image', null);

        if (!empty($title)) {
            $tile->setTitle($title);
            $tile->setDescription($description);
            $tile->setImage($this->get('image_manager')->upload($image));

            $em = $this->getDoctrine()->getManager();

            $em->persist($tile);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/links/{id}", name="tiles_show")
     * @Template()
     *
     * @param Tile $tile
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function showAction(Tile $tile)
    {
        return array(
            'tile' => $tile
        );
    }

    /**
     * @Route("/reorder/{id}", name="tiles_reorder")
     *
     * @param Request $request
     * @param Tile $tile
     * @param $position
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sortAction(Request $request, Tile $tile)
    {
        $position = $request->get('position', 0);

        /** @var TileRepository $tileRepository */
        $tileRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Tile');

        $tileRepository->resort($tile, $position);

        return new JsonResponse(['status' => 'ok']);
    }
}
