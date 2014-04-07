<?php
class Form extends Eloquent {

    protected $table        = 'appeal_forms';
    protected $primaryKey   = 'f_id';
    protected $guarded      = array('f_id');

}