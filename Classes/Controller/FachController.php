<?php
namespace Rere\Rere\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
 *           Sarah Kieninger <sarah.kieninger@gmail.com>, TeamProjektWS14/15
 *           Tim Wacker, TeamProjektWS14/15
 *           Nejat Balta, TeamProjektWS14/15
 *           Tobias Brockner, TeamProjektWS14/15
 *           Nicolas Tedjadharma, TeamProjektWS14/15
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
 * FachController
 */
class FachController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * fachRepository
	 * 
	 * @var \ReRe\Rere\Domain\Repository\FachRepository
	 * @inject
	 */
	protected $fachRepository = NULL;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper
	 * @inject
	 */
	protected $dataMapper = NULL;

	/**
	 * action list
	 * 
	 * @return void
	 */
	public function listAction() {
		$faches = $this->fachRepository->findAll();
		$this->view->assign('faches', $faches);
	}

	/**
	 * @param int $uid
	 * @return type
	 */
	public function listFaecherFromModul(int $uid) {
		$query = $this->createQuery();
		$query->in('modulnr', $uid);
		return $this->dataMapper->map(`\\ReRe\\Rere\\Domain\\Model\\Fach}`, $query->execute());
	}

	/**
	 * action show
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $fach
	 * @return void
	 */
	public function showAction(\ReRe\Rere\Domain\Model\Fach $fach) {
		$this->view->assign('fach', $fach);
	}

	/**
	 * action new
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $newFach
	 * @ignorevalidation $newFach
	 * @return void
	 */
	public function newAction(\ReRe\Rere\Domain\Model\Fach $newFach = NULL) {
		$this->view->assign('newFach', $newFach);
	}

	/**
	 * action create
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $newFach
	 * @return void
	 */
	public function createAction(\ReRe\Rere\Domain\Model\Fach $newFach) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->fachRepository->add($newFach);
		$this->redirect('list');
	}

	/**
	 * action edit
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $fach
	 * @ignorevalidation $fach
	 * @return void
	 */
	public function editAction(\ReRe\Rere\Domain\Model\Fach $fach) {
		$this->view->assign('fach', $fach);
	}

	/**
	 * action update
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $fach
	 * @return void
	 */
	public function updateAction(\ReRe\Rere\Domain\Model\Fach $fach) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->fachRepository->update($fach);
		$this->redirect('list');
	}

	/**
	 * action delete
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $fach
	 * @return void
	 */
	public function deleteAction(\ReRe\Rere\Domain\Model\Fach $fach) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->fachRepository->remove($fach);
		$this->redirect('list');
	}

}