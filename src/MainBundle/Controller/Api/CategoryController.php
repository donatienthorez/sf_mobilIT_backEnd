<?php

namespace MainBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations as FosRest;
use MainBundle\Controller\Api\Base\BaseController;
use MainBundle\Entity\Category;
use MainBundle\Model\CategoryModel;
use MainBundle\Security\Voter\SectionVoter;

/**
 * @FosRest\NamePrefix("api_categories_")
 *
 * @Security("has_role('ROLE_BOARD')")
 */
class CategoryController extends BaseController
{
    /**
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
        $this->checkPermissionsForSection($category->getGuide()->getSection());

        return $this
            ->get('main.category.service')
            ->addChild($category);
    }

    /**
     * @FosRest\Post("/")
     *
     * @FosRest\View()
     *
     * @return CategoryModel $categoryModel
     */
    public function addAction(Request $request)
    {
        $section = $this->getUser()->getSection();

        $this->checkPermissionsForSection($section);

        $guide = $this
            ->get('main.guide.fetcher')
            ->getGuide($section);

        if (!$guide) {
            $guide = $this
                ->get('main.guide.creator')
                ->createGuide($section);

            $this
                ->get('main.guide.manager')
                ->addGuide($guide);
        }

        return $this
            ->get('main.category.service')
            ->add($guide);
    }

    /**
     * @FosRest\View()
     *
     * @FosRest\Put("/{category}/edit", requirements={"category" = "\d+"})
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @param Category $category
     */
    public function editCategoryAction(Category $category, Request $request)
    {
        $this->checkPermissionsForSection($category->getGuide()->getSection());

        $title = $request->request->get('title');
        $content = $request->request->get('content');

        $this
            ->get('main.category.service')
            ->edit($category, $title, $content);
    }

    /**
     * @FosRest\View()
     *
     * @FosRest\Put("/{category}/move", requirements={"category" = "\d+"})
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @param Category $category
     */
    public function moveCategoryAction(Category $category, Request $request)
    {
        $this->checkPermissionsForSection($category->getGuide()->getSection());

        $parentId = $request->request->get('newParentId');
        $position = $request->request->get('position');

        $this
            ->get('main.category.service')
            ->move($category, $parentId, $position);
    }

    /**
     * @FosRest\Delete("/{category}", requirements={"category" = "\d+"})
     *
     * @ParamConverter("category", class="MainBundle:Category")
     *
     * @FosRest\View()
     * @param Category $category
     */
    public function removeAction(Category $category)
    {
        $this->checkPermissionsForSection($category->getGuide()->getSection());

        return $this
            ->get('main.category.service')
            ->removeCategory($category);
    }
}
