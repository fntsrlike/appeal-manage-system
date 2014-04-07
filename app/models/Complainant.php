<?php
class Complainant extends Eloquent {

    protected $table        = 'appeal_complainants';
    protected $primaryKey   = 'c_id';
    protected $guarded      = array('c_id');

}