<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Page;
use AppBundle\Entity\Source;
use AppBundle\Entity\Storage;
use AppBundle\Entity\Widget;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{
    public function savePages($portal, $pages) {

        $em = $this->getEntityManager();
        foreach ($pages as $data) {
            $this->handlePage($em, $portal, $data);
        }
    }

    private function handlePage($em, $portal, $data) {

        if (isset($data['_action'])) {

            switch ($data['_action']) {
                case 'remove':
                    $this->handlePageRemove($em, $portal, $data);
                    break;
                case 'update':
                    $page = $this->handlePageUpdate($em, $portal, $data);
                    $this->handlePageTree($em, $page, $data);
                    break;
                case 'create':
                    $page = $this->handlePageCreate($em, $portal, $data);
                    $this->handlePageTree($em, $page, $data);
                    break;
            }

        } else {
            $page = $this->findOneById($data['id']);
            $this->handlePageTree($em, $page, $data);
        }
    }

    private function handlePageCreate($em, $portal, $data) {

        $page = (new Page())
            ->setName($data['name'])
            ->setPortal($portal)
            ->setTitle($data['title'])
            ->setMetas($this->clearParams($data['metas']))
        ;

        $em->persist($page);
        $em->flush();

        return $page;
    }

    private function handlePageUpdate($em, $portal, $data) {

        $page = $this->findOneById($data['id'])
            ->setName($data['name'])
            ->setTitle($data['title'])
            ->setMetas($this->clearParams($data['metas']))
        ;

        $em->persist($page);
        $em->flush();

        return $page;
    }

    private function handlePageRemove($em, $portal, $data) {

        $page = $this->findOneById($data['id']);

        $em->remove($page);
        $em->flush();
    }

    private function handlePageTree($em, $page, $data) {

        foreach ($data['sources'] as $source) {

            $this->handlePageSource($em, $page, $source);
        }

        foreach ($data['storages'] as $storage) {

            $this->handlePageStorage($em, $page, $storage);
        }

        $nextedContext = [
            'index' => 0,
            'page' => $page,
            'parent' => null,
        ];

        foreach ($data['widgets'] as $widget) {
            $this->handlePageWidget($em, $nextedContext, $widget);
        }
    }

    private function handlePageSource($em, $page, $data) {

        if (isset($data['_action'])) {

            switch ($data['_action']) {
                case 'remove':
                    $this->handlePageSourceRemove($em, $page, $data);
                    break;
                case 'update':
                    $source = $this->handlePageSourceUpdate($em, $page, $data);
                    $this->handlePageSourceTree($em, $page, $source, $data);
                    break;
                case 'create':
                    $source = $this->handlePageSourceCreate($em, $page, $data);
                    $this->handlePageSourceTree($em, $page, $source, $data);
                    break;
            }

        } else {
            $source = $em->getRepository('AppBundle:Source')->findOneById($data['id']);
            $this->handlePageSourceTree($em, $page, $source, $data);
        }
    }

    private function handlePageSourceCreate($em, $page, $data) {

        $source = (new Source())
            ->setName($data['name'])
            ->setPage($page)
            ->setUrl($data['url'])
            ->setMethod($data['method'])
            ->setParams($this->clearParams($data['params']))
        ;

        $em->persist($source);
        $em->flush();

        return $source;
    }

    private function handlePageSourceUpdate($em, $page, $data) {

        $source = $em->getRepository('AppBundle:Source')->findOneById($data['id'])
            ->setName($data['name'])
            ->setUrl($data['url'])
            ->setMethod($data['method'])
            ->setParams($this->clearParams($data['params']))
        ;

        $em->persist($source);
        $em->flush();

        return $source;
    }

    private function handlePageSourceRemove($em, $page, $data) {

        $source = $em->getRepository('AppBundle:Source')->findOneById($data['id']);

        $em->remove($source);
        $em->flush();
    }

    private function handlePageSourceTree($em, $page, $source, $data) {
    }

    private function handlePageStorage($em, $page, $data) {

        if (isset($data['_action'])) {

            switch ($data['_action']) {
                case 'remove':
                    $this->handlePageStorageRemove($em, $page, $data);
                    break;
                case 'update':
                    $storage = $this->handlePageStorageUpdate($em, $page, $data);
                    $this->handlePageStorageTree($em, $page, $storage, $data);
                    break;
                case 'create':
                    $storage = $this->handlePageStorageCreate($em, $page, $data);
                    $this->handlePageStorageTree($em, $page, $storage, $data);
                    break;
            }

        } else {
            $storage = $em->getRepository('AppBundle:Storage')->findOneById($data['id']);
            $this->handlePageStorageTree($em, $page, $storage, $data);
        }
    }

    private function handlePageStorageCreate($em, $page, $data) {

        $storage = (new Storage())
            ->setName($data['name'])
            ->setPage($page)
            ->setVariables($this->clearParams($data['variables']))
        ;

        $em->persist($storage);
        $em->flush();

        return $storage;
    }

    private function handlePageStorageUpdate($em, $page, $data) {

        $storage = $em->getRepository('AppBundle:Storage')->findOneById($data['id'])
            ->setName($data['name'])
            ->setVariables($this->clearParams($data['variables']))
        ;

        $em->persist($storage);
        $em->flush();

        return $storage;
    }

    private function handlePageStorageRemove($em, $page, $data) {

        $storage = $em->getRepository('AppBundle:Storage')->findOneById($data['id']);

        $em->remove($storage);
        $em->flush();
    }

    private function handlePageStorageTree($em, $page, $storage, $data) {
    }

    private function handlePageWidget($em, &$context, $data) {

        if (isset($data['_action'])) {

            switch ($data['_action']) {
                case 'remove':
                    $this->handlePageWidgetRemove($em, $context, $data);
                    break;
                case 'update':
                    $widget = $this->handlePageWidgetUpdate($em, $context, $data);
                    $this->handlePageWidgetTree($em, $context, $widget, $data);
                    break;
                case 'create':
                    $widget = $this->handlePageWidgetCreate($em, $context, $data);
                    $this->handlePageWidgetTree($em, $context, $widget, $data);
                    break;
            }

        } else {
            $widget = $this->handlePageWidgetIndex($em, $context, $data);
            $this->handlePageWidgetTree($em, $context, $widget, $data);
        }
    }

    private function handlePageWidgetCreate($em, &$context, $data) {

        $widget = (new Widget())
            ->setPage($context['page'])
            ->setIndex($context['index']++)
            ->setParent($context['parent'])
            ->setName($data['name'])
            // TODO: Проверить/очистить
            ->setParams($data['params'])
        ;

        $em->persist($widget);
        $em->flush();

        return $widget;
    }

    private function handlePageWidgetIndex($em, &$context, $data) {

        $widget = $em->getRepository('AppBundle:Widget')->findOneById($data['id'])
            ->setIndex($context['index']++)
        ;

        $em->persist($widget);
        $em->flush();

        return $widget;
    }

    private function handlePageWidgetUpdate($em, &$context, $data) {

        $widget = $em->getRepository('AppBundle:Widget')->findOneById($data['id'])
            ->setName($data['name'])
            ->setIndex($context['index']++)
            ->setParams($data['params'])
        ;

        $em->persist($widget);
        $em->flush();

        return $widget;
    }

    private function handlePageWidgetRemove($em, &$context, $data) {

        $widget = $em->getRepository('AppBundle:Widget')->findOneById($data['id']);

        $em->remove($widget);
        $em->flush();
    }

    private function handlePageWidgetTree($em, &$context, $widget, $data) {

        $nestedContext = [
            'index' => 0,
            'page' => null,
            'parent' => $widget,
        ];

        if (isset($data['widgets'])) {
            foreach ($data['widgets'] as $widget) {
                $this->handlePageWidget($em, $nestedContext, $widget);
            }
        }
    }

    private function clearParams($data) {

        $array = [];

        foreach ($data as $param) {
            if (!isset($param['_action']) || $param['_action'] != 'remove') {
                $p = $param;
                unset($p['_action']);
                $array[] = $p;
            }
        }

        return $array;
    }
}
