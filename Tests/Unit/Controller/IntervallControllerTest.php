<?php

namespace ReRe\Rere\Tests\Unit\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
 *  			Sarah Kieninger <sarah.kieninger@gmail.com>, TeamProjektWS14/15
 *  			Tim Wacker , TeamProjektWS14/15
 *  			Nejat Balta , TeamProjektWS14/15
 *  			Tobias Brockner , TeamProjektWS14/15
 *  			Nicolas Tedjadharma , TeamProjektWS14/15
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class ReRe\Rere\Controller\IntervallController.
 *
 * @author Felix Hohlwegler <info@felix-hohlwegler.de>
 * @author Sarah Kieninger <sarah.kieninger@gmail.com>
 * @author Tim Wacker
 * @author Nejat Balta
 * @author Tobias Brockner
 * @author Nicolas Tedjadharma
 */
class IntervallControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \ReRe\Rere\Controller\IntervallController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock('ReRe\\Rere\\Controller\\IntervallController', array('redirect', 'forward', 'addFlashMessage', 'redirectToUri'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenIntervallToView() {
        $intervall = new \ReRe\Rere\Domain\Model\Intervall();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $view->expects($this->once())->method('assign')->with('newIntervall', $intervall);
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($intervall);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenIntervallToIntervallRepository() {
        $intervall = new \ReRe\Rere\Domain\Model\Intervall();

        $intervallRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\IntervallRepository', array('add'), array(), '', FALSE);
        $intervallRepository->expects($this->once())->method('add')->with($intervall);
        $this->inject($this->subject, 'intervallRepository', $intervallRepository);

        $this->subject->createAction($intervall);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenIntervallToView() {
        $intervall = new \ReRe\Rere\Domain\Model\Intervall();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method('assign')->with('intervall', $intervall);

        $this->subject->editAction($intervall);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenIntervallInIntervallRepository() {
        $type = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
        $aktuell = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);
        
        $intervallLogic = new \ReRe\Rere\Services\NestedDirectory\IntervallLogic();
        $intervall = new \ReRe\Rere\Domain\Model\Intervall();

        $intervallRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\IntervallRepository');
        $intervallRepository->expects($this->once())->method('findByUid')->will($this->returnValue($intervall));

        $request = $this->getMock(self::REQUEST, array(), array(), '', FALSE);
        $request->expects($this->once())->method('hasArgument')->will($this->returnValue($this->subject));

        $intervall->getType();
        $intervallLogic->nextStudiIntervall();
        $intervall->getAktuell();

        $request->expects($this->once())->method('getArgument')->will($this->returnValue($type));
        $intervallLogic->genAktuellesIntervall($type);
        
        $intervall->setType($type);
        $this->inject($this->subject, 'request', $request);

        $intervall->setAktuell($aktuell);

        $intervallRepository->expects($this->once())->method('update')->with($intervall);
        
        $this->inject($this->subject, 'intervallRepository', $intervallRepository);

        $this->subject->expects($this->once())->method('redirect')->with('list', 'Modul');
        $this->subject->updateAction($intervall);
    }

}
