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
 * SettingsController
 */
class SettingsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * settingsRepository
     *
     * @var \ReRe\Rere\Domain\Repository\SettingsRepository
     * @inject
     */
    protected $settingsRepository = NULL;

    /**
     * action edit
     *
     * @ignorevalidation $settings
     * @return void
     */
    public function editAction() {
        $settings = $this->settingsRepository->findByUid(1);
        $this->view->assign('settings', $settings);
    }

    /**
     * action update
     *
     * @param \ReRe\Rere\Domain\Model\Settings $settings
     * @return void
     */
    public function updateAction(\ReRe\Rere\Domain\Model\Settings $settings) {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->settingsRepository->update($settings);
        $this->redirect('edit');
    }

}
