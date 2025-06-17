<?php

namespace SolutionPlus\DynamicPages\Filters\Admin;

use Mabrouk\Filterable\Helpers\QueryFilter;

class KeywordFilter extends QueryFilter
{
    /**
     * Filter by visible keywords only.
     */
    public function visible($visible = 'yes')
    {
        return \in_array($visible, \array_keys($this->availableBooleanValues)) ? $this->builder->visible($this->availableBooleanValues[$visible]) : $this->builder;
    }
} 