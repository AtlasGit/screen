var page = require('webpage').create();

page.viewportSize = {width: <?= $width ?>, height: <?= $height ?>};

function onPageReady() {
	/* This will set the page background color white */
	page.evaluate(function() {
		document.body.bgColor = '#FFFFFF';
	});

	page.render('<?= $imageLocation ?>');
	phantom.exit();
}

<?php if (isset($clipWidth) && $clipWidth && isset($clipHeight) && $clipHeight) : ?>
	page.clipRect = {
		top: 0,
		left: 0,
		width: <?= $clipWidth ?>,
		height: <?= $clipHeight ?>
	};
<?php endif ?>

page.open('<?= $url ?>', function () {

	function checkReadyState() {
		setTimeout(function () {
			var readyState = page.evaluate(function () {
				return document.readyState;
			});

			if ("complete" === readyState) {
				onPageReady();
			} else {
				checkReadyState();
			}
		});
	}
	
	checkReadyState();
});
