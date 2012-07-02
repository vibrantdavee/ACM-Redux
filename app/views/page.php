<?php include_once("./app/redux.php"); ?>

<?php rx_pushCSS(rx_getData('page-css')); ?>
<?php rx_pushJS(rx_getData('page-js')); ?>


<?php rx_setTitle("acm@thebeach - " . rx_getData('title')); ?>

<?php includePart("base", "documentTop"); ?>
<?php includePart("base", "header"); ?>

<div class="main-content container_12">
	<div class="grid_12">
		<?php echo rx_getData("content"); ?>		
	</div>
</div>

<?php includePart("base", "documentBottom"); ?>