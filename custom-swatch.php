		<div class="row">
							<style> .theColors { display: none }</style>
			<div class="btn-group-vertical theSizes">
				<?php foreach ( $model->sizes as $size ): ?>
					<? $sizeClass = str_replace('/','',$size)  ?>
					<a class="btn btn-default <?= $sizeClass ?>"> <?= $size ?> </a>
				<?php endforeach; ?>
			</div>
			<?php foreach ( $model->sizes as $size ): ?>
				<? $sizeClass = str_replace('/','',$size)  ?>

				<div class="btn-group-vertical theColors colors<?= $sizeClass ?>">
					<?php foreach ( $model->colors as $color ): ?>
						<a class="btn btn-default text-center colorChooser
				<?php foreach ($model->products as $item):
						if ($item->product_color == $color && $item->product_size == $size) {
						if ( $item->inventory_avail == 0 ) {
							echo 'disabled';
						} ?>
					" href="<?= $item->getLink() ?>"
						   data-color="<?= $item->product_color ?>"
						   title="<?= $item->product_color ?>"
							>
							<?php } endforeach ?>
							<?= $color ?>


						</a>

					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>




			<script>
				jQuery(document).ready(function ($) {
					<?php foreach ( $model->sizes as $size ): ?>
					<? $sizeClass = str_replace('/','',$size)   ?>

					$('.theSizes .<?= $sizeClass ?>').click(function (e) {
						e.preventDefault();
						$('.theSizes .btn').removeClass('active');
						$(this).addClass('active');
						$('.theColors').hide();
						$('.theColors.colors<?= $sizeClass ?>').css('display', 'inline-block');
						;
					});


					<?php endforeach; ?>
				});

				jQuery('.theColors .btn').click(function () {
					jQuery('.theColors .btn').removeClass('active');
					jQuery(this).addClass('active');
				})

				jQuery('.colorChooser').click(function (e) {
					e.preventDefault();

					var color = jQuery(this).attr('data-color');

					jQuery.ajax({
						type: "POST",
						url: '<?php echo $this->createUrl('product/getmatrixproduct') ?>',
						data: {
							id: <?php echo $model->id ?>,
							product_color: color
						},
						success: function (data) {
							<?php
							echo '$("#' . CHtml::activeId($model,'FormattedPrice') . '").html(data.FormattedPrice);
				$("#' . CHtml::activeId($model,'FormattedRegularPrice') . '").html(data.FormattedRegularPrice);
				if (data.FormattedRegularPrice != null) $("#' . CHtml::activeId($model,'FormattedRegularPrice') . '_wrap").show();
					else $("#' . CHtml::activeId($model,'FormattedRegularPrice') . '_wrap").hide();
				$("#' . CHtml::activeId($model,'description_long') . '").html(data.description_long);
				$("#' . CHtml::activeId($model,'image_id') . '").html(data.image_id);
				$("#' . CHtml::activeId($model,'InventoryDisplay') . '").html(data.InventoryDisplay);
				$("#' . CHtml::activeId($model,'title') . '").html(data.title);
				$("#' . CHtml::activeId($model,'code') . '").html(data.code);
				$("#photos").html(data.photos);
				MagicZoomPlus.refresh();
				$("#WishlistAddForm_color").val($("#SelectColor option:selected").val());
				$("#SelectColor").val(color)';
							?>
						},
						dataType: 'json'
					});
				});
			</script>
		</div>
