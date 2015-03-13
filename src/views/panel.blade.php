
@if(Auth::check())

<style>
body{padding-left:58px !important}
.admin-panel{position: fixed;
background: #333;
left: 0;
top: 0;
width: 58px;
height: 100%;
z-index: 100;}
.admin-panel a{display: block;
font-size: 11px;background-position:center center;background-repeat:no-repeat;
text-transform: uppercase;
text-decoration: none;
text-align: center;
color: #C0C0C0;
font-weight: bold;
height: 58px;
line-height: 58px;font-size: 18px;
width: 58px;
}
.admin-panel a:hover{background-color: rgba(255, 255, 255, 0.05);}
.admin-panel a.active{background-color: #F78254;font-size: 28px;color:#fff;}
.admin-panel a.last-b{position:absolute;bottom:0}


.admin-query-log{position: fixed;
bottom: 0;
height: 50%;
width: 100%;
background: #fff;
padding: 1em 2em;
font-size: 12px;
overflow: auto;
z-index: 99;
left: 0;
padding-left: 100px;}
.admin-panel a.b-user{border-left:none;z-index:5;}
.admin-panel a.b-user.active{}
.admin-panel a.b-user img{width: 42px;
height: 42px;
margin: 8px 0;
border: 1px solid #303030;
border-radius: 5px;}

.admin-user-panel{position: fixed;
bottom: 5px;
height: 200px;
background: rgba(249, 249, 249, 1);
padding: .8em 1.2em;
font-size: 12px;
-webkit-transition: left 600ms ease, opacity 200ms ease;
transition: left 600ms ease, opacity 200ms ease;
z-index: 100;display:none;
left: 50px;opacity:0;
border-radius: 2px;
box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.31);}
.admin-user-panel.show{left: 70px;opacity:1;display:block}
.admin-user-panel:before{position: absolute;
width: 0;
height: 0;
border: 10px solid transparent;
content: ' ';
border-right: #fff solid 8px;
left: -18px;
bottom: 15px;}

.admin-user-panel .a-u-name{font-size:18px;margin-bottom:1em;color:#F78254}
</style>

<div class="admin-panel">
<a class="<?php if( ! Request::is('admin/*')) echo 'active';?>" href="{{ URL::route('index') }}" title="Просмотр сайта"><i class="fa fa-search"></i></a>
<a class="<?php if(Request::is('admin/units*') || Request::is('admin/types*') || Request::is('admin/groups*') || Request::is('admin/props*') || Request::is('admin/templates*')) echo 'active';?>" href="{{ URL::to('admin/units'.(Session::has('lastUnitId')?'/'.Session::get('lastUnitId'):'')) }}" title="Содержимое"><i class="fa fa-list-alt"></i></a>

<a class="<?php if(Request::is('admin/albums*')) echo 'active';?>" href="{{ URL::to('admin/albums') }}" title="Изображения"><i class="fa fa-image"></i></a>
@if(access('superadmin'))
<a class="<?php if(Request::is('admin/users*')) echo 'active';?>" href="{{ URL::to('admin/users') }}" title="Пользователи"><i class="fa fa-user"></i></a>
@endif
<a class="<?php if(Request::is('admin/settings*')) echo 'active';?>" href="{{ url('admin/settings') }}"><i class="fa fa-cog"></i></a>

<a class="last-b b-user" onclick="$('#dfsds').toggleClass('show');$(this).toggleClass('active')"><img src="http://www.mmenu.com/img/mm/choke_user_50x50.jpg" /></a>
@if(Auth::user()->id==1)
<a class="last-b" onclick="$('#dfsd').toggle();$(this).toggleClass('active')" style="bottom:58px;" href="#"><i class="fa fa-bug"></i></a>
@endif
</div>
<div id="dfsds" class="admin-user-panel">
	<div class="a-u-name">{{ Auth::user()->name }}</div>
	Выши права:<br/>
	@foreach(Auth::user()->roles as $role)
		{{ $role->role }}<br/>
	@endforeach
	<nav class="nav nav-stacked">
    <ul>
		<li><a href="{{ URL::route('admin.users.show',Auth::user()->id) }}">Личные данные</a></li>
		<li><a href="{{ URL::route('admin.users.show',Auth::user()->id) }}">Сменить пароль</a></li>
		<li><a href="{{ URL::route('admin.logout') }}">Выход</a></li>
	</ul>
	</nav>
	
</div>
<div id="dfsd" class="admin-query-log hide">
<?php
	$queries    = DB::getQueryLog(); 
	echo '<pre>';
	print_r($queries);
	echo '</pre>';
?>
</div>
	@if(in_array(Route::currentRouteName(),['index','unit']))
		@include('wucms::ui.unit-edit')
	@endif
@endif
