<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Form;

final class FeedbackPresenter extends BasePresenter
{
    public function renderDefault()
    {
        dump($this->request->getParameter('poolId'));
    }


    protected function createComponentFeedbackForm()
    {
        $form = new Form;

        $categories = [
            'category1',
            'category2',
            'category3',
        ];

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
