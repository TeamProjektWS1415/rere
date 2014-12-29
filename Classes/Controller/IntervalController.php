<?php

namespace ReRe\Rere\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * IntervalController
 */
class IntervalController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * intervalRepository
     *
     * @var \ReRe\Rere\Domain\Repository\IntervalRepository
     * @inject
     */
    protected $intervalRepository = NULL;

    /**
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Interval $interval
     * @ignorevalidation $interval
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Interval $interval) {
        $this->view->assign('interval', $interval);
    }

    /**
     * action update
     *
     * @return void
     */
    public function updateAction() {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);

        $intervals = $this->intervalRepository->findall();

        var_dump($this->request->hasArgument('nextInterval'));

        if ($this->request->hasArgument('nextInterval')) {
            // Aktuelles Intervall holen.
            foreach ($intervals as $intervaliterate) {
                $interval = $intervaliterate;
            }

            var_dump($interval);
            $interval->setType("Pups");
            $this->intervalRepository->update($interval);
        }


        //$this->redirect('list');
    }

    /**
     * action new
     *
     * @param \ReRe\Rere\Domain\Model\Interval $newInterval
     * @ignorevalidation $newInterval
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Interval $newInterval = NULL) {
        $this->view->assign('newInterval', $newInterval);
    }

    /**
     * action create
     *
     * @param \ReRe\Rere\Domain\Model\Interval $newInterval
     * @return void
     */
    public function createAction(\ReRe\Rere\Domain\Model\Interval $newInterval) {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->intervalRepository->add($newInterval);
        $this->redirect('list');
    }

}
