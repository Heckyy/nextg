<?php
	class login{
		function view_login($e){
?>    
			<script defer src="<?php echo $e; ?>/src/login/js/js.js"></script>
			
	        <div class="container">
	            <div class="row">
	                <div class="col-md-5 col-sm-12 mx-auto">
	                    <div class="card pt-4">
	                        <div class="card-body">
	                            <div class="text-center mb-5">
	                                <img src="<?php echo $e; ?>/assets/images/favicon.png" height="100" class='mb-1'>
	                                <h3>Sign In</h3>
	                                <p>Please sign in to continue.</p>
	                            </div>
	                            <form method="POST" id="login">
	                                <div class="form-group position-relative has-icon-left">
	                                    <label for="username" >Username</label>
	                                    <div class="position-relative">
	                                        <input type="text" class="form-control" id="username" autocomplete='off'>
	                                        <div class="form-control-icon">
	                                            <i class="bi bi-person icons-login"></i>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="form-group position-relative has-icon-left">
	                                    <div class="position-relative">
	                                        <input type="password" class="form-control" id="password">
	                                        <div class="form-control-icon">
	                                            <i class="bi bi-lock icons-login"></i>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div class="clearfix">
	                                    <button type="submit" class="btn btn-success float-end">Login</button>
	                                </div>
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
<?php
		}
	}
?>