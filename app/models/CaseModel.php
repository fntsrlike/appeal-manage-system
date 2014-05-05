<?php
class CaseModel extends Eloquent {

    protected $table        = 'appeal_cases';
    protected $primaryKey   = 'case_id';
    protected $guarded      = array('case_id');

}