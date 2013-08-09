<h2>Edit user "#<?=$user->id;?>"</h2>

<div class="row-fluid">
	<form class="form-horizontal" method="POST" action="<?=Route::url('sentry.users.manage.edit', array('id' => $user->id), true);?>">
		<fieldset>
			<legend>General</legend>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Email</label>
				<div class="controls">
					<input type="text" name="email" value="<?=$user->email;?>" id="inputEmail" placeholder="Email" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Password</label>
				<div class="controls">
					<input type="password" name="password" value="" id="inputPassword" placeholder="Password" /> <span class="text-error">*</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFirstname">First name</label>
				<div class="controls">
					<input type="text" name="first_name" value="<?=$user->first_name;?>" id="inputFirstname" placeholder="First name" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputLastname">Last name</label>
				<div class="controls">
					<input type="text" name="last_name" value="<?=$user->last_name;?>" id="inputLastname" placeholder="Last name" />
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Info</legend>
			<div class="control-group">
				<label class="control-label" for="inputCreated">Created</label>
				<div class="controls">
					<?=$user->created_at;?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputLastLogin">Last login</label>
				<div class="controls">
					<?=$user->last_login;?>
				</div>
			</div>
			<?php if($user->activated == 0):?>
			<div class="control-group">
				<label class="control-label" for="inputActivationCode">Activation code</label>
				<div class="controls">
					<?=$user->activation_code;?>
				</div>
			</div>
			<?php endif;?>
			<?php if($user->reset_password_code != null): ?>
			<div class="control-group">
				<label class="control-label" for="inputResetCode">Reset password code</label>
				<div class="controls">
					<input type="text" class="disabled" value="" id="inputResetCode" />
				</div>
			</div>
			<?php endif; ?>
		</fieldset>
		<fieldset>
			<legend>Group & permissions</legend>
			<div class="control-group">
				<label class="control-label">Groups</label>
				<div class="controls">
					<div class="row-fluid" id="groups">
						<div class="row-fluid">
							<div class="span5">
								<select multiple="multiple" class="span12" id="move-select-base-group" size="8">
									<?php foreach($groups['free'] as $group):?>
									<option value="<?=$group->id;?>"><?=$group->name;?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="span2 pagination-centered" style="padding-top: 60px;">
								<a class="btn btn-small btn-primary" id="move-select-in-group">>></a><br />
								<a class="btn btn-small btn-primary" id="move-select-out-group"><<</a>
							</div>
							<div class="span5">
								<select multiple="multiple" class="span12" id="move-select-container-group" size="8" name="groups[]">
									<?php foreach($groups['excluded'] as $group):?>
									<option value="<?=$group->id;?>"><?=$group->name;?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span5"><a href="#" class="btn btn-mini btn-success" id="move-select-fill-group">Move all</a></div>
							<div class="span2" style="padding-top: 20px; padding-left: 15px"></div>
							<div class="span5"><a href="#" class="btn btn-mini btn-danger pull-right" id="move-select-empty-group">Remove all</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Permissions</label>
				<div class="controls">
					<div class="row-fluid" id="permissions">
						<div class="row-fluid">
							<div class="span5">
								<select multiple="multiple" class="span12" id="move-select-base" size="8">
									<?php foreach($permissions['free'] as $id => $perm):?>
									<option value="<?=$perm;?>"><?=$perm;?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="span2 pagination-centered" style="padding-top: 60px;">
								<a class="btn btn-small btn-primary" id="move-select-in">>></a><br />
								<a class="btn btn-small btn-primary" id="move-select-out"><<</a>
							</div>
							<div class="span5">
								<select multiple="multiple" class="span12" id="move-select-container" size="8" name="permissions[]">
									<?php foreach($permissions['owned'] as $id => $perm):?>
									<option value="<?=$perm;?>"><?=$perm;?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span5"><a href="#" class="btn btn-mini btn-success" id="move-select-fill">Move all</a></div>
							<div class="span2" style="padding-top: 20px; padding-left: 15px"></div>
							<div class="span5"><a href="#" class="btn btn-mini btn-danger pull-right" id="move-select-empty">Remove all</a></div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
</div>
<div class="control-group">
	<div class="controls">
		<input type="submit" class="btn btn-success" id="group-save" value="Edit user" />
	</div>
</div>
</form>
</div>

<div id="push"></div>