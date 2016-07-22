<?php namespace App\Traits\Models;

trait VersionTrait {

    /**
     * @param $query
     * @return mixed
     */
    public function scopeProduction($query)
    {
        return $query->whereStatus('production');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeBuilding($query)
    {
        return $query->whereStatus('building');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeHistorical($query)
    {
        return $query->whereStatus('historical');
    }

};