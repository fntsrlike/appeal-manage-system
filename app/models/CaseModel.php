<?php
class CaseModel extends Eloquent {

    protected $table        = 'appeal_Cases';
    protected $primaryKey   = 'case_id';
    protected $guarded      = array('case_id');

}