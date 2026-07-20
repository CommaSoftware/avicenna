<script>
	document.addEventListener('DOMContentLoaded', function() {
		let trigger = document.getElementById('custom-accessibility-trigger');
		if (trigger) {
				trigger.addEventListener('click', function(e) {
						e.preventDefault();
						let pluginButton = document.querySelector('#evas-panel-toggle');
						if (pluginButton) {
								pluginButton.click();
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
</style>