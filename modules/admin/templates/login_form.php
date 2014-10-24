      <form class="form-signin" role="form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <?php $this->getContext('csrf')->echoInputField(); ?> 
      	<input type="hidden" name="postback" value="1" />
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>