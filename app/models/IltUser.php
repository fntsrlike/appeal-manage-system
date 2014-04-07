<?php
class IltUser extends Eloquent {

    protected $table        = 'appeal_ilt_users';
    protected $primaryKey   = 'u_id';
    protected $guarded      = array('u_id');

}