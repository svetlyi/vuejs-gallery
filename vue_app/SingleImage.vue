<template>
	<div class="card" style="width: 18rem;">
		<img class="card-img-top" v-bind:src="image.path">
		<div class="card-body">
			<h5 class="card-title">{{ image.name }}</h5>
		</div>
	</div>
</template>

<script>
	export default {
		name:       "single-image",
		props:      ['image']
	}
</script>

<style scoped>
</style>