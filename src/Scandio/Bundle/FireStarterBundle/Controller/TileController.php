<?php

namespace Scandio\Bundle\FireStarterBundle\Controller;

use Scandio\Bundle\FireStarterBundle\Entity\Link;
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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ScandioFireStarterBundle:Tile')->findAll();

        return array(
            'entities' => array_chunk($entities, 4),
            'form' => $this->createForm(new TileType())->createView()
        );
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

        return $this->redirect($this->generateUrl('tiles'));
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
}
