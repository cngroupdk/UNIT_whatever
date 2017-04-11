<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Orm;
use Nette\Application\UI\Form;
use App\Model\Poll;

final class FeedbackPresenter extends BasePresenter
{
    /**
	 * @var Orm
	 * @inject
	 */
	public $orm;

	/** @var Poll */
	private $poll;


    public function actionDefault(int $id)
    {
        $this->poll = $this->orm->polls->findById($id)->fetch();
        if ($this->poll === null) {
            $this->flashMessage(sprintf('Poll with id "%s" not found.', $id), 'error');
            $this->redirect('Homepage:');
        }

    }


    protected function createComponentFeedbackForm()
    {
        $form = new Form;
        $categories = $this->orm->categories->findBy(['poll' => $this->poll])->fetchPairs('id', 'name');

        $form->addSelect('category', 'Category:', $categories)
            ->setPrompt('---category---');
        $form->addText('answer', 'What is on your mind?');
        $form->addSubmit('send', 'Send feedback');

        $form->onSuccess[] = function (Form $form, $values) {
            dump($values);
		};

        return $form;
    }
}
