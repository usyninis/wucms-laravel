<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- framework -->
	{{ HTML::style('packages/usyninis/wucms/admin/kube/kube.min.css') }}
	<!-- app -->	
	{{ HTML::style('packages/usyninis/wucms/admin/css/main.css') }}
	{{ HTML::style('packages/usyninis/wucms/admin/css/forms.css') }}
	<!-- plugins -->
	{{ HTML::style('packages/usyninis/wucms/admin/wu/wu-modal-default.css') }}
	{{ HTML::style('packages/usyninis/wucms/admin/js/jquery/plugins/tooltipster/tooltipster.css') }}
	{{ HTML::style('packages/usyninis/wucms/admin/js/jquery/plugins/zebra_dp/default.css') }}	
	{{ HTML::style('packages/usyninis/wucms/admin/js/jquery/plugins/nanoscroller/nanoscroller.css') }}	
	
	<!-- modernizr -->
	{{ HTML::script('packages/usyninis/wucms/admin/js/modernizr.min.js') }}
	<!-- jquery -->
	{{ HTML::jquery('1.11.1') }}
	<!-- jquery plugins -->	
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	{{ HTML::script('packages/usyninis/wucms/admin/kube/kube.min.js') }}
	{{ HTML::script('packages/usyninis/wucms/admin/js/jquery/plugins/jquery.form.js') }}
	{{ HTML::script('packages/usyninis/wucms/admin/tinymce/tinymce.min.js') }}
	{{ HTML::script('packages/usyninis/wucms/admin/js/jquery/plugins/tooltipster/jquery.tooltipster.min.js') }}	
	{{ HTML::script('packages/usyninis/wucms/admin/js/jquery/plugins/nanoscroller/jquery.nanoscroller.min.js') }}	
	
	<!-- helpers -->
		
	{{ HTML::script('packages/usyninis/wucms/admin/js/jquery/plugins/zebra_dp/zebra_datepicker.js') }}	
	<!-- app js -->
	{{ HTML::script('packages/usyninis/wucms/admin/wu/wu-app.js') }}
	{{ HTML::script('packages/usyninis/wucms/admin/js/main.js') }}
	
	
	<!-- custom header -->
	@section('head')
	<title>map</title>
	@show
	<!-- counters -->
	
	<!-- fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ url('packages/usyninis/wucms/admin/css/font-awesome-4.2.0/css/font-awesome.min.css') }}">
	
	<!-- icons -->
	<link rel="icon" href="{{ url('admin/favicon.ico') }}" type="image/x-icon">
	<link rel="shortcut icon" href="{{ url('admin/favicon.ico') }}">	
	
	
	
</head>
<body>
	