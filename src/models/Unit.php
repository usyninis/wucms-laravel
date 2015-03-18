<?php 

namespace Usyninis\Wucms;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use URLify;

/*
	
	version: 0.2
	
*/
	
class Unit extends Eloquent
{
	/**
	 * table name
	 * @var array
	 */
	//protected $table = 'my_users'; 
	
	/**
	 *protected $primaryKey = 'key';
	 * @var array
	 */
	//protected $primaryKey = 'id';
	
	/**
	 * Атрибуты, исключенные из JSON-представления модели.
	 * @var array
	 */
	//protected $hidden = array('password');

	/**
	*мягкое удаление
	 */
	//protected $softDelete = true;
	
	/*
	
		boot
	*/

    public static function boot()
    {
        parent::boot();

		static::creating(function($unit)
		{
			if(Auth::check()) 
			{
				$unit->created_by = Auth::user()->id;
				$unit->updated_by = Auth::user()->id;
			}
			$unit->public_date = date_sql();
		});

		static::updating(function($unit)
		{
			
			if(Auth::check()) 
			{
				$unit->updated_by = Auth::user()->id;
			}
			//die('updating');
		});

		static::saving(function($unit)
		{			
			

			//if( ! $unit->code) $unit->code = URLify::filter($unit->name);
			
			$unit->url = $unit->code;
			$unit->level = 1;
			
			
			DB::table('units_childrens')->where('children_id','=',$unit->id)->delete();
			
			
			
				
				if($parents = $unit->parents())
				{
					$parents = array_reverse($parents);
					foreach($parents as $parent_unit)
					{	
						if($unit->id)			
							DB::table('units_childrens')->insert(array(
								'unit_id'		=> $parent_unit->id,
								'children_id'	=> $unit->id,
								'level'			=> $unit->level
							));						
			
						$unit->level++;
						$unit->url = $parent_unit->code.'/'.$unit->url;
						
					}
					
				}				
				
			if($unit->main) $unit->url = '/';
			
			
			//if(!empty($unit->id))
				
		});
			
			//$unit->updated_by = Auth::user()->id;
			//die('saving');
		
		
		
		static::deleting(function($unit)
        {   
            //	change parent id
			Unit::where('parent_id','=',$unit->id)->update(array('parent_id' => $unit->parent_id));
			DB::table('units_childrens')->where('unit_id','=',$unit->id)->orWhere('children_id','=',$unit->id)->delete();
			
			
			//delete attach
			UnitProp::where('unit_id','=',$unit->id)->delete();
			DB::table('group_unit')->where('unit_id','=',$unit->id)->delete();
			
        });
    }
	
	/*	
		rules
	*/
	
	public static function rules($uid=null)
	{
		return array(
			'name'		=> 'required|min:3',
			'code'		=> 'required|min:3|unique:units,code,'.$uid,
			//'template_id'	=> 'required',
			'type_id'	=> 'required',
		);
	}
	
	/*	
		source
	*/

	public function type()
	{
		return $this->belongsTo('Usyninis\Wucms\Type');
	}

	public function recount()
	{
		if(!empty($this->id))
		{
			$count = Unit::whereParentId($this->id)->count();
			Unit::whereId($this->id)->update(['count'=>$count]);
		}
		else 
			$count = 0;
		
		return $count;
	}

	public function scopeWhereTypeCode($query,$code)
    {
    	$query = $query->select('units.*');
    	return $query->join('types','units.type_id', '=', 'types.id')
        ->where('types.code','=',$code);
    }


	public function template()
	{
		return $this->belongsTo('Usyninis\Wucms\Template');
	}


	public function image()
	{
		return $this->belongsTo('Usyninis\Wucms\Image','image_id');
	}


	public function groups()
	{
		return $this->belongsToMany('Usyninis\Wucms\Group');
	}

	
	/*	
		Attributes
	*/

	
	/* public function getPublicDateAttribute($value)
	{		

		if( ! empty($value)) return $value;
		return $this->attributes['created_at'];
		
	} */
	
	public function getTitleAttribute($value)
	{		

		if($value) return $value;
		return $this->attributes['name'];
		
	}
	
	public function getTemplateIdAttribute($value)
	{		

		if($value) return $value;
		return $this->type->template_id;
		
	}
	
	

	
	public function getMetaTitleAttribute($value)
	{		

		if($value) return $value;
		return $this->attributes['name'];
		
	}
	
