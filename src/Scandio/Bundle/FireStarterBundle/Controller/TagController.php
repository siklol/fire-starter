<?php

namespace Scandio\Bundle\FireStarterBundle\Controller;

use Scandio\Bundle\FireStarterBundle\Entity\Link;
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
 * @Route("/tags")
 */
class TagController extends Controller
{
    /**
     * @Route("/", name="tags")
     *
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        /** @var TagRepository $tagsRepository */
        $tagsRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Tag');

        return ['entities' => $tagsRepository->getAll()];
    }
}
