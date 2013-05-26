<?php

class BlubberNavigation extends StudIPPlugin implements SystemPlugin {
    public function __construct() {
        parent::__construct();
        if (Navigation::hasItem("/start") && Navigation::hasItem("/community")) {
            $nav = Navigation::getItem("/community");
            Navigation::removeItem("/community");
            Navigation::insertItem("/community", $nav, "start");
            Navigation::getItem("/start")->setImage(null);
        }
        if (Navigation::hasItem("/search/users")) {
            Navigation::getItem("/search")->setURL(Navigation::getItem("/search/users")->getURL());
        }
        if (Navigation::hasItem("/links/help")) {
            Navigation::removeItem("/links/help");
        }
        if (Navigation::hasItem("/login/help")) {
            Navigation::removeItem("/login/help");
        }
        if (Navigation::hasItem("/footer/help")) {
            Navigation::removeItem("/footer/help");
        }
        if (Navigation::hasItem("/footer/studip")) {
            Navigation::removeItem("/footer/studip");
        }
        if (Navigation::hasItem("/footer/blog")) {
            Navigation::removeItem("/footer/blog");
        }
        if (Navigation::hasItem("/tools")) {
            Navigation::getItem("/tools")->setImage(null);
        }
        if ($GLOBALS['i_page'] === "index.php" && $GLOBALS['user']->id !== "nobody") {
            header("Location: ". Navigation::getItem("/community")->getURL());
        }
        PageLayout::addHeadElement("link", array('rel' => "stylesheet", "href" => $this->getPluginURL()."/assets/blubber_nav.css"));
    
        //Customized Loginscreen and loginprocess
        if (!$GLOBALS['perm']->have_perm("user") && Request::get('again') === "yes") {
            $uid = $GLOBALS['auth']->auth_validatelogin();
            if ($uid) {
                $GLOBALS['auth']->auth["uid"] = $uid;
                $GLOBALS['auth']->auth["exp"] = time() + (60 * $GLOBALS['auth']->lifetime);
                $GLOBALS['auth']->auth["refresh"] = time() + (60 * $GLOBALS['auth']->refresh);
                $GLOBALS['sess']->regenerate_session_id(array('auth', 'forced_language','_language'));
                $GLOBALS['sess']->freeze();
                header("Location: ".URLHelper::getURL("plugins.php/blubber/streams/global", array(), true));
            }
        }
        if (!$GLOBALS['perm']->have_perm("user")) {
            if (Request::get("loginname")) {
                PageLayout::postMessage(MessageBox::error(_("Falsches Passwort oder Nutzername")));
            }
            $template = $this->getTemplate("login_screen.php");
            PageLayout::setTitle(_("Login"));
            $template->set_attribute("plugin", $this);
            echo $template->render();
            page_close();
            die();
        }
    }
    
    protected function getTemplate($template_file_name, $layout = "without_infobox") {
        if (!$this->template_factory) {
            $this->template_factory = new Flexi_TemplateFactory(dirname(__file__)."/templates");
        }
        $template = $this->template_factory->open($template_file_name);
        if ($layout) {
            if (method_exists($this, "getDisplayName")) {
                PageLayout::setTitle($this->getDisplayName());
            } else {
                PageLayout::setTitle(get_class($this));
            }
            $template->set_layout($GLOBALS['template_factory']->open($layout === "without_infobox" ? 'layouts/base_without_infobox' : 'layouts/base'));
        }
        return $template;
    }
}