	public function getTemplateCodeAttribute($value)
	{		

		if($this->template) return $this->template->code;
		if($this->type) return $this->type->code;
		return null;
		
	}

	
	public function getChildrenTypeIdAttribute($value)
	{		
		//return $value;
		if($value==0) return $this->attributes['type_id'];
		return $value;
	}

	public function parent()
	{
		return $this->hasOne('Usyninis\Wucms\Unit','id','parent_id');//return $this->belongsTo('Unit','parent_id','id');
	}

	function scopeMain($query)
	{
		return $query->whereMain(1)->first();
	}
	
	public function scopeAllChildrens($query,$unit_id)
	{
		$query = $query->join('units_childrens as uc', function($join) use ($unit_id)
		{
			$join->on('uc.children_id', '=', Unit::getTable().'.id')
				->on('uc.unit_id', '=', DB::raw($unit_id));
		});
		return $query;
		//return DB::table('units_props')->where('unit_id','=',$this->id)->get();
	}
	
	public function parents()
	{
		$cunit = $this;
		$parents = array();
		while($parent_unit = $cunit->parent)
		{
			if( ! $parent_unit->id) break;
			if(array_key_exists($parent_unit->id,$parents)) break;
			$parents[$parent_unit->id] = $parent_unit;
			
			$cunit = $parent_unit;	
		}
		if( ! $parents) return false;
		$parents = array_reverse($parents);	
		return $parents;
		/* return Unit::join('units_childrens', 'units.id', '=', 'units_childrens.unit_id')
			->where('units_childrens.children_id','=',$this->id)
			->orderBy('units_childrens.level','ASC')
			->get(); */
	}

	public function children()
	{
		return $this->hasMany('Unit','parent_id')->orderBy('sort','ASC');
	}

/*	public function scopeMain($query)
	{
		return $query->whereGender('W');
	}


	public static function get($key=false)
	{

		if(is_int($key))
			$unit = Unit::where('id','=',$key)->firstOrFail();
		else if($key)
			$unit = Unit::where('code','=',$key)->firstOrFail();
		else 
			$unit = Unit::where('main','=',1)->firstOrFail();
		
		//$unit->parents = $unit->parents();
		//$parent_unit = Unit::find($unit->parent_id);
		//while($parent_id = $unit)
		return $unit;
	}*/

	public static function map()
	{
		$result = array();
		$units = Unit::orderBy('level','ASC')
			->orderBy('sort','ASC')
			->get();
		if($units)
		{
			$max_level = 1;
			foreach ($units as $unit)
			{
				$max_level = $max_level>$unit['level'] ? $max_level : $unit['level'];
				$result[$unit['level']][$unit['parent_id']][$unit['id']] = $unit;
			}
			$result[($max_level+1)] = array();
		}
		return $result;
	}

	public function images()
	{		
		return $this->belongsToMany('Usyninis\Wucms\Image', 'units_images','unit_id','image_id')->orderBy('sort','ASC');
	}

	public static function url($key=false)
	{		
		if((int)$key)
			$unit =Unit::find($key);
		else if($key)
			$unit = Unit::where('code','=',$key)->first();
		if( ! $unit) return false;
		return $unit->url;
	}

	public function scopeWhereProp($query, $code, $operator=null, $value=null)
	{
		$query->select(Unit::getTable().'.*');
		
		if($prop = Prop::whereCode($code)->first())
		{
			$alias = 't_prop_'.$prop->id;
			$id = $prop->id;
			
			$query = $query->addSelect($alias.'.'.$prop->value_key.' as prop_'.$prop->code.'');
			
			
			
			$query = $query->leftJoin('prop_unit as '.$alias, function($join) use ($alias,$id)
			{
				$join->on($alias.'.unit_id', '=', Unit::getTable().'.id')
					->on($alias.'.prop_id', '=', DB::raw($id));
			});
			
			$query = $query->where($alias.'.'.$prop->value_key,$operator,$value);
			
		}
		else
		{
			$query->whereNull('id');
		}
		
		
		
		return $query;
		//return $query->where($code,$param,$value);
	}
	
