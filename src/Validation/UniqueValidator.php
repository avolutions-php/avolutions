<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright	Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */

namespace Avolutions\Validation;

use Avolutions\Orm\EntityCollection;

/**
 * UniqueValidator
 *
 * TODO
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.6.0
 */
class UniqueValidator extends AbstractValidator
{
    /**
     * isValid
     *
     * TODO
     *
     * @return bool TODO
     */
    public function isValid($value) {
        $EntityCollection = new EntityCollection($this->Entity->getEntityName());
        $exists = $EntityCollection->where($this->property.' = \''.$value.'\'')->getFirst();

        return ($exists == null);
    }
}