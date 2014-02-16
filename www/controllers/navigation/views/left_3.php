<?php  if(lucid_navstate::area('nav2')->is_not('left_3')){ ?>
<div class="well">
	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="#!static_content/dropdown1">Dropdown 1</a></li>
		<li><a href="#!static_content/dropdown2">Dropdown 2</a></li>
		<li><a href="#!static_content/dropdown3">Dropdown 3</a></li>
		<li><a href="#!static_content/dropdown4">Dropdown 4</a></li>
	</ul>
</div>
<?php lucid_navstate::set_area('#left','nav2','left_3'); }?>