<?php

defined('IN_IA') or exit('Access Denied');

class Zh_vipModule extends WeModule {

	public function welcomeDisplay()
    {   
        $url = $this->createWebUrl('index');
        Header("Location: " . $url);
    }
}