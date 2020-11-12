<?php

namespace App\Traits;

trait UserEmailAttribute {

    public function user() {
        return $this->belongsTo('Modules\User\Entities\User', 'UserId');
    }

    public function getEmailAttribute() {
        return  $this->attributes['Email'] = ($this->user ?  $this->user->email : null);
    }

    protected function getArrayableAppends()
    {
        $this->appends = array_unique(array_merge($this->appends, ['Email']));

        return parent::getArrayableAppends();
    }
}