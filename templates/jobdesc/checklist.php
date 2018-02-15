<?php foreach ($checklists as $checklist): ?>
<div class="form-group">
  <h4 class="modal-title" id="myLargeModalLabel"><i class="ti-check-box"></i><span id="checklist-<?= $checklist->id; ?>" data-type="text" data-pk="<?= $checklist->id?>" data-title="Enter checklist name" class="editable editable-click liststyle" style="margin-left: 10px;"><?= $checklist->checklistname; ?></span></h4>
  <br/>
  <!-- <div class="pull-left"><span>50%</span></div> -->
  <!-- <div class="progress">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:90%;"><span class="sr-only">100% Complete</span>
    </div>
  </div> -->
  <!-- <div class="checkbox checkbox-success">
    <input id="checkbox3" type="checkbox">
    <label for="checkbox3"> Success </label>
  </div> -->

  <!-- list item -->
  <div class="tdl-holder">
    <div class="tdl-content">
        <ul id="childshow<?= $checklist->id; ?>">
        </ul>
        </div>
      <form id="childnya<?= $checklist->id; ?>" action="<?= $this->pathFor('save-child');?>" method="post">
        <input type="text" name="cheklistid" value="<?= $checklist->id; ?>" class="hidden">
        <input type="text" name="childname" class="tdl-new" placeholder="Write new item and hit 'Enter'...">
        <button type="submit" class="hidden">Add</button>
      </form>
    </div>
</div>

<!-- /* TO DO LIST */ -->
<script type="text/javascript">
   $('form#childnya<?= $checklist->id; ?>').submit(function( event ) {
      event.preventDefault();
      $.ajax({
          url: '<?= $this->pathFor('save-child');?>',
          type: 'post',
          data: $('form#childnya<?= $checklist->id; ?>').serialize(), // Remember that you need to have your csrf token included
          dataType: 'json',
          success: function( _response ){
              // Handle your response..
          },
          error: function( _response ){
              // Handle error
          }
      });
      $('input.tdl-new').val('');
   });
    $('#childnya<?= $checklist->id; ?>').on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
        jQuery.ajax({
            url:'/board/childlist/lihat/<?= $checklist->id; ?>>',
            async: false,
            type: 'GET',
            success: function( data ){
                 $('#childshow<?= $checklist->id; ?>').html(data);
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
      });
     $.ajaxSetup({
          headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
      });
      jQuery.ajax({
          url:'/board/childlist/lihat/<?= $checklist->id; ?>',
          async: false,
          type: 'GET',
          success: function( data ){
               $('#childshow<?= $checklist->id; ?>').html(data);
          },
          error: function (xhr, b, c) {
              console.log("xhr=" + xhr + " b=" + b + " c=" + c);
          }
      });
</script>

<script type="text/javascript">
  $(function(){
       $('#checklist-<?= $checklist->id; ?>').editable({
       url: '<?= $this->pathFor('save-checklist');?>',
       type: 'text',
       pk: <?= $checklist->id?>,
       name: 'checklist',
       showbuttons: 'bottom',
       title: 'Enter checklist'
     });

    });
  </script>
<?php endforeach; ?>

<script src="<?=$this->baseUrl()?>https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js></script>