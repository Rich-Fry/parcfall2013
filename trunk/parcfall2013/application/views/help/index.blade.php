@section('styles')
<style type="text/css">
	body{
		font:"Trebuchet MS",sans-serif;
		margin:0;
		padding:0;
		border:0;
	}

.content {
	float: left;
	width: 75%;
	border-left: 2px solid #000000;
	padding-left: 10px;
}

aside {
	float: left;
	width: 20%;
}

aside ul {
	list-style: none;
	padding-left: 0;
}
.sidenav {
  width: 228px;
  margin: 30px 0 0;
  padding: 0;
  background-color: #fff;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.065);
     -moz-box-shadow: 0 1px 4px rgba(0,0,0,.065);
          box-shadow: 0 1px 4px rgba(0,0,0,.065);
}
.sidenav > li > a {
  display: block;
  width: 190px \9;
  margin: 0 0 -1px;
  padding: 8px 14px;
  border: 1px solid #e5e5e5;
}
.sidenav > li:first-child > a {
  -webkit-border-radius: 6px 6px 0 0;
     -moz-border-radius: 6px 6px 0 0;
          border-radius: 6px 6px 0 0;
}
.sidenav > li:last-child > a {
  -webkit-border-radius: 0 0 6px 6px;
     -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
}
.sidenav > .active > a {
  position: relative;
  z-index: 2;
  padding: 9px 15px;
  border: 0;
  text-shadow: 0 1px 0 rgba(0,0,0,.15);
  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
     -moz-box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
          box-shadow: inset 1px 0 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.1);
}
/* Chevrons */
.sidenav .icon-chevron-right {
  float: right;
  margin-top: 2px;
  margin-right: -6px;
  opacity: .25;
}
.sidenav > li > a:hover {
  background-color: #f5f5f5;
}
.sidenav a:hover .icon-chevron-right {
  opacity: .5;
}
.sidenav .active .icon-chevron-right,
.sidenav .active a:hover .icon-chevron-right {
  background-image: url(../img/glyphicons-halflings-white.png);
  opacity: 1;
}
</style>
@endsection
@section('scripts')
<script type="text/javascript">
$(function () {
	$('.sidenav').affix();
})
</script>
@endsection
<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Help Page</li>
</ul>
<div class="row-fluid">
	<h3 style="text-align:center;">HELP PAGE</h3>

	<div class="span3" style="margin-top:-29px;">
		<ul class="nav nav-list nav-stacked affix-top sidenav" data-offset-top="2000">
			<li>
				<a href="/help/guide/createclientemployee">Create Client or Employee<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/editclientemployee">Edit Client or Employee<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/archiveclientemployee">Archive Client or Employee<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/commonterms">Common Terms<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/editaccount">Edit Account<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/logout">Logout<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/createuser">Create/Edit Users<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/createeditrole">Create/Edit User Role<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/personnelfile">Personnel File Management<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/createeditcategory">Create/Edit Personnel Record Categories<i class="icon-chevron-right"></i></a>
			</li>
			<li>
				<a href="/help/guide/credits">Credits<i class="icon-chevron-right"></i></a>
			</li>
		</ul>
	</div>

	<div class="span8 content">
		{{$content}}
	</div>

</div>