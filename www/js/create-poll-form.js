jQuery(function($) {
	var CreatePollForm = {};

	CreatePollForm.initializeAll = function () {
		$('.wb-create-poll-form').each(function () {
			CreatePollForm.initialize($(this));
		});
	};

	CreatePollForm.initialize = function ($form) {
		if ($form.data('wb-initialized')) {
			return;
		}

		$form.data('wb-initialized', true);

		$form.on('click', '.wb-switch-step-btn', function () {
			event.preventDefault();
			var step = $(this).data('wb-step');
			CreatePollForm.switchStep($form, step);
		});

		var defaultStep = $form.data('wb-default-step');
		CreatePollForm.switchStep($form, defaultStep);

		$form.on('click', '.wb-add-category-btn', function (event) {
			event.preventDefault();
			CreatePollForm.addCategory($form);
		});

		$form.on('click', '.wb-remove-category-btn', function (event) {
			event.preventDefault();
			var $categoryContainer = $(this).closest('.wb-category-container');
			CreatePollForm.removeCategory($categoryContainer);
		});
	};

	CreatePollForm.switchStep = function ($form, step) {
		var $stepPanels = $form.find('.wb-step-panel');

		$stepPanels.each(function () {
			var $stepPanel = $(this);
			$stepPanel.toggle($stepPanel.data('wb-step') === step);
		});
	};

	var categoryCounter = 1;

	CreatePollForm.addCategory = function ($form) {
		var $categoriesContainer = $form.find('.wb-categories-container');
		var $categoryTemplate = $form.find('.wb-category-template');

		var $category = $categoryTemplate.clone();
		$category.removeClass('wb-category-template');
		$category.addClass('wb-category-container');
		$category.appendTo($categoriesContainer);

		var $label = $category.find('label');
		var $input = $category.find('input');
		var id = 'wb-dynamic-category-' + categoryCounter++;
		$input.attr('id', id);
		$label.attr('for', id);
	};

	CreatePollForm.removeCategory = function ($categoryContainer) {
		$categoryContainer.remove();
	};

	CreatePollForm.initializeAll();
});
