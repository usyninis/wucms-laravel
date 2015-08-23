
@if(access(Config::get('wucms::access_panel')))

{{ HTML::style('packages/usyninis/wucms/admin/css/panel.css') }}

<div class="ab-panel">

	<div class="ab-sbtns ab-sbtns_top">
	
	<a class="ab-sbtns__btn <?php if( ! Request::is('admin/*')) echo 'active';?>" href="{{ URL::route('index') }}" title="Просмотр сайта"><i class="fa fa-search"></i></a>
	
	@if(access(['admin']))	
	<a class="ab-sbtns__btn <?php if(Request::is('admin/units*') || Request::is('admin/types*') || Request::is('admin/groups*') || Request::is('admin/props*') || Request::is('admin/templates*')) echo 'active';?>" href="{{ URL::to('admin/units'.(Session::has('lastUnitId')?'/'.Session::get('lastUnitId'):'')) }}" title="Содержимое"><i class="fa fa-list-alt"></i></a>
	@endif

	@if(access(['admin']))	
	<a class="ab-sbtns__btn <?php if(Request::is('admin/albums*')) echo 'active';?>" href="{{ URL::to('admin/albums') }}" title="Изображения"><i class="fa fa-image"></i></a>
	@endif

	@if(access('superadmin'))
		<a class="ab-sbtns__btn <?php if(Request::is('admin/users*')) echo 'active';?>" href="{{ URL::to('admin/users') }}" title="Пользователи"><i class="fa fa-user"></i></a>
	@endif

	@if(access('superadmin'))
		<a class="ab-sbtns__btn <?php if(Request::is('admin/settings*')) echo 'active';?>" href="{{ url('admin/settings') }}"><i class="fa fa-cog"></i></a>		
	@endif



	</div>
	
	<div class="ab-sbtns ab-sbtns_bottom">	

		@if(in_array(Auth::id(),Config::get('wucms::access_debug')))
		<a class="ab-sbtns__btn ab-sbtns__btn_qrs" onclick="$('#ab-query-panel').toggle();$(this).toggleClass('active')" style="bottom:58px;" href="#">
			<i class="fa fa-bug"></i>
		</a>
		@endif

		<a class="ab-sbtns__btn ab-sbtns__btn_user" onclick="$('#ab-user-panel').toggleClass('show');$(this).toggleClass('active')">
			{{ HTML::image('packages/usyninis/wucms/admin/img/user_50x50.jpg') }}
		</a>
		
	</div>
</div>



<div id="ab-user-panel" class="ab-user-panel">
	<div class="ab-user-panel__label">Ваше имя</div>
	<div class="ab-user-panel__user-name">{{ Auth::user()->name }}</div>
	
	<div class="ab-user-panel__user-roles">
		<div class="ab-user-panel__label">Выши права:</div>
		@foreach(Auth::user()->roles as $role)
			<div class="ab-user-panel__user-role">
			{{ $role->role }}
			</div>
		@endforeach
	</div>	
	<div class="ab-user-panel__btns">
		
		<?php /* <a class="ab-user-panel__btn" href="#">Сменить пароль</a> */ ?>
		<a class="ab-user-panel__btn" href="{{ URL::route('admin.logout') }}">Выход</a>
	</div>

	
</div>
@if(in_array(Auth::id(),Config::get('wucms::access_debug')))
<div id="ab-query-panel" style="display:none" class="ab-query-panel">
<div style="background:#222;margin-bottom:1em;padding:0 1em">{{ App::environment() }}</div>
@foreach(DB::getQueryLog() as $query)
	<div class="ab-query-panel__query">{{ $query['query'] }}</div>
@endforeach

</div>
@endif

	@if(in_array(Route::currentRouteName(),['index','unit']))
		@include('wucms::ui.unit-edit')
	@endif
@endif
