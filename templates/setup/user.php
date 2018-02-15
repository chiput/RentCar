<?php 
  $this->layout('layouts/main', [
    // app profile
    'title' => 'Daftar User',
    'app_name' => $app_profile['name'],
    'author' => $app_profile['author'],
    'description' => $app_profile['description'],
    'developer' => $app_profile['developer'],
    // breadcrumb
    'main_location' => 'User',
    'submain_location' => 'Daftar User'
  ]); 
?>


<?php if ($this->getSessionFlash('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $this->getSessionFlash('success'); ?>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">User</h3>
            <p class="text-muted m-b-30">Data User</p>
            <p class="text-muted m-b-20"><a href="<?php echo $this->pathFor('setup-user-new'); ?>" class="btn btn-primary">Tambah User</a></p>
            <table class="table table-striped myDataTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td class="text-nowrap">
                            <a href="<?php echo $this->pathFor('setup-user-update', ['id' => $user->id]) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <a href="<?php echo $this->pathFor('setup-user-delete', ['id' => $user->id]) ?>" data-toggle="tooltip" data-original-title="Hapus"> <i class="fa fa-close text-danger m-r-10"></i> </a>
                            <a href="<?php echo $this->pathFor('setup-useraccess', ['userId' => $user->id]) ?>" data-toggle="tooltip" data-original-title="Akses"> <i class="fa fa-key text-inverse m-r-10"></i> </a>
                        </td>
                        <td><?php echo $user->code; ?></td>
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo $user->email; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
