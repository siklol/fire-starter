<?php

namespace Scandio\Bundle\FireStarterBundle\Controller;

use Scandio\Bundle\FireStarterBundle\Entity\Link;
use Scandio\Bundle\FireStarterBundle\Entity\LinkRepository;
use Scandio\Bundle\FireStarterBundle\Entity\TagRepository;
use Scandio\Library\Http\HtmlParser;
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
 * @Route("/links")
 */
class LinkController extends Controller
{

    /**
     * @param Request $request
     *
     * @Route("/new/{id}", name="links_add", defaults={"id":null})
     * @Method("POST")
     */
    public function newAction(Request $request, Tile $tile = null)
    {
        $link = new Link();
        $title = $request->get('title', '');
        $url = $request->get('url', '');
        $tags = $request->get('tags', '');

        if (!empty($title) && !empty($url)) {
            $link->setTitle($title);
            $link->setUrl($url);
            $link->setTile($tile);
            $link->setFavicon($this->get('fav_icon_fetcher')->getByGoogleService($url));

            $em = $this->getDoctrine()->getManager();
            /** @var TagRepository $tagsRepository */
            $tagsRepository = $em->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Tag');

            $em->persist($link);
            $em->flush();

            $tags = explode(',', $tags);
            array_walk($tags, function(&$tag) { $tag = trim($tag); });
            foreach ($tags as $tag) {
                $tagsRepository->add($link, $tag);
            }
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/uncategorized", name="links_uncategorized")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function uncategorizedAction(Request $request)
    {
        /** @var LinkRepository $linksRepository */
        $linksRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Link');

        return ['links' => $linksRepository->getUncategorized()];
    }

    /**
     * @Route("/keywords", name="links_keywords")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getKeywordsAction(Request $request)
    {
        $url = $request->get('url');

        $response = ['keywords' => '', 'title' => ''];
        if (!empty($url)) {
            $htmlData = file_get_contents($url);
            $response['keywords'] = str_replace(";", ",", HtmlParser::getMetaKeywords($htmlData));
            $response['title'] = HtmlParser::getTitle($htmlData);
        }

        return new JsonResponse($response);
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
