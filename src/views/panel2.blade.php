@if(Auth::check())
@if(Auth::user()->isAdmin())
<style>
.admin-panel-2{position: fixed;
left: 58px;
text-align: center;
height: 100%;
background: rgba(64, 64, 64, 1);
width: 110px;}

.admin-panel-2 a{display: block;
font-size: 11px;
background-position: center center;
background-repeat: no-repeat;
text-transform: uppercase;
text-decoration: none;
color: #C0C0C0;
font-weight: bold;
line-height: 14px;
position: relative;
padding: 10px 10px;
border-bottom: 1px solid #4D4D4D;}
.admin-panel-2 a:hover{color:#fff;}
.admin-panel-2 a.active{color: #FFFFFF;
background: #383838;}
.admin-panel-2 a.active:after{position: absolute;
display: block;
content: ' ';
right: 0;
top: 50%;
margin-top:-5px;
border: 5px solid transparent;
border-right-color: #E7E7E7;
width: 0;
}
.admin-panel-2 a .fa{display: block;
margin: 5px 0 5px 0;
color: #666;
font-size: 26px;}
.admin-panel-2 a.active .fa{color: #F78254}
</style>
<?php
	$list_items = [
		[ 'code' => 'units'	, 'name' => 'Страницы', 'icon' => 'fa-sitemap' ],
		[ 'code' => 'types'	, 'name' => 'Типы страниц', 'icon' => 'fa-cube' ],
		[ 'code' => 'props'	, 'name' => 'Свойства', 'icon' => 'fa-list' ],
		[ 'code' => 'groups'	, 'name' => 'Группы', 'icon' => 'fa-th-large' ],
		[ 'code' => 'templates'	, 'name' => 'Шаблоны', 'icon' => 'fa-list-alt' ],
	];
?>
<div class="admin-panel-2">
	@foreach($list_items as $item)
	<a href="{{ url('admin/'.$item['code']) }}" class="{{ Request::is('admin/'.$item['code'].'*') ? 'active' : '' }}"><i class="fa {{ $item['icon'] }}"></i>{{ $item['name'] }}</a>
	@endforeach

</div>
@endif
@endif