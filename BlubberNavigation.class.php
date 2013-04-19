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
        if ($GLOBALS['i_page'] === "index.php" && $GLOBALS['user']->id !== "nobody") {
            header("Location: ". Navigation::getItem("/community")->getURL());
        }
    }
}