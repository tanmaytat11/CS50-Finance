<form action="password_change.php" method="post">
    <fieldset>
        <div class="form-group">
            <input class="form-control" name="current_password" placeholder="Current Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new_password" placeholder="New Password" type="password"/>
        </div>
		<div class="form-group">
			<input class="form-control" name="new_confirmation" placeholder="Confirm Password" type="password"/>
		</div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Change Password</button>
        </div>
    </fieldset>
</form>
