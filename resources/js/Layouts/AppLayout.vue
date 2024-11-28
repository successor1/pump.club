<script setup>
	import FlashMessages from "@/Layouts/AppLayout/FlashMessages.vue";
	import Footer from "@/Layouts/AppLayout/Footer.vue";
	import TopNav from "@/Layouts/AppLayout/TopNav.vue";
	// Props
	defineProps({
		title: {
			type: String,
			default: "",
		},
	});

	// We'll add state management and other functionality as needed
</script>
<template>
	<div class="min-h-screen bg-gray-900">
		<!-- Flash Messages Component (Will be created next) -->
		<FlashMessages />
		<!-- Top Navigation (Will be created next) -->
		<TopNav class="sticky top-0 z-50" />
		<!-- Main Content -->
		<main class="min-h-[calc(100vh-4rem)] mt-[45px]">
			<!-- Main Content Area -->
			<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
				<slot></slot>
			</div>
		</main>
		<!-- Footer (Will be created next) -->
		<Footer />
	</div>
</template>
