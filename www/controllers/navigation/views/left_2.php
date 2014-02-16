<?php  if(lucid_navstate::area('nav2')->is_not('left_2')){ ?>
<div class="well">
	<ul class="nav nav-pills nav-stacked">
		<li class="active"><a href="#!static_content/about">About</a></li>
		<li><a href="#!static_content/contact">Contact</a></li>
	</ul>
</div>
<?php lucid_navstate::set_area('#left','nav2','left_2'); }?>