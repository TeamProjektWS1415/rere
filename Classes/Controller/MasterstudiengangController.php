<?php

namespace ReRe\Rere\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015
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
 * MasterstudiengangController
 */
class MasterstudiengangController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * masterstudiengangRepository
     *
     * @var \ReRe\Rere\Domain\Repository\MasterstudiengangRepository
     * @inject
     */
    protected $masterstudiengangRepository = NULL;

    /**
     * Protected Variable objectManager wird mit NULL initialisiert.
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager = NULL;

    /**
     * Listet alle Masterstudiengänge auf.
     * @param \Rere\Kaka\Domain\Model\Masterstudiengang $newMasterstudiengang
     * @return void
     */
    public function listAction(\ReRe\Rere\Domain\Model\Masterstudiengang $newMasterstudiengang = NULL) {
	$masterstudiengangs = $this->masterstudiengangRepository->findAll();
	$this->view->assignMultiple(array('masterstudiengangs' => $masterstudiengangs, 'newMasterstudiengang', $newMasterstudiengang));
    }

    /**
     * action new
     *
     * @param \Rere\Kaka\Domain\Model\Masterstudiengang $newMasterstudiengang
     * @ignorevalidation $newMasterstudiengang
     * @return void
     */
    public function newAction(\ReRe\Rere\Domain\Model\Masterstudiengang $newMasterstudiengang = NULL) {
	$this->view->assign('newMasterstudiengang', $newMasterstudiengang);
    }

    /**
     * Methode um einen neuen Masterstudiengang anzulegen.
     *
     * @return void
     */
    public function createAction() {
	$name = $this->request->getArgument('name');

	$newMasterstudiengang = $this->objectManager->create('\\ReRe\\Rere\\Domain\\Model\\Masterstudiengang');
	$newMasterstudiengang->setName($name);

	$this->masterstudiengangRepository->add($newMasterstudiengang);
	$this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \ReRe\Rere\Domain\Model\Masterstudiengang $masterstudiengang
     * @ignorevalidation $masterstudiengang
     * @return void
     */
    public function editAction(\ReRe\Rere\Domain\Model\Masterstudiengang $masterstudiengang) {
	$this->view->assign('masterstudiengang', $masterstudiengang);
    }

    /**
     * action update
     *
     * @param \ReRe\Rere\Domain\Model\Masterstudiengang $masterstudiengang
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Masterstudiengang $masterstudiengang) {
	$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
	$this->masterstudiengangRepository->update($masterstudiengang);
	$this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \ReRe\Rere\Domain\Model\Masterstudiengang $masterstudiengang
     * @return void
     */
    public function deleteAction(\ReRe\Rere\Domain\Model\Masterstudiengang $masterstudiengang) {
	$this->masterstudiengangRepository->remove($masterstudiengang);
	$this->redirect('list');
    }

}
