<?php

function print_array($var)
{
	echo '<pre>';print_r($var);echo '</pre>';die();
}


function access($roles)
{
	
	if( ! Auth::check()) return false;
	$roles = (array)$roles;
	foreach($roles as $role_code)
		if(Auth::user()->isRole($role_code)) return true;
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