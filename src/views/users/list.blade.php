@extends('wucms::template')



@section('content')


<div class="units-row end h-h100">
	
	<div class="unit-50 list-el-s1">	
		
		<div class="header-s1 group">			
			<h3 class="h-title left">Пользователи</h3>
			<button type="button" class="btn right btn-add js-wu-modal" data-code="user">Добавить пользователя</button>
		</div>		
		
			
		
		<div class="unit-d-units-list">		
		@foreach($users as $user)
			<div class="unit{{ empty($cuser)? '' : ($cuser->id==$user->id ? ' active': '') }} js-wu-modal"  data-code="user" data-id="{{ $user->id }}">
				<span class="u-name">{{ $user->id }} : {{ $user->name }}</span>
				<span class="u-url">{{ $user->email }}</span>
			</div>
		@endforeach		
		</div>
		
	</div>
	
	
	
</div>



	






@stop

