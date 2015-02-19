<?php

function print_array($var)
{
	echo '<pre>';print_r($var);echo '</pre>';die();
}


function access($key)
{
	switch($key)
	{
		case 'admin': 
			if( ! Auth::check()) return false;
			if(Auth::user()->isAdmin()) return true;
			break;			
		case 'dev': 
			if( ! Auth::check()) return false;
			if(Auth::user()->id==1) return true;
			break;			
	}
	return false;
}

function date_sql($date = false)
{
	//if( ! $date) $date = time();
	return date('Y-m-d H:i:s');
}


function get_last_query() 
{
  $queries = DB::getQueryLog();
  $sql = end($queries);
	
  if( ! empty($sql['bindings']))
  {
    $pdo = DB::getPdo();
    foreach($sql['bindings'] as $binding)
    {
      $sql['query'] =
        preg_replace('/\?/', $pdo->quote($binding),
          $sql['query'], 1);
    }
  }
	
  return $sql['query'];
}