<?php 

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;
	
class UnitProp extends Eloquent
{

	public $timestamps = false;
	
	protected $table = 'prop_unit';

	public function Units()
	{
		return $this->belongsTo('Unit');
	}

	public function prop()
	{
		return $this->belongsTo('Prop');
	}
	

}