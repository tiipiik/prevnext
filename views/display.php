<div style="padding-top:10px;">
<?php if( ( $this->uri->segment(1) == 'blog' ) && ( $id != 0 )  ) {?>
	<div style="float:left;">
		<?php if($prev_url != '') 
		echo "&nbsp;&lt;";
		?>
		<a href='<?php echo $prev_url ?>'><?php echo $prev_title?></a>
	</div>
	<div style="float:right;">
		<a href='<?php echo $next_url?>'><?php echo $next_title?></a>
		<?php if($next_url != '') 
		echo "&nbsp;&gt;";
		?>
	</div>
<?php ; } ?>
</div>