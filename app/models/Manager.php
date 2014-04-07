<?php
class Manager extends Eloquent {

    protected $table        = 'appeal_managers';
    protected $primaryKey   = 'm_id';
    protected $guarded      = array('m_id');

}