<style>
    #layout_content {
        background-color: #aaaaaa;
        transition-property: all;
        transition-duration: 1s;
    }
    #layout_content:hover {
        background-color: #eeeeee;
        transition-property: all;
        transition-duration: 1s;
    }
</style>
<div style="border-radius: 20px;
            padding: 15px;
            background-image: url('<?= $plugin->getPluginURL() ?>/assets/blubb_front.jpg');
            background-size: 100%;
            background-position: top;
            background-color: white;
            background-repeat: no-repeat;">
    <form action="<?= URLHelper::getLink("?", array('again' => "yes")) ?>" method="post" name="login">
        <input type="hidden" name="login_ticket" value="<?= Seminar_Session::get_ticket() ?>">
        <?= CSRFProtection::tokenTag() ?>
        <input type="hidden" name="resolution"  value="">
        <input type="hidden" name="device_pixel_ratio" value="1">
        <div style="margin-left: auto; margin-right: auto; margin-top: 150px; width: 250px;">
            <div>
                <input style="width: 100%;" type="text" name="loginname" id="loginname" value="" placeholder="<?= _("Login") ?>" aria-label="<?= _("Login") ?>">
            </div>
            <div>
                <input style="width: 100%;" type="password" name="password" id="password" value="" placeholder="<?= _("Passwort") ?>" aria-label="<?= _("Passwort") ?>">
            </div>
            <div style="text-align: center;">
                <?= Studip\Button::create(_('Anmelden'), _('Login')); ?>
            </div>
            <div style="font-weight: bold; text-align: center;">
                <a href="<?= URLHelper::getLink("request_new_password.php") ?>"><?= _("Passwort vergessen") ?></a>
                /
                <a href="<?= URLHelper::getLink("register1.php") ?>"><?= _("Registrieren") ?></a>
            </div>
        </div>
        <div style="min-height: 80px; min-width: 100%;"></div>
    </form>
</div>
    
<script type="text/javascript" language="javascript">
//<![CDATA[
jQuery(function () {
  jQuery('form[name=login]').submit(function () {
    jQuery('input[name=resolution]', this).val( screen.width + 'x' + screen.height );
    jQuery('input[name=device_pixel_ratio]').val(window.devicePixelRatio || 1);
  });
  jQuery("#loginname").focus();
});
// -->
</script>