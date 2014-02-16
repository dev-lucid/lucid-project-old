<?php  if(lucid_navstate::area('nav2')->is_not('left_1')){ ?>
<div class="well">
	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="#!static_content/details1">Details 1</a></li>
		<li><a href="#!static_content/details2">Details 2</a></li>
		<li><a href="#!static_content/details3">Details 3</a></li>
	</ul>
</div>
<?php lucid_navstate::set_area('#left','nav2','left_1'); }?>