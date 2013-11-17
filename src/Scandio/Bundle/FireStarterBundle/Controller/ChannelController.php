<?php

namespace Scandio\Bundle\FireStarterBundle\Controller;

use Scandio\Bundle\FireStarterBundle\Entity\Channel;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Tile controller.
 *
 * @Route("/c")
 */
class ChannelController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/new", name="channels_add")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $tile = new Channel();

        $name = $request->get('name', '');
        $description = $request->get('description', '');

        if (!empty($name)) {
            $tile->setName($name);
            $tile->setDescription($description);
            $em = $this->getDoctrine()->getManager();

            $em->persist($tile);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/{slug}/tiles", name="channels_add_tiles")
     * @Template("ScandioFireStarterBundle:Channel:tile_list.html.twig")
     */
    public function addTilesAction(Request $request, Channel $channel)
    {
        $em = $this->getDoctrine()->getManager();

        return [
            'tiles' => array_chunk($em->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Tile')->getAll(), 4),
            'channel' => $channel
        ];
    }

    /**
     * @param Request $request
     * @param Channel $channel
     * @param Tile $tile
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/toggle/{slug}/{tileId}", name="channels_toggle")
     * @ParamConverter("tile", class="ScandioFireStarterBundle:Tile", options={"id" = "tileId"})
     */
    public function toggleAction(Request $request, Channel $channel, Tile $tile)
    {
        $em = $this->getDoctrine()->getManager();

        if ($channel->has($tile)) {
            $channel->remove($tile);
        } else {
            $channel->add($tile);
        }

        $em->persist($channel);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
