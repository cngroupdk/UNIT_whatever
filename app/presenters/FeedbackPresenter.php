<?php

namespace App\Presenters;

use App\Model\Answer;
use App\Model\Feedback;
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

	/**
     * @var Poll
     */
	private $poll;


    public function actionDefault(int $id)
    {
        $this->poll = $this->orm->polls->getById($id);

        if ($this->poll === null) {
            $this->flashMessage('Poll not found.', 'error');
            $this->redirect('Register:');
        }
    }


    protected function createComponentFeedbackForm()
    {
        $form = new Form;

        $categories = $this->orm->categories->findBy(['poll' => $this->poll])->fetchPairs('id', 'name');

        $form->addSelect('category', 'Category:', $categories)
            ->setPrompt('--- Please choose ---');

        $form->addTextArea('answer', 'What is on your mind?');

        $form->addSubmit('send', 'Send feedback');

        $form->onSuccess[] = function (Form $form, $values) {
            $answer = new Answer;
            $answer->category = $this->orm->categories->getById($values->category);
            $answer->text = $values->answer;

            $feedback = new Feedback;
            $feedback->poll = $this->poll;
            $feedback->createdAt = new \DateTimeImmutable;
            $feedback->answers->add($answer);
            $this->orm->persistAndFlush($feedback);

            $this->redirect('thanks');
		};

        return $form;
    }
}
