<?php 
	$multi_user = $model->recipient_name == Queue::ALL_TUTOR || $model->recipient_name == Queue::ACTIVE_TUTOR || $model->recipient_name == Queue::SELECTED_TUTOR;
?>
<h2>
	<?php echo $model->title?>
</h2>
<h4>
	<p>From: <?php echo $model->sender_name . '(' . $model->sender_email . ')'?></p>
	
</h4>
<?php if(!$multi_user) {?>
	
	<p>To: <?php echo $model->recipient_name . '(' . $model->recipient_email . ')'?></p>
	
<?php } else {?>

	<p>To: [<?php echo $model->recipient_name?>] <a id="selectUsers"><i class="icon-chevron-down"></i></a></p>
		<div id="tutors" class="collapse out">

			<div style="overflow: scroll; height: 100px; width: 400px">
			
				<table class="table table-condensed table-nonfluid">
				<thead>
					<tr>
						<th>Name</th>
						<th>e-mail</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $model->showSelectedTutor($model->recipient_email)?>
				</tbody>
				</table>

			</div>

		</div>
		
<?php }?>
	
<h5>
	<?php echo date('d M Y H:i', strtotime($model->created))?>
</h5>
<h5>
	Status: <?php echo $model->status == Queue::SUCCESS ? 'Sent' : 'Pending'?>
</h5>
<hr />

<?php echo $model->message?>

<input type="hidden" value="<?php echo $model->status?>" id="queue_status"/>
<input type="hidden" value="<?php echo $model->id?>" id="queue_id"/>

<script type="text/javascript">

    $(function() {

        $("#selectUsers").click(function() {
            $("#tutors").collapse('toggle');

            var css = ($("i", this).attr('class') === 'icon-chevron-down')
                    ? 'icon-chevron-up'
                    : 'icon-chevron-down';
            $("i", this).attr('class', css);

        });

    });


</script>