<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;


/**
 * Base presenter for all application presenters.
 * @method Template getTemplate()
 */
abstract class BasePresenter extends Presenter
{

}
