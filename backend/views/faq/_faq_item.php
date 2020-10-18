<tr id="<?php echo $data->id?>" >
	<td><input type='checkbox' class="select-on-check" value="<?php echo $data->id?>"/>
	</td>
	<td><a href="<?php echo url('/faq/edit', array('id'=>$data->id))?>"><?php echo $data->title?></a>
	</td>
	<td><?php echo date("d M Y", strtotime($data->created))?></td>
	<td><?php echo !empty($data->updated) ? date("d M Y", strtotime($data->updated)) : ""?></td>
	<td><?php echo $data->status == 0 ? "Draft" : "Published"?></td>
	<td><i class="icon-chevron-up" id="up-<?php echo $data->id?>" style="cursor: pointer;"></i><i class="icon-chevron-down" id="down-<?php echo $data->id?>" style="cursor: pointer;"></i>
	</td>
</tr>