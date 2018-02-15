<?php foreach ($childs as $child): ?>
	<?php 
		if($child->status == 0){
			$status = 1;
			$checked = '';
		} else {
			$status = 0;
			$checked = 'checked';
		}
	?>
	<li><label id="checkbox<?= $child->id; ?>" class="centang"><input type="checkbox" name="checkbox[]" value="<?= $child->id; ?>" <?= $checked; ?>><i></i><span><?= $child->childname; ?></span><a id="blabla<?= $child->id; ?>" class="fa fa-trash-o"></a></label></li>
	<script type="text/javascript">
	$("#blabla<?= $child->id; ?>").click(function(){
		var id = $(this).data("id");
		token = $(this).data("token");
		$.ajax(
		{
		    url: "/board/childlist/delete/<?= $child->id; ?>",
		    type: 'GET',
		    data: {
		        "id": <?= $child->id; ?>,
		        "_method": 'DELETE',
		        "_token": token,
		    }
		});
	});
	$(".tdl-content a").bind("click", function(){
    var _li = $(this).parent().parent("li");
        _li.addClass("remove").stop().delay(100).slideUp("fast", function(){
          _li.remove();
        });
    return false;
  	});
	<?php foreach ($child->details as $checklist): ?>
	$("#checkbox<?= $child->id; ?>").click(function(){
		var id = $(this).data("id");
		token = $(this).data("tokens");
		$.ajax(
		{
		    url: "/board/childlist/save/<?= $checklist->card_id; ?>/<?= $child->id; ?>/<?= $child->childname; ?>/<?= $status; ?>",
		    type: 'GET',
		    data: {
		        "id": <?= $child->id; ?>,
		        "status" : 1,
		        "_method": 'UPDATE',
		        "_token": token,
		    }
		});
		jQuery.ajax({
            url:'/board/activities/lihat/<?= $checklist->card_id;?>',
            async: false,
            type: 'GET',
            success: function( data ){
                 $('#activitynya-<?= $checklist->card_id; ?>').html(data);
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
	});
	<?php endforeach; ?>
	$(document).on('click', 'label#checkbox<?= $child->id; ?>', function(){
		 jQuery.ajax({
            url:'/board/childlist/lihat/<?= $child->checklist_id;?>',
            async: false,
            type: 'GET',
            success: function( data ){
                 $('ul#childshow<?= $child->checklist_id; ?>').html(data);
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
	});
	</script>
<?php endforeach; ?>