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
 * IntervallController
 */
class IntervallController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Protected Variable intervallRepository wird mit NULL initialisiert.
	 * 
	 * @var \ReRe\Rere\Domain\Repository\IntervallRepository
	 * @inject
	 */
	protected $intervallRepository = NULL;

	/**
	 * Diese Methode dient dem Editieren des Intervalls. 
         * Sie wird in der aktuellen Version jedoch nicht verwendet.
	 * 
	 * @param \ReRe\Rere\Domain\Model\Intervall $intervall
	 * @ignorevalidation $intervall
	 * @return void
	 */
	public function editAction(\ReRe\Rere\Domain\Model\Intervall $intervall) {
		$this->view->assign('intervall', $intervall);
	}

	/**
	 * Diese Methode setzt je nach ausgewählter Richtung das vorherige bzw. das nächste Intervall als aktuell angezeigtes Intervall.
         * Dabei wird nach dem Typ (Studienhalbjahr oder Schulhabljahr) unterschieden.
	 * 
	 * @return void
	 */
	public function updateAction() {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$intervalLogic = new \ReRe\Rere\Services\NestedDirectory\IntervallLogic();
		$intervall = $this->intervallRepository->findByUid(1);
		// nächstes Intervall
		if ($this->request->hasArgument('nextIntervall')) {
			if ($intervall->getType() == 'studienhalbjahr') {
				$aktuell = $intervalLogic->nextStudiIntervall($intervall->getAktuell());
			} else {
				$aktuell = $intervalLogic->nextSchulIntervall($intervall->getAktuell());
			}
		}
		// Vorheriges Intervall
		if ($this->request->hasArgument('prevIntervall')) {
			if ($intervall->getType() == 'studienhalbjahr') {
				$aktuell = $intervalLogic->prevStudiIntervall($intervall->getAktuell());
			} else {
				$aktuell = $intervalLogic->prevSchulIntervall($intervall->getAktuell());
			}
		}
		// Typ setzen
		if ($this->request->hasArgument('type')) {
			$type = $this->request->getArgument('type');
			$aktuell = $intervalLogic->genAktuellesIntervall($type);
			$intervall->setType($type);
		}
		$intervall->setAktuell($aktuell);
		$this->intervallRepository->update($intervall);
		$this->redirect('list', 'Modul');
	}

	/**
	 * Diese Methode zum Erzeugen eines neuen Intervalls wird momentan nicht verwendet.
	 * 
	 * @param \ReRe\Rere\Domain\Model\Intervall $newIntervall
	 * @ignorevalidation $newIntervall
	 * @return void
	 */
	public function newAction(\ReRe\Rere\Domain\Model\Intervall $newIntervall = NULL) {
		$this->view->assign('newIntervall', $newIntervall);
	}

	/**
	 * Diese Methode dient dem Hinzufügen eines neuen Intervalls zum Reposotory.
	 * 
	 * @param \ReRe\Rere\Domain\Model\Intervall $newIntervall
	 * @return void
	 */
	public function createAction(\ReRe\Rere\Domain\Model\Intervall $newIntervall) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->intervallRepository->add($newIntervall);
		$this->redirect('list');
	}

}