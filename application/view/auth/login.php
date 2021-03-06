<?php
$old = new \Micro\Core\Old;

$tab = \Micro\Core\SessionManager::flushSession('tab');
$active_1 = (!$tab ? 'active' : '');
$active_2 = ($tab == 2 ? 'active' : '');

?>
<div class="container">
    <div class="row">
        <div class="site-logo">
            <a href="<?= get_url('', FALSE) ?>" class="brand"><img src="/img/front/logo.png" height="60"></a>
        </div>
        <div class="col-md-6 col-md-offset-3">

            <div class="card">

                <div class="row">
                    <div id="signup" class="col-md-12 full-width-tabs">

                        <ul  class="nav nav-pills">
                            <li class="<?= $active_1 ?>" ><a  href="#1b" data-toggle="tab">Login</a></li>
                            <li class="<?= $active_2 ?>"><a href="#2b" data-toggle="tab">Signup</a></li>
                        </ul>

                        <?= $this->partial(getPath('views') . 'admin/_flashes.php') ?>

                        <div class="tab-content clearfix">
                            <div class="tab-pane <?= $active_1 ?>" id="1b">
                                <div class="content">
                                    <form id="login-form"  method="post" role="form">
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Email/Username" value="<?= $old->value('username','admin') ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="admin">
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> Remember Me</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-info btn-fill" value="Log In">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="http://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- /tab-pane -->

                            <div class="tab-pane <?= $active_2 ?>" id="2b">
                                <div class="content">
                                    <form id="register-form" method="post" role="form" >
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?= $old->value('username') ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="fullname" id="fullname" tabindex="1" class="form-control" placeholder="Fullname" value="<?= $old->value('fullname') ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?= $old->value('email') ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="hidden" name="_method" value="<?= METHOD_PUT ?>" />
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-success btn-fill" value="Register Now">
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div> <!-- /tab-pane -->

                        </div>

                    </div>
                </div>

            </div> <!-- Card -->

        </div>
    </div>
</div>





