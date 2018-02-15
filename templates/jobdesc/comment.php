<style type="text/css">
	.member-initials {
	    display: block;
	    font-size: 12pt;
	    font-weight: 700;
	    height: 35px;
	    left: 0;
	    line-height: 30px;
	    overflow: hidden;
	    position: absolute;
	    text-align: center;
	    top: 0;
	    width: 100%;
	    background: #e0e0e0;
	    text-transform: uppercase;
	    padding: 2px;
	    border-radius: 7px;
	}
</style>
<?php 
function TanggalIndo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}
foreach ($comments as $comment): ?>
	<div class="comment-body" style="display: block;margin-left: 3px;">
		<?php foreach ($comment->details as $user): ?>
			<?php if(isset($user->name)){ ?>
			    <div class="user-img" style="margin-top: -5px;"><span class="member-initials"><?php $initial = substr($user->name, 0, 1); echo $initial[0];?></span></div>
			    <div class="mail-contnet" style="width: 94%;">
			      <h5><?=$user->name; ?></h5>
	    	<?php } else { ?>
		    	<div class="user-img"> <img src="<?=$this->baseUrl()?>plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"></div>
			    <div class="mail-contnet" style="width: 94%;">
			      <h5>Unknown</h5>
	    	<?php } ?>
	    <?php endforeach; ?>
	      <span style="margin-top: -15px;font-size: 12px;" class="time pull-right"><?php $date= explode(' ', $comment->created_at); echo $date[1].', '.TanggalIndo($date[0]);?></span>

	      <span class="mail-desc"><?php echo $comment->comment?></span>
	    </div>
	</div>
<?php endforeach; ?>   