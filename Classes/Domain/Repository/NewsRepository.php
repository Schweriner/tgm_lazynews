<?php
namespace TGM\TgmLazynews\Domain\Repository;


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
 * The repository for News
 */
class NewsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	protected $defaultOrderings = array(
        'datetime' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
        'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    /**
     * Finds news by offset and additional constraints
     */
    public function findByOffset($offset, $limit, $constraints=NULL) {

        // TODO: The offset does not respect already displayed news e.g. from top news
        $query = $this->createQuery();
        $query->setOffset($offset)->setLimit($limit);
        
        if($constraints!=NULL) {

            $fullConstraints = array();

            foreach ($constraints as $singleConstraint) {

                if(isset($singleConstraint['property'])
                    && isset($singleConstraint['value'])
                    && isset($singleConstraint['operator'])) {

                    if($singleConstraint['intval']=='1') {
                        $value = intval($singleConstraint['value']);
                    } else {
                        $value = $singleConstraint['value'];
                    }

                    $property = $singleConstraint['property'];

                    // TODO: Include other operators
                    switch($singleConstraint['operator']) {
                        case 'contains' : $fullConstraints[] =  $query->contains($property, $value); break;
                        case 'equals' : $fullConstraints[] =  $query->equals($property, $value); break;
                        case 'greaterThan' : $fullConstraints[] =  $query->greaterThan($property, $value); break;
                        case 'greaterThanOrEqual' : $fullConstraints[] =  $query->greaterThanOrEqual($property, $value); break;
                        case 'lessThan' : $fullConstraints[] =  $query->lessThan($property, $value); break;
                        case 'lessThanOrEqual' : $fullConstraints[] =  $query->lessThanOrEqual($property, $value); break;
                    }
                }
            }

            if(!empty($fullConstraints)) {
                $query->matching($query->logicalAnd($fullConstraints));
            }
        }
        
        return $query->execute();
    }
}