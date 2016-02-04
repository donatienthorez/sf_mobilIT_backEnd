<?php

namespace MainBundle\Controller\Api;

use MainBundle\Entity\Category;
use MainBundle\Entity\Section;
use MainBundle\Model\CategoryModel;
use MainBundle\Security\Voter\SectionVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FosRest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @FosRest\NamePrefix("api_categories_")
 */
class CategoryController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     *
     * @FosRest\Post("/{category}/addChild", requirements={"category" = "\d+"})
     *
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @FosRest\View()
     * @param Category $category
     *
     * @return CategoryModel $categoryModel
     */
    public function addChildAction(Category $category)
    {
        if (!$this->isGranted(SectionVoter::ACCESS, $category->getGuide()->getSection())) {
            throw new AccessDeniedHttpException(
                "Only admins can edit guides of others sections than theirs."
            );
        }

        return $this
            ->get('main.category.service')
            ->addChild($category);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     *
     * @FosRest\Post()
     *
     * @FosRest\View()
     *
     * @return CategoryModel $categoryModel
     */
    public function addAction(Request $request)
    {
        $section = $request->request->get('section');
        $section =
            $section ?
                $this
                    ->get('main.section.fetcher')
                    ->getSection($section)
                : $this->getUser()->getSection();

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuide($section);

        if (!$this->isGranted(SectionVoter::ACCESS, $section)) {
            throw new AccessDeniedHttpException(
                "Only admins can edit guides of others sections than theirs."
            );
        }

        return $this
            ->get('main.category.service')
            ->add($guide);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     *
     * @FosRest\View()
     *
     * @FosRest\Post("/{category}/edit", requirements={"category" = "\d+"})
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @param Category $category
     */
    public function editCategoryAction(Category $category, Request $request)
    {
        if (!$this->isGranted(SectionVoter::ACCESS, $category->getGuide()->getSection())) {
            throw new AccessDeniedHttpException(
                "Only admins can edit guides of others sections than theirs."
            );
        }

        $title = $request->request->get('title');
        $content = $request->request->get('content');

        $this
            ->get('main.category.service')
            ->edit($category, $title, $content);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     *
     * @FosRest\View()
     *
     * @FosRest\Post("/{category}/move", requirements={"category" = "\d+"})
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @param Category $category
     */
    public function moveCategoryAction(Category $category, Request $request)
    {
        $parentId = $request->request->get('newParentId');
        $position = $request->request->get('position');

        $this
            ->get('main.category.service')
            ->move($category, $parentId, $position);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     *
     * @FosRest\Delete("/{category}/remove", requirements={"category" = "\d+"})
     *
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @FosRest\View()
     * @param Category $category
     */
    public function removeAction(Category $category)
    {
        if (!$this->isGranted(SectionVoter::ACCESS, $category->getGuide()->getSection())) {
            throw new AccessDeniedHttpException(
                "Only admins can edit guides of others sections than theirs."
            );
        }

        return $this
            ->get('main.category.service')
            ->removeCategory($category);
    }
}