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
class LinkController extends Controller
{

    /**
     * @param Request $request
     *
     * @Route("/new/{id}", name="links_add")
     * @Method("POST")
     */
    public function newAction(Request $request, Tile $tile)
    {
        $link = new Link();
        $title = $request->get('title', '');
        $url = $request->get('url', '');

        if (!empty($title) && !empty($url)) {
            $link->setTitle($title);
            $link->setUrl($url);
            $link->setTile($tile);

            $em = $this->getDoctrine()->getManager();

            $em->persist($link);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/remove/{id}", name="links_remove")
     *
     * @param Link $link
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Link $link)
    {
        $tile = $link->getTile();

        $em = $this->getDoctrine()->getManager();
        $em->remove($link);
        $em->flush();

        return $this->redirect($this->generateUrl('tiles_show', array('id' => $tile->getId())));
    }

    /**
     * @Route("/out/{id}", name="links_out")
     *
     * @param Link $link
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function outAction(Link $link)
    {
        $link->increaseClickCount();

        $em = $this->getDoctrine()->getManager();
        $em->persist($link);
        $em->flush();

        return $this->redirect($link->getUrl());
    }
}
