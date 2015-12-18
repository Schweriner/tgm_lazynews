<?php
namespace TGM\TgmLazynews\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Paul Beck <pb@teamgeist-medien.de>, Teamgeist Medien GbR
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
 ***************************************************************/

/**
 * NewsController
 */
class NewsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * newsRepository
	 *
	 * @var \TGM\TgmLazynews\Domain\Repository\NewsRepository
	 * @inject
	 */
	protected $newsRepository = NULL;

	/**
	 * action ajax
	 *
	 * @return void
	 */
	public function ajaxAction() {
		if($this->request->hasArgument('offset') && $this->request->hasArgument('limit') && $this->request->hasArgument('model')) {
            $model = $this->request->getArgument('model');
            $limit = $this->request->getArgument('limit');
            $offset = $this->request->getArgument('offset');
            
            $constraints = $this->request->hasArgument('constraints') ? $this->request->getArgument('constraints') : NULL;
            
            if($model=='news') {
                $data = $this->newsRepository->findByOffset((integer)$this->request->getArgument('offset'), (integer)$this->request->getArgument('limit'), $constraints);                
            }            
            if($data->count()==0) {
                return 'end';
            }
            $this->view->assignMultiple(array(
                'news' => $data,
                'model' => $model
            ));
        } else {
            return "Error. Missing Arguments Offset, Limit and Model";
        }
	}

}