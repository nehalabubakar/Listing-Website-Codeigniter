<div class="container margin_60">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8">
            <div class="box_account">
                <h3 class="client"><?php echo get_phrase('already_registered'); ?></h3>
                <form class="" action="<?php echo site_url('login/phone_login_validation'); ?>" method="post">
                    <div class="form_container">
                        <div class="divider"><span><?php echo get_phrase('login_using_phone'); ?></span></div>
                        <!-- <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email*">
                        </div> -->
                        <!-- <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name*">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address*">
                        </div> -->
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone" id="phone" value="" placeholder="Phone Number*">
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <input type="submit" value="Send OTP" class="btn_1 w-100">
                            </div>
                            <div class="col-md-12">
                                <a id="sign_up" class="btn_1 full-width outline wishlist icon-login" href="<?php echo site_url('home/sign_up'); ?>"><?php echo get_phrase("sign_up"); ?></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>