	public function scopeWithProps($query, $prop_codes)
	{
		//$props_array = func_get_args();
		/* $prop_codes = [];
		foreach($props_array as $i => $arg)
			if($i>0) $prop_codes[] = current((array)$arg); */
		$prop_codes = (array) $prop_codes;
		$query = $query->select(Unit::getTable().'.*');
		//$query = $query->addSelect('units.id');
		if($props = Prop::whereIn('code',$prop_codes)->get())
		
			foreach($props as $prop)
			{
				$alias = 't_prop_'.$prop->code;
				$id = $prop->id;
				$query = $query->addSelect($alias.'.'.$prop->value_key.' as prop_'.$prop->code);
				$query = $query->leftJoin('prop_unit as '.$alias, function($join) use ($alias,$id)
				{
					$join->on($alias.'.unit_id', '=', Unit::getTable().'.id')
					->on($alias.'.prop_id', '=', DB::raw($id));
					
					
				});
				
				
				
			}
			
		
		
		return $query;
		//return $query->from('prop_unit')->select('prop_unit.*');//->join('units','units.id', '=', 'prop_unit.unit_id');
			
		//return $query;
	}

	public function scopeActive($query)
	{
		return $query->where('active','=',1);
			
		//return $query;
	}
	
	/* public function scopeWherePropCode($query,$code,$value)
	{
		//print_array($query);
		
		
		//$query = $query->select('units.*');
		//$query = $query->join('prop_unit','units.id', '=', 'prop_unit.unit_id');
		if($prop = Prop::whereCode($code)->first())
		{
				//return $prop;
			return $query->orWhere(function($query) use ($prop,$value)
            {
                $query->where('prop_unit.prop_id', '=', $prop->id)
                      ->where('prop_unit.'.$prop->value_key, '=', $value);
            });
            //$query = $query->where('prop_unit.prop_id', '=', $prop->id);
            //$query = $query->where('prop_unit.'.$prop->value_key, '=', $value);
        }
		else
		{
			return $query->where('prop_unit.prop_id', '=', 0);
		}
		//return $query;
		
	}

	public function scopeWherePropId($query,$id,$value)
	{
		
		//$query = $query->select('units.*');
		//$query = $query->join('prop_unit','units.id', '=', 'prop_unit.unit_id');
		if($prop = Prop::find($id))
		{
				//return $prop;
            $query = $query->where('prop_unit.prop_id', '=', $prop->id);
            $query = $query->where('prop_unit.'.$prop->value_key, '=', $value);
        }
		else
		{
			$query = $query->where('prop_unit.prop_id', '=', 0);
		}
		return $query;
		
	} */

	public function propm($code)
	{
		return $this->prop($code,true);
	}
	
	public function prop($code,$multiple=false)

	{
		//$prop = Prop::where('code','=',$code)->
		$uprops = UnitProp::select('prop_unit.*')
			->join('props','props.id','=','prop_unit.prop_id')
			->where('prop_unit.unit_id','=',$this->id)
			->where('props.code','=',$code)
			->get();

		if($uprops->isEmpty()) return false;
		
		$prop_multiple = [];
		
		foreach ($uprops as $uprop) 
		{			
				
			$aprop = $uprop->prop;
			$field = $uprop->prop->value_key;
			
			if( ! $multiple) 
			{					
				if( $aprop->type=='prop') return Prop::find($uprop->$field);
				if( $aprop->type=='album') return Album::find($uprop->$field);
				if( in_array($aprop->type,['unit','list'])) return Unit::find($uprop->$field);
				return $uprop->$field;
			}
			$prop_multiple[] = $uprop->$field;
			
		}
		
		
		if( $aprop->type=='prop') return Prop::whereIn('id',$prop_multiple)->get();
		if( $aprop->type=='album') return Album::whereIn('id',$prop_multiple)->get();
		if( in_array($aprop->type,['unit','list'])) return Unit::whereIn('id',$prop_multiple)->get();		
		return $prop_multiple;
		/*return DB::table('units_props')
			->where('unit_id','=',$this->id)
			->where('code','=',$code)
			->get();*/
	}

	/* public function propValue($code)
	{
		return $this->prop($code,true);
	} */

	public function props()
	{
		return $this->hasMany('UnitProp');
		//return DB::table('units_props')->where('unit_id','=',$this->id)->get();
	}

	


	



	
}