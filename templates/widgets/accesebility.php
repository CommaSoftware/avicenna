<script>
	document.addEventListener('DOMContentLoaded', function() {
		let trigger = document.getElementById('custom-accessibility-trigger');
		if (trigger) {
				trigger.addEventListener('click', function(e) {
						e.preventDefault();
						let pluginButton = document.querySelector('#evas-panel-toggle');
						let defaultButtonSetting = document.querySelector('#evas-action-light-contrast');
						if (!!pluginButton) {
							pluginButton.click();
						}
						if (!!defaultButtonSetting) {
							defaultButtonSetting.click();
						}
				});
		}
	});
</script>
<style>
	.evas-toggle-wrapper {
		pointer-events: none !important;
		opacity: 0;
	}

	@media screen and (max-width: 480px) {
		#evas-panel.evas-position-bottom-right {
			right: 0;
			bottom: 0px;
			left: 0px;
		}
	}
</style>