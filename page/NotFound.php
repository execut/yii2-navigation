<?php
/**
 */

namespace execut\navigation\page;


use Codeception\PHPUnit\ResultPrinter\HTML;
use execut\navigation\Page;

class NotFound extends Page
{
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setName('Not found');
        $this->setText(<<<HTML
<p>Page is not found.</p>
<p>The above error occurred while the Web server was processing your request.</p>
<p>Please contact us if you think this is a server error. Thank you.</p>
HTML
);
    }
}