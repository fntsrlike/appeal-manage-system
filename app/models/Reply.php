<?php
class Reply extends Eloquent {

    protected $table        = 'appeal_replies';
    protected $primaryKey   = 'r_id';
    protected $guarded      = array('r_id');

}